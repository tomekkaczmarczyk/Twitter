<?php

class User
{
    private $id;
    private $email;
    private $hashedPassword;
    private $description;
    private $isActive;

    
    public function __construct($email = "", $hashedPassword = "", $description = "", $isActive = false, $id = -1)
    {
        $this->id = $id;
        $this->email = $email;
        $this->hashedPassword = $hashedPassword;
        $this->description = $description;
        $this->isActive = $isActive;
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getEmail()
    {
        return $this->email;
    }
    
    public function setEmail($email)
    {
        $this->email = $email;
    }
    
    public function getHashedPassword()
    {
        return $this->hashedPassword;
    }
    
    public function setPassword($password)
    {
        $this->hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    }
    
    public function getDescription()
    {
        return $this->description;
    }
    
    public function setDescription($description)
    {
        $this->description = $description;
    }
    
    public function isUserActive()
    {
        return $this->isActive;
    }
    
    public function activate()
    {
        $this->isActive = true;
    }
    
    public function deactivate()
    {
        $this->isActive = false;
    }
    
    public function verifyPassword($password)
    {
        return password_verify($password, $this->hashedPassword);
    }

    public function save(mysqli $conn)
    {
        if (-1 === $this->id) {
            $query = "INSERT INTO users (email, hashed_password, description, is_active)"
                . "VALUES ('{$this->email}', '{$this->hashedPassword}', '{$this->description}', '{$this->isActive}')";
            $result = $conn->query($query);
            
            if(true == $result) {
                $this->id = $conn->insert_id;
                
                return true;
            } else {
                return false;
            }
        } else {
            $query = "UPDATE users SET "
                . "email='" . $this->getEmail()
                . "', hashed_password='" . $this->getHashedPassword()
                . "', description='" . $this->getDescription()
                . "', is_active='" . $this->isUserActive()
                . "' WHERE id='" . $this->getId() . "'";

            $result = $conn->query($query);

            return $result;
        }
    }

    public function getAllTweets($conn)
    {
        $query = "SELECT * FROM tweets WHERE user_id='{$this->id}' ORDER BY creation_date DESC";

        $result = $conn->query($query);

        if (!$result) {
            die('Error: ' .$conn->error);
        }

        $tweets = [];

        if (0 < $result->num_rows) {
            foreach ($result as $tweet) {
                $tweetObj = new Tweet(
                    $tweet['user_id'],
                    $tweet['content'],
                    $tweet['creation_date'],
                    $tweet['id']
                );

                $tweets[] = $tweetObj;
            }

            return $tweets;
        } else {
            return false;
        }
        
    }

    public function getAllMessages($conn)
    {
        $query = "SELECT * FROM messages WHERE sender_id='{$this->id}'  or addresser_id='{$this->id}' ORDER BY creation_date DESC";

        $result = $conn->query($query);

        if (!$result) {
            die('Error: ' .$conn->error);
        }

        $messages = [];

        if (0 < $result->num_rows) {
            foreach ($result as $message) {
                $messageObj = new Message(
                    $message['sender_id'],
                    $message['addresser_id'],
                    $message['content'],
                    $message['creation_date'],
                    $message['if_read'],
                    $message['id']
                );

                $messages[] = $messageObj;
            }

            return $messages;
        } else {
            return false;
        }

    }

    public function getAllMessagesByUser($conn, $otherUserId)
    {
        $allMessages = $this->getAllMessages($conn);
        $messages = [];
        foreach ($allMessages as $message) {
            if ($message->getSenderId() == $otherUserId or $message->getAddresserId() == $otherUserId) {
                $messages[] = $message;
            }
        }
        return $messages;

    }

    public static function logIn(mysqli $conn, $email, $password)
    {
        $email = $conn->real_escape_string($email);
        $query = "SELECT * FROM users WHERE email='$email'";
        $result = $conn->query($query);
        if (true == $result) {
            if (1 == $result->num_rows) {
                $row = $result->fetch_assoc();
                if (password_verify($password, $row['hashed_password'])) {
                    $user = new User(
                        $row['email'],
                        $row['hashed_password'],
                        $row['description'],
                        $row['is_active'],
                        $row['id']
                    );

                    return $user;
                }
            } else {
                return false;
            }
        }
    }

    public static function getAllUsers(mysqli $conn)
    {
        $query = 'SELECT * FROM users';
        
        $result = $conn->query($query);
        
        if (!$result) {
            die('Error: ' .$conn->error);
        }
        
        $users = [];
        
        foreach ($result as $user) {
            $userObj = new User(
                $user['email'],
                $user['hashed_password'],
                $user['description'],
                $user['is_active'],
                $user['id']
            );
            
            $users[] = $userObj;
        }
        
        return $users;
    }
    
    public static function getUser(mysqli $conn, $id)
    {
        $id = $conn->real_escape_string($id);
        
        $query = "SELECT * FROM users WHERE id = '$id'";
        
        $result = $conn->query($query);
        
        if (!$result) {
            die('Error: ' . $conn->error);
        }
        
        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
        } else {
            return null;
        }
        
        $user = new User(
            $row['email'],
            $row['hashed_password'],
            $row['description'],
            $row['is_active'],
            $row['id']
            );
        
        return $user;
    }
}
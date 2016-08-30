<?php

class Tweet
{
    private $id;
    private $user_id;
    private $text;
    private $creationDate;

    public function __construct($user_id = 0, $text = "", $creationDate = '', $id = -1)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->text = $text;
        $this->creationDate = $creationDate;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function getText()
    {
        return $this->text;
    }

    public function setText($text)
    {
        $this->text = $text;
    }

    public function getCreationDate()
    {
        return $this->creationDate;
    }


    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
    }

    public function save(mysqli $conn)
    {
        if (-1 === $this->id) {
            $query = "INSERT INTO tweets (user_id, content, creation_date)"
                . "VALUES ('{$this->user_id}', '{$this->text}', '{$this->creationDate}')";
            $result = $conn->query($query);

            if(true == $result) {
                $this->id = $conn->insert_id;

                return true;
            } else {
                return false;
            }
        } else {
            $query = "UPDATE tweets SET "
                . "content = {$this->text}"
                . "creation_date = {$this->creationDate}"
                . "WHERE id={$this->id}";

            $result = $conn->query($query);

            return $result;
        }
    }

    public function getAllComments($conn)
    {
        $query = "SELECT * FROM comments WHERE tweet_id='{$this->id}' ORDER BY creation_date DESC";

        $result = $conn->query($query);

        if (!$result) {
            die('Error: ' .$conn->error);
        }

        $comments = [];
        
        if (0 < $result->num_rows) {
            foreach ($result as $comment) {
                $commentObj = new Comment(
                    $comment['user_id'],
                    $comment['tweet_id'],
                    $comment['creation_date'],
                    $comment['content'],
                    $comment['id']
                );

                $comments[] = $commentObj;
            }

            return $comments;
        } else {
            return false;
        }
        
    }

    public static function getTweet($conn, $tweet_id)
    {
        $tweet_id = $conn->real_escape_string($tweet_id);

        $query = "SELECT * FROM tweets WHERE id = '$tweet_id'";

        $result = $conn->query($query);

        if (!$result) {
            die('Error: ' . $conn->error);
        }

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
        } else {
            return null;
        }

        $tweet = new Tweet(
            $row['user_id'],
            $row['content'],
            $row['creation_date'],
            $row['id']
        );

        return $tweet;
    }
}
<?php

class Comment
{
    private $id;
    private $userId;
    private $tweetId;
    private $creationDate;
    private $text;
    
    public function __construct($userId = 0, $tweetID = 0, $creationDate = '', $text = '', $id = -1)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->tweetId = $tweetID;
        $this->creationDate = $creationDate;
        $this->text = $text;
    }
    
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
    }

    public function getCreationDate()
    {
        return $this->creationDate;
    }

    
    public function setText($text)
    {
        $this->text = $text;
    }
    
    public function getText()
    {
        return $this->text;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUserId()
    {
        return $this->userId;
    }
    
    public function getTweetId()
    {
        return $this->tweetId;
    }

    public function save(mysqli $conn)
    {
        if (-1 === $this->id) {
            $query = "INSERT INTO comments (user_id, tweet_id, creation_date, content)"
                . "VALUES ('{$this->userId}', '{$this->tweetId}', '{$this->creationDate}', '{$this->text}')";
            $result = $conn->query($query);
            
            if(true == $result) {
                $this->id = $conn->insert_id;

                return true;
            } else {
                return false;
            }
        } else {
            $query = "UPDATE comments SET "
                . "creation_date = {$this->creationDate}"
                . "content = {$this->text}"
                . "WHERE id={$this->id}";

            $result = $conn->query($query);

            return $result;
        }
    }
}

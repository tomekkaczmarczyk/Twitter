<?php

class Message
{
    private $id;
    private $senderId;
    private $addresserId;
    private $text;
    private $ifRead;
    private $creationDate;


    public function __construct($senderId = -1, $addresserId = -1, $text = "", $creationDate = '', $ifRead = 1, $id = -1)
    {
        $this->id = $id;
        $this->senderId = $senderId;
        $this->addresserId = $addresserId;
        $this->text = $text;
        $this->creationDate = $creationDate;
        $this->ifRead = $ifRead;
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getSenderId()
    {
        return $this->senderId;
    }

    public function getAddresserId()
    {
        return $this->addresserId;
    }
    
    public function getText()
    {
        return $this->text;
    }
    
    public function setText($text)
    {
        $this->text = $text;
    }
    
    public function getIfRead()
    {
        if ($this->ifRead = 0) {
            $read = 'Przeczytana';
        } elseif ($this->ifRead = 1) {
            $read = 'Nieprzeczytana';
        } else {
            $read = 'invalid state';
        }
        
        return $read;
    }

    
    public function setIfRead($ifRead)
    {
        $this->ifRead = $ifRead;
    }
    
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    public function save(mysqli $conn)
    {
        if (-1 === $this->id) {
            $query = "INSERT INTO messages (sender_id, addresser_id, content, creation_date, if_read)"
                . "VALUES ('{$this->senderId}', '{$this->addresserId}', '{$this->text}', "
                . "'{$this->creationDate}', '{$this->ifRead}')";
            $result = $conn->query($query);

            if(true == $result) {
                $this->id = $conn->insert_id;

                return true;
            } else {
                return false;
            }
        } else {
            $query = "UPDATE messages SET "
                . "content = {$this->text}"
                . "creation_date = {$this->creationDate}"
                . "if_read = {$this->ifRead}"
                . "WHERE id={$this->id}";

            $result = $conn->query($query);

            return $result;
        }
    }
    
}
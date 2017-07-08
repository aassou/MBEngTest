<?php

namespace Objects;

class Message
{
    
    //attributes
    
    protected $_originator;
    protected $_recipient;
    protected $_message;


    //constructor
    
    public function __construct($data){
        $this->hydrate($data);
    }

    
    //hydrate : use setters dynamically
    
    public function hydrate($data){
        foreach ($data as $key => $value){
            $method = 'set'.ucfirst($key);
            
            if (method_exists($this, $method)){
                $this->$method($value);
            }
        }
    }


    //setters
    
    public function setOriginator($originator)
    {
        $this->_originator = $originator;
    }

    public function setRecipient($recipient)
    {
        $this->_recipient = $recipient;
    }
    
    public function setMessage($message)
    {
        $this->_message = $message;
    }
    
    
    //getters
    
    public function getOriginator()
    {
        return $this->_originator;
    }

    public function getRecipient()
    {
        return $this->_recipient;
    }

    public function getMessage()
    {
        return $this->_message;
    }

}
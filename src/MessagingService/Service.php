<?php

namespace MessagingService;

class Service
{
        
    //attributes 
    
    private $_key;
    
    //constructor
    
    public function __construct($key)
    {
        $this->setKey($key);
    }
    
    public function validate($data){
        
        $counter = 0;
        foreach ($data as $key => $value) {
            if ( !empty($data[$key]) )
            {
                $counter++;
            }
        }   
        return $counter;
    }
    
    public function createMessage($request)
    {
        $message = '';
        if ( $request['REQUEST_METHOD'] === 'POST' 
            and isset($request['CONTENT_TYPE']) 
            and $request['CONTENT_TYPE'] === 'application/json' )
        {
            $data = json_decode(file_get_contents('php://input'), true);
            if ( $this->validate($data) == 3 ) {
                $message = new \Objects\Message($data);    
            }    
        }
        return $message;
    }



    public function send($request)
    {
        if ( !empty($this->createMessage($request)) )
        {
            $message = $this->createMessage($request);
            $MessageBird = new \MessageBird\Client($this->getKey());
            $Message = new \MessageBird\Objects\Message();
            $Message->originator = $message->getOriginator();
            $Message->recipients = $message->getRecipient();
            $Message->body = $message->getMessage();
            $MessageBird->messages->create($Message);
            echo 'Message Sent Correctly!';    
            return 1;
        }
        else {
            echo 'Something went wrong!';
            return 0;
        }
    }


    public function split($message)
    {
        $strSplit = str_split($message, 157);
        $bytesContent = array();
        foreach ( $strSplit as $key => $value )
        {
            $strlength = strlen($value) + 6; // 6 added for UDH
            $bytesContent[$key] = array();
            $bytesContent[$key][0] = dechex(0x05);
            $bytesContent[$key][1] = dechex(0x00);
            $bytesContent[$key][2] = dechex(0x03);
            $bytesContent[$key][3] = dechex(0xCC);
            $bytesContent[$key][4] = dechex(count($strSplit));
            $bytesContent[$key][5] = dechex($key);
            for ( $i=6, $j=0; $i < $strlength; $i++, $j++ )
            {
                $bytesContent[$key][$i] = dechex(ord($value[$j]));
            }
        }
        
        return $bytesContent;
    }
    
    
    public function conactenate($message)
    {
        $concatenatedMessage = '';
        foreach ( $message as $key => $value )
        {
            $arraylength = count($value);
            for ( $j=6; $j < $arraylength; $j++ )
            {
                $concatenatedMessage .= chr(hexdec($value[$j]));
            }
        }
        
        return $concatenatedMessage;
    } 
    
    //setters
    
    public function setKey($key)
    {
        $this->_key = $key;
    }
    
    
    //getters
    
    public function getKey()
    {
        return $this->_key;
    }
    
}




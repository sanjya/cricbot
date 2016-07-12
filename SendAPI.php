<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SendAPI
 *
 * @author sanjaya
 */
class SendAPI {
    //put your code here
    var $access_token;
    function __construct($access_token) {
        $this->access_token=$access_token;
    }
    
    
    
    function sendTextMessage($recipientId, $messageText) {
    
   
        $data = array("recipient" => array("id"=>$recipientId), 
                         "message" => array("text"=>$messageText));                                                                    
        $data_string = json_encode($data);  

        $this->callSendAPI($data_string);

    }
    
    
    
    
    function callSendAPI($data_string){
        $ch = curl_init("https://graph.facebook.com/v2.6/me/messages?access_token=".$this->access_token);                                                                      
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
            'Content-Type: application/json',                                                                                
            'Content-Length: ' . strlen($data_string))                                                                       
        );                                                                                                                   
        $result = curl_exec($ch);
    }
}

<?php

require './SendAPI.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ReceivedPostBack
 *
 * @author sanjaya
 */
class ReceivedPostBack {
    //put your code here
   
    var $sender_id;
    var $recipient_id;
    var $timestamp;
    var $payload; //array
    var $send_api;
    
    function __construct($message) {
        $this->sender_id=$message['sender']['id'];
        $this->recipient_id= $message['recipient']['id'];
        //$this->timestamp= $message['timestamp'];
        $this->payload= $message['postback']['payload'];
        $this->send_api= new SendAPI(getenv('access_token'));
    }
    
    function handle(){
        
        if(preg_match('[View Score ]', $this->payload)) {
            
            $this->handleViewScore();
        }
        else{
            print "nothing";
        }
    }
    
    function decode(){
        $postback_array= array();
        
    }
    
    function handleViewScore(){
        
        preg_match_all('!\d+!', $this->payload, $matches);
        $match_id=$matches[0][0];
       
        
        
        
        $input= json_decode(file_get_contents("https://cricscore-api.appspot.com/csa?id=$match_id"),true);
        print_r($input);
        
        $summry_enrty= $input[0];
        $this->send_api->sendTextMessage($this->sender_id, $summry_enrty['de']);
        $this->send_api->sendTextMessage($this->sender_id, $summry_enrty['si']);
        
        
		
        
        
    }
    
    
    
    
   

}

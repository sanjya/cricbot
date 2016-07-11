<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ReceivedPostBack
 *
 * @author 
 */
class ReceivedPostBack {
    //put your code here
   
    var $sender_id;
    var $recipient_id;
    var $timestamp;
    var $payload; //array
    
    function __construct($message) {
        $this->sender_id=$message['sender']['id'];
        $this->recipient_id= $message['recipient']['id'];
        //$this->timestamp= $message['timestamp'];
        $this->payload= $message['postback']['payload'];
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
        
        $output_array=array();
        preg_match("/\d/", $this->payload, $output_array);
        
        $match_number= $output_array[0];
        //print $match_number;
        
        $input= json_decode(file_get_contents('https://cricscore-api.appspot.com/csa'),true);
 
 
        if(count($input)==0){
        //no live matches
        //sendTextMessage($recipientId,"Sorry :( There are no live matches\n ");
        }else{
       
	   
        $match_entry= $input[$match_number];
        //print_r($match_entry);
        $match_id= $match_entry['id'];
        
        
        $input= json_decode(file_get_contents("https://cricscore-api.appspot.com/csa?id=$match_id"),true);
        //print_r($input);
        
        $summry_enrty= $input[0];
        $this->sendTextMessage($this->sender_id, $summry_enrty['de']);
        $this->sendTextMessage($this->sender_id, $summry_enrty['si']);
        
        
		
        }
        
    }
    
    
    
    
    function sendTextMessage($recipientId, $messageText) {
    
   
    $data = array("recipient" => array("id"=>$recipientId), 
                     "message" => array("text"=>$messageText));                                                                    
    $data_string = json_encode($data);  

    $this->callSendAPI($data_string);

}
    
    
    
    
    function callSendAPI($data_string){
$ch = curl_init('https://graph.facebook.com/v2.6/me/messages?access_token=EAAIiguQ4fcQBADgTCY78eONR4gly10IGjGaxNWIBLQziIaTnZANZBY8ZA69dixicjfAEw2cbpCaNBE8ZA37kblCpANOadZBtCm27FUSaZCbGMZCc89TmVHx6Xt34qNUZCP27olcX3GPlVZCdikt5TupoRZB488l3jIlS2DJfH63SSSdwZDZD');                                                                      
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

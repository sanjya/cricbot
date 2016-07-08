<?php
$messageText="typing_on";
$recipientId="1084524121623966";
  sendAttach($recipientId);
  
  print "sent";

  /*$data = array("recipient" => array("id"=>$recipientId), 
                     "sender_action"=>$messageText);                                                                    
    $data_string = json_encode($data);  

    callSendAPI($data_string);



/*$url="https://graph.facebook.com/v2.6/$recipientId?access_token=EAAIiguQ4fcQBADgTCY78eONR4gly10IGjGaxNWIBLQziIaTnZANZBY8ZA69dixicjfAEw2cbpCaNBE8ZA37kblCpANOadZBtCm27FUSaZCbGMZCc89TmVHx6Xt34qNUZCP27olcX3GPlVZCdikt5TupoRZB488l3jIlS2DJfH63SSSdwZDZD";
//echo $url;
//echo "\n";
$input=  json_decode(file_get_contents($url));

//print_r($input);
//print $input;
    $messageText="Hi ".$input->last_name;
    echo $messageText; 
    echo $input['last_name'];
    //sendTextMessage($recipientId, $messageText);*/
    
    
   function sendTextMessage($recipientId, $messageText) {
    
   
    $data = array("recipient" => array("id"=>$recipientId), 
                     "message" => array("text"=>$messageText));                                                                    
    $data_string = json_encode($data);  
    callSendAPI($data_string);
}


function sendAttach($recipientId){
  
  $button1=array("type"=>"web_url","title"=>"View Score","payload"=>"this is res");
  $buttons=array($button1);
  $payload= array("template_type"=>"button","text"=>"match description","buttons"=>array());
  $attachment= array("type"=>"template","payload"=>$payload);
  $data = array("recipient" => array("id"=>$recipientId), 
                     "message" => $attachment);
  $data_string = json_encode($data);  
  callSendAPI($data_string);
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

?>

<?php

echo getenv('VERIFY_TOKEN');
print "env\n";

$button1= array("type"=>"postback","title"=>"View Score","payload"=>"view_score_match_id:") ;
$buttons= array($button1);

$payload=array("template_type"=>"button","text"=>"Match name","buttons"=>$buttons);

$attachment=array("type"=>"template","payload"=>$payload);

$messageData= array("recipient"=>"1084524121623966", "message"=>array("attachment"=>$attachment));


$data= json_encode($messageData);
callSendAPI($data);

print "sent";

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

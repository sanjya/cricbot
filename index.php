<?php
$access_token="EAAIiguQ4fcQBADgTCY78eONR4gly10IGjGaxNWIBLQziIaTnZANZBY8ZA69dixicjfAEw2cbpCaNBE8ZA37kblCpANOadZBtCm27FUSaZCbGMZCc89TmVHx6Xt34qNUZCP27olcX3GPlVZCdikt5TupoRZB488l3jIlS2DJfH63SSSdwZDZD";
$verify_token="my_bot";
$hub_verify_token="null";
if(isset($_REQUEST['hub_challenge'])){
$challenge= $_REQUEST['hub_challenge'];
$hub_verify_token= $_REQUEST['hub_verify_token'];
}
if($hub_verify_token==$verify_token){
echo $challenge;
}
$input = json_decode(file_get_contents('php://input'), true);
// Make sure this is a page subscription
  if ($input['object'] == 'page') {
    // Iterate over each entry
    // There may be multiple if batched
      
    $entries= $input['entry'];
    
    foreach ($entries as $entry) {
        
        $messages= $entry['messaging'];
        foreach ($messages as $message) {
            
            //need to check message event type, but this app is only subcribed to "message" event 
            receivedMessage($message);
        }
    }
  }
 
  
  
/*
$sender = $input['entry'][0]['messaging'][0]['sender']['id'];
$message = $input['entry'][0]['messaging'][0]['message']['text'];
if(preg_match('[time|current time|now]', strtolower($message))) {
 
    // Make request to Time API
    ini_set('user_agent','Mozilla/4.0 (compatible; MSIE 6.0)');
    $result = file_get_contents("http://www.timeapi.org/utc/now?format=%25a%20%25b%20%25d%20%25I:%25M:%25S%20%25Y");
    if($result != '') {
        $message_to_reply = $result;
    }
} else {
    $message_to_reply = 'Huh! what do you mean?';
}
print $message_to_reply;
$url = 'https://graph.facebook.com/v2.6/me/messages?access_token='.$access_token;
 
 
//Initiate cURL.
$ch = curl_init($url);
 
//The JSON data.
$jsonData = '{
    "recipient":{
        "id":"'.$sender.'"
    },
    "message":{
        "text":"'.$message_to_reply.'"
    }
}';
 
//Encode the array into JSON.
$jsonDataEncoded = json_encode($jsonData);
 
$data = array("recipient" => array("id"=>"1084524121623966"), "message" => array("text"=>"hi hi hi"));                                                                    
$data_string = json_encode($data);                                                                                   
$ch = curl_init('https://graph.facebook.com/v2.6/me/messages?access_token=EAAIiguQ4fcQBADgTCY78eONR4gly10IGjGaxNWIBLQziIaTnZANZBY8ZA69dixicjfAEw2cbpCaNBE8ZA37kblCpANOadZBtCm27FUSaZCbGMZCc89TmVHx6Xt34qNUZCP27olcX3GPlVZCdikt5TupoRZB488l3jIlS2DJfH63SSSdwZDZD');                                                                      
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);                                                                  
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
    'Content-Type: application/json',                                                                                
    'Content-Length: ' . strlen($data_string))                                                                       
);                                                                                                                   
$result = curl_exec($ch);*/
 
//Execute the request
/*if(!empty($input['entry'][0]['messaging'][0]['message'])){
    $result = curl_exec($ch);
echo "done";
}*/
 function receivedMessage($event){
   $senderID = $event['sender']['id'];
   $recipientID = $event['recipient']['id'];
   $timeOfMessage = $event['timestamp'];
   $message = $event['message'];
  /*console.log("Received message for user %d and page %d at %d with message:", 
    senderID, recipientID, timeOfMessage);
  console.log(JSON.stringify(message));*/
   $messageId = $message['mid'];
   $seq= $message['seq'];
  // You may get a text or attachment but not both
   $messageText = $message['text'];
   $messageAttachments = $message['attachments'];
  
  if ($messageText) {
    // If we receive a text message, check to see if it matches any special
    // keywords and send back the corresponding example. Otherwise, just echo
    // the text we received.
    
    $messageText="hi";
    switch ($messageText) {
      case "hi":
        sendWelcomeMessage($senderID);
        break;
      case 'button':
        sendButtonMessage($senderID);
        break;
      case 'generic':
        sendGenericMessage($senderID);
        break;
      case 'receipt':
        sendReceiptMessage($senderID);
        break;
      case 'help':
        $messageText="type ";
        sendReceiptMessage($senderID);
        break;
        
      default:
        $messageText= "Sorry for rebellion \n type help to suppress";
        sendTextMessage($senderID, $messageText);
    }
  } elseif ($messageAttachments) {
    sendTextMessage($senderID, "Message with attachment received");
  }
  }
  
  
  
function sendWelcomeMessage($recipientId){
    
    $input=  json_decode(file_get_contents("https://graph.facebook.com/v2.6/$recipientId?access_token=EAAIiguQ4fcQBADgTCY78eONR4gly10IGjGaxNWIBLQziIaTnZANZBY8ZA69dixicjfAEw2cbpCaNBE8ZA37kblCpANOadZBtCm27FUSaZCbGMZCc89TmVHx6Xt34qNUZCP27olcX3GPlVZCdikt5TupoRZB488l3jIlS2DJfH63SSSdwZDZD"));
    $messageText="Hi ".$input->first_name';
    sendTextMessage($recipientId, $messageText);
}


function sendTextMessage($recipientId, $messageText) {
    $data = array("recipient" => array("id"=>$recipientId), 
                     "message" => array("text"=>$messageText));                                                                    
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

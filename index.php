<?php

require './ReceivedPostBack.php';


$access_token=getenv('access_token');
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
        //1084524121623966
        $messages= $entry['messaging'];


        foreach ($messages as $message) {
            
            //need to check message event type, but this app is only subcribed to "message" event 
            $keys = array_keys($message); //sender,recipient,event_name('postback','message')
            $event = end($keys);
            
            

            if($event=="message"){
              
              receivedMessage($message);
            }
            else if($event=="postback"){
              
              $postback= new ReceivedPostBack($message);
              $postback->handle();
              
            }

            
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
   //$messageAttachments = $message['attachments'];

  
  if ($messageText) {

    // If we receive a text message, check to see if it matches any special
    // keywords and send back the corresponding example. Otherwise, just echo
    // the text we received.
	
	print $messageText;
	
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

      case 'image':
        sendImage($senderID);
        break;
    
      case "help":
        $messageText="Type keywords and choose from showed options.\ne.g.\nlast SriLanka match\nlive games\n";
		print $messageText;
        sendTextMessage($senderID,$messageText);
        break;
    
      case "live":
      	//sendAction($senderID);
        sendLiveMessage($senderID);
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
    
    $input=  json_decode(file_get_contents("https://graph.facebook.com/v2.6/".$recipientId."?access_token=".getenv('access-token')),true);
    $messageText="Hi ".$input['first_name'];
    sendTextMessage($recipientId, $messageText);
	//print $messageText;
}
function sendLiveMessage($recipientId){
    
    $input= json_decode(file_get_contents('https://cricscore-api.appspot.com/csa'),true);
 
 
    if(count($input)==0){
      //no live matches
       sendTextMessage($recipientId,"Sorry :( There are no live matches\n ");
    }else{
       
	   $messageText="";
	   $count=0;
        foreach ($input as $entry) {
			$count++;
            $messageText="Match $count ".$entry['t2']." vs ".$entry['t1']."\n ";
            $id=$entry['id'];

             $button= array("type"=>"postback","title"=>"View Score match ","payload"=>"View Score $id") ;
            sendButtonMessage($recipientId,$entry['t2']." vs ".$entry['t1'],$button);
        }
        
        //$messageText="Type Match Number to get the live score ;)";
        //sendTextMessage($recipientId, $messageText);
		
    }
    
} 




function sendTextMessage($recipientId, $messageText) {
    
   
    $data = array("recipient" => array("id"=>$recipientId), 
                     "message" => array("text"=>$messageText));                                                                    
    $data_string = json_encode($data);  

    callSendAPI($data_string);

}


function sendAction($recipientId){

  $messageText="typing_on";
  
  $data = array("recipient" => array("id"=>$recipientId), 
                     "sender_action"=>$messageText);                                                                    
  $data_string = json_encode($data);  

  callSendAPI($data_string);
    

}




function sendImage($recipientId){
  //array("type"=>"image","payload"=>array("url"=>"https://petersapparel.com/img/shirt.png"))
  //$payload= array("url"=>"https://petersapparel.com/img/shirt.png");
   //$attachment= array("type"=>"image","payload"=>$payload);
  $data = array("recipient" => array("id"=>$recipientId), 
                 "message" =>  array("attachment"=>array(
                 					"type"=>"image",
                 					"payload"=>array("url"=>"http://i.imgci.com/espncricinfo/ci_apple_webclip.png")))
                 
                 
                 );
  $data_string = json_encode($data);  
  callSendAPI($data_string);
}


function sendButtonMessage($recipientId,$payload_text,$button){
  
           
            $buttons= array($button);

            $payload=array("template_type"=>"button","text"=>$payload_text,"buttons"=>$buttons);

            $attachment=array("type"=>"template","payload"=>$payload);

            $messageData= array("recipient"=>array("id"=>"1084524121623966"), "message"=>array("attachment"=>$attachment));


            $data= json_encode($messageData);

            //print_r(json_decode($data));

            callSendAPI($data);

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

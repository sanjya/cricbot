<?php
$input= json_decode(file_get_contents('https://cricscore-api.appspot.com/csa'),true);
    
    if(count($input)==0){
      //no live matches
      sendTextMessage($recipientId, "Sorry :( There are no live matches\n ");
    }else{
       
	   $messageText="";
	   $count=0;
        foreach ($input as $entry) {
			$count++;
            $messageText.="Match $count ".$entry['t2']." vs ".$entry['t1']."\n ";
        }
        
        sendTextMessage($recipientId, $messageText);
		print $messageText;
    }


$recipientId="1084524121623966";
$url="https://graph.facebook.com/v2.6/$recipientId?access_token=EAAIiguQ4fcQBADgTCY78eONR4gly10IGjGaxNWIBLQziIaTnZANZBY8ZA69dixicjfAEw2cbpCaNBE8ZA37kblCpANOadZBtCm27FUSaZCbGMZCc89TmVHx6Xt34qNUZCP27olcX3GPlVZCdikt5TupoRZB488l3jIlS2DJfH63SSSdwZDZD";
//echo $url;
//echo "\n";
$input=  json_decode(file_get_contents($url));

//print_r($input);
//print $input;
    $messageText="Hi ".$input->last_name;
    echo $messageText; 
    echo $input['last_name'];
    //sendTextMessage($recipientId, $messageText);
?>

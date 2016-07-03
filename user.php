<?php
$input= json_decode(file_get_contents('https://cricscore-api.appspot.com/csa'));
 print_r($input);
print $input;   
    /*if(count($input)==0){
      //no live matches
      echo "Sorry :( There are no live matches\n ";
    }else{
       
        foreach ($input as $entry) {
            $messageText.="Match 1 ".$entry['t2']." vs ".$entry['t1']."\n ";
        }
        
        echo $messageText;
    }*/


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

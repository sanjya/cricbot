<?php
$recipientId="1084524121623966";
$url="https://graph.facebook.com/v2.6/".$recipientId."?access_token=EAAIiguQ4fcQBADgTCY78eONR4gly10IGjGaxNWIBLQziIaTnZANZBY8ZA69dixicjfAEw2cbpCaNBE8ZA37kblCpANOadZBtCm27FUSaZCbGMZCc89TmVHx6Xt34qNUZCP27olcX3GPlVZCdikt5TupoRZB488l3jIlS2DJfH63SSSdwZDZD";
//echo $url;
$input=  json_decode(file_get_contents());

print_r($input);
print $input;
    $messageText="Hi ".$input['first_name'];
    echo $messageText; 
    //sendTextMessage($recipientId, $messageText);
?>

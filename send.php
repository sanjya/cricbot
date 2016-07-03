<?php 

// is cURL installed yet?
    if (!function_exists('curl_init')){
        echo "curl is not available";
    }
	
 $msg = "Test message";

// use wordwrap() if lines are longer than 70 characters
$msg = wordwrap($msg,70);

// send email
mail("sanjayanuwanaj@gmail.com","My subject",$msg);


$data = array("recipient" => array("id"=>"1084524121623966"), "message" => array("text"=>"hi hi hi"));                                                                    
$data_string = json_encode($data);                                                                                   
$ch = curl_init('https://graph.facebook.com/v2.6/me/messages?access_token=EAAIiguQ4fcQBADgTCY78eONR4gly10IGjGaxNWIBLQziIaTnZANZBY8ZA69dixicjfAEw2cbpCaNBE8ZA37kblCpANOadZBtCm27FUSaZCbGMZCc89TmVHx6Xt34qNUZCP27olcX3GPlVZCdikt5TupoRZB488l3jIlS2DJfH63SSSdwZDZD');                                                                      
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
    'Content-Type: application/json',                                                                                
    'Content-Length: ' . strlen($data_string))                                                                       
);                                                                                                                   

$result = curl_exec($ch);

echo $result;

?>

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


?>

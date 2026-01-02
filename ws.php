<?php
   if( $_GET["mensaje"] ) {
        $curl = curl_init('https://api.pushbullet.com/v2/pushes');

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Authorization: Bearer o.ZItfqC2vlWXvogW3LuaBHgntP633Bifa']);
        curl_setopt($curl, CURLOPT_POSTFIELDS, ["email" => $email, "type" => "link", "title" => "Push notifications", "body" => $_GET["mensaje"], "url" => ""]);
        
        // UN-COMMENT TO BYPASS THE SSL VERIFICATION IF YOU DON'T HAVE THE CERT BUNDLE (NOT RECOMMENDED).
        // curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        
        $response = curl_exec($curl);
        
        print_r($response);
   }
?>


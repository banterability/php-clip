<?php

$file = "last_tweet.txt";

if(!file_exists($file)){
    $since_id = 0;
} else {
    $handle = fopen($file, 'r');
    
    if(filesize($file)==0){
        $since_id = 0;
    } else {
        $since_id = fread($handle, filesize($file));
    }
    fclose($handle);    
}

# move credentials to include

require 'cred.php';
$url = "http://twitter.com/direct_messages.xml?since_id=$since_id";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_USERAGENT, 'Clipd/1.0');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($ch, CURLOPT_USERPWD, "$usr:$pwd");

$xml = curl_exec($ch);
curl_close($ch);

$response = simplexml_load_string($xml);
    
# are there any?

if (isset($response->direct_message)){
    
    foreach ($response->direct_message as $dm){

        $submit_url= 'http://banterability.com/clip/';
            
        $ch = curl_init($submit_url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'u=null&t='.urlencode("Twitter clip").'&s='.urlencode($dm->text));
        curl_exec($ch);
        curl_close($ch);
                        
        if(($dm->id)>$since_id){
            $since_id = $dm->id;
        }
      }

      $handle = fopen($file, 'w+');
      fwrite($handle, $since_id);
      fclose($handle);
} else {
    echo 'nothing to do.';
}
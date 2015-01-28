<?php
include "rb.php";
include "config.php"; 

R::setup("mysql:host=$host;dbname=$dbname", $user, $pass);



function cache_url($url, $skip_cache = false, $post = false) {
    // settings
    $cachetime = 43200; // 6 hours
   /* $where = "cache";
    if ( ! is_dir($where)) {
        mkdir($where);
    }*/
    
    $hash = md5($url.$post);
    $file = "$where/$hash.cache";
    
    // check the bloody file.
    $mtime = 0;
    if (file_exists($file)) {
        $mtime = filemtime($file);
    }
    $filetimemod = $mtime + $cachetime;
    
    // if the renewal date is smaller than now, return true; else false (no need for update)
    if ($filetimemod < time() OR $skip_cache) {
        $ch = curl_init($url);
        curl_setopt_array($ch, array(
            CURLOPT_HEADER         => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS     => "deviceid=&reallat=44.44178480525191&timestamp=1419101507216&mcc=226&mnc=10&lat=44.44178483809404&lang=en&os=ios&version=2.1.6&versioncode=2510&account_id=&token=&lng=26.13587681204081&hash=%619c1048%61b7d3c33fbfdb0b715b0d8b5c&reallng=26.13587681598318&target_cids=%5B5%2C9%2C20%2C64%2C22%2C12%2C76%2C62%2C13%2C8%2C27%2C40%2C55%2C74%2C75%2C29%2C63%2C7%2C61%5D",
            CURLOPT_USERAGENT      => 'CleverTaxi/510 CFNetwork/711.1.12 Darwin/14.0.0',
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS      => 5,
            CURLOPT_CONNECTTIMEOUT => 15,
            CURLOPT_TIMEOUT        => 30,
        ));
        $data = curl_exec($ch);
        curl_close($ch);
        
        // save the file if there's data
        if ($data AND ! $skip_cache) {
            file_put_contents($file, $data);
        }
    } else {
        $data = file_get_contents($file);
    }
    
    return $data;
}

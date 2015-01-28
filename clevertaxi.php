<?php
include "kernel/bootstrap.php";
$expireTime = time() + 60;
while (time() < $expireTime) {
/*    
$url = "http://c16f8146f54f2i.uservoice.ro/api/users/getDriversInArea?user_id=1&t=&radius=2000000000000&h=&long=26.1026305&lng=en&lat=44.4354644&session_key=1";
*/
$taxi = cache_url("https://app2.clevertaxi.com/webservice2/getCarPositions.php", true, true);



    $taxi = json_decode($taxi, true);

    $i = 0;
    foreach ($taxi["cars"] as $soferi){


    $data = R::dispense('clevertaxi');
    $data->lat  =  $soferi["a"];
    $data->long =  $soferi["n"];
    //$data->busy  = $soferi["busy"];
    $data->datetime  = date( 'Y-m-d H:i:s');

    R::store($data);
    $i++;
    }
    
    R::close();

    print "done, $i records\n"; 


    sleep(10); 

}






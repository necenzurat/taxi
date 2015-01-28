<?php
include "kernel/bootstrap.php";
$expireTime = time() + 60;
while (time() < $expireTime) {
	
$url = "http://c16f8146f54f2i.uservoice.ro/api/users/getDriversInArea?user_id=1&t=&radius=2000000000000&h=&long=26.1026305&lng=en&lat=44.4354644&session_key=1";


	$taxi = json_decode(file_get_contents($url), true);

	$i = 0;
	foreach ($taxi["params"]["drivers"] as $soferi){

	$data = R::dispense('startaxi');
	$data->lat 	=  $soferi["lat"];
	$data->long =  $soferi["long"];
	$data->ppkm =  $soferi["ppkm"];
	$data->ppkmn = $soferi["ppkmn"];
	$data->busy  = $soferi["busy"];
	$data->datetime  = date( 'Y-m-d H:i:s');

	R::store($data);
	$i++;
	}
	
	R::close();

	print "done, $i records\n"; 


     sleep(10); 

}
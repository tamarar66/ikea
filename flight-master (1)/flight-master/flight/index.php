<?php
require 'flight/Flight.php';
require 'jsonindent.php';


Flight::route('/', function(){

	die("");
});

Flight::register('db', 'Database', array('flightNiz'));
$json_podaci = file_get_contents("php://input");
Flight::set('json_podaci', $json_podaci );


Flight::route('GET /taskovi.json', function()
{
	header("Content-Type: application/json; charset=utf-8");
	$db = Flight::db();
	$db->taskovi();

	$niz =  array();
	$iterator = 0;
	while ($red = $db->getResult()->fetch_object())
	{
		$niz[$iterator] = $red;
		$iterator += 1;
	}

	echo json_encode($niz);
});



Flight::route('POST /unesiAdmina.json', function()
{
	header("Content-Type: application/json; charset=utf-8");
	$db = Flight::db();
	$post_data = file_get_contents('php://input');
	$json_data = json_decode($post_data,true);


	$db->unesiAdmina($json_data);
	if($db->getResult())
	{
		$response = "OK";
	}
	else
	{
		$response = "Desila se greska";

	}

	echo indent(json_encode($response));

});

/*Flight::route('DELETE /korisnik@id', function($id){
	header ("Content-Type: application/json; charset=utf-8");
	$db = Flight::db();
	if ($db->delete($id)){
			$odgovor["poruka"] = "OK";
			$json_odgovor = json_encode ($odgovor,JSON_UNESCAPED_UNICODE);
			echo $json_odgovor;
			
	} else {
			$odgovor["poruka"] = "Neuspelo brisanje";
			$json_odgovor = json_encode ($odgovor,JSON_UNESCAPED_UNICODE);
			echo $json_odgovor;
			
	
	}		
			
});*/
Flight::route('DELETE /users/@id', function($id){
	header ("Content-Type: application/json; charset=utf-8");
	$db = Flight::db();
	if ($db->delete("users", array("id"),array($id))){
			$response = "OK";
		}
		else
		{
			$response = "Desila se greska";
	
		}
	
		echo indent(json_encode($response));
			
});




Flight::start();
?>
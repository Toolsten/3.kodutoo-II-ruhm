<?php
	require("../../../config.php");
	require("Helper.class.php");
	require("Scores.class.php");
	require("User.class.php");
	require("Interest.class.php");
	// functions.php
	//var_dump($GLOBALS);
	
	//ühendus
	$database = "if16_StenT_2";
	$mysqli = new mysqli($serverHost, $serverUsername, $serverPassword, $database);

	$User = new User($mysqli);
	$Scores = new Scores($mysqli);
	$Helper = new Helper($mysqli);
	$Interest = new Interest($mysqli);
	
	
	// functions.php
	//var_dump($GLOBALS);
	
	// see fail, peab olema kõigil lehtedel kus 
	// tahan kasutada SESSION muutujat
	
	//***************
	//**** SIGNUP ***
	//***************
	// see fail, peab olema kõigil lehtedel kus 
	// tahan kasutada SESSION muutujat
	session_start();
	
	//***************
	//**** SIGNUP ***
	//***************
	
	
	


?>
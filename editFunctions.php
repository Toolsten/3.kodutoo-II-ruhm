<?php

	require_once("../../../config.php");
	
	function getSingleScoreData($edit_id){
    
        $database = "if16_StenT_2";

		//echo "id on ".$edit_id;
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
		
		$stmt = $mysqli->prepare("SELECT leaguename, hometeam, awayteam, homescore, awayscore FROM savedScores WHERE id=? AND deleted IS NULL");

		$stmt->bind_param("i", $edit_id);
		$stmt->bind_result($leaguename, $hometeam, $awayteam, $homescore, $awayscore);
		$stmt->execute();
		
		//tekitan objekti
		$scores = new Stdclass();
		
		//saime ühe rea andmeid
		if($stmt->fetch()){
			// saan siin alles kasutada bind_result muutujaid
			$scores->leaguename = $leaguename;
			$scores->hometeam = $hometeam;
			$scores->awayteam = $awayteam;
			$scores->homescore = $homescore;
			$scores->awayscore = $awayscore;
			
			
		}else{
			// ei saanud rida andmeid kätte
			// sellist id'd ei ole olemas
			// see rida võib olla kustutatud
			header("Location: data.php");
			exit();
		}
		
		$stmt->close();
		$mysqli->close();
		
		return $scores;
		
	}


	function UpdateScores($id, $leaguename, $hometeam, $awayteam, $homescore, $awayscore){
    	
        $database = "if16_StenT_2";

		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
		
		$stmt = $mysqli->prepare("UPDATE savedScores SET leaguename=?, hometeam=?, awayteam=?, homescore=?, awayscore=? WHERE id=? AND deleted IS NULL");
		$stmt->bind_param("sssiii",$leaguename, $hometeam, $awayteam, $homescore, $awayscore, $id);
		
		// kas õnnestus salvestada
		if($stmt->execute()){
			// õnnestus
			echo "salvestus õnnestus!";
		}
		
		$stmt->close();
		$mysqli->close();
		
	}
	
	function kustuta($id){
		
		$database = "if16_StenT_2";

		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
		
		$stmt = $mysqli->prepare("UPDATE savedScores SET deleted=NOW() WHERE id=? AND deleted IS NULL");
		$stmt->bind_param("i",$id);
		
		// kas õnnestus salvestada
		if($stmt->execute()){
			// õnnestus
			echo "kustutamine õnnestus";
		}
		
		$stmt->close();
		$mysqli->close();
		
		
		
		
		
		
	}
	
?>
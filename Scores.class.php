<?php
class Scores {
	
	
	private $connection;
	
	
	function __construct($mysqli){
		//This viitab klassile(this == user)
		$this->connection = $mysqli;
		
	}
	
	function saveScores ($league, $hometeam, $awayteam, $homescore, $awayscore) {
		
		$database = "if16_StenT_2";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
		$stmt = $mysqli->prepare("INSERT INTO savedScores (leaguename, hometeam, awayteam, homescore, awayscore) VALUES (?, ?, ?, ?, ?)");
	
		echo $mysqli->error;
		
		$stmt->bind_param("sssii", $league, $hometeam, $awayteam, $homescore, $awayscore);
		
		if($stmt->execute()) {
			echo "salvestamine õnnestus";
		} else {
		 	echo "ERROR ".$stmt->error;
		}
		
		$stmt->close();
		$mysqli->close();
		
	}
	
	function getAllScores() {
		
		$database = "if16_StenT_2";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
		
		$stmt = $mysqli->prepare("
			SELECT id, leaguename, hometeam, awayteam, homescore, awayscore
			FROM savedScores
		");
		echo $mysqli->error;
		
		$stmt->bind_result($id, $league, $hometeam, $awayteam, $homescore, $awayscore);
		$stmt->execute();
		
		
		//tekitan massiivi
		$result = array();
		
		// tee seda seni, kuni on rida andmeid
		// mis vastab select lausele
		while ($stmt->fetch()) {
			
			//tekitan objekti
			$scores = new StdClass();
			
			$scores->id = $id;
			$scores->league = $league;
			$scores->hometeam = $hometeam;
			$scores->awayteam = $awayteam;
			$scores->homescore = $homescore;
			$scores->awayscore = $awayscore;
			
			
			array_push($result, $scores);
		}
		
		$stmt->close();
		$mysqli->close();
		
		return $result;
	}
	
	function get($q, $sort, $direction) {
		
		//mis sort ja järjekord
		$allowedSortOptions = ["id", "leaguename", "hometeam"];
		//kas sort on lubatud valikute sees
		if(!in_array($sort, $allowedSortOptions)) {
			$sort = "id";
		}
		
		echo "sorteerin :".$sort." ";
		//TURVALISELT LUBAN AINULT 2 VALIKUT
		$orderBy = "ASC";
		if($direction == "descending") {
			$orderBy = "DESC";
		}
		echo "Järjekord: ".$orderBy." ";
		
		if($q == ""){
		echo "ei otsi";
		
		$stmt = $this->connection->prepare("
			SELECT id, leaguename, hometeam, awayteam, homescore, awayscore
			FROM savedScores WHERE deleted IS NULL ORDER BY $sort $orderBy
		");
		} else {
			echo "otsib: ".$q;
			
			//teen otsisõna
			//lisan mõlemale poole "%"
			$searchword = "%".$q."%";
			
			$stmt = $this->connection->prepare("
			SELECT id, leaguename, hometeam, awayteam, homescore, awayscore
			FROM savedScores WHERE deleted IS NULL AND 
			(leaguename LIKE ? OR hometeam LIKE ?)
			ORDER BY $sort $orderBy
		");
			$stmt->bind_param("ss", $searchword, $searchword);
		}
		
		
		echo $this->connection->error;
		
		$stmt->bind_result($id, $leaguename, $hometeam, $awayteam, $homescore, $awayscore);
		$stmt->execute();
		
		
		//tekitan massiivi
		$result = array();
		
		// tee seda seni, kuni on rida andmeid
		// mis vastab select lausele
		while ($stmt->fetch()) {
			
			//tekitan objekti
			$scores = new StdClass();
			
			$scores->id = $id;
			$scores->leaguename = $leaguename;
			$scores->hometeam = $hometeam;
			$scores->awayteam = $awayteam;
			$scores->homescore = $homescore;
			$scores->awayscore = $awayscore;
			
			//echo $plate."<br>";
			// iga kord massiivi lisan juurde nr märgi
			array_push($result, $scores);
		}
		
		$stmt->close();
		
		
		return $result;
	}
	
	
	
	
	
	
}



?>
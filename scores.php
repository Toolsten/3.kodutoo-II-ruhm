<?php

	require("functions.php");
	
	
	$leaguenameError = "";
	$hometeamError = "";
	$awayteamError = "";
	$homescoreError = "";
	$awayscoreError = "";
	
	
	//kui ei ole kasutaja id'd
	if (!isset($_SESSION["userId"])){
		
		//suunan sisselogimise lehele
		header("Location: login.php");
		exit();
	}
	
	
	//kui on ?logout aadressireal siis login välja
	if (isset($_GET["logout"])) {
		
		session_destroy();
		header("Location: login.php");
		exit();
	}
	
	$msg = "";
	if(isset($_SESSION["message"])){
		$msg = $_SESSION["message"];
		
		//kui ühe näitame siis kustuta ära, et pärast refreshi ei näitaks
		unset($_SESSION["message"]);
	}
	
		if( isset( $_POST["league"] ) ){
		
		if(empty( $_POST["league"] ) ){
			
			$leaguenameError = "See väli on kohustuslik";
			//$LeaguenameError = $_POST["leaguename"];
			
		}
		
	}
	
	if(isset($_GET["q"]) && isset($_GET["direction"])){
		$sort = ($_GET["sort"]);
		$direction = ($_GET["direction"]);
	} else {
		//kui ei ole määratyd, siis vaikimis id ja ASC
		$sort = "id";
		$direction = "ascending";
		
	}
	
	if(isset($_GET["q"])){
		
		$q = $Helper->cleaninput($_GET["q"]);
		
		$scoreData = $Scores->get($q, $sort, $direction);
		
	} else {
		$q = "";
		$scoreData = $Scores->get($q, $sort, $direction);	
			
	}
	
	
	if( isset( $_POST["hometeam"] ) ){
		
		if(empty( $_POST["hometeam"] ) ){
		
			$hometeamError = "See väli on kohustuslik";
			
		}
		
	} 
	
	if( isset( $_POST["awayteam"] ) ){
		
		if(empty( $_POST["awayteam"] ) ){
		
			$awayteamError = "See väli on kohustuslik";
			
		}
		
	} 
	
	if( isset( $_POST["homescore"] ) ){
		
		if(empty( $_POST["homescore"] ) ){
		
			$homescoreError = "See väli on kohustuslik";
			
		}
		
	} 
	
	if( isset( $_POST["awayscore"] ) ){
		
		if(empty( $_POST["awayscore"] ) ){
		
			$awayscoreError = "See väli on kohustuslik";
			
		}
		
	} 

	
if  (isset($_POST["league"]) && 
		isset($_POST["hometeam"]) && 
		isset($_POST["awayteam"]) && 
		isset($_POST["homescore"]) && 
		isset($_POST["awayscore"]) &&  
		!empty($_POST["league"]) &&
		!empty($_POST["hometeam"]) && 		
		!empty($_POST["awayteam"]) && 
		!empty($_POST["homescore"]) && 
		!empty($_POST["awayscore"]) 
	)	{
		  
		$Scores->saveScores($Helper->cleanInput($_POST["league"]), $Helper->cleanInput($_POST["hometeam"]), $Helper->cleanInput($_POST["awayteam"]), $Helper->cleanInput($_POST["homescore"]), $Helper->cleanInput($_POST["awayscore"]));
		header("Location: scores.php");
	  }


	$scores = $Scores->getAllScores();
	
	
	





?>

<html>
<h2>SaveScore</h2>
<h2><a href="data.php"> < tagasi</a></h2>

<form method="POST">
	
	<label>League</label><br>
	<input name="league" type="text"><?php echo $leaguenameError; ?>
	<br><br>
	
	<label>Home Team</label><br>
	<input type="text" name="hometeam" ><?php echo $hometeamError; ?>
	<br><br>
	
	<label>Away Team</label><br>
	<input name="awayteam" type="text"><?php echo $awayteamError; ?>
	<br><br>
	
	<label>Home Score</label><br>
	<input name="homescore" type="text"><?php echo $homescoreError; ?>
	<br><br>
	
	<label>Away Score</label><br>
	<input name="awayscore" type="text"><?php echo $awayscoreError; ?>
	<br><br>
	
	<input type="submit" value="Salvesta">
	
	
</form>
        <?php
            
    $html = "<table>";
	
	$html .= "<tr>";
		$html .= "<th>id</th>";
		$html .= "<th>leaguename</th>";
		$html .= "<th>hometeam</th>";
		$html .= "<th>awayteam</th>";
		$html .= "<th>homescore</th>";
		$html .= "<th>awayscore</th>";
	$html .= "</tr>";
	
	
	foreach($scores as $s){
		
		
		$html .= "<tr>";
			$html .= "<td>".$s->id."</td>";
			$html .= "<td>".$s->league."</td>";
			$html .= "<td>".$s->hometeam."</td>";
			$html .= "<td>".$s->awayteam."</td>";
			$html .= "<td>".$s->homescore."</td>";
			$html .= "<td>".$s->awayscore."</td>";	
		$html .= "</tr>";
	};
	
	$html .= "</table>";
	
	//echo $html;
	
	$listHtml = "<br><br>";
	

	
	echo $listHtml;
            
        ?>
    </select>

<form>
	<input type="search" name="q" value=><?=$q?>
	<input type="submit" value="Otsi">
</form>
<?php 
	
	$direction = "ascending";
	if (isset($_GET["direction"])){
		if ($_GET["direction"] == "ascending"){
			$direction = "descending";
		}
	}
	
	$html = "<table class='table  table-bordered table-hover'>";
	
	$html .= "<tr>";
		$html .= "<th>
		<a href='?q=".$q."&sort=id&direction=".$direction."'>
		id
		</a>
		</th>";
		$html .= "<th>
		<a href='?q=".$q."&sort=leaguename&direction=".$direction."'>
		leaguename
		</a>
		</th>";
		$html .= "<th>
		<a href='?q=".$q."&sort=hometeam&direction=".$direction."'>
		hometeam
		</a>
		</th>";
		$html .= "<th>
		<a href='?q=".$q."&sort=awayteam&direction=".$direction."'>
		awayteam
		</a>
		</th>";
		$html .= "<th>
		<a href='?q=".$q."&sort=homescore&direction=".$direction."'>
		homescore
		</a>
		</th>";
		$html .= "<th>
		<a href='?q=".$q."&sort=awayscore&direction=".$direction."'>
		awayscore
		</a>
		</th>";
	$html .= "</tr>";
	
	//iga liikme kohta massiivis
	foreach($scoreData as $c){
		// iga auto on $c
		//echo $c->plate."<br>";
		
		$html .= "<tr>";
			$html .= "<td>".$c->id."</td>";
			$html .= "<td>".$c->leaguename."</td>";         
			$html .= "<td>".$c->hometeam."</td>";
			$html .= "<td>".$c->awayteam."</td>";
			$html .= "<td>".$c->homescore."</td>";
			$html .= "<td>".$c->awayscore."</td>";
			//$html .= "<td style='background-color:".$c->hometeam."'>".$c->hometeam."</td>";
			$html .= "<td><a href='edit.php?id=".$c->id."' class='btn btn=default' ><span class='glyphicon glyphicon-pencil'</span>Muuda</a></td>";
			
		$html .= "</tr>";
	}
	
	$html .= "</table>";
	
	echo $html;
	
	
	$listHtml = "<br><br>";
	
	foreach($scoreData as $c){
		
		
		$listHtml .= "<h1 style='text:".$c->hometeam."'>".$c->leaguename."</h1>";
		$listHtml .= "<p>color = ".$c->hometeam."</p>";
	}
	
	//echo $listHtml;
	
	
	

?>

    
	
</form>
</html>


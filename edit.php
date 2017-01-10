<?php
	//edit.php
	require("functions.php");
	require("editFunctions.php");
	
	//kas kasutaja uuendab andmeid
	if(isset($_POST["update"])){
		
		UpdateScores($Helper->cleanInput($_POST["id"]), $Helper->cleanInput($_POST["leaguename"]), $Helper->cleanInput($_POST["hometeam"]), $Helper->cleanInput($_POST["awayteam"]), $Helper->cleanInput($_POST["homescore"]), $Helper->cleanInput($_POST["awayscore"]));
		
		header("Location: edit.php?id=".$_POST["id"]."&success=true");
        exit();	
		
	}
	
	if(isset($_POST["delete"])){
		
		kustuta(cleanInput($_POST["id"]), cleanInput($_POST["leaguename"]), cleanInput($_POST["hometeam"]), cleanInput($_POST["awayteam"]), cleanInput($_POST["homescore"]), cleanInput($_POST["awayscore"]));
		
		header("Location: edit.php?id=".$_POST["id"]."&delete=true");
        exit();	
		
	}
	
	//saadan kaasa id
	$c = getSingleScoreData($_GET["id"]);
	var_dump($c);

	
?>
<br><br>
<a href="data.php"> tagasi </a>

<h2>Muuda kirjet</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
	<input type="hidden" name="id" value="<?=$_GET["id"];?>" > 
  	<label for="leaguename" >Liiga</label><br>
	<input id="leaguename" name="leaguename" type="text" value="<?php echo $c->leaguename;?>" ><br><br>
  	<label for="hometeam" >Hometeam</label><br>
	<input id="hometeam" name="hometeam" type="text" value="<?=$c->hometeam;?>"><br><br>
	<label for="awayteam" >awayteam</label><br>
	<input id="awayteam" name="awayteam" type="text" value="<?=$c->awayteam;?>"><br><br>
	<label for="homescore" >homescore</label><br>
	<input id="homescore" name="homescore" type="number" value="<?=$c->homescore;?>"><br><br>
	<label for="awayscore" >Away score</label><br>
	<input id="awayscore" name="awayscore" type="number" value="<?=$c->awayscore;?>"><br><br>
  	
	<input type="submit" name="update" value="Salvesta">
	<input type="submit" name="delete" value ="Kustuta">

  </form>

  

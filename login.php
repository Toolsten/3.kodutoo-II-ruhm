<?php 
	
	require("functions.php");
	
	// kui on juba sisse loginud siis suunan data lehele
	if (isset($_SESSION["userId"])){
		
		//suunan sisselogimise lehele
		header("Location: data.php");
		exit();
		
	}
	
	$loginEmailError = "";
	$loginEmail = "";
	if(isset($_POST["loginEmail"])) {
		
		
		if(empty($_POST["loginEmail"])) {
			
			$loginEmailError="See v�li on kohustuslik";
		}else{
			
			$loginEmail = $_POST["loginEmail"];
			
			
		}
	}
	
	//echo hash("sha512", "b");
	
	
	//GET ja POSTi muutujad
	//var_dump($_GET);
	//echo "<br>";
	//var_dump($_POST);
	
	//echo strlen("��");
	
	// MUUTUJAD
	$signupEmailError = "";
	$signupPasswordError = "";
	$signupEmail = "";
	$signupGender = "";
	
	// on �ldse olemas selline muutja
	if( isset( $_POST["signupEmail"] ) ){
		
		//jah on olemas
		//kas on t�hi
		if( empty( $_POST["signupEmail"] ) ){
			
			$signupEmailError = "See v�li on kohustuslik";
			
		} else {
			
			// email olemas 
			$signupEmail = $_POST["signupEmail"];
			
		}
		
	} 
	
	if( isset( $_POST["signupPassword"] ) ){
		
		if( empty( $_POST["signupPassword"] ) ){
			
			$signupPasswordError = "Parool on kohustuslik";
			
		} else {
			
			// siia j�uan siis kui parool oli olemas - isset
			// parool ei olnud t�hi -empty
			
			// kas parooli pikkus on v�iksem kui 8 
			if ( strlen($_POST["signupPassword"]) < 8 ) {
				
				$signupPasswordError = "Parool peab olema v�hemalt 8 t�hem�rkki pikk";
			
			}
			
		}
		
	}
	
	
	// GENDER
	if( isset( $_POST["signupGender"] ) ){
		
		if(!empty( $_POST["signupGender"] ) ){
		
			$signupGender = $_POST["signupGender"];
			
		}
		
	} 
	
	// peab olema email ja parool
	// �htegi errorit
	
	if ( isset($_POST["signupEmail"]) && 
		 isset($_POST["signupPassword"]) && 
		 $signupEmailError == "" && 
		 empty($signupPasswordError)
		) {
		
		// salvestame ab'i
		echo "Salvestan... <br>";
		
		echo "email: ".$signupEmail."<br>";
		echo "password: ".$_POST["signupPassword"]."<br>";
		
		$password = hash("sha512", $_POST["signupPassword"]);
		
		echo "password hashed: ".$password."<br>";
		
		
		//echo $serverUsername;
		
		// KASUTAN FUNKTSIOONI
		$signupEmail = cleanInput($signupEmail);
		
		signUp($signupEmail, cleanInput($password));
		
	
	}
	
	
	$error ="";
	if ( isset($_POST["loginEmail"]) && 
		isset($_POST["loginPassword"]) && 
		!empty($_POST["loginEmail"]) && 
		!empty($_POST["loginPassword"])
	  ) {
		  
		$error = $User->login($Helper->cleanInput($_POST["loginEmail"]), $Helper->cleanInput($_POST["loginPassword"]));
		
	}
	
			$eesnimierror= "";
	
   if(isset($_POST["Eesnimi"])) {
		
		
		if(empty($_POST["Eesnimi"])) {
			
			$eesnimierror="See v�li on kohustuslik";
		}
	}
	
	$Perenimierror= "";
	
	if(isset($_POST["Perenimi"])) {
		
		
		if(empty($_POST["Perenimi"])) {
			
			$Perenimierror="See v�li on kohustuslik";
		}
	}
	
	$Aadresserror= "";
	
	if(isset($_POST["aadress"])) {
		
		
		if(empty($_POST["aadress"])) {
			
			$Aadresserror="See v�li on kohustuslik";
		}
	}
	
?>
<!DOCTYPE html>
<html>
<head>
	<title>Logi sisse v�i loo kasutaja</title>
</head>
<body>

	<h1>Logi sisse</h1>
	<form method="POST">
		<p style="color:red;"><?=$error;?></p>
		<label>E-post</label>
		<br>
		
		<input name="loginEmail" placeholder="email" type="text" value="<?=$loginEmail;?>"><?php echo $loginEmailError; ?>
		<br><br>
		
		<input type="password" name="loginPassword" placeholder="Parool">
		<br><br>
		
		<input type="submit" value="Logi sisse">
		
		
	</form>
	
	
	
		
	<h1>Loo kasutaja</h1>
	<form method="POST">
		
		<label>E-post</label>
		<br>
		
		<input name="signupEmail" type="text" value="<?=$signupEmail;?>"> <?=$signupEmailError;?>
		<br><br>
		
		<input name="Eesnimi" placeholder="Sisestage eesnimi" type="text"> <?php echo $eesnimierror; ?>
		<br><br>
		
		<input name="Perenimi" placeholder="Sisestage Perekonnanimi" type="text"> <?php echo $Perenimierror; ?>
		<br><br>
		
		<input name="Aadress" placeholder="Sisestage aadress" type="text"> <?=$Aadresserror; ?>
		<br><br>
		
		
		<br>
		<input type="password" name="signupPassword" placeholder="Parool"> <?php echo $signupPasswordError; ?>
		<br><br>
		
		<input type="submit" value="Loo kasutaja">
		
		
	</form>
		
		

		
		
	</form>

</body>
</html>

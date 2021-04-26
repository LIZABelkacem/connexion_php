	<?php
	session_start();
	 
	$bdd = new PDO('mysql:host=127.0.0.1;dbname=egis', 'root', '');
	include_once('cookieconnect.php');
 
	if(isset($_SESSION['id'])) {
	   $requser = $bdd->prepare("SELECT * FROM admine WHERE id = ?");
	   $requser->execute(array($_SESSION['id']));
	   $user = $requser->fetch();
	   if(isset($_POST['newpseudo']) AND !empty($_POST['newpseudo']) AND $_POST['newpseudo'] != $user['pseudo']) {
	      $newpseudo = htmlspecialchars($_POST['newpseudo']);
	      $insertpseudo = $bdd->prepare("UPDATE admine SET pseudo = ? WHERE id = ?");
	      $insertpseudo->execute(array($newpseudo, $_SESSION['id']));
	      header('Location: monprofil.php?id='.$_SESSION['id']);
	   }
	   if(isset($_POST['newmail']) AND !empty($_POST['newmail']) AND $_POST['newmail'] != $user['mail']) {
	      $newmail = htmlspecialchars($_POST['newmail']);
	      $insertmail = $bdd->prepare("UPDATE admine SET mail = ? WHERE id = ?");
	      $insertmail->execute(array($newmail, $_SESSION['id']));
	      header('Location: monprofil.php?id='.$_SESSION['id']);
	   }
	   if(isset($_POST['newmdp1']) AND !empty($_POST['newmdp1']) AND isset($_POST['newmdp2']) AND !empty($_POST['newmdp2'])) {
	      $mdp1 = sha1($_POST['newmdp1']);
	      $mdp2 = sha1($_POST['newmdp2']);
	      if($mdp1 == $mdp2) {
	         $insertmdp = $bdd->prepare("UPDATE admine SET motdepasse = ? WHERE id = ?");
	         $insertmdp->execute(array($mdp1, $_SESSION['id']));
	         header('Location: monprofil.php?id='.$_SESSION['id']);
	      } else {
	         $msg = "Vos deux mdp ne correspondent pas !";
	      }
	   }
	?>
	<html>
	   <head>
	      <title>Profil</title>
	      <meta charset="utf-8">
		  <link rel="stylesheet" href="css/inscrptioncss.css" media="screen" type="text/css" />

	   </head>
	   <body>
  <div class = "container flex">           
    <div><img src="logo.gif" alt="" ></div>  
    <div class ="item">  <?php echo '<p> <a href="javascript:history.go(-1)"> Retour</a> </p>'; ?> </div>

    <div class ="item"><?php echo '<p> <a href="deconnexion.php"> Deconnexion</a> </p>'; ?> </div>

</div>


	      <div align="center">
	         <h2>Edition de mon profil</h2>
	         <div id="container" align="left">
	            <form method="POST" action="" class ="form" enctype="multipart/form-data">
	               <label>Pseudo :</label>
	               <input type="text" name="newpseudo" placeholder="Pseudo" value="<?php echo $user['pseudo']; ?>" /><br /><br />
	               <label>Mail :</label>
	               <input type="text" name="newmail" placeholder="Mail" value="<?php echo $user['mail']; ?>" /><br /><br />
	               <label>Mot de passe :</label>
	               <input type="password" name="newmdp1" placeholder="Mot de passe"/><br /><br />
	               <label>Confirmation - mot de passe :</label>
	               <input type="password" name="newmdp2" placeholder="Confirmation du mot de passe" /><br /><br />
	               <input type="submit" class ="lol name ="forminscription" value="Mettre à jour" />
	            </form>
	            <?php if(isset($msg)) { echo $msg; } ?>
	         </div>
	      </div>
	   </body>
	</html>
	<?php   
	}
	else {
	   header("Location: connexion.php");
	}
	?>
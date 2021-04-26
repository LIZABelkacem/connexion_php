<?php
session_start();
 
$bdd = new PDO('mysql:host=127.0.0.1;port=3308;dbname=espace_membre', 'root', '');
 
if(isset($_GET['id']) AND $_GET['id'] > 0) {
   $getid = intval($_GET['id']);
   $requser = $bdd->prepare('SELECT * FROM membres WHERE id = ?');
   $requser->execute(array($getid));
   $userinfo = $requser->fetch();
?>
<html>
   <head>
      <title>TUTO PHP</title>
      <meta charset="utf-8">
      <link rel="stylesheet" href="css/inscrptioncss.css" media="screen" type="text/css" />

   </head>
   <body>
         <h1 align ="center">Profil <?php echo $userinfo['pseudo']; ?></h1>
         <br /><br />
         Pseudo = <?php echo $userinfo['pseudo']; ?>
         <br />
         Mail = <?php echo $userinfo['mail']; ?>
         <br />
         <?php
         if(isset($_SESSION['id']) AND $userinfo['id'] == $_SESSION['id']) {
         ?>
         <br />
         <a href="editionprofil.php">Editer mon profil</a>
         <a href="http://site/menu/menuprincipal.php"> Menu <a>
         <a href="deconnexion.php">Se déconnecter</a>
         <?php
         }
         ?>
      </div>
   </body>
</html>
<?php   
}
?>
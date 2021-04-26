<?php
session_start();
 
$bdd = new PDO('mysql:host=127.0.0.1;dbname=egis', 'root', '');
include_once('cookieconnect.php');
 
if(isset($_GET['id']) AND $_GET['id'] > 0) {
   $getid = intval($_GET['id']);
   $requser = $bdd->prepare('SELECT * FROM admine WHERE id = ?');
   $requser->execute(array($getid));
   $userinfo = $requser->fetch();
  }
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>page menu principal </title>
<link href="css/menucss.css" rel="stylesheet">
  <script src="script.js"></script>
</head>
<body > 
<div class = "container flex">           
    <div><img src="logo.gif" alt="" ></div>  
    <div class ="item">  <?php echo '<p> <a href="javascript:history.go(-1)"> Retour</a> </p>'; ?> </div>

    <div class ="item"><?php echo '<p> <a href="deconnexion.php"> Deconnexion</a> </p>'; ?> </div>

</div>
        <h1 align ="center">Profil <?php echo $userinfo['pseudo']; ?></h1>
     
         Pseudo = <?php echo $userinfo['pseudo']; ?>
         <br />
         Mail = <?php echo $userinfo['mail']; ?>
         <br />
         <?php
         if(isset($_SESSION['id']) AND $userinfo['id'] == $_SESSION['id']) {
         ?>

         <br />
	   
         

         <div class="BU">
        
      	     <button onclick="window.location.href = 'editionprofil.php';" class="a"> Editer mon profil
      	     </button> 
          </div>

          <div class="BU">
        
        <button onclick="window.location.href = 'http://localhost/dashboard/Tests/app/admin/gestion/gestionusers.php';" class="d"> Gestion Utilisateurs
        </button> 
          </div>  


  
        <div class="BU">

      	     <button onclick="window.location.href = 'http://localhost/dashboard/Tests/app/admin/menu/menuprincipal.php';" class="b"> Menu
      	     </button> 
      	    
        </div>  



      	<div class="BU">

      	      <button onclick="window.location.href = 'deconnexion.php';" class="c"> Me deconnecter
      	      </button>              
        </div>
        
 </body>
</html>
<?php   
}
?>
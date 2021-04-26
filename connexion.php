<?php
session_start();
 
$bdd = new PDO('mysql:host=127.0.0.1;dbname=egis', 'root', '');
include_once('cookieconnect.php');

if(isset($_POST['formconnexion'])) {
   $mailconnect = htmlspecialchars($_POST['mailconnect']);
   $mdpconnect = sha1($_POST['mdpconnect']);
   if(!empty($mailconnect) AND !empty($mdpconnect)) {
      $requser = $bdd->prepare("SELECT * FROM admine WHERE mail = ? AND motdepasse = ?");
      $requser->execute(array($mailconnect, $mdpconnect));
      $userexist = $requser->rowCount();
      if($userexist == 1) {
         if(isset($_POST['rememberme'])) {
            setcookie('email',$mailconnect,time()+365*24*3600,null,null,false,true);
	         setcookie('password',$mdpconnect,time()+365*24*3600,null,null,false,true);
         }
         $userinfo = $requser->fetch();
         $_SESSION['id'] = $userinfo['id'];
         $_SESSION['pseudo'] = $userinfo['pseudo'];
         $_SESSION['mail'] = $userinfo['mail'];
         header("Location: monprofil.php?id=".$_SESSION['id']);
      } else {
         $erreur = " mail ou mot de passe incorrect !";
      }
   } else {
      $erreur = "Tous les champs doivent être complétés !";
   }
}
?>
<html>
   <head>

      <meta charset="utf-8">
      <link rel="stylesheet" href="css/inscrptioncss.css" media="screen" type="text/css" />

   </head>
   <body >
   <img src="logo.gif" alt="">  
 


   <div id="container" align ="center" >

         <form method="POST" class = "form" align ="center">

         <h1>Connexion Administrateur</h1>
         <table>
         <tr align ="center" >
                 <td align ="right">
                <label><b>@-Email</b></label>
                 </td>
                 <br\>
                 <td>
                <input type="email" placeholder="nom d'utilisateur" name="mailconnect" required>
                </td>  
                <br/> 
                </tr>
                <tr align ="center">
                <td align ="right">
                <label><b>Password</b></label>
                </td >
                <td >
                <input type="password" placeholder="Entrer le mot de passe" name="mdpconnect" required>
                </td>
                </tr> 
                </table> 
                <input type="checkbox" name ="remember me" id ="remembercheckbox"/> <label for ="remembercheckbox"> Se souvenir de moi </label>
                <input class="lol" type="submit" id='submit' name="formconnexion" value ="login" href="">
               
          </form>
         <?php
         if(isset($erreur)) {
            echo '<font color="red">'.$erreur."</font>";
         }
         ?>
   </div>



   </body>
</html>
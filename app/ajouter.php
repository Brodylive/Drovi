<?php

		// ini_set('display_errors', 1);
		// error_reporting(E_ALL);

try
{
	$bdd = new PDO('mysql:host=localhost;dbname=jenniferdenis', 'jenniferdenis', 'SjwYCnv2tt29BqLd');
}
catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}

session_start();




?>
<!DOCTYPE html>

<head>
	<meta charset="UTF-8">

		
	<link rel="shortcut icon" type="image/png" href="img/iconedrovi.png" />
  	<link rel="icon" type="image/png" href="img/iconedrovi.png" />
  	
  	<!--meta name="viewport" content="user-scalable=no, initial-scale=1" /-->
	<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=no"/>
	
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="mobile-web-app-capable" content="yes">
	
	
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	
	<link rel="apple-touch-icon" href="img/icontouchdrovi.png" />
	<link rel="apple-touch-startup-image" href="img/iconstartupdrovi.png">

	<title>Ajouter un commerce | Drovi</title>
	
	<meta name="apple-mobile-web-app-title" content="Drovi">
	
	<link rel="stylesheet" type="text/css" href="css/reset.css">
	<link type="text/css" rel="stylesheet" href="css/style.css" />
	<link rel="stylesheet" type="text/css" href="skinny_font/stylesheet.css">


	<link type="text/css" rel="stylesheet" href="src/css/jquery.mmenu.css" />
	

	<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js?ver=1.7.2'></script>
    <script type="text/javascript" src="src/js/jquery.mmenu.js"></script>
		
    <script type="text/javascript">
		$(function() {
			$('nav#menu').mmenu();
		});
		
		
		
	</script>
		

	<script src="js/selectize.js"></script>
	
	<link rel="stylesheet" href="css/selectize.legacy.css">
	


	<script type="text/javascript" src="js/jshashtable-2.1_src.js"></script>
	<script type="text/javascript" src="js/jquery.numberformatter-1.2.3.js"></script>
	<script type="text/javascript" src="js/tmpl.js"></script>
	<script type="text/javascript" src="js/jquery.dependClass-0.1.js"></script>
	<script type="text/javascript" src="js/draggable-0.1.js"></script>
	<script type="text/javascript" src="js/jquery.slider.js"></script>


	
<!-- 	<script type="text/javascript" src="js/jquery.js"></script> -->
	<script type="text/javascript" src="js/datepicker.js"></script>
    <script type="text/javascript" src="js/eye.js"></script>
    <script type="text/javascript" src="js/utils.js"></script>
    <script type="text/javascript" src="js/layout.js"></script>



    <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAgrj58PbXr2YriiRDqbnL1RSqrCjdkglBijPNIIYrqkVvD1R4QxRl47Yh2D_0C1l5KXQJGrbkSDvXFA"
      type="text/javascript"></script>




</head>
<body>

<?php

			if(!$_SESSION['drovi'] || $_SESSION['drovi_xp']<=10) {
			
				?>
				
				<script type="text/javascript">
					window.location.href='inscription.php';
				</script>
				
				<?
				
			}
			
			
		if($_GET['action']=='deco') {
			$_SESSION['drovi']='';
			$_SESSION['drovi_xp']='';
			
			echo "<script>popup('Tu va être déconnecté...') setTimeout(function(){window.location.reload();},3000);</script>";
		}
			
			?>

 

	
<div id="page">

<div id="overlay" style="display:none;" onclick="$('#overlay, #popupfortop').hide();"></div>
 
	<header>
	
		<a href="#menu" id="voirmenu" title="Menu">Menu</a>
		
		<a href="apropos.php" id="apropos" title="Infos">A propos</a>
		
		
		<a href="recherche.php" id="chercheruncommerce" title="Recherche un commerce">Recherche un commerce</a>
		
		<?
		
		if($_SESSION['drovi_xp']>= 10) {
		?>
			<a href="ajouter.php" id="ajouteruncommerce" title="Ajouter un commerce">Ajouter un commerce</a>

		<?
		$stylechanged="changed";
		}
		
		if($_SESSION['drovi']) {
			
			$nomuser=$_SESSION['drovi_nom'];
		
		?>
			<a href="?action=deco" id="deconnexion" title="Déconnexion">Ton compte</a>
			<p class="popin ofmenu <? echo $stylechanged; ?>" id="decoinfos">Déconnexion du compte</p>
			<a href="compte.php" id="nomuser" style="text-decoration:none;margin-top:8px;margin-right:10px;float:right;">Salut <? echo $nomuser; ?>!</a>
		<?
		} else {
		?>
			<a href="inscription.php" id="connexion" title="Inscris-toi ou connecte-toi">Inscris-toi ou connecte-toi</a>
			<p class="popin ofmenu" id="coinfos">Connecte-toi ou inscris-toi</p>
		<?
			
		}
		?>
	
		<h1><a href="index.php" title="Un commerce ouvert ici et maintenant">Drovi - Trouver un commerce</a></h1>
	

	</header>
	

	<p id='popup'></p>

	
	<div id="content">
	
		
		<h2 class="ajouteruncommerce">Ajouter un commerce</h2>


		<div class="ajouteruncommerce">
	
<?	
	if ($_POST['action']=='add') {
		$string1=$_POST['nom'];
		$nom=str_replace("'", "\\\''", $string1);
		
		$string2=$_POST['adresse'];
		$adresse=str_replace("'", "\\\''", $string2);
		
		$string4=$_POST['description'];
		$description=str_replace("'", "\\\''", $string4);
		
		$string3=$_POST['latlng'];
		$latlng=preg_replace('/[()]/', '', $string3);
		
		
		$cat=$_POST['cat'];
		
		if(isset($_POST['lundi'])){
		
			if(isset($_POST['lundi2'])) {
				$lundi="'".$_POST['lundi_debut'] .":00 to ". $_POST['lundi_fin'].":00 and ".$_POST['lundi_debut2'].":00 to ".$_POST['lundi_fin2'].":00'";
			} else {
				$lundi="'".$_POST['lundi_debut'] .":00 to ". $_POST['lundi_fin'].":00'";
			}
						
		} else {
			$lundi='NULL';
		}
		
		if(isset($_POST['mardi'])){
			
			if(isset($_POST['mardi2'])) {
				$mardi="'".$_POST['mardi_debut'] .":00 to ". $_POST['mardi_fin'].":00 and ".$_POST['mardi_debut2'].":00 to ".$_POST['mardi_fin2'].":00'"; 
			} else {
				$mardi="'".$_POST['mardi_debut'] .":00 to ". $_POST['mardi_fin'].":00'";
			}
						
		} else {
			$mardi='NULL';
		}
		
		
		
		if(isset($_POST['mercredi'])){
		
			if(isset($_POST['mercredi2'])) {
				$mercredi="'".$_POST['mercredi_debut'] .":00 to ". $_POST['mercredi_fin'].":00 and ".$_POST['mercredi_debut2'].":00 to ".$_POST['mercredi_fin2'].":00'"; 
			} else {
				$mercredi="'".$_POST['mercredi_debut'] .":00 to ". $_POST['mercredi_fin'].":00'";
			}

			
		} else {
			$mercredi='NULL';
		}
		
		if(isset($_POST['jeudi'])){
		
			if(isset($_POST['jeudi2'])) {
				$jeudi="'".$_POST['jeudi_debut'] .":00 to ". $_POST['jeudi_fin'].":00 and ".$_POST['jeudi_debut2'].":00 to ".$_POST['jeudi_fin2'].":00'"; 
			} else {
				$jeudi="'".$_POST['jeudi_debut'] .":00 to ". $_POST['jeudi_fin'].":00'";
			}
			
		} else {
			$jeudi='NULL';
		}
		
		
		if(isset($_POST['vendredi'])){
			
			if(isset($_POST['vendredi2'])) {
				$vendredi="'".$_POST['vendredi_debut'] .":00 to ". $_POST['vendredi_fin'].":00 and ".$_POST['vendredi_debut2'].":00 to ".$_POST['vendredi_fin2'].":00'"; 
			} else {
				$vendredi="'".$_POST['vendredi_debut'] .":00 to ". $_POST['vendredi_fin'].":00'";
			}
			
		} else {
			$vendredi='NULL';
		}
		
		if(isset($_POST['samedi'])){
		
			if(isset($_POST['samedi2'])) {
				$samedi="'".$_POST['samedi_debut'] .":00 to ". $_POST['samedi_fin'].":00 and ".$_POST['samedi_debut2'].":00 to ".$_POST['samedi_fin2'].":00'"; 
			} else {
				$samedi="'".$_POST['samedi_debut'] .":00 to ". $_POST['samedi_fin'].":00'";
			}
			
		} else {
			$samedi='NULL';
		}
		
		if(isset($_POST['dimanche'])){
		
			if(isset($_POST['dimanche2'])) {
				$dimanche="'".$_POST['dimanche_debut'] .":00 to ". $_POST['dimanche_fin'].":00 and ".$_POST['dimanche_debut2'].":00 to ".$_POST['dimanche_fin2'].":00'"; 
			} else {
				$dimanche="'".$_POST['dimanche_debut'] .":00 to ". $_POST['dimanche_fin'].":00'";
			}
			
		} else {
			$dimanche='NULL';
		}
	
	
		$reponse = $bdd->query("INSERT INTO `drovi_magasins` (`nom`, `description`, `adresse`, `latLng`, `cat`, `1`, `2`, `3`, `4`, `5`, `6`, `0`) VALUES ('$nom', '$description', '$adresse', '$latlng', '$cat', $lundi, $mardi, $mercredi, $jeudi, $vendredi, $samedi, $dimanche)");
		
		if($_POST['inputDatej1']) {
			if(isset($_POST['jour1'])){
		
			if(isset($_POST['jour12'])) {
				$jour1=$_POST['jour1_debut'] .":00 to ". $_POST['jour1_fin'].":00 and ".$_POST['jour1_debut2'].":00 to ".$_POST['jour1_fin2'].":00"; 
			} else {
				$jour1=$_POST['jour1_debut'] .":00 to ". $_POST['jour1_fin'].":00";
			}
			
			} else {
				$jour1='fermé';
			}
			$date=$_POST['inputDatej1'];
			$reponse = $bdd->query("INSERT INTO drovi_conges (nom_magasin, date, horaire) VALUES ('$nom', '$date', '$jour1')");

		}
		
		if($_POST['inputDatej2']) {
			if(isset($_POST['jour2'])){
		
			if(isset($_POST['jour22'])) {
				$jour2=$_POST['jour2_debut'] .":00 to ". $_POST['jour2_fin'].":00 and ".$_POST['jour2_debut2'].":00 to ".$_POST['jour2_fin2'].":00"; 
			} else {
				$jour2=$_POST['jour2_debut'] .":00 to ". $_POST['jour2_fin'].":00";
			}
			
			} else {
				$jour2='fermé';
			}
			
			$date=$_POST['inputDatej2'];
			$reponse = $bdd->query("INSERT INTO drovi_conges (nom_magasin, date, horaire) VALUES ('$nom', '$date', '$jour2')");
		}
		
		
		if($_POST['inputDatej3']) {
			if(isset($_POST['jour3'])){
		
			if(isset($_POST['jour32'])) {
				$jour3=$_POST['jour3_debut'] .":00 to ". $_POST['jour3_fin'].":00 and ".$_POST['jour3_debut2'].":00 to ".$_POST['jour3_fin2'].":00"; 
			} else {
				$jour3=$_POST['jour3_debut'] .":00 to ". $_POST['jour3_fin'].":00";
			}
			
			} else {
				$jour3='fermé';
			}
			$date=$_POST['inputDatej3'];
			$reponse = $bdd->query("INSERT INTO drovi_conges (nom_magasin, date, horaire) VALUES ('$nom', '$date', '$jour3')");
		}
		
		
		if($_POST['inputDatej4']) {
			if(isset($_POST['jour4'])){
		
			if(isset($_POST['jour42'])) {
				$jour4=$_POST['jour4_debut'] .":00 to ". $_POST['jour4_fin'].":00 and ".$_POST['jour4_debut2'].":00 to ".$_POST['jour4_fin2'].":00"; 
			} else {
				$jour4=$_POST['jour4_debut'] .":00 to ". $_POST['jour4_fin'].":00";
			}
			
			} else {
				$jour4='fermé';
			}
			$date=$_POST['inputDatej4'];
			$reponse = $bdd->query("INSERT INTO drovi_conges (nom_magasin, date, horaire) VALUES ('$nom', '$date', '$jour4')");
		}
		
		if($_POST['inputDatej5']) {
			if(isset($_POST['jour5'])){
		
			if(isset($_POST['jour52'])) {
				$jour5=$_POST['jour5_debut'] .":00 to ". $_POST['jour5_fin'].":00 and ".$_POST['jour5_debut2'].":00 to ".$_POST['jour5_fin2'].":00"; 
			} else {
				$jour5=$_POST['jour5_debut'] .":00 to ". $_POST['jour5_fin'].":00";
			}
			
			} else {
				$jour5='fermé';
			}
			$date=$_POST['inputDatej5'];
			$reponse = $bdd->query("INSERT INTO drovi_conges (nom_magasin, date, horaire) VALUES ('$nom', '$date', '$jour5')");
		}
		
		
		if($_POST['inputDatej6']) {
			if(isset($_POST['jour6'])){
		
			if(isset($_POST['jour62'])) {
				$jour6=$_POST['jour6_debut'] .":00 to ". $_POST['jour6_fin'].":00 and ".$_POST['jour6_debut2'].":00 to ".$_POST['jour6_fin2'].":00"; 
			} else {
				$jour6=$_POST['jour6_debut'] .":00 to ". $_POST['jour6_fin'].":00";
			}
			
			} else {
				$jour6='fermé';
			}
			$date=$_POST['inputDatej6'];
			$reponse = $bdd->query("INSERT INTO drovi_conges (nom_magasin, date, horaire) VALUES ('$nom', '$date', '$jour6')");
		}
		
		if($_POST['inputDatej7']) {
			if(isset($_POST['jour7'])){
		
			if(isset($_POST['jour72'])) {
				$jour7=$_POST['jour7_debut'] .":00 to ". $_POST['jour7_fin'].":00 and ".$_POST['jour7_debut2'].":00 to ".$_POST['jour7_fin2'].":00"; 
			} else {
				$jour7=$_POST['jour7_debut'] .":00 to ". $_POST['jour7_fin'].":00";
			}
			
			} else {
				$jour7='fermé';
			}
			$date=$_POST['inputDatej7'];
			$reponse = $bdd->query("INSERT INTO drovi_conges (nom_magasin, date, horaire) VALUES ('$nom', '$date', '$jour7')");
		}
		
		if($_POST['inputDatej8']) {
			if(isset($_POST['jour8'])){
		
			if(isset($_POST['jour82'])) {
				$jour8=$_POST['jour8_debut'] .":00 to ". $_POST['jour8_fin'].":00 and ".$_POST['jour8_debut2'].":00 to ".$_POST['jour8_fin2'].":00"; 
			} else {
				$jour8=$_POST['jour8_debut'] .":00 to ". $_POST['jour8_fin'].":00";
			}
			
			} else {
				$jour8='fermé';
			}
			$date=$_POST['inputDatej8'];
			$reponse = $bdd->query("INSERT INTO drovi_conges (nom_magasin, date, horaire) VALUES ('$nom', '$date', '$jour8')");
		}
		
		if($_POST['inputDatej9']) {
			if(isset($_POST['jour9'])){
		
			if(isset($_POST['jour92'])) {
				$jour9=$_POST['jour9_debut'] .":00 to ". $_POST['jour9_fin'].":00 and ".$_POST['jour9_debut2'].":00 to ".$_POST['jour9_fin2'].":00"; 
			} else {
				$jour9=$_POST['jour9_debut'] .":00 to ". $_POST['jour9_fin'].":00";
			}
			
			} else {
				$jour9='fermé';
			}
			$date=$_POST['inputDatej9'];
			$reponse = $bdd->query("INSERT INTO drovi_conges (nom_magasin, date, horaire) VALUES ('$nom', '$date', '$jour9')");
		}
		
		if($_POST['inputDatej10']) {
			if(isset($_POST['jour10'])){
		
			if(isset($_POST['jour102'])) {
				$jour10=$_POST['jour10_debut'] .":00 to ". $_POST['jour10_fin'].":00 and ".$_POST['jour10_debut2'].":00 to ".$_POST['jour10_fin2'].":00"; 
			} else {
				$jour10=$_POST['jour10_debut'] .":00 to ". $_POST['jour10_fin'].":00";
			}
			
			} else {
				$jour10='fermé';
			}
			
			$date=$_POST['inputDatej10'];
			$reponse = $bdd->query("INSERT INTO drovi_conges (nom_magasin, date, horaire) VALUES ('$nom', '$date', '$jour10')");
		}
		
		$id_user=$_SESSION['drovi'];
			
		$addlevel= $bdd->query("SELECT * FROM drovi_users WHERE id='$id_user'");
		$row=$addlevel->fetch();
			
		$lvl=$row['niveau'];
		$lvlup=$lvl + 15;
			
		$addlevel= $bdd->query("UPDATE drovi_users SET niveau='$lvlup' WHERE id='$id_user'");
		
		$username=$row['username'];
		
		$to = $row['email'];
		$subject = 'Tu as ajouté un commerce sur Drovi';

		$headers = "From: info@drovi.be\n";
		$headers.= "Content-type: text/html";

		if($lundi=='NULL') {$lundi="fermé";}
		if($mardi=='NULL') {$mardi="fermé";}
		if($mercredi=='NULL') {$mercredi="fermé";}
		if($jeudi=='NULL') {$jeudi="fermé";}
		if($vendredi=='NULL') {$vendredi="fermé";}
		if($samedi=='NULL') {$samedi="fermé";}
		if($dimanche=='NULL') {$dimanche="fermé";}
		
		$nom=$_POST['nom'];		
		$adresse=$_POST['adresse'];
		$description=$_POST['description'];
		
		
		$lundi=str_replace("to", "à", $lundi);
		$mardi=str_replace("to", "à", $mardi);
		$mercredi=str_replace("to", "à", $mercredi);
		$jeudi=str_replace("to", "à", $jeudi);
		$vendredi=str_replace("to", "à", $vendredi);
		$samedi=str_replace("to", "à", $samedi);
		$dimanche=str_replace("to", "à", $dimanche);
		
		$lundi=str_replace("'", "", $lundi);
		$mardi=str_replace("'", "", $mardi);
		$mercredi=str_replace("'", "", $mercredi);
		$jeudi=str_replace("'", "", $jeudi);
		$vendredi=str_replace("'", "", $vendredi);
		$samedi=str_replace("'", "", $samedi);
		$dimanche=str_replace("'", "", $dimanche);
		
		$message="
<body style='margin:0;padding:0; font-family:arial, sans-serif;' bgcolor='#fff' color='#fff'>
					
				<table bgcolor='#2980b9' border='0' cellpadding='30 15' cellspacing='0' style='font-family: arial, sans-serif; margin: 0px auto;'' width='700'>
					<tbody>
					
						<tr>
							<td bgcolor='#2c3e50' colspan='2' style='font-family: arial, sans-serif; color: rgb(255, 255, 255);text-align: center;'>
							<img src='http://jenniferdenis.be/tfe/prototype/img/drovilogo.png' style='font-family: arial, sans-serif; display: block; margin: 0 auto 30px;' />
				<h1 style=' font-size: 18px; font-weight: normal;'>
					Salut &agrave; toi $username!</h1>
							</td>
						</tr>
						
						<tr>
							<td style='color:#fff; border-bottom-style: solid; border-bottom-color: #3498db; border-bottom-width: 3px;' width='500'>
								
									<p style='margin-top: 30px;'>
									Tu viens d'ajouter un commerce sur <a href='http://jenniferdenis.be/tfe/prototype/' style='text-decoration: none; color:#ddd;'> Drovi</a><br>
									Voici un r&eacute;capitulatif du comerce :</p>

									<p style='margin-bottom: 30px;'>
										Nom :<span style='color:#ddd;'>&nbsp;$nom&nbsp;</span><br />
										Adresse :<span style='color:#ddd;'>&nbsp;$adresse</span><br />
										Coordonn&eacutees :<span style='color:#ddd;'>&nbsp;$latlng&nbsp;</span><br />
										Cat :<span style='color:#ddd;'>&nbsp;$cat</span><br />
									
									</p>
																
							</td>
							<td style='color:#fff;  border-bottom-style: solid; border-bottom-color: #3498db; border-bottom-width: 3px;' width='200'>
								<h1 style='font-size: 18px; text-align: center;margin-top: 30px;''>
									Besoin d&#39;aide?</h1>
								<p style='background-color: #3498db; padding: 10px 10px; text-align: center; border-radius:5px;'>
									Contacte le webmaster <br> jennifer.brody.denis@gmail.com</p>
							</td>
						</tr>
						<tr>
							<td colspan='2' style='color:#fff; text-align:center;'>
								<p>Voici l'horaire du commerce:</p>
								<p>Lundi</p>
								<span>$lundi</span>
								
								<p>Mardi</p>
								<span>$mardi</span>
								
								<p>Mercredi</p>
								<span>$mercredi</span>
								
								<p>Jeudi</p>
								<span>$jeudi</span>
								
								<p>Vendredi</p>
								<span>$vendredi</span>
								
								<p>Samedi</p>
								<span>$samedi</span>
								
								<p>Dimanche</p>
								<span>$dimanche</span>
		

							</td>
						</tr>
						
						<tr>
							<td bgcolor='#2c3e50' colspan='2' style='color:#fff; text-align:center;'>
								<p>
									A bient&ocirc;t sur Drovi!</p>
							</td>
						</tr>
						<tr>
							<td bgcolor='#fff' colspan='2' style='color:#000; text-align:center;'>
								<p>
									<a href='http://jenniferdenis.be/tfe/prototype/supprimer.php?id=$id_user'>Si vous souhaitez vous d&eacute;sinscrire, c'est par ici!</a></p>
									
						</td>
						</tr>
					</tbody>
				</table>
				";
			mail($to, $subject, $message, $headers);
					
						
	?>
	
	<form method="POST">
	
		<p style="color:#111;margin-bottom:40px;line-height:140%;">Tu recevra <strong>un email avec ce récapitulatif</strong> si tu remarques une erreur, tu peux la <strong>corriger via la page recherche</strong> en cliquant sur <strong>l'icône "modifier"</strong> du commerce.</p>
	
		<label>Nom du commerce</label>
		<input type="text" value="<? echo $nom;?>" readonly="readonly">
		
		<label>Description du magasin</label>
		<input type="text" value="<? echo $description;?>" readonly="readonly">
		
		<label>Adresse du magasin</label>
		<input type="text" value="<? echo $adresse;?>" readonly="readonly">
		
		<label>Coordonées (automatique)</label>
		<input type="text" value="<? echo $latlng;?>" readonly="readonly">
		
		<label>Catégorie</label>
		<input type="text" value="<? echo $cat;?>" readonly="readonly">
		
		<p class="title">Horaire</p>
		
		<label>Lundi</label>
		<input type="text" value="<? if($lundi=='NULL') {echo "fermé";} else {echo $lundi;}?>" readonly="readonly">
		
		<label>Mardi</label>
		<input type="text" value="<? if($mardi=='NULL') {echo "fermé";} else {echo $mardi;}?>" readonly="readonly">
		
		<label>Mercredi</label>
		<input type="text" value="<? if($mercredi=='NULL') {echo "fermé";} else {echo $mercredi;}?>" readonly="readonly">
		
		<label>Jeudi</label>
		<input type="text" value="<? if($jeudi=='NULL') {echo "fermé";} else {echo $jeudi;}?>" readonly="readonly">
		
		<label>Vendredi</label>
		<input type="text" value="<? if($vendredi=='NULL') {echo "fermé";} else {echo $vendredi;}?>" readonly="readonly">
		
		<label>Samedi</label>
		<input type="text" value="<? if($samedi=='NULL') {echo "fermé";} else {echo $samedi;}?>" readonly="readonly">
		
		<label>Dimanche</label>
		<input type="text" value="<? if($dimanche=='NULL') {echo "fermé";} else {echo $dimanche;}?>" readonly="readonly">
		
		
		<a href="ajouter.php">Ajouter un commerce et son horaire</a>
		
		<a href="recherche.php">Chercher un horaire</a>
		
	</form>

	
	<?
	
	
	} else {
	

?>

		<form method="POST">
	
		<label for="nom">Nom du commerce</label>
		<input type="text" id="nom" name="nom" placeholder="Nom du Commerce">
		
		<label for="description">Description du commerce</label>
		<input type="text" id="description" name="description" placeholder="Description brève du commerce">
		
		<label for="adresse">Adresse du magasin</label>
		<input type="text" id="adresse" name="adresse" onchange="getAdresse();" placeholder="Adresse du commerce">
		
		<p class="popin" id="adresseinfos">L'adresse doit contenir le <strong>nom de la rue</strong>, le <strong>numéro</strong> du/des bâtiment(s) et le <strong>code postal</strong> et/ou la <strong>localité</strong>.<br><br> 
		
		La nomenclature souhaitée: <br>
		<strong>Rue de l'étoile 10, 5000 Namur</strong>
		
		</p>
		
		<label for="latlng">Coordonées (automatique)</label>
		<input type="text" id="latlng" name="latlng" placeholder="Latitude et longitude">
		
		<p class="popin" id="latlnginfos">Les coordonées se calculent <strong>automatiquement</strong>, mais tu peux les changer si tu as les <strong>coordonées exactes</strong> du magasin.</p>
		
		<label for="cat">Catégorie</label>
		<select name="cat" id="cat" placeholder="Sélectionner une catégorie...">
			<option value="">Sélectionner une catégorie...</option>
			<option value="alimentaire">Alimentaire</option>
			<option value="horeca">Horeca</option>
			<option value="nightshop">Night Shop</option>
			<option value="boutique">Boutique</option>
			<option value="pharmacie">Pharmacie</option>
			<option value="autre">Autre</option>
		</select>
		
		

		
		<div id="checkmap"></div>
		
		<p class="title" id="horaire" style="cursor:help;">Horaire régulier</p>
		
		<p class="popin" id="horaireinfos"><strong>Attention!</strong><br> Si le commerce est ouvert <strong>lundi de 18h à 02h</strong>, tu dois procèder comme suit: <br><strong>lundi 18h à 24h</strong> et mardi <strong>00h à 02h.</strong></p>
	
		<p class="day">Lundi</p>
		
		<input type="checkbox" id="trigger1" name="lundi" class="checkbox-11-2">
		<label for="trigger1"></label>
		
		<input type="hidden" id="lundi_debut" name="lundi_debut">
		<input type="hidden" id="lundi_fin" name="lundi_fin">

	    <div class="layout-slider" id="layout-slider1">
	      <input id="Slider1" type="slider" name="area" value="480;1080" />
	      <input type="checkbox" id="openSlider12"  name="lundi2"><label for="openSlider12">Ajouter une nouvelle tranche horaire</label>
	    </div>
	    
	    <input type="hidden" id="lundi_debut2" name="lundi_debut2">
		<input type="hidden" id="lundi_fin2" name="lundi_fin2">
	    
	    <div class="layout-slider" id="layout-slider12">
	      <input id="Slider12" type="slider" name="area" value="480;1080" />
	    </div>
	    
	    <p class="day">Mardi</p>
		
		<input type="checkbox" id="trigger2" name="mardi" class="checkbox-11-2">
		<label for="trigger2"></label>
		
		<input type="hidden" id="mardi_debut" name="mardi_debut">
		<input type="hidden" id="mardi_fin" name="mardi_fin">

	    <div class="layout-slider" id="layout-slider2">
	      <input id="Slider2" type="slider" name="area" value="480;1080" />
	      <input type="checkbox" id="openSlider22"  name="mardi2"><label for="openSlider22">Ajouter une nouvelle tranche horaire</label>
	    </div>
	    
	    <input type="hidden" id="mardi_debut2" name="mardi_debut2">
		<input type="hidden" id="mardi_fin2" name="mardi_fin2">
	    
	    <div class="layout-slider" id="layout-slider22">
	      <input id="Slider22" type="slider" name="area" value="480;1080" />
	    </div>

	    
	    
	    <p class="day">Mercredi</p>
		
		<input type="checkbox" id="trigger3" name="mercredi" class="checkbox-11-2">
		<label for="trigger3"></label>
		
		<input type="hidden" id="mercredi_debut" name="mercredi_debut">
		<input type="hidden" id="mercredi_fin" name="mercredi_fin">

	    <div class="layout-slider" id="layout-slider3">
	      <input id="Slider3" type="slider" name="area" value="480;1080" />
	      <input type="checkbox" id="openSlider32"  name="mercredi2"><label for="openSlider32">Ajouter une nouvelle tranche horaire</label>
	    </div>
	    
	    <input type="hidden" id="mercredi_debut2" name="mercredi_debut2">
		<input type="hidden" id="mercredi_fin2" name="mercredi_fin2">
	    
	    <div class="layout-slider" id="layout-slider32">
	      <input id="Slider32" type="slider" name="area" value="480;1080" />
	    </div>
	    
	    
	    
	    <p class="day">Jeudi</p>
		
		<input type="checkbox" id="trigger4" name="jeudi" class="checkbox-11-2">
		<label for="trigger4"></label>
		
		<input type="hidden" id="jeudi_debut" name="jeudi_debut">
		<input type="hidden" id="jeudi_fin" name="jeudi_fin">

	    <div class="layout-slider" id="layout-slider4">
	      <input id="Slider4" type="slider" name="area" value="480;1080" />
	      <input type="checkbox" id="openSlider42" name="jeudi2"><label for="openSlider42">Ajouter une nouvelle tranche horaire</label>
	    </div>
	    
	    <input type="hidden" id="jeudi_debut2" name="jeudi_debut2">
		<input type="hidden" id="jeudi_fin2" name="jeudi_fin2">
	    
	    <div class="layout-slider" id="layout-slider42">
	      <input id="Slider42" type="slider" name="area" value="480;1080" />
	    </div>
	    
	    
	    
	    <p class="day">Vendredi</p>
		
		<input type="checkbox" id="trigger5" name="vendredi" class="checkbox-11-2">
		<label for="trigger5"></label>
		
		<input type="hidden" id="vendredi_debut" name="vendredi_debut">
		<input type="hidden" id="vendredi_fin" name="vendredi_fin">

	    <div class="layout-slider" id="layout-slider5">
	      <input id="Slider5" type="slider" name="area" value="480;1080" />
	      <input type="checkbox" id="openSlider52"  name="vendredi2"><label for="openSlider52">Ajouter une nouvelle tranche horaire</label>
	    </div>
	    
	    <input type="hidden" id="vendredi_debut2" name="vendredi_debut2">
		<input type="hidden" id="vendredi_fin2" name="vendredi_fin2">
	    
	    <div class="layout-slider" id="layout-slider52">
	      <input id="Slider52" type="slider" name="area" value="480;1080" />
	    </div>
	    
	    
	    <p class="day">Samedi</p>
		
		<input type="checkbox" id="trigger6" name="samedi" class="checkbox-11-2">
		<label for="trigger6"></label>
		
		<input type="hidden" id="samedi_debut" name="samedi_debut">
		<input type="hidden" id="samedi_fin" name="samedi_fin">

	    <div class="layout-slider" id="layout-slider6">
	      <input id="Slider6" type="slider" name="area" value="480;1080" />
	      <input type="checkbox" id="openSlider62"  name="samedi2"><label for="openSlider62">Ajouter une nouvelle tranche horaire</label>
	    </div>
	    
	    <input type="hidden" id="samedi_debut2" name="samedi_debut2">
		<input type="hidden" id="samedi_fin2" name="samedi_fin2">
	    
	    <div class="layout-slider" id="layout-slider62">
	      <input id="Slider62" type="slider" name="area" value="480;1080" />
	    </div>
	    
	    
	    
	    <p class="day">Dimanche</p>
		
		<input type="checkbox" id="trigger0" name="dimanche" class="checkbox-11-2">
		<label for="trigger0"></label>
		
		<input type="hidden" id="dimanche_debut" name="dimanche_debut">
		<input type="hidden" id="dimanche_fin" name="dimanche_fin">

	    <div class="layout-slider" id="layout-slider0">
	      <input id="Slider0" type="slider" name="area" value="480;1080" />
	      <input type="checkbox" id="openSlider02"  name="dimanche2"><label for="openSlider02">Ajouter une nouvelle tranche horaire</label>
	    </div>
	    
	    <input type="hidden" id="dimanche_debut2" name="dimanche_debut2">
		<input type="hidden" id="dimanche_fin2" name="dimanche_fin2">
	    
	    <div class="layout-slider" id="layout-slider02">
	      <input id="Slider02" type="slider" name="area" value="480;1080" />
	    </div>
	    
	    
	    
		<p class="title" style="clear:both;" id="jour">Ajouter des jours particuliers</p>
		
		<p class="popin" id="jourinfos">Tu peux ajouter les jours qui n'ont <strong>pas l'horaire régulier</strong>, indique la date, puis choisi si le jour est fermé ou non.</p>
		
		<p class="day spec">Date</p>
		
		<input type="checkbox" id="triggerj1" name="jour1" class="checkbox-11-2">
		<label for="triggerj1"></label>
		
		<input type="text" class="inputDate" id="inputDatej1" name="inputDatej1" placeholder="2014-01-01" />
		
		<input type="hidden" id="jour1_debut" name="jour1_debut">
		<input type="hidden" id="jour1_fin" name="jour1_fin">

	    <div class="layout-slider" id="layout-sliderj1">
	      <input id="Sliderj1" type="slider" name="area" value="480;1080" />
	      <input type="checkbox" id="openSliderj12"  name="jour12"><label for="openSliderj12">Ajouter une nouvelle tranche horaire</label>
	    </div>
	    
	    <input type="hidden" id="jour1_debut2" name="jour1_debut2">
		<input type="hidden" id="jour1_fin2" name="jour1_fin2">
	    
	    <div class="layout-slider" id="layout-sliderj12">
	      <input id="Sliderj12" type="slider" name="area" value="480;1080" />
	    </div>
	    
	    <a href="javascript:add_day('jour2', 'link2');" id="link2" title="Ajouter un jour spécial">+</a>
		
		
	  <div id="jour2">
		    <p class="day spec">Date</p>

		<input type="checkbox" id="triggerj2" name="jour2" class="checkbox-11-2">
		<label for="triggerj2"></label>
		
		<input type="text" class="inputDate" id="inputDatej2" name="inputDatej2" placeholder="2014-01-01" />
		
		<input type="hidden" id="jour2_debut" name="jour2_debut">
		<input type="hidden" id="jour2_fin" name="jour2_fin">

	    <div class="layout-slider" id="layout-sliderj2">
	      <input id="Sliderj2" type="slider" name="area" value="480;1080" />
	      <input type="checkbox" id="openSliderj22"  name="jour22"><label for="openSliderj22">Ajouter une nouvelle tranche horaire</label>
	    </div>
	    
	    <input type="hidden" id="jour2_debut2" name="jour2_debut2">
		<input type="hidden" id="jour2_fin2" name="jour2_fin2">
	    
	    <div class="layout-slider" id="layout-sliderj22">
	      <input id="Sliderj22" type="slider" name="area" value="480;1080" />
	    </div>
	     <a href="javascript:add_day('jour3', 'link3');" id="link3" title="Ajouter un jour spécial">+</a>

	  </div>
	    
	    <div id="jour3">
		    <p class="day spec">Date</p>
		
		<input type="checkbox" id="triggerj3" name="jour3" class="checkbox-11-2">
		<label for="triggerj3"></label>
		
		<input type="text" class="inputDate" id="inputDatej3" name="inputDatej3" placeholder="2014-01-01" />
		
		<input type="hidden" id="jour3_debut" name="jour3_debut">
		<input type="hidden" id="jour3_fin" name="jour3_fin">

	    <div class="layout-slider" id="layout-sliderj3">
	      <input id="Sliderj3" type="slider" name="area" value="480;1080" />
	      <input type="checkbox" id="openSliderj32"  name="jour32"><label for="openSliderj32">Ajouter une nouvelle tranche horaire</label>
	    </div>
	    
	    <input type="hidden" id="jour3_debut2" name="jour3_debut2">
		<input type="hidden" id="jour3_fin2" name="jour3_fin2">
	    
	    <div class="layout-slider" id="layout-sliderj32">
	      <input id="Sliderj32" type="slider" name="area" value="480;1080" />
	    </div>
	     <a href="javascript:add_day('jour4', 'link4');" id="link4" title="Ajouter un jour spécial">+</a>

	    </div>
	    
	   <div id="jour4">
		    <p class="day spec">Date</p>

		<input type="checkbox" id="triggerj4" name="jour4" class="checkbox-11-2">
		<label for="triggerj4"></label>
		
		<input type="text" class="inputDate" id="inputDatej4" name="inputDatej4" placeholder="2014-01-01" />
		
		<input type="hidden" id="jour4_debut" name="jour4_debut">
		<input type="hidden" id="jour4_fin" name="jour4_fin">

	    <div class="layout-slider" id="layout-sliderj4">
	      <input id="Sliderj4" type="slider" name="area" value="480;1080" />
	      <input type="checkbox" id="openSliderj42"  name="jour42"><label for="openSliderj42">Ajouter une nouvelle tranche horaire</label>
	    </div>
	    
	    <input type="hidden" id="jour4_debut2" name="jour4_debut2">
		<input type="hidden" id="jour4_fin2" name="jour4_fin2">
	    
	    <div class="layout-slider" id="layout-sliderj42">
	      <input id="Sliderj42" type="slider" name="area" value="480;1080" />
	    </div>
	     <a href="javascript:add_day('jour5', 'link5');" id="link5" title="Ajouter un jour spécial">+</a>

	   </div>
	    
	    <div id="jour5">
		    <p class="day spec">Date</p>

		<input type="checkbox" id="triggerj5" name="jour5" class="checkbox-11-2">
		<label for="triggerj5"></label>
		
		<input type="text" class="inputDate" id="inputDatej5" name="inputDatej5" placeholder="2014-01-01" />
		
		<input type="hidden" id="jour5_debut" name="jour5_debut">
		<input type="hidden" id="jour5_fin" name="jour5_fin">

	    <div class="layout-slider" id="layout-sliderj5">
	      <input id="Sliderj5" type="slider" name="area" value="480;1080" />
	      <input type="checkbox" id="openSliderj52"  name="jour52"><label for="openSliderj52">Ajouter une nouvelle tranche horaire</label>
	    </div>
	    
	    <input type="hidden" id="jour5_debut2" name="jour5_debut2">
		<input type="hidden" id="jour5_fin2" name="jour5_fin2">
	    
	    <div class="layout-slider" id="layout-sliderj52">
	      <input id="Sliderj52" type="slider" name="area" value="480;1080" />
	    </div>
	     <a href="javascript:add_day('jour6', 'link6');" id="link6" title="Ajouter un jour spécial">+</a>


	    </div>	    
	    
	    <div id="jour6">
		    <p class="day spec">Date</p>
		
		<input type="checkbox" id="triggerj6" name="jour6" class="checkbox-11-2">
		<label for="triggerj6"></label>
		
		<input type="text" class="inputDate" id="inputDatej6" name="inputDatej6" placeholder="2014-01-01" />
		
		<input type="hidden" id="jour6_debut" name="jour6_debut">
		<input type="hidden" id="jour6_fin" name="jour6_fin">

	    <div class="layout-slider" id="layout-sliderj6">
	      <input id="Sliderj6" type="slider" name="area" value="480;1080" />
	      <input type="checkbox" id="openSliderj62"  name="jour62"><label for="openSliderj62">Ajouter une nouvelle tranche horaire</label>
	    </div>
	    
	    <input type="hidden" id="jour6_debut2" name="jour6_debut2">
		<input type="hidden" id="jour6_fin2" name="jour6_fin2">
	    
	    <div class="layout-slider" id="layout-sliderj62">
	      <input id="Sliderj62" type="slider" name="area" value="480;1080" />
	    </div>
	     <a href="javascript:add_day('jour7', 'link7');" id="link7" title="Ajouter un jour spécial">+</a>

	    </div>
	    
	    <div id="jour7">
		     <p class="day spec">Date</p>

		
		<input type="checkbox" id="triggerj7" name="jour7" class="checkbox-11-2">
		<label for="triggerj7"></label>
		
		<input type="text" class="inputDate" id="inputDatej7" name="inputDatej7" placeholder="2014-01-01" />
		
		<input type="hidden" id="jour7_debut" name="jour7_debut">
		<input type="hidden" id="jour7_fin" name="jour7_fin">

	    <div class="layout-slider" id="layout-sliderj7">
	      <input id="Sliderj7" type="slider" name="area" value="480;1080" />
	      <input type="checkbox" id="openSliderj72"  name="jour72"><label for="openSliderj72">Ajouter une nouvelle tranche horaire</label>
	    </div>
	    
	    <input type="hidden" id="jour7_debut2" name="jour7_debut2">
		<input type="hidden" id="jour7_fin2" name="jour7_fin2">
	    
	    <div class="layout-slider" id="layout-sliderj72">
	      <input id="Sliderj72" type="slider" name="area" value="480;1080" />
	    </div>
	     <a href="javascript:add_day('jour8', 'link8');" id="link8" title="Ajouter un jour spécial">+</a>

	    </div>
		
		<div id="jour8">
			<p class="day spec">Date</p>
		
		<input type="checkbox" id="triggerj8" name="jour8" class="checkbox-11-2">
		<label for="triggerj8"></label>
		
		<input type="text" class="inputDate" id="inputDatej8" name="inputDatej8" placeholder="2014-01-01" />
		
		<input type="hidden" id="jour8_debut" name="jour8_debut">
		<input type="hidden" id="jour8_fin" name="jour8_fin">

	    <div class="layout-slider" id="layout-sliderj8">
	      <input id="Sliderj8" type="slider" name="area" value="480;1080" />
	      <input type="checkbox" id="openSliderj82"  name="jour82"><label for="openSliderj82">Ajouter une nouvelle tranche horaire</label>
	    </div>
	    
	    <input type="hidden" id="jour8_debut2" name="jour8_debut2">
		<input type="hidden" id="jour8_fin2" name="jour8_fin2">
	    
	    <div class="layout-slider" id="layout-sliderj82">
	      <input id="Sliderj82" type="slider" name="area" value="480;1080" />
	    </div>
	     <a href="javascript:add_day('jour9', 'link9');" id="link9" title="Ajouter un jour spécial">+</a>

		</div>
	    
	    <div id="jour9">
		    <p class="day spec">Date</p>
		
			<input type="checkbox" id="triggerj9" name="jour9" class="checkbox-11-2">
			<label for="triggerj9"></label>
			
			<input type="text" class="inputDate" id="inputDatej9" name="inputDatej9" placeholder="2014-01-01" />
			
			<input type="hidden" id="jour9_debut" name="jour9_debut">
			<input type="hidden" id="jour9_fin" name="jour9_fin">
	
		    <div class="layout-slider" id="layout-sliderj9">
		      <input id="Sliderj9" type="slider" name="area" value="480;1080" />
		      <input type="checkbox" id="openSliderj92"  name="jour92"><label for="openSliderj92">Ajouter une nouvelle tranche horaire</label>
		    </div>
		    
		    <input type="hidden" id="jour9_debut2" name="jour9_debut2">
			<input type="hidden" id="jour9_fin2" name="jour9_fin2">
		    
		    <div class="layout-slider" id="layout-sliderj92">
		      <input id="Sliderj92" type="slider" name="area" value="480;1080" />
		    </div>
		     <a href="javascript:add_day('jour10', 'link10');" id="link10" title="Ajouter un jour spécial">+</a>

	    </div>
	    
	   <div id="jour10">
		    <p class="day spec">Date</p>
		
		<input type="checkbox" id="triggerj10" name="jour10" class="checkbox-11-2">
		<label for="triggerj10"></label>
		
		<input type="text" class="inputDate" id="inputDatej10" name="inputDatej10" placeholder="2014-01-01" />
		
		<input type="hidden" id="jour10_debut" name="jour10_debut">
		<input type="hidden" id="jour10_fin" name="jour10_fin">

	    <div class="layout-slider" id="layout-sliderj10">
	      <input id="Sliderj10" type="slider" name="area" value="480;1080" />
	      <input type="checkbox" id="openSliderj102"  name="jour102"><label for="openSliderj102">Ajouter une nouvelle tranche horaire</label>
	    </div>
	    
	    <input type="hidden" id="jour10_debut2" name="jour10_debut2">
		<input type="hidden" id="jour10_fin2" name="jour10_fin2">
	    
	    <div class="layout-slider" id="layout-sliderj102">
	      <input id="Sliderj102" type="slider" name="area" value="480;1080" />
	    </div>
	    
	    
	    
	    
	   </div>



    
    
    
    <script type="text/javascript" charset="utf-8">
    	
    	
    	      
      jQuery("#Slider1, #Slider12, #Slider2, #Slider22, #Slider3, #Slider32, #Slider4, #Slider42, #Slider5, #Slider52, #Slider6, #Slider62, #Slider0, #Slider02, #Sliderj1, #Sliderj12, #Sliderj2, #Sliderj22, #Sliderj3, #Sliderj32, #Sliderj4, #Sliderj42, #Sliderj5, #Sliderj52, #Sliderj6, #Sliderj62, #Sliderj7, #Sliderj72, #Sliderj8, #Sliderj82, #Sliderj9, #Sliderj92, #Sliderj10, #Sliderj102").slider({ 

        scale: ['00h', '02h', '04h', '06h','08h', '10h', '12h', '14h', '16h', '18h', '20h', '22h', '24h'], 

        calculate: function( value ){
        var hours = Math.floor( value / 60 );
        var mins = ( value - hours*60 );
        return (hours < 10 ? "0"+hours : hours) + ":" + ( mins == 0 ? "00" : mins );

      }})


      function add_day(id, link) { 
      	document.getElementById(id).style.display="block";
      	document.getElementById(link).style.display="none";
      }

      
    </script>

    <script type="text/javascript">

	    $("#openSlider12").click( function(){
    		
		    if($("#layout-slider12").css('display')=="none"){
	    		$("#layout-slider12").css("display", "block");
	    		$("#openSlider12 + label").html("Supprimer la nouvelle tranche horaire");
	    		
    		} else {
	    		$("#layout-slider12").css("display", "none");
	    		$("#openSlider12 + label").html("Ajouter une nouvelle tranche horaire");
    		}

    	})
    	
    	 $("#openSlider22").click( function(){
    		
		    if($("#layout-slider22").css('display')=="none"){
	    		$("#layout-slider22").css("display", "block");
	    		$("#openSlider22 + label").html("Supprimer la nouvelle tranche horaire");
	    		
    		} else {
	    		$("#layout-slider22").css("display", "none");
	    		$("#openSlider22 + label").html("Ajouter une nouvelle tranche horaire");
    		}

    	})
    	
    	 $("#openSlider32").click( function(){
    		
		    if($("#layout-slider32").css('display')=="none"){
	    		$("#layout-slider32").css("display", "block");
	    		$("#openSlider32 + label").html("Supprimer la nouvelle tranche horaire");
	    		
    		} else {
	    		$("#layout-slider32").css("display", "none");
	    		$("#openSlider32 + label").html("Ajouter une nouvelle tranche horaire");
    		}

    	})
    	
    	$("#openSlider42").click( function(){
    		
		    if($("#layout-slider42").css('display')=="none"){
	    		$("#layout-slider42").css("display", "block");
	    		$("#openSlider42 + label").html("Supprimer la nouvelle tranche horaire");
	    		
    		} else {
	    		$("#layout-slider42").css("display", "none");
	    		$("#openSlider42 + label").html("Ajouter une nouvelle tranche horaire");
    		}

    	})
    	
    	 $("#openSlider52").click( function(){
    		
		    if($("#layout-slider52").css('display')=="none"){
	    		$("#layout-slider52").css("display", "block");
	    		$("#openSlider52 + label").html("Supprimer la nouvelle tranche horaire");
	    		
    		} else {
	    		$("#layout-slider52").css("display", "none");
	    		$("#openSlider52 + label").html("Ajouter une nouvelle tranche horaire");
    		}

    	})
    	
    	 $("#openSlider62").click( function(){
    		
		    if($("#layout-slider62").css('display')=="none"){
	    		$("#layout-slider62").css("display", "block");
	    		$("#openSlider62 + label").html("Supprimer la nouvelle tranche horaire");
	    		
    		} else {
	    		$("#layout-slider62").css("display", "none");
	    		$("#openSlider62 + label").html("Ajouter une nouvelle tranche horaire");
    		}

    	})
    	
    	$("#openSlider02").click( function(){
    		
		    if($("#layout-slider02").css('display')=="none"){
	    		$("#layout-slider02").css("display", "block");
	    		$("#openSlider02 + label").html("Supprimer la nouvelle tranche horaire");
	    		
    		} else {
	    		$("#layout-slider02").css("display", "none");
	    		$("#openSlider02 + label").html("Ajouter une nouvelle tranche horaire");
    		}

    	})
    	
    	$("#openSliderj12").click( function(){
    		
		    if($("#layout-sliderj12").css('display')=="none"){
	    		$("#layout-sliderj12").css("display", "block");
	    		$("#openSliderj12 + label").html("Supprimer la nouvelle tranche horaire");
	    		
    		} else {
	    		$("#layout-sliderj12").css("display", "none");
	    		$("#openSliderj12 + label").html("Ajouter une nouvelle tranche horaire");
    		}

    	})
    	
    	$("#openSliderj22").click( function(){
    		
		    if($("#layout-sliderj22").css('display')=="none"){
	    		$("#layout-sliderj22").css("display", "block");
	    		$("#openSliderj22 + label").html("Supprimer la nouvelle tranche horaire");
	    		
    		} else {
	    		$("#layout-sliderj22").css("display", "none");
	    		$("#openSliderj22 + label").html("Ajouter une nouvelle tranche horaire");
    		}

    	})
    	
    	$("#openSliderj32").click( function(){
    		
		    if($("#layout-sliderj32").css('display')=="none"){
	    		$("#layout-sliderj32").css("display", "block");
	    		$("#openSliderj32 + label").html("Supprimer la nouvelle tranche horaire");
	    		
    		} else {
	    		$("#layout-sliderj32").css("display", "none");
	    		$("#openSliderj32 + label").html("Ajouter une nouvelle tranche horaire");
    		}

    	})
    	
    	$("#openSliderj42").click( function(){
    		
		    if($("#layout-sliderj42").css('display')=="none"){
	    		$("#layout-sliderj42").css("display", "block");
	    		$("#openSliderj42 + label").html("Supprimer la nouvelle tranche horaire");
	    		
    		} else {
	    		$("#layout-sliderj42").css("display", "none");
	    		$("#openSliderj42 + label").html("Ajouter une nouvelle tranche horaire");
    		}

    	})
    	
    	$("#openSliderj52").click( function(){
    		
		    if($("#layout-sliderj52").css('display')=="none"){
	    		$("#layout-sliderj52").css("display", "block");
	    		$("#openSliderj52 + label").html("Supprimer la nouvelle tranche horaire");
	    		
    		} else {
	    		$("#layout-sliderj52").css("display", "none");
	    		$("#openSliderj52 + label").html("Ajouter une nouvelle tranche horaire");
    		}

    	})
    	
    	$("#openSliderj62").click( function(){
    		
		    if($("#layout-sliderj62").css('display')=="none"){
	    		$("#layout-sliderj62").css("display", "block");
	    		$("#openSliderj62 + label").html("Supprimer la nouvelle tranche horaire");
	    		
    		} else {
	    		$("#layout-sliderj62").css("display", "none");
	    		$("#openSliderj62 + label").html("Ajouter une nouvelle tranche horaire");
    		}

    	})
    	
    	$("#openSliderj72").click( function(){
    		
		    if($("#layout-sliderj72").css('display')=="none"){
	    		$("#layout-sliderj72").css("display", "block");
	    		$("#openSliderj72 + label").html("Supprimer la nouvelle tranche horaire");
	    		
    		} else {
	    		$("#layout-sliderj72").css("display", "none");
	    		$("#openSliderj72 + label").html("Ajouter une nouvelle tranche horaire");
    		}

    	})
    	
    	$("#openSliderj82").click( function(){
    		
		    if($("#layout-sliderj82").css('display')=="none"){
	    		$("#layout-sliderj82").css("display", "block");
	    		$("#openSliderj82 + label").html("Supprimer la nouvelle tranche horaire");
	    		
    		} else {
	    		$("#layout-sliderj82").css("display", "none");
	    		$("#openSliderj82 + label").html("Ajouter une nouvelle tranche horaire");
    		}

    	})
    	
    	$("#openSliderj92").click( function(){
    		
		    if($("#layout-sliderj92").css('display')=="none"){
	    		$("#layout-sliderj92").css("display", "block");
	    		$("#openSliderj92 + label").html("Supprimer la nouvelle tranche horaire");
	    		
    		} else {
	    		$("#layout-sliderj92").css("display", "none");
	    		$("#openSliderj92 + label").html("Ajouter une nouvelle tranche horaire");
    		}

    	})
    	
    	$("#openSliderj102").click( function(){
    		
		    if($("#layout-sliderj102").css('display')=="none"){
	    		$("#layout-sliderj102").css("display", "block");
	    		$("#openSliderj102 + label").html("Supprimer la nouvelle tranche horaire");
	    		
    		} else {
	    		$("#layout-sliderj102").css("display", "none");
	    		$("#openSliderj102 + label").html("Ajouter une nouvelle tranche horaire");
    		}

    	})


	$(document).ready(function(){
	
	    window.setInterval(function(){
	
	          var lundi_debut = $("#layout-slider1 #receptdebut").text();
	          $("#lundi_debut").val(lundi_debut);
	
	          var lundi_fin = $("#layout-slider1 #receptfin").text();
	          $("#lundi_fin").val(lundi_fin);
	          
	          var mardi_debut = $("#layout-slider2 #receptdebut").text();
	          $("#mardi_debut").val(mardi_debut);
	
	          var mardi_fin = $("#layout-slider2 #receptfin").text();
	          $("#mardi_fin").val(mardi_fin);
	             
	          var mercredi_debut = $("#layout-slider3 #receptdebut").text();
	          $("#mercredi_debut").val(mercredi_debut);
	
	          var mercredi_fin = $("#layout-slider3 #receptfin").text();
	          $("#mercredi_fin").val(mercredi_fin);
	          
	          var jeudi_debut = $("#layout-slider4 #receptdebut").text();
	          $("#jeudi_debut").val(jeudi_debut);
	
	          var jeudi_fin = $("#layout-slider4 #receptfin").text();
	          $("#jeudi_fin").val(jeudi_fin);
	          
	          var vendredi_debut = $("#layout-slider5 #receptdebut").text();
	          $("#vendredi_debut").val(vendredi_debut);
	
	          var vendredi_fin = $("#layout-slider5 #receptfin").text();
	          $("#vendredi_fin").val(vendredi_fin);
	             
	          var samedi_debut = $("#layout-slider6 #receptdebut").text();
	          $("#samedi_debut").val(samedi_debut);
	
	          var samedi_fin = $("#layout-slider6 #receptfin").text();
	          $("#samedi_fin").val(samedi_fin);
	          
	          var dimanche_debut = $("#layout-slider0 #receptdebut").text();
	          $("#dimanche_debut").val(dimanche_debut);
	
	          var dimanche_fin = $("#layout-slider0 #receptfin").text();
	          $("#dimanche_fin").val(dimanche_fin);
	          
	          
	          var lundi_debut2 = $("#layout-slider12 #receptdebut").text();
	          $("#lundi_debut2").val(lundi_debut2);
	
	          var lundi_fin2 = $("#layout-slider12 #receptfin").text();
	          $("#lundi_fin2").val(lundi_fin2);
	          
	          var mardi_debut2 = $("#layout-slider22 #receptdebut").text();
	          $("#mardi_debut2").val(mardi_debut2);
	
	          var mardi_fin2 = $("#layout-slider22 #receptfin").text();
	          $("#mardi_fin2").val(mardi_fin2);
	             
	          var mercredi_debut2 = $("#layout-slider32 #receptdebut").text();
	          $("#mercredi_debut2").val(mercredi_debut2);
	
	          var mercredi_fin2 = $("#layout-slider32 #receptfin").text();
	          $("#mercredi_fin2").val(mercredi_fin2);
	          
	          var jeudi_debut2 = $("#layout-slider42 #receptdebut").text();
	          $("#jeudi_debut2").val(jeudi_debut2);
	
	          var jeudi_fin2 = $("#layout-slider42 #receptfin").text();
	          $("#jeudi_fin2").val(jeudi_fin2);
	          
	          var vendredi_debut2 = $("#layout-slider52 #receptdebut").text();
	          $("#vendredi_debut2").val(vendredi_debut2);
	
	          var vendredi_fin2 = $("#layout-slider52 #receptfin").text();
	          $("#vendredi_fin2").val(vendredi_fin2);
	             
	          var samedi_debut2 = $("#layout-slider62 #receptdebut").text();
	          $("#samedi_debut2").val(samedi_debut2);
	
	          var samedi_fin2 = $("#layout-slider62 #receptfin").text();
	          $("#samedi_fin2").val(samedi_fin2);
	          
	          var dimanche_debut2 = $("#layout-slider02 #receptdebut").text();
	          $("#dimanche_debut2").val(dimanche_debut2);
	
	          var dimanche_fin2 = $("#layout-slider02 #receptfin").text();
	          $("#dimanche_fin2").val(dimanche_fin2);
	          
	          
	          
	          
	          var jour1_debut = $("#layout-sliderj1 #receptdebut").text();
	          $("#jour1_debut").val(jour1_debut);
	
	          var jour1_fin = $("#layout-sliderj1 #receptfin").text();
	          $("#jour1_fin").val(jour1_fin);
	          
	          var jour2_debut = $("#layout-sliderj2 #receptdebut").text();
	          $("#jour2_debut").val(jour2_debut);
	
	          var jour2_fin = $("#layout-sliderj2 #receptfin").text();
	          $("#jour2_fin").val(jour2_fin);
	             
	          var jour3_debut = $("#layout-sliderj3 #receptdebut").text();
	          $("#jour3_debut").val(jour3_debut);
	
	          var jour3_fin = $("#layout-sliderj3 #receptfin").text();
	          $("#jour3_fin").val(jour3_fin);
	          
	          var jour4_debut = $("#layout-sliderj4 #receptdebut").text();
	          $("#jour4_debut").val(jour4_debut);
	
	          var jour4_fin = $("#layout-sliderj4 #receptfin").text();
	          $("#jour4_fin").val(jour4_fin);
	          
	          var jour5_debut = $("#layout-sliderj5 #receptdebut").text();
	          $("#jour5_debut").val(jour5_debut);
	
	          var jour5_fin = $("#layout-sliderj5 #receptfin").text();
	          $("#jour5_fin").val(jour5_fin);
	             
	          var jour6_debut = $("#layout-sliderj6 #receptdebut").text();
	          $("#jour6_debut").val(jour6_debut);
	
	          var jour6_fin = $("#layout-sliderj6 #receptfin").text();
	          $("#jour6_fin").val(jour6_fin);
	          
	          var jour7_debut = $("#layout-sliderj7 #receptdebut").text();
	          $("#jour7_debut").val(jour7_debut);
	
	          var jour7_fin = $("#layout-sliderj7 #receptfin").text();
	          $("#jour7_fin").val(jour7_fin);
	          
	          var jour8_debut = $("#layout-sliderj8 #receptdebut").text();
	          $("#jour8_debut").val(jour8_debut);
	
	          var jour8_fin = $("#layout-sliderj8 #receptfin").text();
	          $("#jour8_fin").val(jour8_fin);
	             
	          var jour9_debut = $("#layout-sliderj9 #receptdebut").text();
	          $("#jour9_debut").val(jour9_debut);
	
	          var jour9_fin = $("#layout-sliderj9 #receptfin").text();
	          $("#jour9_fin").val(jour9_fin);
	          
	          var jour10_debut = $("#layout-sliderj10 #receptdebut").text();
	          $("#jour10_debut").val(jour10_debut);
	
	          var jour10_fin = $("#layout-sliderj10 #receptfin").text();
	          $("#jour10_fin").val(jour10_fin);
	          
	          
	          
	          
	          
	          
	          
	          var jour1_debut2 = $("#layout-sliderj12 #receptdebut").text();
	          $("#jour1_debut2").val(jour1_debut2);
	
	          var jour1_fin2 = $("#layout-sliderj12 #receptfin").text();
	          $("#jour1_fin2").val(jour1_fin2);
	          
	          var jour2_debut2 = $("#layout-sliderj22 #receptdebut").text();
	          $("#jour2_debut2").val(jour2_debut2);
	
	          var jour2_fin2 = $("#layout-sliderj22 #receptfin").text();
	          $("#jour2_fin2").val(jour2_fin2);
	             
	          var jour3_debut2 = $("#layout-sliderj32 #receptdebut").text();
	          $("#jour3_debut2").val(jour3_debut2);
	
	          var jour3_fin2 = $("#layout-sliderj32 #receptfin").text();
	          $("#jour3_fin2").val(jour3_fin2);
	          
	          var jour4_debut2 = $("#layout-sliderj42 #receptdebut").text();
	          $("#jour4_debut2").val(jour4_debut2);
	
	          var jour4_fin2 = $("#layout-sliderj42 #receptfin").text();
	          $("#jour4_fin2").val(jour4_fin2);
	          
	          var jour5_debut2 = $("#layout-sliderj52 #receptdebut").text();
	          $("#jour5_debut2").val(jour5_debut2);
	
	          var jour5_fin2 = $("#layout-sliderj52 #receptfin").text();
	          $("#jour5_fin2").val(jour5_fin2);
	             
	          var jour6_debut2 = $("#layout-sliderj62 #receptdebut").text();
	          $("#jour6_debut2").val(jour6_debut2);
	
	          var jour6_fin2 = $("#layout-sliderj62 #receptfin").text();
	          $("#jour6_fin2").val(jour6_fin2);
	          
	          var jour7_debut2 = $("#layout-sliderj72 #receptdebut").text();
	          $("#jour7_debut2").val(jour7_debut2);
	
	          var jour7_fin2 = $("#layout-sliderj72 #receptfin").text();
	          $("#jour7_fin2").val(jour7_fin2);
	          
	          var jour8_debut2 = $("#layout-sliderj82 #receptdebut").text();
	          $("#jour8_debut2").val(jour8_debut2);
	
	          var jour8_fin2 = $("#layout-sliderj82 #receptfin").text();
	          $("#jour8_fin2").val(jour8_fin2);
	             
	          var jour9_debut2 = $("#layout-sliderj92 #receptdebut").text();
	          $("#jour9_debut2").val(jour9_debut2);
	
	          var jour9_fin2 = $("#layout-sliderj92 #receptfin").text();
	          $("#jour9_fin2").val(jour9_fin2);
	          
	          var jour10_debut2 = $("#layout-sliderj102 #receptdebut").text();
	          $("#jour10_debut2").val(jour10_debut2);
	
	          var jour10_fin2 = $("#layout-sliderj102 #receptfin").text();
	          $("#jour10_fin2").val(jour10_fin2);

	          
	          
	          }, 100);
	          
	          
	
	});


      $("#trigger1").click( function(){
        $(".layout-slider#layout-slider1").slideToggle("fast");
        $("#Slider1").slider().update();
        if($("#layout-slider12").css('display')=="block") {
	        $(".layout-slider#layout-slider12").slideToggle("fast");
	        $("#Slider12").slider().update();
	        $("#openSlider12 + label").html("Ajouter une nouvelle tranche horaire");
        }
      });
      
      $("#trigger2").click( function(){
        $(".layout-slider#layout-slider2").slideToggle("fast");
        $("#Slider2").slider().update();
        if($("#layout-slider22").css('display')=="block") {
	        $(".layout-slider#layout-slider22").slideToggle("fast");
	        $("#Slider22").slider().update();
	        $("#openSlider22 + label").html("Ajouter une nouvelle tranche horaire");
        }
      });
      
      $("#trigger3").click( function(){
        $(".layout-slider#layout-slider3").slideToggle("fast");
        $("#Slider3").slider().update();
        if($("#layout-slider32").css('display')=="block") {
	        $(".layout-slider#layout-slider32").slideToggle("fast");
	        $("#Slider32").slider().update();
	        $("#openSlider32 + label").html("Ajouter une nouvelle tranche horaire");
        }
      });
      
      $("#trigger4").click( function(){
        $(".layout-slider#layout-slider4").slideToggle("fast");
        $("#Slider4").slider().update();
        if($("#layout-slider42").css('display')=="block") {
	        $(".layout-slider#layout-slider42").slideToggle("fast");
	        $("#Slider42").slider().update();
	        $("#openSlide42 + label").html("Ajouter une nouvelle tranche horaire");
        }
      });
      
      $("#trigger5").click( function(){
        $(".layout-slider#layout-slider5").slideToggle("fast");
        $("#Slider5").slider().update();
        if($("#layout-slider52").css('display')=="block") {
	        $(".layout-slider#layout-slider52").slideToggle("fast");
	        $("#Slider52").slider().update();
	        $("#openSlider52 + label").html("Ajouter une nouvelle tranche horaire");
        }
      });
      
      $("#trigger6").click( function(){
        $(".layout-slider#layout-slider6").slideToggle("fast");
        $("#Slider6").slider().update();
        if($("#layout-slider62").css('display')=="block") {
	        $(".layout-slider#layout-slider62").slideToggle("fast");
	        $("#Slider62").slider().update();
	        $("#openSlider62 + label").html("Ajouter une nouvelle tranche horaire");
        }
      });
      
      $("#trigger0").click( function(){
        $(".layout-slider#layout-slider0").slideToggle("fast");
        $("#Slider0").slider().update();
        if($("#layout-slider02").css('display')=="block") {
	        $(".layout-slider#layout-slider02").slideToggle("fast");
	        $("#Slider02").slider().update();
	        $("#openSlider02 + label").html("Ajouter une nouvelle tranche horaire");
        }
      });
      
      $("#triggerj1").click( function(){
        $(".layout-slider#layout-sliderj1").slideToggle("fast");
        $("#Sliderj1").slider().update();
        if($("#layout-sliderj12").css('display')=="block") {
	        $(".layout-slider#layout-sliderj12").slideToggle("fast");
	        $("#Sliderj12").slider().update();
	        $("#openSliderj12 + label").html("Ajouter une nouvelle tranche horaire");
        }
      });
      
      $("#triggerj2").click( function(){
        $(".layout-slider#layout-sliderj2").slideToggle("fast");
        $("#Sliderj2").slider().update();
        if($("#layout-sliderj22").css('display')=="block") {
	        $(".layout-slider#layout-sliderj22").slideToggle("fast");
	        $("#Sliderj22").slider().update();
	        $("#openSliderj22 + label").html("Ajouter une nouvelle tranche horaire");
        }
      });
      
      $("#triggerj3").click( function(){
        $(".layout-slider#layout-sliderj3").slideToggle("fast");
        $("#Sliderj3").slider().update();
        if($("#layout-sliderj32").css('display')=="block") {
	        $(".layout-slider#layout-sliderj32").slideToggle("fast");
	        $("#Sliderj32").slider().update();
	        $("#openSliderj32 + label").html("Ajouter une nouvelle tranche horaire");
        }
      });
      
      $("#triggerj4").click( function(){
        $(".layout-slider#layout-sliderj4").slideToggle("fast");
        $("#Sliderj4").slider().update();
        if($("#layout-sliderj42").css('display')=="block") {
	        $(".layout-slider#layout-sliderj42").slideToggle("fast");
	        $("#Sliderj42").slider().update();
	        $("#openSlidej42 + label").html("Ajouter une nouvelle tranche horaire");
        }
      });
      
      $("#triggerj5").click( function(){
        $(".layout-slider#layout-sliderj5").slideToggle("fast");
        $("#Sliderj5").slider().update();
        if($("#layout-sliderj52").css('display')=="block") {
	        $(".layout-slider#layout-sliderj52").slideToggle("fast");
	        $("#Sliderj52").slider().update();
	        $("#openSliderj52 + label").html("Ajouter une nouvelle tranche horaire");
        }
      });
      
      $("#triggerj6").click( function(){
        $(".layout-slider#layout-sliderj6").slideToggle("fast");
        $("#Sliderj6").slider().update();
        if($("#layout-sliderj62").css('display')=="block") {
	        $(".layout-slider#layout-sliderj62").slideToggle("fast");
	        $("#Sliderj62").slider().update();
	        $("#openSliderj62 + label").html("Ajouter une nouvelle tranche horaire");
        }
      });
      
      $("#triggerj7").click( function(){
        $(".layout-slider#layout-sliderj7").slideToggle("fast");
        $("#Sliderj7").slider().update();
        if($("#layout-sliderj72").css('display')=="block") {
	        $(".layout-slider#layout-sliderj72").slideToggle("fast");
	        $("#Sliderj72").slider().update();
	        $("#openSlidej72 + label").html("Ajouter une nouvelle tranche horaire");
        }
      });
      
      $("#triggerj8").click( function(){
        $(".layout-slider#layout-sliderj8").slideToggle("fast");
        $("#Sliderj8").slider().update();
        if($("#layout-sliderj82").css('display')=="block") {
	        $(".layout-slider#layout-sliderj82").slideToggle("fast");
	        $("#Sliderj82").slider().update();
	        $("#openSliderj82 + label").html("Ajouter une nouvelle tranche horaire");
        }
      });
      
      $("#triggerj9").click( function(){
        $(".layout-slider#layout-sliderj9").slideToggle("fast");
        $("#Sliderj9").slider().update();
        if($("#layout-sliderj92").css('display')=="block") {
	        $(".layout-slider#layout-sliderj92").slideToggle("fast");
	        $("#Sliderj92").slider().update();
	        $("#openSliderj92 + label").html("Ajouter une nouvelle tranche horaire");
        }
      });
      
      $("#triggerj10").click( function(){
        $(".layout-slider#layout-sliderj10").slideToggle("fast");
        $("#Sliderj10").slider().update();
        if($("#layout-sliderj102").css('display')=="block") {
	        $(".layout-slider#layout-sliderj102").slideToggle("fast");
	        $("#Sliderj102").slider().update();
	        $("#openSliderj102 + label").html("Ajouter une nouvelle tranche horaire");
        }
      });



    </script>
		
			
		<input type="hidden" name="action" value="add">
		<input type="submit" value="Ajouter ce commerce" id="submit_ajouter" disabled="disabled">
	</form>
	
	<? } ?>
</div>


	
    
   <div id="popupfortop" style="display:none;">
   	<h2 onclick="$('#popupfortop, #overlay').hide();">Meilleurs contributeurs</h2>
   	<a href="#" onclick="$('#popupfortop, #overlay').hide();" class="fermer">Fermer</a>
   	<ul style="clear:both;">
   	
   	<?
    	$topuser = $bdd->query("SELECT id, username, niveau FROM drovi_users ORDER BY niveau DESC LIMIT 3");
    	$top=1;
    	
    	while($row = $topuser->fetch()){
	    	echo "<li><span><span>$top</span> ". $row['username'] ." </span> <strong>". $row['niveau'] ."</strong> XP </li>";
	    	$top++;
	    	
	    	if($row['id']==$_SESSION['drovi']) $ok=1;
    	}
    	
    	if(!$_SESSION['drovi']) {
	    	echo "<p style='padding:20px 10px;text-align:center;'>Toi aussi participe à Drovi, inscris-toi et gagne de l'expérience!</p>";
    	} else {
    	
    	if($ok) {
	    	echo "<p style='padding:20px 10px;text-align:center;'><strong>FELICITATIONS!<strong></p>";
    	} else {    	
	    	echo "<p style='padding:20px 10px;'><strong>Ajoute</strong> des favoris et des commerces, <strong>modifie</strong> les commerces qui ont un horaire incorrect pour <strong>gagner de l'expérience</strong> et arriver dans le <strong>top 3</strong>!</p>";
	    	}
    	}
    	
    	
    ?>

   	</ul>
   </div>
   
   
   <div id="sidebar">
   	<ul>
   		<li id="twitter">
   		<a href="http://twitter.com/DroviBe" target="_blank">
	   		<img src="img/twitter_blanc.png">
	   		<p>Abonne-toi!</p>
	   	</a>
   		</li>
   		<li id="top">
   		<a href="#" onclick="$('#popupfortop, #overlay').show();">
	   		<img src="img/trophy.png">
	   		<p>Voir le top 3</p>
   		</li>
   		</a>
   	</ul>
   </div>



</div>
	
		<nav id="menu">
				<ul>
				
				<li id="home"><a href="recherche.php">RECHERCHE</a></li>
				
				<?php					
				
				if($_SESSION['drovi']) {
		
						
?>
					<li id="favoris"><a href="favoris.php">FAVORIS</a></li>
					<script>var w=3</script>
					<?
										
					if($_SESSION['drovi_xp']>= 10){
						echo "<li id='ajoutermenu'><a href='ajouter.php'>AJOUTER</a></li>";
						echo '<script>var w=4</script>';
					}
					
					
					?>
					<li id="compte"><a href="compte.php">COMPTE</a></li>					
				<?php
				
				
				} else {
					echo '<script>var w=2</script>';
				
					?>
					
					<li id="compte"><a href="inscription.php">COMPTE</a></li>
					
					<?php
				}
				
				
				?>
				</ul>
			</nav>



	
	<!-- Chargement de l'API Google maps -->
	<script src="http://maps.google.com/maps/api/js?sensor=true"></script>


</div>

<script>

	var flag_latlng=false;

	function getAdresse() {
		// Une variable pour contenir notre future marker
		var myMarker = null;
		document.getElementById("checkmap").style.height="300px";
		document.getElementById("checkmap").style.opacity="1";

		// Des coordonnées de départ
		var myLatlng = new google.maps.LatLng(-34.397, 150.644);

		// Les options de notre carte
		var myOptions = {
			zoom: 17,
			center: myLatlng,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		};

		// On créé la carte
		var myMap = new google.maps.Map(
			document.getElementById('checkmap'),
			myOptions
			);
		

		// L'adresse que nous allons rechercher
		var resultat=document.getElementById("adresse").value;
		var GeocoderOptions = {
		    'address' : resultat,
		    'region' : 'BE'
		}

		// Notre fonction qui traitera le resultat
		function GeocodingResult( results , status )
		{
		  // Si la recher à fonctionné
		  if( status == google.maps.GeocoderStatus.OK ) {
		  

		    // S'il existait déjà un marker sur la map,
		    // on l'enlève
		    if(myMarker != null) {
		      myMarker.setMap(null);
                    }

		    // On créé donc un nouveau marker sur l'adresse géocodée
		    myMarker = new google.maps.Marker({
		      position: results[0].geometry.location,
		      map: myMap,
		      title: "Nouveau commerce"
		    });

		    // Et on centre la vue sur ce marker
		    myMap.setCenter(results[0].geometry.location);
		    
		    var latlng_value=results[0].geometry.location;
		    var regExp = /\(([^)]+)\)/;
		    latlng_value = regExp.exec(latlng_value);
		    document.getElementById("latlng").value = latlng_value[1];
		    
		    
		    flag_latlng=true;
		    

		  } else {
			  popup('L\'adresse que tu as donné semble inconnue...');
			  document.getElementById("adresse").style.background="#e74c3c";
			  document.getElementById("adresse").className="";
			  $('#adresse').hover(function(){$(this).css("color", "#fff");});
		  }
		}

		// Nous pouvons maintenant lancer la recherche de l'adresse
		var myGeocoder = new google.maps.Geocoder();
		myGeocoder.geocode( GeocoderOptions, GeocodingResult );
		
		
	}
	




</script>

		<script type="text/javascript">
			
			$('#cat').selectize({});
			
			
	
function createXhrObject(){
	    if (window.XMLHttpRequest)
		return new XMLHttpRequest();

	    if (window.ActiveXObject){
		var names = [
		    "Msxml2.XMLHTTP.6.0",
		    "Msxml2.XMLHTTP.3.0",
		    "Msxml2.XMLHTTP",
		    "Microsoft.XMLHTTP"
		];
		for(var i in names){
		    try{ return new ActiveXObject(names[i]); }
		    catch(e){}
		}
	}
	    window.alert("Votre navigateur ne prend pas en charge l'objet XMLHTTPRequest.");
	    return null; // non supporté
	}

	xhr=createXhrObject();

    function gm(action) {
    
    	if(action == 'nomcommercedispo'){
    		var nom=document.getElementById("nom").value;
					
			xhr.open("GET","gm.php?action="+action+"&nom="+nom,true);
			xhr.onreadystatechange=function(){
			  if(xhr.readyState==4)
			    if(xhr.status==200) {
					eval(xhr.responseText);
			    }
			}
		}
		
		if(action == 'adressecommercedispo'){
    		var adresse=document.getElementById("adresse").value;
					
			xhr.open("GET","gm.php?action="+action+"&adresse="+adresse,true);
			xhr.onreadystatechange=function(){
			  if(xhr.readyState==4)
			    if(xhr.status==200) {
					eval(xhr.responseText);
			    }
			}
		}
		
		xhr.send();
		
		
	}
	
	
	function popup(text) {
		var popup = document.getElementById('popup');
	
		popup.innerHTML=text;
		popup.style.top='35px';
		
		
		setTimeout(function(){popup.style.top='-100px';},10000);
	}
	
	function wrong_input(id){
		$(id).removeClass('ok');
		$(id).css('background', '#e74c3c');
		$(id).mouseover(function(event){$(id).css("color", "#fff");});
	}


		$(document).ready(function(){
		
		var adresseinfos = $("#adresseinfos").height();
		$("#adresseinfos").css("margin-top", "-"+(adresseinfos+120)+"px");
		
		var latlnginfos = $("#latlnginfos").height();
		$("#latlnginfos").css("margin-top", "-"+(latlnginfos+120)+"px");
		
		var horaireinfos = $("#horaireinfos").height();
		$("#horaireinfos").css("margin-top", "-"+(horaireinfos+80)+"px");
		
		var jourinfos = $("#jourinfos").height();
		$("#jourinfos").css("margin-top", "-"+(jourinfos+80)+"px");

    	$("#adresse, #adresseinfos").click(function(event){
    		var z = $("#adresseinfos");
    		if(z.css("opacity")==="0") {
	    		z.css({"opacity": "1", "left": "auto"});
    		} else {
	    		z.css({"opacity": "0", "left": "-600px"});
    		}
	    })

    	$("#latlng, #latlnginfos").click(function(event){
    		var z = $("#latlnginfos");
    		if(z.css("opacity")==="0") {
	    		z.css({"opacity": "1", "left": "auto"});
    		} else {
	    		z.css({"opacity": "0", "left": "-600px"});
    		}
	    })
	    
	    $("#horaire, .day").mouseover(function(event){
    		var z = $("#horaireinfos");
    		if(z.css("opacity")==="0") {
	    		z.css({"opacity": "1", "left": "auto"});
    		} /*
else {
	    		z.css({"opacity": "0", "left": "-600px"});
    		}
*/
	    })
	    
	     $("#horaireinfos").click(function(event){
	    	var z = $("#horaireinfos");
    		if(z.css("opacity")==="0") {
	    		z.css({"opacity": "1", "left": "auto"});
    		} else {
	    		z.css({"opacity": "0", "left": "-600px"});
    		}
	    })
	    
	    	$("#jour, .spec").mouseover(function(event){
    		var z = $("#jourinfos");
    		if(z.css("opacity")==="0") {
	    		z.css({"opacity": "1", "left": "auto"});
    		} /*
else {
	    		z.css({"opacity": "0", "left": "-600px"});
    		}
*/
	    })
	    
	     $("#jourinfos").click(function(event){
	    	var z = $("#jourinfos");
    		if(z.css("opacity")==="0") {
	    		z.css({"opacity": "1", "left": "auto"});
    		} else {
	    		z.css({"opacity": "0", "left": "-600px"});
    		}
	    })
	     
		
	    $("#connexion").mouseover(function(event){
    		var z = $("#coinfos");
	    	z.css({"opacity": "1", "right": "10px", "left": "auto"});

	    })
	    
	    $("#connexion, #coinfos").mouseout(function(event){
    		var z = $("#coinfos");
    		z.css({"opacity": "0", "right": "auto", "left": "-600px"});
	    })
	    
	    $("#deconnexion").mouseover(function(event){
    		var z = $("#decoinfos");
	    	z.css({"opacity": "1", "right": "10px", "left": "auto"});

	    })
	    
	    $("#deconnexion, #decoinfos").mouseout(function(event){
    		var z = $("#decoinfos");
    		z.css({"opacity": "0", "right": "auto", "left": "-600px"});
	    })
	     


	    })


		var x = $( window ).height(); 
    	
    	
			var z = (x-(20*w))/w;	
			var prc = z * (1 * (10 / 100));	
			$('#menu li a').css("padding", z-prc+"px 0 "+prc+"px");
			
			if(z-prc<115){
				$("#menu li a").css("text-indent", "-9999px");
			} else {
				$("#menu li a").css("text-indent", "0px");
			}
			
			if(x<=300){
				$("#menu li a").css("text-indent", "0px");
				$('#menu li a').css("padding", z/2+"px 0px");
			}
			
    	
	    	
	    	
    	
    	
    	$(window).on('resize', function(event) {
	    	var x = $( window ).height(); 
	    	
	    	
			var z = (x-(20*w))/w;	
			var prc = z * (1 * (10 / 100));	
			$('#menu li a').css("padding", z-prc+"px 0 "+prc+"px");
			
			if(z-prc<115){
				$("#menu li a").css("text-indent", "-9999px");
			} else {
				$("#menu li a").css("text-indent", "0px");
			}
			
			if(x<=300){
				$("#menu li a").css("text-indent", "0px");
				$('#menu li a').css("padding", z/2+"px 0px");
			}
			   	
    	});
    	
    	
    	$( "#nom" ).change(function() {
    		
    		gm('nomcommercedispo');
	    	
			if($("#nom").val().length <= 2){
				$("#nom").removeClass("ok");
				$("#nom").css("background", "#e74c3c");
				$('#nom').hover(function(){$(this).css("color", "#fff");});
				popup('Le nom du magasin est trop court!');	
			} else {
				$("#nom").addClass("ok");
			}
		
	    });
	    
	    $( "#description" ).change(function() {
    			    	
			if($("#description").val().length > 40){
				$("#description").removeClass("ok");
				$("#description").css("background", "#e74c3c");
				$('#description').hover(function(){$(this).css("color", "#fff");});
				popup('La description du commerce est trop longue!');	
			} else {
				$("#description").addClass("ok");
			}
		
	    });
	    
	    var regex = /[0-9a-zA-Z]/;
	    
	    
	    $( "#adresse" ).change(function() {
	    
	    	gm('adressecommercedispo');
	    	
			if(!regex.test($("#adresse").val())){
				$("#adresse").removeClass("ok");
				$("#adresse").css("background", "#e74c3c");
				$('#adresse').hover(function(){$(this).css("color", "#fff");});
				popup('L\'adresse n\'est pas valide');	
			} else {
				$("#adresse").addClass("ok");
			}
		
	    });
	    
	    var regex2 = /[0-9.,]/;
	    
	    $( "#latlng" ).change(function() {
	    	
			if(!regex2.test($("#latlng").val())){
				$("#latlng").removeClass("ok");
				$("#latlng").css("background", "#e74c3c");
				$('#latlng').hover(function(){$(this).css("color", "#fff");});
				popup('Coordonées fausses');	
			} else {
				$("#latlng").addClass("ok");
			}
		
	    });
	    
	    
	    $( "#cat" ).change(function() {
	    	
	    	
			if(!$("#cat").val()){
				$(".selectize-input.full, .selectize-input").removeClass("ok");
				$(".selectize-input.full, .selectize-input").css("background", "#e74c3c");
				$('.selectize-input.full, .selectize-input').hover(function(){$(this).css("color", "#fff");});
				popup('Veuillez choisir une catégorie!');	
			} else {
				$(".selectize-input.full, .selectize-input").addClass("ok");
			}
		
	    });

	    
	    $('input, select').change(function(){
	    
	   
	    
	    if( $("#nom").val().length > 2 && regex.test($("#adresse").val()) && (regex2.test($("#latlng").val()) || flag_latlng==true) && $("#cat").val()){
		    $("#submit_ajouter").removeAttr('disabled');
	    }
	    
	    });

				
		</script>

</body>
</html>

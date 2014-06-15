<?php

session_start();

		// ini_set('display_errors', 1);
		// error_reporting(E_ALL);

try {
	$bdd = new PDO('mysql:host=localhost;dbname=DB', 'DB', 'MDP');
}

catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
}



$id=$_SESSION['drovi'];

		$donneesuser = $bdd->query("SELECT * FROM drovi_users WHERE id='$id'");
					
		$row = $donneesuser->fetch();
		
		$_SESSION['drovi_xp']=$row[4];
		$_SESSION['drovi_nom']=$row[1];

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
	
	<title>Recherche | Drovi</title>
	
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
		

      
      
      <script type="text/javascript">
      
      function openFiltres(){
			var elmt = document.getElementById("filtres");
			var title = document.getElementById("openfiltres");
			
			var winwidth = window.innerWidth;
			
			var divwidth = 220;
						
			if(winwidth>640){
				divwidth=110;
			}
			
			if(elmt.style.height=="0px" || !elmt.style.height){
				elmt.style.height= divwidth+"px";
				title.style.marginTop="-"+(divwidth)+"px";
				title.style.backgroundColor="#2c3e50";
				title.innerHTML="&#9660; <?php 
				
				if($_GET['filtre'] ) { 
					echo "Filtre choisi : ";
					
					if($_GET['filtre']=='nightshop') {
						echo "night shop";
					} else {
					echo "<span>".$_GET['filtre']."</span>"; 
					}
					
					echo "<a id='supprfiltre' href='?'>X</a>";
				} else { 
					echo "Choisir un filtre"; 
				} 				
		?> &#9660;";

			} else {
				elmt.style.height="0px";
				title.style.marginTop="0px";
				title.style.backgroundColor="#1abc9c";
				title.innerHTML="&#9650; <?php 
				
				if($_GET['filtre'] ) { 
					
					if($_GET['filtre']=='nightshop') {
						echo "Filtre choisi :  Night Shop";
					} else {
					echo "Filtre choisi :  <span>".$_GET['filtre']."</span>"; 
					}
				} else { 
					echo "Choisir un filtre"; 
				} 
				
		?> &#9650;";
			}
		}
		
		
     <!--



function multiClass(eltId) {
	
	arrLinkId = new Array('_0','_1','_2');
	intNbLinkElt = new Number(arrLinkId.length);
	arrClassLink = new Array('current','ghost');
	strContent = new String()
	
	for (i=0; i<intNbLinkElt; i++) {
		strContent = "menu"+arrLinkId[i];
		if ( arrLinkId[i] == eltId ) {
			document.getElementById(arrLinkId[i]).className = arrClassLink[0];
			document.getElementById(strContent).className = 'on content';
			
		} else {
			document.getElementById(arrLinkId[i]).className = arrClassLink[1];
			document.getElementById(strContent).className = 'off content';
		}
	}	
}


-->


      </script>
      
      
		
		    <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAgrj58PbXr2YriiRDqbnL1RSqrCjdkglBijPNIIYrqkVvD1R4QxRl47Yh2D_0C1l5KXQJGrbkSDvXFA"
      type="text/javascript"></script>
    
</head>
<body>


	
<div id="page">

<div id="popupforfavoris">


<?


 if($_GET['commerce']){
	$commerce=$_GET['commerce'];
	
	if($_GET['filtre']) $filtre="AND cat='".$_GET['filtre']."'";

					
	$reponsepattern = $bdd->query("SELECT * FROM drovi_magasins WHERE nom LIKE '%$commerce%' $filtre");
	$resultatspattern = $reponsepattern->rowCount();

	if($resultatspattern == 0) {
	
	?>
	<h2 onclick="$('#popupforfavoris, #overlay').hide();">Liste des résultats</h2><a href="$('#popupforfavoris, #overlay').hide();" class="fermer">Fermer</a><ul>
	<p style='text-align: center;'>Il n'y a aucun résultat<p>
	<?
	} else {
	?><h2 onclick="$('#popupforfavoris, #overlay').hide();">Liste des <? echo $resultatspattern; ?> résultats</h2><?
	if($_GET['latlng_choice']){
		?>
		
		<a style="color:#000;text-decoration:none;" href="?"><p style="text-align:center;width:200px;display:block;float:left"><strong>Voir ta position sur la carte</strong>
		</p></a>
		

		<?
	}
	?><a href="#" onclick="$('#popupforfavoris, #overlay').hide();" class="fermer">Fermer</a><ul><?
}




while($donnees=$reponsepattern->fetch()){
	$nom=$donnees['nom'];
	$adresse=$donnees['adresse'];
	$description=$donnees['description'];
	$cat=$donnees['cat'];
	$latlng=$donnees['latLng'];
	
	$nom=str_replace("\'", "'", $nom);
	$adresse=str_replace("\'", "'", $adresse);
	$description=str_replace("\'", "'", $description);
	
	$lundi=$donnees['1'];
	$mardi=$donnees['2'];
	$mercredi=$donnees['3'];
	$jeudi=$donnees['4'];
	$vendredi=$donnees['5'];
	$samedi=$donnees['6'];
	$dimanche=$donnees['0'];
	
	$lundi=str_replace("to", "à", $lundi);
	$mardi=str_replace("to", "à", $mardi);
	$mercredi=str_replace("to", "à", $mercredi);
	$jeudi=str_replace("to", "à", $jeudi);
	$vendredi=str_replace("to", "à", $vendredi);
	$samedi=str_replace("to", "à", $samedi);
	$dimanche=str_replace("to", "à", $dimanche);
	
	$lundi=str_replace("and", "et", $lundi);
	$mardi=str_replace("and", "et", $mardi);
	$mercredi=str_replace("and", "et", $mercredi);
	$jeudi=str_replace("and", "et", $jeudi);
	$vendredi=str_replace("and", "et", $vendredi);
	$samedi=str_replace("and", "et", $samedi);
	$dimanche=str_replace("and", "et", $dimanche);
	
	if(!$lundi) {$lundi="fermé";} //else {$lundi=substr($lundi, 0, -3);}
	if(!$mardi) {$mardi="fermé";} //else {$mardi=substr($mardi, 0, -3);}
	if(!$mercredi) {$mercredi="fermé";} //else {$mercredi=substr($mercredi, 0, -3);}
	if(!$jeudi) {$jeudi="fermé";} //else {$jeudi=substr($jeudi, 0, -3);}
	if(!$vendredi) {$vendredi="fermé";} //else {$vendredi=substr($vendredi, 0, -3);}
	if(!$samedi) {$samedi="fermé";} //else {$samedi=substr($samedi, 0, -3);}
	if(!$dimanche) {$dimanche="fermé";} //else {$dimanche=substr($dimanche, 0, -3);}
	
	

	
	?>
	
	<li class="favorisliste">
		<a style="color:#000;text-decoration:none;" href="?commerce=<? echo $commerce; ?>&latlng_choice=<? echo $latlng; ?>"><p><strong><? echo $nom; ?></strong></p>
		<p><em><? echo $adresse; ?></em><br>
		<? echo $cat; if($description) echo " - ". $description; ?><br>
		</p></a>	
		<? echo "<strong>Lundi</strong> ". $lundi ."<br> <strong>Mardi</strong> ". $mardi ."<br> <strong>Mercredi</strong> ". $mercredi ."<br> <strong>Jeudi</strong> ". $jeudi ."<br> <strong>Vendredi</strong> ". $vendredi ."<br> <strong>Samedi</strong> ". $samedi ."<br> <strong>Dimanche</strong> ". $dimanche; ?>	
	</li>
	
	<?
	
}

} else {
?>
	<h2 onclick="$('#popupforfavoris, #overlay').hide();">Liste des résultats</h2><ul>
	<p style='text-align: center;'>Il n'y a aucune recherche effectuée<p>
<?
}

?>
<ul>
</div>
<div id="overlay" style="display:none;" onclick="$('#popupforfavoris, #overlay, #popupfortop').hide();"></div>

	
 
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
		
		
		
		if($_GET['action']=='deco') {
			$_SESSION['drovi']='';
			$_SESSION['drovi_xp']='';
			
			echo "<script>popup('Tu va être déconnecté...') setTimeout(function(){window.location.reload();},3000);</script>";
		}
		?>
			
		
		
		<h1><a href="index.php" title="Un commerce ouvert ici et maintenant">Drovi - Trouver un commerce</a></h1>
	

	</header>
	

		
	
	<div id="content">	

	
		<div id="recherchecommerce">
		
			<form method="get">
			<h2>Rechercher </h2>
				<input type="text" name="commerce" id="commerce" value="<? if($_GET['commerce']) echo $_GET['commerce']; ?>" placeholder="Super Commerce">
			
				<input type="submit" value="Chercher">
			
			</form>
		
		</div>
	
	<a id="voir_listefavoris" href="#" onclick="$('#popupforfavoris, #overlay').show();">
	<?
		if($_GET['commerce']){
			$commerce=$_GET['commerce'];
			if($_GET['filtre']) $filtre="AND cat='".$_GET['filtre']."'";
							
			$reponsepattern = $bdd->query("SELECT * FROM drovi_magasins WHERE nom LIKE '%$commerce%' $filtre");
			$resultatspattern = $reponsepattern->rowCount();
		
			if($resultatspattern == 0) {
			
			echo "Il n'y a aucun résultat";
			
			} else {
				if($resultatspattern == 1) {
					echo "Voir le résultat";
				} else {
					echo "Liste des $resultatspattern résultats";
				}
			}
		} else {
			echo "Aucune recherche effectuée";
		}
	?>
	</a>
	
	
	
	
	
<!--   _______________________       AFFICHAGE GOOGLE MAP    _______________________________      -->
		<div id="map"></div> <!-- GM -->
		
		<div id="wrapper">
			  <div id="border">
			    <div id="whitespace">
			      <div id="line">
			      </div>
			    </div>
			  </div>
		</div>
		
		<p id='popup'></p>
		
		<div id="maposition"></div> <!-- Débugage Géolocalisation GM -->	
		<script src="http://maps.google.com/maps/api/js?sensor=true" type="text/javascript"></script> <!-- API Google maps -->



		
		<h2 id="openfiltres" onclick="openFiltres();">
		&#9650; <?php 
				
				if($_GET['filtre'] ) { 
				
					echo "Filtre choisi : ";
					
					if($_GET['filtre']=='nightshop') {
						echo "night shop";
					} else {
					echo "<span>".$_GET['filtre']."</span>"; 
					}
					
					echo "<a id='supprfiltre' href='?'>X</a>";
				} else { 
					echo "Choisir un filtre"; 
				} 
				
		?> &#9650;</h2>
	
		<ul id="filtres">
			<li id="alimentaire" <? if($_GET['filtre']=='alimentaire') echo "class='current'"; ?>><a href="?<? if($_GET['commerce']) echo "commerce=".$_GET['commerce']."&"; if($_GET['latlng_choice']) echo "latlng_choice=".$_GET['latlng_choice']."&"; ?>action=filtrer&filtre=alimentaire">Alimentaire</a></li>
			<li id="horeca" <? if($_GET['filtre']=='horeca') echo "class='current'"; ?>><a href="?<? if($_GET['commerce']) echo "commerce=".$_GET['commerce']."&"; if($_GET['latlng_choice']) echo "latlng_choice=".$_GET['latlng_choice']."&"; ?>action=filtrer&filtre=horeca">Horeca</a></li>
			<li id="nightshop" <? if($_GET['filtre']=='nightshop') echo "class='current'"; ?>><a href="?<? if($_GET['commerce']) echo "commerce=".$_GET['commerce']."&"; if($_GET['latlng_choice']) echo "latlng_choice=".$_GET['latlng_choice']."&"; ?>action=filtrer&filtre=nightshop">Night Shop</a></li>
			<li id="boutique" <? if($_GET['filtre']=='boutique') echo "class='current'"; ?>><a href="?<? if($_GET['commerce']) echo "commerce=".$_GET['commerce']."&"; if($_GET['latlng_choice']) echo "latlng_choice=".$_GET['latlng_choice']."&"; ?>action=filtrer&filtre=boutique">Boutique</a></li>
			<li id="pharmacie" <? if($_GET['filtre']=='pharmacie') echo "class='current'"; ?>><a href="?<? if($_GET['commerce']) echo "commerce=".$_GET['commerce']."&"; if($_GET['latlng_choice']) echo "latlng_choice=".$_GET['latlng_choice']."&"; ?>action=filtrer&filtre=pharmacie">Pharmacie</a></li>
			<li id="autre" <? if($_GET['filtre']=='autre') echo "class='current'"; ?>><a href="?<? if($_GET['commerce']) echo "commerce=".$_GET['commerce']."&"; if($_GET['latlng_choice']) echo "latlng_choice=".$_GET['latlng_choice']."&"; ?>action=filtrer&filtre=autre">Autre</a></li>
		</ul>


		
    
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


		
	
	</div> <!--   _______________________       FIN CONTENT    _______________________________      -->
			
			
			
			
			
				
			
			
			
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
						echo '<li id="ajoutermenu"><a href="ajouter.php">AJOUTER</a></li>';
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
	
	</div> <!--   _______________________       FIN PAGE    _______________________________      -->
	
	
	
	
	
	
	
	
	
<!--   _______________________       SCRIPT POUR GOOGLE MAP    _______________________________      -->
	
	<script type="text/javascript">
	
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

    function ajax(action) {
    	
    	var commerce=document.getElementById("commerce").value;
    	    	
		xhr.open("GET","ajax.php?action="+action+"&commerce="+commerce,true);
		xhr.onreadystatechange=function(){
		  if(xhr.readyState==4)
		    if(xhr.status==200) {
				eval(xhr.responseText);
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
	
	
	
		
		
		infos = [];
		
		// Position par défaut
		var centerpos = new google.maps.LatLng(50.464970, 4.864255);
		
		// Ansi que des options pour la carte, centrée sur latlng
		var optionsGmaps = {
			center:centerpos,
			navigationControlOptions: {style: google.maps.NavigationControlStyle.SMALL},
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			zoom: 15
		};
		
		
		// Initialisation de la carte avec les options
		var map = new google.maps.Map(document.getElementById("map"), optionsGmaps);
		
		if(navigator.geolocation) {
		
			// Fonction de callback en cas de succès
			function affichePosition(position) {
			
				var infopos = "<div class='info'><strong>Votre position actuelle</strong> <br><br></div>";
				document.getElementById("maposition").innerHTML = infopos;
		
				
				
				var latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
		
				// Ajout d'un marqueur à la position trouvée
				
				var html = infopos;
									

				var marker_user = new google.maps.Marker({
					position: latlng,
					icon: "img/marker_user.png",
					map: map,
					content: html,
					title:"Vous êtes ici"
				});
				
				$('#wrapper').hide();

				
				
				google.maps.event.addListener(marker_user, 'click', function() {
							 
				 /* close the previous info-window */
					closeInfos();
									 
			   /* the marker's content gets attached to the info-window: */
			   		var info = new google.maps.InfoWindow({content: this.content});
									 
			  /* trigger the infobox's open function */
				   info.open(map,this);
									 
			 /* keep the handle, in order to close it on next click event */
				   infos[0]=info;
									 
				});
				
				google.maps.event.addListener(map, 'click', function() {
										   closeInfos();
										});
				
				
			<?
			if($_GET['commerce']) {
				
				if($_GET['filtre']) {
				
				$filtre=$_GET['filtre'];
						$commerce=$_GET['commerce'];
		
				$dayweek=date('w');
				$daydate=date('d m Y');
				
				$id_user=$_SESSION['drovi'];
			
		
		/* 		$daydate=date('d m Y');		 */
		
				$reponse = $bdd->query("SELECT * FROM drovi_magasins WHERE nom LIKE '%$commerce%' AND cat='$filtre' AND $dayweek IS NOT NULL");
				
		
				
				while ($donnees = $reponse->fetch()){
		
					/* $timesearch=date('H:i:s'); */
					
					$nom=$donnees['nom'];
				
					$conges = $bdd->query("SELECT * FROM drovi_conges WHERE date='$daydate' AND nom_magasin='$nom'");												
					$donneesconges = $conges->fetch();
					
					if($donneesconges['horaire']) {
						$subject=$donneesconges['horaire'];
					} else {
						$subject=$donnees[$dayweek];
					}
								
					if(preg_match('/and/', $subject)){
					
						$timesopen=explode(' and ', $subject);
						
						foreach($timesopen as $element) {
							
							$timeopen=explode(' to ', $element);
							
							if($_POST['timesearch']) {
								$timesearch=$_POST['timesearch'].":00";
							} else {
								$timesearch=date('H:i:s');
							}
							
							if($timesearch >= $timeopen[0] && $timesearch < $timeopen[1]) {
						
								$timeclose=substr($timeopen[1], 0, -3);
								
								if($timeclose=='24:00' && $donnees[$dayweek+1]) {
									if(preg_match('/and/', $donnees[$dayweek+1])){
										$nexttimesopen=explode(' and ', $donnees[$dayweek+1]);
										
										foreach($nexttimesopen as $element) {
											$nexttimeopen=explode(' to ', $element);
											
											if($nexttimeopen[0]=='00:00:00') {
												$timeclose=$nexttimeopen[1];
												$timeclose=substr($nexttimeopen[1], 0, -3);
											}
										}
									} else {
										$nexttimeopen=explode(' to ', $donnees[$dayweek+1]);
										if($nexttimeopen[0]=='00:00:00') {
											$timeclose=$nexttimeopen[1];
											$timeclose=substr($nexttimeopen[1], 0, -3);
										}
									}
								} 
								
								
								$id_magasin=$donnees['id'];
								$id_user=$_SESSION['drovi'];
								
							$reponsefavoris = $bdd->query("SELECT * FROM drovi_favoris WHERE id_magasin='$id_magasin' AND id_user='$id_user'");
								
							$rowfavoris = $reponsefavoris->fetch();
							
							$signaler= $bdd->query("SELECT id FROM drovi_report WHERE id_magasin='$id_magasin' AND id_user='$id_user' AND date=CURRENT_DATE");
							$rowsignaler=$signaler->fetch();
									
							$signaler= $bdd->query("SELECT id FROM drovi_report WHERE id_magasin='$id_magasin' AND date=CURRENT_DATE");
							$signalernmb=$signaler->rowCount();

								
								if($_SESSION['drovi']) {
								if($_SESSION['drovi_xp']<10) 
								$modifier="javascript:popup('Tu n\\\'as pas assez d\\\'expérience');"; 
								else 
								$modifier= "modifier.php?id=$id_magasin";
								} else {
								$modifier= "javascript:popup('Tu n\\\'es pas connecté');";} ?>
				
								
								
								var html = "<div class='info' style='max-height:600px'><strong><?php echo $donnees['nom']; ?></strong> <br><br> <em><?php echo $donnees['adresse']; ?> </em><br><span class='cat'><?php if($donnees['cat']=='nightshop') echo "Night Shop"; else echo $donnees['cat']; ?></span> <em><?php if($donnees['description']) echo "-".$donnees['description']; ?></em> <br><br> <? if($donneesconges['horaire']) echo '<span style=\'color:#e74c3c\'>Cet horaire est exceptionnel</span><br>'; ?> <strong>Ouvert jusque <?php echo $timeclose; ?></strong> <?php if($signalernmb>5) { echo '<br><span style=\'color:#e74c3c\'>Cet horaire semble faux</span>'; } else { if($signalernmb>=1) {echo '<br><span>Cet horaire a été signalé '.$signalernmb.' fois</span>';} } ?> <br><br> <a class='modifier' href=\"<? echo $modifier; ?>\">Modifier cet horaire</a> <?php if($rowsignaler[0]) echo '<a class=\'dejasignaler\' href=\"javascript:gm(\'signaler\','.$id_magasin.');\">Tu as signalé cet horaire</a>'; else echo '<a class=\'signaler\' id=\'sign_'.$id_magasin.'\' href=\"javascript:gm(\'signaler\','.$id_magasin.');\"> Signaler cet horaire</a>'; ?> <?php if($rowfavoris[0]) echo '<a id=\'mag_'.$id_magasin.'\' class=\'favoris\' href=\"javascript:gm(\'removefavoris\','.$id_magasin.');\"> Retirer des favoris'; else echo '<a id=\'mag_'.$id_magasin.'\' class=\'pourfavoris\' href=\"javascript:gm(\'favoris\','.$id_magasin.');\"> Mettre en favoris'; ?></a></div>";
								
								var marker_<?php echo $donnees['id']; ?> = new google.maps.Marker({
									position: new google.maps.LatLng(<?php echo $donnees['latLng']; ?>),
									icon: "img/marker_<?php echo $donnees['cat']; ?>.png",
									map: map,
									draggable:false,
									content:html,
									title:"<?php echo $donnees['nom']; ?>"
								});
								
								google.maps.event.addListener(marker_<?php echo $donnees['id']; ?>, 'click', function() {
							 
								   /* close the previous info-window */
								   closeInfos();
								 
								   /* the marker's content gets attached to the info-window: */
								   var info = new google.maps.InfoWindow({content: this.content});
								 
								   /* trigger the infobox's open function */
								   info.open(map,this);
								 
								   /* keep the handle, in order to close it on next click event */
								   infos[0]=info;
								 
								});
								 
								/* ... or one may optionally bind the map on-click event as well */
								google.maps.event.addListener(map, 'click', function() {
								   closeInfos();
								});

						
						
								<?php
							
							} /*FIN IF*/ else {
								
								if($timesearch < $timeopen[0]) {
									
									$timeclose=substr($timeopen[0], 0, -3);
									
									if($timeclose=='24:00' && $donnees[$dayweek+1]) {
									if(preg_match('/and/', $donnees[$dayweek+1])){
										$nexttimesopen=explode(' and ', $donnees[$dayweek+1]);
										
										foreach($nexttimesopen as $element) {
											$nexttimeopen=explode(' to ', $element);
											
											if($nexttimeopen[0]=='00:00:00') {
												$timeclose=$nexttimeopen[1];
												$timeclose=substr($nexttimeopen[1], 0, -3);
											}
										}
									} else {
										$nexttimeopen=explode(' to ', $donnees[$dayweek+1]);
										if($nexttimeopen[0]=='00:00:00') {
											$timeclose=$nexttimeopen[1];
											$timeclose=substr($nexttimeopen[1], 0, -3);
										}
									}
								} 
								
								$id_magasin=$donnees['id'];
								$id_user=$_SESSION['drovi'];
								
							$reponsefavoris = $bdd->query("SELECT * FROM drovi_favoris WHERE id_magasin='$id_magasin' AND id_user='$id_user'");
								
							$rowfavoris = $reponsefavoris->fetch();
							
							$signaler= $bdd->query("SELECT id FROM drovi_report WHERE id_magasin='$id_magasin' AND id_user='$id_user' AND date=CURRENT_DATE");
							$rowsignaler=$signaler->fetch();
									
							$signaler= $bdd->query("SELECT id FROM drovi_report WHERE id_magasin='$id_magasin' AND date=CURRENT_DATE");
							$signalernmb=$signaler->rowCount();

								
								if($_SESSION['drovi']) {
								if($_SESSION['drovi_xp']<10) 
								$modifier="javascript:popup('Tu n\\\'as pas assez d\\\'expérience');"; 
								else 
								$modifier= "modifier.php?id=$id_magasin";
								} else {
								$modifier= "javascript:popup('Tu n\\\'es pas connecté');";} ?>
								
								
									var html = "<div class='info' style='max-height:600px'><strong><?php echo $donnees['nom']; ?></strong> <br><br> <em><?php echo $donnees['adresse']; ?> </em><br> <span class='cat'><?php if($donnees['cat']=='nightshop') echo "Night Shop"; else echo $donnees['cat']; ?></span> <em><?php if($donnees['description']) echo "-".$donnees['description']; ?></em> <br><br> <? if($donneesconges['horaire']) echo '<span style=\'color:#e74c3c\'>Cet horaire est exceptionnel</span><br>'; ?> <strong>Prochaine ouverture à <?php echo $timeclose; ?></strong> <?php if($signalernmb>5) { echo '<br><span style=\'color:#e74c3c\'>Cet horaire semble faux</span>'; } else { if($signalernmb>=1) {echo '<br><span>Cet horaire a été signalé '.$signalernmb.' fois</span>';} } ?> <br><br> <a class='modifier' href=\"<? echo $modifier; ?>\">Modifier cet horaire</a> <?php if($rowsignaler[0]) echo '<a class=\'dejasignaler\' href=\"javascript:gm(\'signaler\','.$id_magasin.');\">Tu as signalé cet horaire</a>'; else echo '<a class=\'signaler\' id=\'sign_'.$id_magasin.'\' href=\"javascript:gm(\'signaler\','.$id_magasin.');\"> Signaler cet horaire</a>'; ?> <?php if($rowfavoris[0]) echo '<a id=\'mag_'.$id_magasin.'\' class=\'favoris\' href=\"javascript:gm(\'removefavoris\','.$id_magasin.');\"> Retirer des favoris'; else echo '<a id=\'mag_'.$id_magasin.'\' class=\'pourfavoris\' href=\"javascript:gm(\'favoris\','.$id_magasin.');\"> Mettre en favoris'; ?></a></div>";
								
									var marker_<?php echo $donnees['id']; ?> = new google.maps.Marker({
										position: new google.maps.LatLng(<?php echo $donnees['latLng']; ?>),
										icon: "img/marker_ferme_<?php echo $donnees['cat']; ?>.png",
										map: map,
										draggable:false,
										content:html,
										title:"<?php echo $donnees['nom']; ?>"
									});
									
									google.maps.event.addListener(marker_<?php echo $donnees['id']; ?>, 'click', function() {
								 
									   /* close the previous info-window */
									   closeInfos();
									 
									   /* the marker's content gets attached to the info-window: */
									   var info = new google.maps.InfoWindow({content: this.content});
									 
									   /* trigger the infobox's open function */
									   info.open(map,this);
									 
									   /* keep the handle, in order to close it on next click event */
									   infos[0]=info;
									 
									});
									 
									/* ... or one may optionally bind the map on-click event as well */
									google.maps.event.addListener(map, 'click', function() {
									   closeInfos();
									});
									
									<?php
								}
							}
						
						} /*FIN FOREACH*/
		
					} else {
					
						$timeopen=explode(' to ', $subject);
						
							if($_POST['timesearch']) {
								$timesearch=$_POST['timesearch'].":00";
							} else {
								$timesearch=date('H:i:s');
							}
		
		
						if($timesearch >= $timeopen[0] && $timesearch < $timeopen[1]) {
											
							$timeclose=substr($timeopen[1], 0, -3);
							
							if($timeclose=='24:00' && $donnees[$dayweek+1]) {
									if(preg_match('/and/', $donnees[$dayweek+1])){
										$nexttimesopen=explode(' and ', $donnees[$dayweek+1]);
										
										foreach($nexttimesopen as $element) {
											$nexttimeopen=explode(' to ', $element);
											
											if($nexttimeopen[0]=='00:00:00') {
												$timeclose=$nexttimeopen[1];
												$timeclose=substr($nexttimeopen[1], 0, -3);
											}
										}
									} else {
										$nexttimeopen=explode(' to ', $donnees[$dayweek+1]);
										if($nexttimeopen[0]=='00:00:00') {
											$timeclose=$nexttimeopen[1];
											$timeclose=substr($nexttimeopen[1], 0, -3);
										}
									}
								} 
						
							$id_magasin=$donnees['id'];
							$id_user=$_SESSION['drovi'];
								
							$reponsefavoris = $bdd->query("SELECT * FROM drovi_favoris WHERE id_magasin='$id_magasin' AND id_user='$id_user'");
								
							$rowfavoris = $reponsefavoris->fetch();
							
							$signaler= $bdd->query("SELECT id FROM drovi_report WHERE id_magasin='$id_magasin' AND id_user='$id_user' AND date=CURRENT_DATE");
							$rowsignaler=$signaler->fetch();
									
							$signaler= $bdd->query("SELECT id FROM drovi_report WHERE id_magasin='$id_magasin' AND date=CURRENT_DATE");
							$signalernmb=$signaler->rowCount();

							if($_SESSION['drovi']) {
								if($_SESSION['drovi_xp']<10) 
								$modifier="javascript:popup('Tu n\\\'as pas assez d\\\'expérience');"; 
								else 
								$modifier= "modifier.php?id=$id_magasin";
								} else {
								$modifier= "javascript:popup('Tu n\\\'es pas connecté');";
								
								} ?>
							

								var html = "<div class='info' style='max-height:600px'><strong><?php echo $donnees['nom']; ?></strong> <br><br> <em><?php echo $donnees['adresse']; ?> </em><br> <span class='cat'><?php if($donnees['cat']=='nightshop') echo "Night Shop"; else echo $donnees['cat']; ?></span> <em><?php if($donnees['description']) echo "-".$donnees['description']; ?></em><br><br> <? if($donneesconges['horaire']) echo '<span style=\'color:#e74c3c\'>Cet horaire est exceptionnel</span><br>'; if($timeopen[0]=='00:00:00' && $timeopen[1]=='24:00:00') { echo "<strong>Ouvert 24/24h</strong>"; } else {  echo "<strong>Ouvert jusque ".$timeclose."</strong>"; } if($signalernmb>5) { echo '<br><span style=\'color:#e74c3c\'>Cet horaire semble faux</span>'; } else { if($signalernmb>=1) {echo '<br><span>Cet horaire a été signalé '.$signalernmb.' fois</span>';} } ?> <br><br> <a class='modifier' href=\"<? echo $modifier; ?>\">Modifier cet horaire</a> <?php if($rowsignaler[0]) echo '<a class=\'dejasignaler\' href=\"javascript:gm(\'signaler\','.$id_magasin.');\">Tu as signalé cet horaire</a>'; else echo '<a class=\'signaler\' id=\'sign_'.$id_magasin.'\' href=\"javascript:gm(\'signaler\','.$id_magasin.');\"> Signaler cet horaire</a>'; ?> <?php if($rowfavoris[0]) echo '<a id=\'mag_'.$id_magasin.'\' class=\'favoris\' href=\"javascript:gm(\'removefavoris\','.$id_magasin.');\"> Retirer des favoris'; else echo '<a id=\'mag_'.$id_magasin.'\' class=\'pourfavoris\' href=\"javascript:gm(\'favoris\','.$id_magasin.');\"> Mettre en favoris'; ?></a></div>";				
										
								var marker_<?php echo $donnees['id']; ?> = new google.maps.Marker({
									position: new google.maps.LatLng(<?php echo $donnees['latLng']; ?>),
									icon: "img/marker_<?php echo $donnees['cat']; ?>.png",
									map: map,
									draggable:false,
									content:html,
									title:"<?php echo $donnees['nom']; ?>"
								});
								
								
								google.maps.event.addListener(marker_<?php echo $donnees['id']; ?>, 'click', function() {
								 
								   /* close the previous info-window */
								   closeInfos();
								 
								   /* the marker's content gets attached to the info-window: */
								   var info = new google.maps.InfoWindow({content: this.content});
								 
								   /* trigger the infobox's open function */
								   info.open(map,this);
								 
								   /* keep the handle, in order to close it on next click event */
								   infos[0]=info;
								 
								});
								 
								/* ... or one may optionally bind the map on-click event as well */
								google.maps.event.addListener(map, 'click', function() {
								   closeInfos();
								});
										
								
							<?php
							
							} else {
					
							
								if($timesearch < $timeopen[0] && $timeopen[0]!=NULL) {
								
									$timeclose=substr($timeopen[0], 0, -3);
									
									if($timeclose=='24:00' && $donnees[$dayweek+1]) {
									if(preg_match('/and/', $donnees[$dayweek+1])){
										$nexttimesopen=explode(' and ', $donnees[$dayweek+1]);
										
										foreach($nexttimesopen as $element) {
											$nexttimeopen=explode(' to ', $element);
											
											if($nexttimeopen[0]=='00:00:00') {
												$timeclose=$nexttimeopen[1];
												$timeclose=substr($nexttimeopen[1], 0, -3);
											}
										}
									} else {
										$nexttimeopen=explode(' to ', $donnees[$dayweek+1]);
										if($nexttimeopen[0]=='00:00:00') {
											$timeclose=$nexttimeopen[1];
											$timeclose=substr($nexttimeopen[1], 0, -3);
										}
									}
								} 
								
								
								$id_magasin=$donnees['id'];
								$id_user=$_SESSION['drovi'];
								
							$reponsefavoris = $bdd->query("SELECT * FROM drovi_favoris WHERE id_magasin='$id_magasin' AND id_user='$id_user'");
								
							$rowfavoris = $reponsefavoris->fetch();
							
							$signaler= $bdd->query("SELECT id FROM drovi_report WHERE id_magasin='$id_magasin' AND id_user='$id_user' AND date=CURRENT_DATE");
							$rowsignaler=$signaler->fetch();
									
							$signaler= $bdd->query("SELECT id FROM drovi_report WHERE id_magasin='$id_magasin' AND date=CURRENT_DATE");
							$signalernmb=$signaler->rowCount();
							
							if($_SESSION['drovi']) {
								if($_SESSION['drovi_xp']<10) 
								$modifier="javascript:popup('Tu n\\\'as pas assez d\\\'expérience');"; 
								else 
								$modifier= "modifier.php?id=$id_magasin";
								} else {
								$modifier= "javascript:popup('Tu n\\\'es pas connecté');";} ?>
								
									var html = "<div class='info' style='max-height:600px'><strong><?php echo $donnees['nom']; ?></strong> <br><br> <em><?php echo $donnees['adresse']; ?> </em><br> <span class='cat'><?php if($donnees['cat']=='nightshop') echo "Night Shop"; else echo $donnees['cat']; ?></span> <em><?php if($donnees['description']) echo "-".$donnees['description']; ?></em> <br><br> <? if($donneesconges['horaire']) echo '<span style=\'color:#e74c3c\'>Cet horaire est exceptionnel</span><br>'; ?> <strong>Prochaine ouverture à <?php echo $timeclose; ?></strong> <?php if($signalernmb>5) { echo '<br><span style=\'color:#e74c3c\'>Cet horaire semble faux</span>'; } else { if($signalernmb>=1) {echo '<br><span>Cet horaire a été signalé '.$signalernmb.' fois</span>';} } ?> <br><br> <a class='modifier' href=\"<? echo $modifier; ?>\">Modifier cet horaire</a> <?php if($rowsignaler[0]) echo '<a class=\'dejasignaler\' href=\"javascript:gm(\'signaler\','.$id_magasin.');\">Tu as signalé cet horaire</a>'; else echo '<a class=\'signaler\' id=\'sign_'.$id_magasin.'\' href=\"javascript:gm(\'signaler\','.$id_magasin.');\"> Signaler cet horaire</a>'; ?> <?php if($rowfavoris[0]) echo '<a id=\'mag_'.$id_magasin.'\' class=\'favoris\' href=\"javascript:gm(\'removefavoris\','.$id_magasin.');\"> Retirer des favoris'; else echo '<a id=\'mag_'.$id_magasin.'\' class=\'pourfavoris\' href=\"javascript:gm(\'favoris\','.$id_magasin.');\"> Mettre en favoris'; ?></a></div>";
								
									var marker_<?php echo $donnees['id']; ?> = new google.maps.Marker({
										position: new google.maps.LatLng(<?php echo $donnees['latLng']; ?>),
										icon: "img/marker_ferme_<?php echo $donnees['cat']; ?>.png",
										map: map,
										draggable:false,
										content:html,
										title:"<?php echo $donnees['nom']; ?>"
									});
									
									google.maps.event.addListener(marker_<?php echo $donnees['id']; ?>, 'click', function() {
								 
									   /* close the previous info-window */
									   closeInfos();
									 
									   /* the marker's content gets attached to the info-window: */
									   var info = new google.maps.InfoWindow({content: this.content});
									 
									   /* trigger the infobox's open function */
									   info.open(map,this);
									 
									   /* keep the handle, in order to close it on next click event */
									   infos[0]=info;
									 
									});
									 
									/* ... or one may optionally bind the map on-click event as well */
									google.maps.event.addListener(map, 'click', function() {
									   closeInfos();
									});
									
									<?php
							
							} else {
							
						
								$dayweeknext = $dayweek + 1;
								
																
								if($dayweeknext==7){
									$dayweeknext=0;
								}
		
								if($donnees[$dayweeknext]!=NULL) {
									
									$id_magasin=$donnees['id'];
									$id_user=$_SESSION['drovi'];
								
							$reponsefavoris = $bdd->query("SELECT * FROM drovi_favoris WHERE id_magasin='$id_magasin' AND id_user='$id_user'");
								
							$rowfavoris = $reponsefavoris->fetch();
							
							$signaler= $bdd->query("SELECT id FROM drovi_report WHERE id_magasin='$id_magasin' AND id_user='$id_user' AND date=CURRENT_DATE");
							$rowsignaler=$signaler->fetch();
									
							$signaler= $bdd->query("SELECT id FROM drovi_report WHERE id_magasin='$id_magasin' AND date=CURRENT_DATE");
							$signalernmb=$signaler->rowCount();
							
						
								if($_SESSION['drovi']) {
								if($_SESSION['drovi_xp']<10) 
								$modifier="javascript:popup('Tu n\\\'as pas assez d\\\'expérience');"; 
								else 
								$modifier= "modifier.php?id=$id_magasin";
								} else {
								$modifier= "javascript:popup('Tu n\\\'es pas connecté');";} ?>
									
									var html = "<div class='info' style='max-height:600px'><strong><?php echo $donnees['nom']; ?></strong> <br><br> <em><?php echo $donnees['adresse']; ?> </em><br> <span class='cat'><?php if($donnees['cat']=='nightshop') echo "Night Shop"; else echo $donnees['cat']; ?></span> <em><?php if($donnees['description']) echo "-".$donnees['description']; ?></em> <br><br> <? if($donneesconges['horaire']) echo '<span style=\'color:#e74c3c\'>Cet horaire est exceptionnel</span><br>'; ?> <strong>Prochaine ouverture demain</strong> <?php if($signalernmb>5) { echo '<br><span style=\'color:#e74c3c\'>Cet horaire semble faux</span>'; } else { if($signalernmb>=1) {echo '<br><span>Cet horaire a été signalé '.$signalernmb.' fois</span>';} } ?> <br><br> <a class='modifier' href=\"<? echo $modifier; ?>\">Modifier cet horaire</a> <?php if($rowsignaler[0]) echo '<a class=\'dejasignaler\' href=\"javascript:gm(\'signaler\','.$id_magasin.');\">Tu as signalé cet horaire</a>'; else echo '<a class=\'signaler\' id=\'sign_'.$id_magasin.'\' href=\"javascript:gm(\'signaler\','.$id_magasin.');\"> Signaler cet horaire</a>'; ?> <?php if($rowfavoris[0]) echo '<a id=\'mag_'.$id_magasin.'\' class=\'favoris\' href=\"javascript:gm(\'removefavoris\','.$id_magasin.');\"> Retirer des favoris'; else echo '<a id=\'mag_'.$id_magasin.'\' class=\'pourfavoris\' href=\"javascript:gm(\'favoris\','.$id_magasin.');\"> Mettre en favoris'; ?></a></div>";
								
									var marker_<?php echo $donnees['id']; ?> = new google.maps.Marker({
										position: new google.maps.LatLng(<?php echo $donnees['latLng']; ?>),
										icon: "img/marker_ferme_<?php echo $donnees['cat']; ?>.png",
										map: map,
										draggable:false,
										content:html,
										title:"<?php echo $donnees['nom']; ?>"
									});
									
									google.maps.event.addListener(marker_<?php echo $donnees['id']; ?>, 'click', function() {
								 
									   /* close the previous info-window */
									   closeInfos();
									 
									   /* the marker's content gets attached to the info-window: */
									   var info = new google.maps.InfoWindow({content: this.content});
									 
									   /* trigger the infobox's open function */
									   info.open(map,this);
									 
									   /* keep the handle, in order to close it on next click event */
									   infos[0]=info;
									 
									});
									 
									/* ... or one may optionally bind the map on-click event as well */
									google.maps.event.addListener(map, 'click', function() {
									   closeInfos();
									});
									
									
							<?php
									
								} else {
									
									$id_magasin=$donnees['id'];
									$id_user=$_SESSION['drovi'];
								
							$reponsefavoris = $bdd->query("SELECT * FROM drovi_favoris WHERE id_magasin='$id_magasin' AND id_user='$id_user'");
								
							$rowfavoris = $reponsefavoris->fetch();
							
							$signaler= $bdd->query("SELECT id FROM drovi_report WHERE id_magasin='$id_magasin' AND id_user='$id_user' AND date=CURRENT_DATE");
							$rowsignaler=$signaler->fetch();
									
							$signaler= $bdd->query("SELECT id FROM drovi_report WHERE id_magasin='$id_magasin' AND date=CURRENT_DATE");
							$signalernmb=$signaler->rowCount();
							
							if($_SESSION['drovi']) {
								if($_SESSION['drovi_xp']<10) 
								$modifier="javascript:popup('Tu n\\\'as pas assez d\\\'expérience');"; 
								else 
								$modifier= "modifier.php?id=$id_magasin";
								} else {
								$modifier= "javascript:popup('Tu n\\\'es pas connecté');";} ?>
								
								
											var html = "<div class='info' style='max-height:600px'><strong><?php echo $donnees['nom']; ?></strong> <br><br> <em><?php echo $donnees['adresse']; ?> </em><br> <span class='cat'><?php if($donnees['cat']=='nightshop') echo "Night Shop"; else echo $donnees['cat']; ?></span> <em><?php if($donnees['description']) echo "-".$donnees['description']; ?></em> <br><br> <? if($donneesconges['horaire']) echo '<span style=\'color:#e74c3c\'>Cet horaire est exceptionnel</span><br>'; ?> <strong>N'ouvre pas dans les prochains jours</strong> <?php if($signalernmb>5) { echo '<br><span style=\'color:#e74c3c\'>Cet horaire semble faux</span>'; } else { if($signalernmb>=1) {echo '<br><span>Cet horaire a été signalé '.$signalernmb.' fois</span>';} } ?> <br><br> <a class='modifier' href=\"<? echo $modifier; ?>\">Modifier cet horaire</a> <?php if($rowsignaler[0]) echo '<a class=\'dejasignaler\' href=\"javascript:gm(\'signaler\','.$id_magasin.');\">Tu as signalé cet horaire</a>'; else echo '<a class=\'signaler\' id=\'sign_'.$id_magasin.'\' href=\"javascript:gm(\'signaler\','.$id_magasin.');\"> Signaler cet horaire</a>'; ?> <?php if($rowfavoris[0]) echo '<a id=\'mag_'.$id_magasin.'\' class=\'favoris\' href=\"javascript:gm(\'removefavoris\','.$id_magasin.');\"> Retirer des favoris'; else echo '<a id=\'mag_'.$id_magasin.'\' class=\'pourfavoris\' href=\"javascript:gm(\'favoris\','.$id_magasin.');\"> Mettre en favoris'; ?></a></div>";
								
									var marker_<?php echo $donnees['id']; ?> = new google.maps.Marker({
										position: new google.maps.LatLng(<?php echo $donnees['latLng']; ?>),
										icon: "img/marker_ferme_<?php echo $donnees['cat']; ?>.png",
										map: map,
										draggable:false,
										content:html,
										title:"<?php echo $donnees['nom']; ?>"
									});
									
									google.maps.event.addListener(marker_<?php echo $donnees['id']; ?>, 'click', function() {
								 
									   /* close the previous info-window */
									   closeInfos();
									 
									   /* the marker's content gets attached to the info-window: */
									   var info = new google.maps.InfoWindow({content: this.content, maxWidth: 300});
									 
									   /* trigger the infobox's open function */
									   info.open(map,this);
									 
									   /* keep the handle, in order to close it on next click event */
									   infos[0]=info;
									 
									});
									 
									/* ... or one may optionally bind the map on-click event as well */
									google.maps.event.addListener(map, 'click', function() {
									   closeInfos();
									});							
									<?php
									
								}
				
								
							
						}
	
					} /*FIN ELSE*/
				
				} /*FIN WHILE*/
			
			} /*FIN ELSE*/
			
			
				$id_user=$_SESSION['drovi'];
		
				$dayweek=date('w');
				$dayweeknext=$dayweek+1;
				if($dayweeknext==7){$dayweeknext=0;}
		
		/* 		$daydate=date('d m Y');		 */
		
				$reponse = $bdd->query("SELECT * FROM drovi_magasins WHERE nom LIKE '%$commerce%' AND cat='$filtre' AND $dayweek IS NULL AND $dayweeknext IS NOT NULL");
				
				while($donnees=$reponse->fetch()) {
					
					$id_magasin=$donnees['id'];
					$id_user=$_SESSION['drovi'];
								
							$reponsefavoris = $bdd->query("SELECT * FROM drovi_favoris WHERE id_magasin='$id_magasin' AND id_user='$id_user'");
								
							$rowfavoris = $reponsefavoris->fetch();
							
							$signaler= $bdd->query("SELECT id FROM drovi_report WHERE id_magasin='$id_magasin' AND id_user='$id_user' AND date=CURRENT_DATE");
							$rowsignaler=$signaler->fetch();
									
							$signaler= $bdd->query("SELECT id FROM drovi_report WHERE id_magasin='$id_magasin' AND date=CURRENT_DATE");
							$signalernmb=$signaler->rowCount();

							if($_SESSION['drovi']) {
								if($_SESSION['drovi_xp']<10) 
								$modifier="javascript:popup('Tu n\\\'as pas assez d\\\'expérience');"; 
								else 
								$modifier= "modifier.php?id=$id_magasin";
								} else {
								$modifier= "javascript:popup('Tu n\\\'es pas connecté');";} ?>
								
								
								
											var html = "<div class='info' style='max-height:600px'><strong><?php echo $donnees['nom']; ?></strong> <br><br> <em><?php echo $donnees['adresse']; ?> </em><br> <span class='cat'><?php if($donnees['cat']=='nightshop') echo "Night Shop"; else echo $donnees['cat']; ?></span> <em><?php if($donnees['description']) echo "-".$donnees['description']; ?></em> <br><br> <? if($donneesconges['horaire']) echo '<span style=\'color:#e74c3c\'>Cet horaire est exceptionnel</span><br>'; ?> <strong>Prochaine ouverture demain</strong> <?php if($signalernmb>5) { echo '<br><span style=\'color:#e74c3c\'>Cet horaire semble faux</span>'; } else { if($signalernmb>=1) {echo '<br><span>Cet horaire a été signalé '.$signalernmb.' fois</span>';} } ?> <br><br> <a class='modifier' href=\"<? echo $modifier; ?>\">Modifier cet horaire</a><?php if($rowsignaler[0]) echo '<a class=\'dejasignaler\' href=\"javascript:gm(\'signaler\','.$id_magasin.');\">Tu as signalé cet horaire</a>'; else echo '<a class=\'signaler\' id=\'sign_'.$id_magasin.'\' href=\"javascript:gm(\'signaler\','.$id_magasin.');\"> Signaler cet horaire</a>'; ?> <?php if($rowfavoris[0]) echo '<a id=\'mag_'.$id_magasin.'\' class=\'favoris\' href=\"javascript:gm(\'removefavoris\','.$id_magasin.');\"> Retirer des favoris'; else echo '<a id=\'mag_'.$id_magasin.'\' class=\'pourfavoris\' href=\"javascript:gm(\'favoris\','.$id_magasin.');\"> Mettre en favoris'; ?></a></div>";
								
									var marker_<?php echo $donnees['id']; ?> = new google.maps.Marker({
										position: new google.maps.LatLng(<?php echo $donnees['latLng']; ?>),
										icon: "img/marker_ferme_<?php echo $donnees['cat']; ?>.png",
										map: map,
										draggable:false,
										content:html,
										title:"<?php echo $donnees['nom']; ?>"
									});
									
									google.maps.event.addListener(marker_<?php echo $donnees['id']; ?>, 'click', function() {
								 
									   /* close the previous info-window */
									   closeInfos();
									 
									   /* the marker's content gets attached to the info-window: */
									   var info = new google.maps.InfoWindow({content: this.content});
									 
									   /* trigger the infobox's open function */
									   info.open(map,this);
									 
									   /* keep the handle, in order to close it on next click event */
									   infos[0]=info;
									 
									});
									 
									/* ... or one may optionally bind the map on-click event as well */
									google.maps.event.addListener(map, 'click', function() {
									   closeInfos();
									});							
									<?php
									
				}
				
		
		
		
		$reponse = $bdd->query("SELECT * FROM drovi_magasins WHERE nom LIKE '%$commerce%' AND cat='$filtre' AND $dayweek IS NULL AND $dayweeknext IS NULL");
				
				while($donnees=$reponse->fetch()) {
					
					$id_magasin=$donnees['id'];
					$id_user=$_SESSION['drovi'];
								
							$reponsefavoris = $bdd->query("SELECT * FROM drovi_favoris WHERE id_magasin='$id_magasin' AND id_user='$id_user'");
								
							$rowfavoris = $reponsefavoris->fetch();
							
							$signaler= $bdd->query("SELECT id FROM drovi_report WHERE id_magasin='$id_magasin' AND id_user='$id_user' AND date=CURRENT_DATE");
							$rowsignaler=$signaler->fetch();
									
							$signaler= $bdd->query("SELECT id FROM drovi_report WHERE id_magasin='$id_magasin' AND date=CURRENT_DATE");
							$signalernmb=$signaler->rowCount();

				
					
							if($_SESSION['drovi']) {
								if($_SESSION['drovi_xp']<10) 
								$modifier="javascript:popup('Tu n\\\'as pas assez d\\\'expérience');"; 
								else 
								$modifier= "modifier.php?id=$id_magasin";
								} else {
								$modifier= "javascript:popup('Tu n\\\'es pas connecté');";} ?>
								
								
											var html = "<div class='info' style='max-height:600px'><strong><?php echo $donnees['nom']; ?></strong> <br><br> <em><?php echo $donnees['adresse']; ?> </em><br> <span class='cat'><?php if($donnees['cat']=='nightshop') echo "Night Shop"; else echo $donnees['cat']; ?></span> <em><?php if($donnees['description']) echo "-".$donnees['description']; ?></em> <br><br> <? if($donneesconges['horaire']) echo '<span style=\'color:#e74c3c\'>Cet horaire est exceptionnel</span><br>'; ?> <strong>N'ouvre pas dans les prochains jours</strong> <?php if($signalernmb>5) { echo '<br><span style=\'color:#e74c3c\'>Cet horaire semble faux</span>'; } else { if($signalernmb>=1) {echo '<br><span>Cet horaire a été signalé '.$signalernmb.' fois</span>';} } ?> <br><br> <a class='modifier' href=\"<? echo $modifier; ?>\">Modifier cet horaire</a><?php if($rowsignaler[0]) echo '<a class=\'dejasignaler\' href=\"javascript:gm(\'signaler\','.$id_magasin.');\">Tu as signalé cet horaire</a>'; else echo '<a class=\'signaler\' id=\'sign_'.$id_magasin.'\' href=\"javascript:gm(\'signaler\','.$id_magasin.');\"> Signaler cet horaire</a>'; ?> <?php if($rowfavoris[0]) echo '<a id=\'mag_'.$id_magasin.'\' class=\'favoris\' href=\"javascript:gm(\'removefavoris\','.$id_magasin.');\"> Retirer des favoris'; else echo '<a id=\'mag_'.$id_magasin.'\' class=\'pourfavoris\' href=\"javascript:gm(\'favoris\','.$id_magasin.');\"> Mettre en favoris'; ?></a></div>";
								
									var marker_<?php echo $donnees['id']; ?> = new google.maps.Marker({
										position: new google.maps.LatLng(<?php echo $donnees['latLng']; ?>),
										icon: "img/marker_ferme_<?php echo $donnees['cat']; ?>.png",
										map: map,
										draggable:false,
										content:html,
										title:"<?php echo $donnees['nom']; ?>"
									});
									
									google.maps.event.addListener(marker_<?php echo $donnees['id']; ?>, 'click', function() {
								 
									   /* close the previous info-window */
									   closeInfos();
									 
									   /* the marker's content gets attached to the info-window: */
									   var info = new google.maps.InfoWindow({content: this.content});
									 
									   /* trigger the infobox's open function */
									   info.open(map,this);
									 
									   /* keep the handle, in order to close it on next click event */
									   infos[0]=info;
									 
									});
									 
									/* ... or one may optionally bind the map on-click event as well */
									google.maps.event.addListener(map, 'click', function() {
									   closeInfos();
									});							
									<?php
									
				}
				
		
				$reponse = $bdd->query("SELECT * FROM drovi_magasins WHERE nom LIKE '%$commerce%' AND cat='$filtre' AND 1 IS NULL AND 2 IS NULL AND 3 IS NULL AND 4 IS NULL AND 5 IS NULL AND 6 IS NULL AND 0 IS NULL");
				
				while($donnees=$reponse->fetch()) {
					
					$id_magasin=$donnees['id'];
					$id_user=$_SESSION['drovi'];
								
							$reponsefavoris = $bdd->query("SELECT * FROM drovi_favoris WHERE id_magasin='$id_magasin' AND id_user='$id_user'");
								
							$rowfavoris = $reponsefavoris->fetch();
							
							$signaler= $bdd->query("SELECT id FROM drovi_report WHERE id_magasin='$id_magasin' AND id_user='$id_user' AND date=CURRENT_DATE");
							$rowsignaler=$signaler->fetch();
									
							$signaler= $bdd->query("SELECT id FROM drovi_report WHERE id_magasin='$id_magasin' AND date=CURRENT_DATE");
							$signalernmb=$signaler->rowCount();

				
							if($_SESSION['drovi']) {
								if($_SESSION['drovi_xp']<10) 
								$modifier="javascript:popup('Tu n\\\'as pas assez d\\\'expérience');"; 
								else 
								$modifier= "modifier.php?id=$id_magasin";
								} else {
								$modifier= "javascript:popup('Tu n\\\'es pas connecté');";} ?>
								
								
								
											var html = "<div class='info' style='max-height:600px'><strong><?php echo $donnees['nom']; ?></strong> <br><br> <em><?php echo $donnees['adresse']; ?> </em><br> <span class='cat'><?php if($donnees['cat']=='nightshop') echo "Night Shop"; else echo $donnees['cat']; ?></span> <em><?php if($donnees['description']) echo "-".$donnees['description']; ?></em> <br><br> <? if($donneesconges['horaire']) echo '<span style=\'color:#e74c3c\'>Cet horaire est exceptionnel</span><br>'; ?> <strong>Le magasin est fermé</strong> <?php if($signalernmb>5) { echo '<br><span style=\'color:#e74c3c\'>Cet horaire semble faux</span>'; } else { if($signalernmb>=1) {echo '<br><span>Cet horaire a été signalé '.$signalernmb.' fois</span>';} } ?> <br><br> <a class='modifier' href=\"<? echo $modifier; ?>\">Modifier cet horaire</a><?php if($rowsignaler[0]) echo '<a class=\'dejasignaler\' href=\"javascript:gm(\'signaler\','.$id_magasin.');\">Tu as signalé cet horaire</a>'; else echo '<a class=\'signaler\' id=\'sign_'.$id_magasin.'\' href=\"javascript:gm(\'signaler\','.$id_magasin.');\"> Signaler cet horaire</a>'; ?> <?php if($rowfavoris[0]) echo '<a id=\'mag_'.$id_magasin.'\' class=\'favoris\' href=\"javascript:gm(\'removefavoris\','.$id_magasin.');\"> Retirer des favoris'; else echo '<a id=\'mag_'.$id_magasin.'\' class=\'pourfavoris\' href=\"javascript:gm(\'favoris\','.$id_magasin.');\"> Mettre en favoris'; ?></a></div>";
								
									var marker_<?php echo $donnees['id']; ?> = new google.maps.Marker({
										position: new google.maps.LatLng(<?php echo $donnees['latLng']; ?>),
										icon: "img/marker_ferme_<?php echo $donnees['cat']; ?>.png",
										map: map,
										draggable:false,
										content:html,
										title:"<?php echo $donnees['nom']; ?>"
									});
									
									google.maps.event.addListener(marker_<?php echo $donnees['id']; ?>, 'click', function() {
								 
									   /* close the previous info-window */
									   closeInfos();
									 
									   /* the marker's content gets attached to the info-window: */
									   var info = new google.maps.InfoWindow({content: this.content});
									 
									   /* trigger the infobox's open function */
									   info.open(map,this);
									 
									   /* keep the handle, in order to close it on next click event */
									   infos[0]=info;
									 
									});
									 
									/* ... or one may optionally bind the map on-click event as well */
									google.maps.event.addListener(map, 'click', function() {
									   closeInfos();
									});							
									<?php
									
				}
				} else {
						$commerce=$_GET['commerce'];
		
				$dayweek=date('w');
				$daydate=date('d m Y');
				
				$id_user=$_SESSION['drovi'];
			
		
		/* 		$daydate=date('d m Y');		 */
		
				$reponse = $bdd->query("SELECT * FROM drovi_magasins WHERE nom LIKE '%$commerce%' AND $dayweek IS NOT NULL");
				
		
				
				while ($donnees = $reponse->fetch()){
		
					/* $timesearch=date('H:i:s'); */
					
					$nom=$donnees['nom'];
				
					$conges = $bdd->query("SELECT * FROM drovi_conges WHERE date='$daydate' AND nom_magasin='$nom'");												
					$donneesconges = $conges->fetch();
					
					if($donneesconges['horaire']) {
						$subject=$donneesconges['horaire'];
					} else {
						$subject=$donnees[$dayweek];
					}
								
					if(preg_match('/and/', $subject)){
					
						$timesopen=explode(' and ', $subject);
						
						foreach($timesopen as $element) {
							
							$timeopen=explode(' to ', $element);
							
							if($_POST['timesearch']) {
								$timesearch=$_POST['timesearch'].":00";
							} else {
								$timesearch=date('H:i:s');
							}
							
							if($timesearch >= $timeopen[0] && $timesearch < $timeopen[1]) {
						
								$timeclose=substr($timeopen[1], 0, -3);
								
								if($timeclose=='24:00' && $donnees[$dayweek+1]) {
									if(preg_match('/and/', $donnees[$dayweek+1])){
										$nexttimesopen=explode(' and ', $donnees[$dayweek+1]);
										
										foreach($nexttimesopen as $element) {
											$nexttimeopen=explode(' to ', $element);
											
											if($nexttimeopen[0]=='00:00:00') {
												$timeclose=$nexttimeopen[1];
												$timeclose=substr($nexttimeopen[1], 0, -3);
											}
										}
									} else {
										$nexttimeopen=explode(' to ', $donnees[$dayweek+1]);
										if($nexttimeopen[0]=='00:00:00') {
											$timeclose=$nexttimeopen[1];
											$timeclose=substr($nexttimeopen[1], 0, -3);
										}
									}
								} 
								
								
								$id_magasin=$donnees['id'];
								$id_user=$_SESSION['drovi'];
								
							$reponsefavoris = $bdd->query("SELECT * FROM drovi_favoris WHERE id_magasin='$id_magasin' AND id_user='$id_user'");
								
							$rowfavoris = $reponsefavoris->fetch();
							
							$signaler= $bdd->query("SELECT id FROM drovi_report WHERE id_magasin='$id_magasin' AND id_user='$id_user' AND date=CURRENT_DATE");
							$rowsignaler=$signaler->fetch();
									
							$signaler= $bdd->query("SELECT id FROM drovi_report WHERE id_magasin='$id_magasin' AND date=CURRENT_DATE");
							$signalernmb=$signaler->rowCount();

								
								if($_SESSION['drovi']) {
								if($_SESSION['drovi_xp']<10) 
								$modifier="javascript:popup('Tu n\\\'as pas assez d\\\'expérience');"; 
								else 
								$modifier= "modifier.php?id=$id_magasin";
								} else {
								$modifier= "javascript:popup('Tu n\\\'es pas connecté');";} ?>
				
								
								
								var html = "<div class='info' style='max-height:600px'><strong><?php echo $donnees['nom']; ?></strong> <br><br> <em><?php echo $donnees['adresse']; ?> </em><br><span class='cat'><?php if($donnees['cat']=='nightshop') echo "Night Shop"; else echo $donnees['cat']; ?></span> <em><?php if($donnees['description']) echo "-".$donnees['description']; ?></em> <br><br> <? if($donneesconges['horaire']) echo '<span style=\'color:#e74c3c\'>Cet horaire est exceptionnel</span><br>'; ?> <strong>Ouvert jusque <?php echo $timeclose; ?></strong> <?php if($signalernmb>5) { echo '<br><span style=\'color:#e74c3c\'>Cet horaire semble faux</span>'; } else { if($signalernmb>=1) {echo '<br><span>Cet horaire a été signalé '.$signalernmb.' fois</span>';} } ?> <br><br> <a class='modifier' href=\"<? echo $modifier; ?>\">Modifier cet horaire</a> <?php if($rowsignaler[0]) echo '<a class=\'dejasignaler\' href=\"javascript:gm(\'signaler\','.$id_magasin.');\">Tu as signalé cet horaire</a>'; else echo '<a class=\'signaler\' id=\'sign_'.$id_magasin.'\' href=\"javascript:gm(\'signaler\','.$id_magasin.');\"> Signaler cet horaire</a>'; ?> <?php if($rowfavoris[0]) echo '<a id=\'mag_'.$id_magasin.'\' class=\'favoris\' href=\"javascript:gm(\'removefavoris\','.$id_magasin.');\"> Retirer des favoris'; else echo '<a id=\'mag_'.$id_magasin.'\' class=\'pourfavoris\' href=\"javascript:gm(\'favoris\','.$id_magasin.');\"> Mettre en favoris'; ?></a></div>";
								
								var marker_<?php echo $donnees['id']; ?> = new google.maps.Marker({
									position: new google.maps.LatLng(<?php echo $donnees['latLng']; ?>),
									icon: "img/marker_<?php echo $donnees['cat']; ?>.png",
									map: map,
									draggable:false,
									content:html,
									title:"<?php echo $donnees['nom']; ?>"
								});
								
								google.maps.event.addListener(marker_<?php echo $donnees['id']; ?>, 'click', function() {
							 
								   /* close the previous info-window */
								   closeInfos();
								 
								   /* the marker's content gets attached to the info-window: */
								   var info = new google.maps.InfoWindow({content: this.content});
								 
								   /* trigger the infobox's open function */
								   info.open(map,this);
								 
								   /* keep the handle, in order to close it on next click event */
								   infos[0]=info;
								 
								});
								 
								/* ... or one may optionally bind the map on-click event as well */
								google.maps.event.addListener(map, 'click', function() {
								   closeInfos();
								});

						
						
								<?php
							
							} /*FIN IF*/ else {
								
								if($timesearch < $timeopen[0]) {
									
									$timeclose=substr($timeopen[0], 0, -3);
									
									if($timeclose=='24:00' && $donnees[$dayweek+1]) {
									if(preg_match('/and/', $donnees[$dayweek+1])){
										$nexttimesopen=explode(' and ', $donnees[$dayweek+1]);
										
										foreach($nexttimesopen as $element) {
											$nexttimeopen=explode(' to ', $element);
											
											if($nexttimeopen[0]=='00:00:00') {
												$timeclose=$nexttimeopen[1];
												$timeclose=substr($nexttimeopen[1], 0, -3);
											}
										}
									} else {
										$nexttimeopen=explode(' to ', $donnees[$dayweek+1]);
										if($nexttimeopen[0]=='00:00:00') {
											$timeclose=$nexttimeopen[1];
											$timeclose=substr($nexttimeopen[1], 0, -3);
										}
									}
								} 
								
								$id_magasin=$donnees['id'];
								$id_user=$_SESSION['drovi'];
								
							$reponsefavoris = $bdd->query("SELECT * FROM drovi_favoris WHERE id_magasin='$id_magasin' AND id_user='$id_user'");
								
							$rowfavoris = $reponsefavoris->fetch();
							
							$signaler= $bdd->query("SELECT id FROM drovi_report WHERE id_magasin='$id_magasin' AND id_user='$id_user' AND date=CURRENT_DATE");
							$rowsignaler=$signaler->fetch();
									
							$signaler= $bdd->query("SELECT id FROM drovi_report WHERE id_magasin='$id_magasin' AND date=CURRENT_DATE");
							$signalernmb=$signaler->rowCount();

								
								if($_SESSION['drovi']) {
								if($_SESSION['drovi_xp']<10) 
								$modifier="javascript:popup('Tu n\\\'as pas assez d\\\'expérience');"; 
								else 
								$modifier= "modifier.php?id=$id_magasin";
								} else {
								$modifier= "javascript:popup('Tu n\\\'es pas connecté');";} ?>
								
								
									var html = "<div class='info' style='max-height:600px'><strong><?php echo $donnees['nom']; ?></strong> <br><br> <em><?php echo $donnees['adresse']; ?> </em><br> <span class='cat'><?php if($donnees['cat']=='nightshop') echo "Night Shop"; else echo $donnees['cat']; ?></span> <em><?php if($donnees['description']) echo "-".$donnees['description']; ?></em> <br><br> <? if($donneesconges['horaire']) echo '<span style=\'color:#e74c3c\'>Cet horaire est exceptionnel</span><br>'; ?> <strong>Prochaine ouverture à <?php echo $timeclose; ?></strong> <?php if($signalernmb>5) { echo '<br><span style=\'color:#e74c3c\'>Cet horaire semble faux</span>'; } else { if($signalernmb>=1) {echo '<br><span>Cet horaire a été signalé '.$signalernmb.' fois</span>';} } ?> <br><br> <a class='modifier' href=\"<? echo $modifier; ?>\">Modifier cet horaire</a> <?php if($rowsignaler[0]) echo '<a class=\'dejasignaler\' href=\"javascript:gm(\'signaler\','.$id_magasin.');\">Tu as signalé cet horaire</a>'; else echo '<a class=\'signaler\' id=\'sign_'.$id_magasin.'\' href=\"javascript:gm(\'signaler\','.$id_magasin.');\"> Signaler cet horaire</a>'; ?> <?php if($rowfavoris[0]) echo '<a id=\'mag_'.$id_magasin.'\' class=\'favoris\' href=\"javascript:gm(\'removefavoris\','.$id_magasin.');\"> Retirer des favoris'; else echo '<a id=\'mag_'.$id_magasin.'\' class=\'pourfavoris\' href=\"javascript:gm(\'favoris\','.$id_magasin.');\"> Mettre en favoris'; ?></a></div>";
								
									var marker_<?php echo $donnees['id']; ?> = new google.maps.Marker({
										position: new google.maps.LatLng(<?php echo $donnees['latLng']; ?>),
										icon: "img/marker_ferme_<?php echo $donnees['cat']; ?>.png",
										map: map,
										draggable:false,
										content:html,
										title:"<?php echo $donnees['nom']; ?>"
									});
									
									google.maps.event.addListener(marker_<?php echo $donnees['id']; ?>, 'click', function() {
								 
									   /* close the previous info-window */
									   closeInfos();
									 
									   /* the marker's content gets attached to the info-window: */
									   var info = new google.maps.InfoWindow({content: this.content});
									 
									   /* trigger the infobox's open function */
									   info.open(map,this);
									 
									   /* keep the handle, in order to close it on next click event */
									   infos[0]=info;
									 
									});
									 
									/* ... or one may optionally bind the map on-click event as well */
									google.maps.event.addListener(map, 'click', function() {
									   closeInfos();
									});
									
									<?php
								}
							}
						
						} /*FIN FOREACH*/
		
					} else {
					
						$timeopen=explode(' to ', $subject);
						
							if($_POST['timesearch']) {
								$timesearch=$_POST['timesearch'].":00";
							} else {
								$timesearch=date('H:i:s');
							}
		
		
						if($timesearch >= $timeopen[0] && $timesearch < $timeopen[1]) {
											
							$timeclose=substr($timeopen[1], 0, -3);
							
							if($timeclose=='24:00' && $donnees[$dayweek+1]) {
									if(preg_match('/and/', $donnees[$dayweek+1])){
										$nexttimesopen=explode(' and ', $donnees[$dayweek+1]);
										
										foreach($nexttimesopen as $element) {
											$nexttimeopen=explode(' to ', $element);
											
											if($nexttimeopen[0]=='00:00:00') {
												$timeclose=$nexttimeopen[1];
												$timeclose=substr($nexttimeopen[1], 0, -3);
											}
										}
									} else {
										$nexttimeopen=explode(' to ', $donnees[$dayweek+1]);
										if($nexttimeopen[0]=='00:00:00') {
											$timeclose=$nexttimeopen[1];
											$timeclose=substr($nexttimeopen[1], 0, -3);
										}
									}
								} 
						
							$id_magasin=$donnees['id'];
							$id_user=$_SESSION['drovi'];
								
							$reponsefavoris = $bdd->query("SELECT * FROM drovi_favoris WHERE id_magasin='$id_magasin' AND id_user='$id_user'");
								
							$rowfavoris = $reponsefavoris->fetch();
							
							$signaler= $bdd->query("SELECT id FROM drovi_report WHERE id_magasin='$id_magasin' AND id_user='$id_user' AND date=CURRENT_DATE");
							$rowsignaler=$signaler->fetch();
									
							$signaler= $bdd->query("SELECT id FROM drovi_report WHERE id_magasin='$id_magasin' AND date=CURRENT_DATE");
							$signalernmb=$signaler->rowCount();

							if($_SESSION['drovi']) {
								if($_SESSION['drovi_xp']<10) 
								$modifier="javascript:popup('Tu n\\\'as pas assez d\\\'expérience');"; 
								else 
								$modifier= "modifier.php?id=$id_magasin";
								} else {
								$modifier= "javascript:popup('Tu n\\\'es pas connecté');";
								
								} ?>
							

								var html = "<div class='info' style='max-height:600px'><strong><?php echo $donnees['nom']; ?></strong> <br><br> <em><?php echo $donnees['adresse']; ?> </em><br> <span class='cat'><?php if($donnees['cat']=='nightshop') echo "Night Shop"; else echo $donnees['cat']; ?></span> <em><?php if($donnees['description']) echo "-".$donnees['description']; ?></em><br><br> <? if($donneesconges['horaire']) echo '<span style=\'color:#e74c3c\'>Cet horaire est exceptionnel</span><br>'; if($timeopen[0]=='00:00:00' && $timeopen[1]=='24:00:00') { echo "<strong>Ouvert 24/24h</strong>"; } else {  echo "<strong>Ouvert jusque ".$timeclose."</strong>"; } if($signalernmb>5) { echo '<br><span style=\'color:#e74c3c\'>Cet horaire semble faux</span>'; } else { if($signalernmb>=1) {echo '<br><span>Cet horaire a été signalé '.$signalernmb.' fois</span>';} } ?> <br><br> <a class='modifier' href=\"<? echo $modifier; ?>\">Modifier cet horaire</a> <?php if($rowsignaler[0]) echo '<a class=\'dejasignaler\' href=\"javascript:gm(\'signaler\','.$id_magasin.');\">Tu as signalé cet horaire</a>'; else echo '<a class=\'signaler\' id=\'sign_'.$id_magasin.'\' href=\"javascript:gm(\'signaler\','.$id_magasin.');\"> Signaler cet horaire</a>'; ?> <?php if($rowfavoris[0]) echo '<a id=\'mag_'.$id_magasin.'\' class=\'favoris\' href=\"javascript:gm(\'removefavoris\','.$id_magasin.');\"> Retirer des favoris'; else echo '<a id=\'mag_'.$id_magasin.'\' class=\'pourfavoris\' href=\"javascript:gm(\'favoris\','.$id_magasin.');\"> Mettre en favoris'; ?></a></div>";				
										
								var marker_<?php echo $donnees['id']; ?> = new google.maps.Marker({
									position: new google.maps.LatLng(<?php echo $donnees['latLng']; ?>),
									icon: "img/marker_<?php echo $donnees['cat']; ?>.png",
									map: map,
									draggable:false,
									content:html,
									title:"<?php echo $donnees['nom']; ?>"
								});
								
								
								google.maps.event.addListener(marker_<?php echo $donnees['id']; ?>, 'click', function() {
								 
								   /* close the previous info-window */
								   closeInfos();
								 
								   /* the marker's content gets attached to the info-window: */
								   var info = new google.maps.InfoWindow({content: this.content});
								 
								   /* trigger the infobox's open function */
								   info.open(map,this);
								 
								   /* keep the handle, in order to close it on next click event */
								   infos[0]=info;
								 
								});
								 
								/* ... or one may optionally bind the map on-click event as well */
								google.maps.event.addListener(map, 'click', function() {
								   closeInfos();
								});
										
								
							<?php
							
							} else {
					
							
								if($timesearch < $timeopen[0] && $timeopen[0]!=NULL) {
								
									$timeclose=substr($timeopen[0], 0, -3);
									
									if($timeclose=='24:00' && $donnees[$dayweek+1]) {
									if(preg_match('/and/', $donnees[$dayweek+1])){
										$nexttimesopen=explode(' and ', $donnees[$dayweek+1]);
										
										foreach($nexttimesopen as $element) {
											$nexttimeopen=explode(' to ', $element);
											
											if($nexttimeopen[0]=='00:00:00') {
												$timeclose=$nexttimeopen[1];
												$timeclose=substr($nexttimeopen[1], 0, -3);
											}
										}
									} else {
										$nexttimeopen=explode(' to ', $donnees[$dayweek+1]);
										if($nexttimeopen[0]=='00:00:00') {
											$timeclose=$nexttimeopen[1];
											$timeclose=substr($nexttimeopen[1], 0, -3);
										}
									}
								} 
								
								
								$id_magasin=$donnees['id'];
								$id_user=$_SESSION['drovi'];
								
							$reponsefavoris = $bdd->query("SELECT * FROM drovi_favoris WHERE id_magasin='$id_magasin' AND id_user='$id_user'");
								
							$rowfavoris = $reponsefavoris->fetch();
							
							$signaler= $bdd->query("SELECT id FROM drovi_report WHERE id_magasin='$id_magasin' AND id_user='$id_user' AND date=CURRENT_DATE");
							$rowsignaler=$signaler->fetch();
									
							$signaler= $bdd->query("SELECT id FROM drovi_report WHERE id_magasin='$id_magasin' AND date=CURRENT_DATE");
							$signalernmb=$signaler->rowCount();
							
							if($_SESSION['drovi']) {
								if($_SESSION['drovi_xp']<10) 
								$modifier="javascript:popup('Tu n\\\'as pas assez d\\\'expérience');"; 
								else 
								$modifier= "modifier.php?id=$id_magasin";
								} else {
								$modifier= "javascript:popup('Tu n\\\'es pas connecté');";} ?>
								
									var html = "<div class='info' style='max-height:600px'><strong><?php echo $donnees['nom']; ?></strong> <br><br> <em><?php echo $donnees['adresse']; ?> </em><br> <span class='cat'><?php if($donnees['cat']=='nightshop') echo "Night Shop"; else echo $donnees['cat']; ?></span> <em><?php if($donnees['description']) echo "-".$donnees['description']; ?></em> <br><br> <? if($donneesconges['horaire']) echo '<span style=\'color:#e74c3c\'>Cet horaire est exceptionnel</span><br>'; ?> <strong>Prochaine ouverture à <?php echo $timeclose; ?></strong> <?php if($signalernmb>5) { echo '<br><span style=\'color:#e74c3c\'>Cet horaire semble faux</span>'; } else { if($signalernmb>=1) {echo '<br><span>Cet horaire a été signalé '.$signalernmb.' fois</span>';} } ?> <br><br> <a class='modifier' href=\"<? echo $modifier; ?>\">Modifier cet horaire</a> <?php if($rowsignaler[0]) echo '<a class=\'dejasignaler\' href=\"javascript:gm(\'signaler\','.$id_magasin.');\">Tu as signalé cet horaire</a>'; else echo '<a class=\'signaler\' id=\'sign_'.$id_magasin.'\' href=\"javascript:gm(\'signaler\','.$id_magasin.');\"> Signaler cet horaire</a>'; ?> <?php if($rowfavoris[0]) echo '<a id=\'mag_'.$id_magasin.'\' class=\'favoris\' href=\"javascript:gm(\'removefavoris\','.$id_magasin.');\"> Retirer des favoris'; else echo '<a id=\'mag_'.$id_magasin.'\' class=\'pourfavoris\' href=\"javascript:gm(\'favoris\','.$id_magasin.');\"> Mettre en favoris'; ?></a></div>";
								
									var marker_<?php echo $donnees['id']; ?> = new google.maps.Marker({
										position: new google.maps.LatLng(<?php echo $donnees['latLng']; ?>),
										icon: "img/marker_ferme_<?php echo $donnees['cat']; ?>.png",
										map: map,
										draggable:false,
										content:html,
										title:"<?php echo $donnees['nom']; ?>"
									});
									
									google.maps.event.addListener(marker_<?php echo $donnees['id']; ?>, 'click', function() {
								 
									   /* close the previous info-window */
									   closeInfos();
									 
									   /* the marker's content gets attached to the info-window: */
									   var info = new google.maps.InfoWindow({content: this.content});
									 
									   /* trigger the infobox's open function */
									   info.open(map,this);
									 
									   /* keep the handle, in order to close it on next click event */
									   infos[0]=info;
									 
									});
									 
									/* ... or one may optionally bind the map on-click event as well */
									google.maps.event.addListener(map, 'click', function() {
									   closeInfos();
									});
									
									<?php
							
							} else {
							
						
								$dayweeknext = $dayweek + 1;
								
																
								if($dayweeknext==7){
									$dayweeknext=0;
								}
		
								if($donnees[$dayweeknext]!=NULL) {
									
									$id_magasin=$donnees['id'];
									$id_user=$_SESSION['drovi'];
								
							$reponsefavoris = $bdd->query("SELECT * FROM drovi_favoris WHERE id_magasin='$id_magasin' AND id_user='$id_user'");
								
							$rowfavoris = $reponsefavoris->fetch();
							
							$signaler= $bdd->query("SELECT id FROM drovi_report WHERE id_magasin='$id_magasin' AND id_user='$id_user' AND date=CURRENT_DATE");
							$rowsignaler=$signaler->fetch();
									
							$signaler= $bdd->query("SELECT id FROM drovi_report WHERE id_magasin='$id_magasin' AND date=CURRENT_DATE");
							$signalernmb=$signaler->rowCount();
							
						
								if($_SESSION['drovi']) {
								if($_SESSION['drovi_xp']<10) 
								$modifier="javascript:popup('Tu n\\\'as pas assez d\\\'expérience');"; 
								else 
								$modifier= "modifier.php?id=$id_magasin";
								} else {
								$modifier= "javascript:popup('Tu n\\\'es pas connecté');";} ?>
									
									var html = "<div class='info' style='max-height:600px'><strong><?php echo $donnees['nom']; ?></strong> <br><br> <em><?php echo $donnees['adresse']; ?> </em><br> <span class='cat'><?php if($donnees['cat']=='nightshop') echo "Night Shop"; else echo $donnees['cat']; ?></span> <em><?php if($donnees['description']) echo "-".$donnees['description']; ?></em> <br><br> <? if($donneesconges['horaire']) echo '<span style=\'color:#e74c3c\'>Cet horaire est exceptionnel</span><br>'; ?> <strong>Prochaine ouverture demain</strong> <?php if($signalernmb>5) { echo '<br><span style=\'color:#e74c3c\'>Cet horaire semble faux</span>'; } else { if($signalernmb>=1) {echo '<br><span>Cet horaire a été signalé '.$signalernmb.' fois</span>';} } ?> <br><br> <a class='modifier' href=\"<? echo $modifier; ?>\">Modifier cet horaire</a> <?php if($rowsignaler[0]) echo '<a class=\'dejasignaler\' href=\"javascript:gm(\'signaler\','.$id_magasin.');\">Tu as signalé cet horaire</a>'; else echo '<a class=\'signaler\' id=\'sign_'.$id_magasin.'\' href=\"javascript:gm(\'signaler\','.$id_magasin.');\"> Signaler cet horaire</a>'; ?> <?php if($rowfavoris[0]) echo '<a id=\'mag_'.$id_magasin.'\' class=\'favoris\' href=\"javascript:gm(\'removefavoris\','.$id_magasin.');\"> Retirer des favoris'; else echo '<a id=\'mag_'.$id_magasin.'\' class=\'pourfavoris\' href=\"javascript:gm(\'favoris\','.$id_magasin.');\"> Mettre en favoris'; ?></a></div>";
								
									var marker_<?php echo $donnees['id']; ?> = new google.maps.Marker({
										position: new google.maps.LatLng(<?php echo $donnees['latLng']; ?>),
										icon: "img/marker_ferme_<?php echo $donnees['cat']; ?>.png",
										map: map,
										draggable:false,
										content:html,
										title:"<?php echo $donnees['nom']; ?>"
									});
									
									google.maps.event.addListener(marker_<?php echo $donnees['id']; ?>, 'click', function() {
								 
									   /* close the previous info-window */
									   closeInfos();
									 
									   /* the marker's content gets attached to the info-window: */
									   var info = new google.maps.InfoWindow({content: this.content});
									 
									   /* trigger the infobox's open function */
									   info.open(map,this);
									 
									   /* keep the handle, in order to close it on next click event */
									   infos[0]=info;
									 
									});
									 
									/* ... or one may optionally bind the map on-click event as well */
									google.maps.event.addListener(map, 'click', function() {
									   closeInfos();
									});
									
									
							<?php
									
								} else {
									
									$id_magasin=$donnees['id'];
									$id_user=$_SESSION['drovi'];
								
							$reponsefavoris = $bdd->query("SELECT * FROM drovi_favoris WHERE id_magasin='$id_magasin' AND id_user='$id_user'");
								
							$rowfavoris = $reponsefavoris->fetch();
							
							$signaler= $bdd->query("SELECT id FROM drovi_report WHERE id_magasin='$id_magasin' AND id_user='$id_user' AND date=CURRENT_DATE");
							$rowsignaler=$signaler->fetch();
									
							$signaler= $bdd->query("SELECT id FROM drovi_report WHERE id_magasin='$id_magasin' AND date=CURRENT_DATE");
							$signalernmb=$signaler->rowCount();
							
							if($_SESSION['drovi']) {
								if($_SESSION['drovi_xp']<10) 
								$modifier="javascript:popup('Tu n\\\'as pas assez d\\\'expérience');"; 
								else 
								$modifier= "modifier.php?id=$id_magasin";
								} else {
								$modifier= "javascript:popup('Tu n\\\'es pas connecté');";} ?>
								
								
											var html = "<div class='info' style='max-height:600px'><strong><?php echo $donnees['nom']; ?></strong> <br><br> <em><?php echo $donnees['adresse']; ?> </em><br> <span class='cat'><?php if($donnees['cat']=='nightshop') echo "Night Shop"; else echo $donnees['cat']; ?></span> <em><?php if($donnees['description']) echo "-".$donnees['description']; ?></em> <br><br> <? if($donneesconges['horaire']) echo '<span style=\'color:#e74c3c\'>Cet horaire est exceptionnel</span><br>'; ?> <strong>N'ouvre pas dans les prochains jours</strong> <?php if($signalernmb>5) { echo '<br><span style=\'color:#e74c3c\'>Cet horaire semble faux</span>'; } else { if($signalernmb>=1) {echo '<br><span>Cet horaire a été signalé '.$signalernmb.' fois</span>';} } ?> <br><br> <a class='modifier' href=\"<? echo $modifier; ?>\">Modifier cet horaire</a> <?php if($rowsignaler[0]) echo '<a class=\'dejasignaler\' href=\"javascript:gm(\'signaler\','.$id_magasin.');\">Tu as signalé cet horaire</a>'; else echo '<a class=\'signaler\' id=\'sign_'.$id_magasin.'\' href=\"javascript:gm(\'signaler\','.$id_magasin.');\"> Signaler cet horaire</a>'; ?> <?php if($rowfavoris[0]) echo '<a id=\'mag_'.$id_magasin.'\' class=\'favoris\' href=\"javascript:gm(\'removefavoris\','.$id_magasin.');\"> Retirer des favoris'; else echo '<a id=\'mag_'.$id_magasin.'\' class=\'pourfavoris\' href=\"javascript:gm(\'favoris\','.$id_magasin.');\"> Mettre en favoris'; ?></a></div>";
								
									var marker_<?php echo $donnees['id']; ?> = new google.maps.Marker({
										position: new google.maps.LatLng(<?php echo $donnees['latLng']; ?>),
										icon: "img/marker_ferme_<?php echo $donnees['cat']; ?>.png",
										map: map,
										draggable:false,
										content:html,
										title:"<?php echo $donnees['nom']; ?>"
									});
									
									google.maps.event.addListener(marker_<?php echo $donnees['id']; ?>, 'click', function() {
								 
									   /* close the previous info-window */
									   closeInfos();
									 
									   /* the marker's content gets attached to the info-window: */
									   var info = new google.maps.InfoWindow({content: this.content, maxWidth: 300});
									 
									   /* trigger the infobox's open function */
									   info.open(map,this);
									 
									   /* keep the handle, in order to close it on next click event */
									   infos[0]=info;
									 
									});
									 
									/* ... or one may optionally bind the map on-click event as well */
									google.maps.event.addListener(map, 'click', function() {
									   closeInfos();
									});							
									<?php
									
								}
				
								
							
						}
	
					} /*FIN ELSE*/
				
				} /*FIN WHILE*/
			
			} /*FIN ELSE*/
			
			
				$id_user=$_SESSION['drovi'];
		
				$dayweek=date('w');
				$dayweeknext=$dayweek+1;
				if($dayweeknext==7){$dayweeknext=0;}
		
		/* 		$daydate=date('d m Y');		 */
		
				$reponse = $bdd->query("SELECT * FROM drovi_magasins WHERE nom LIKE '%$commerce%' AND $dayweek IS NULL AND $dayweeknext IS NOT NULL");
				
				while($donnees=$reponse->fetch()) {
					
					$id_magasin=$donnees['id'];
					$id_user=$_SESSION['drovi'];
								
							$reponsefavoris = $bdd->query("SELECT * FROM drovi_favoris WHERE id_magasin='$id_magasin' AND id_user='$id_user'");
								
							$rowfavoris = $reponsefavoris->fetch();
							
							$signaler= $bdd->query("SELECT id FROM drovi_report WHERE id_magasin='$id_magasin' AND id_user='$id_user' AND date=CURRENT_DATE");
							$rowsignaler=$signaler->fetch();
									
							$signaler= $bdd->query("SELECT id FROM drovi_report WHERE id_magasin='$id_magasin' AND date=CURRENT_DATE");
							$signalernmb=$signaler->rowCount();

							if($_SESSION['drovi']) {
								if($_SESSION['drovi_xp']<10) 
								$modifier="javascript:popup('Tu n\\\'as pas assez d\\\'expérience');"; 
								else 
								$modifier= "modifier.php?id=$id_magasin";
								} else {
								$modifier= "javascript:popup('Tu n\\\'es pas connecté');";} ?>
								
								
								
											var html = "<div class='info' style='max-height:600px'><strong><?php echo $donnees['nom']; ?></strong> <br><br> <em><?php echo $donnees['adresse']; ?> </em><br> <span class='cat'><?php if($donnees['cat']=='nightshop') echo "Night Shop"; else echo $donnees['cat']; ?></span> <em><?php if($donnees['description']) echo "-".$donnees['description']; ?></em> <br><br> <? if($donneesconges['horaire']) echo '<span style=\'color:#e74c3c\'>Cet horaire est exceptionnel</span><br>'; ?> <strong>Prochaine ouverture demain</strong> <?php if($signalernmb>5) { echo '<br><span style=\'color:#e74c3c\'>Cet horaire semble faux</span>'; } else { if($signalernmb>=1) {echo '<br><span>Cet horaire a été signalé '.$signalernmb.' fois</span>';} } ?> <br><br> <a class='modifier' href=\"<? echo $modifier; ?>\">Modifier cet horaire</a><?php if($rowsignaler[0]) echo '<a class=\'dejasignaler\' href=\"javascript:gm(\'signaler\','.$id_magasin.');\">Tu as signalé cet horaire</a>'; else echo '<a class=\'signaler\' id=\'sign_'.$id_magasin.'\' href=\"javascript:gm(\'signaler\','.$id_magasin.');\"> Signaler cet horaire</a>'; ?> <?php if($rowfavoris[0]) echo '<a id=\'mag_'.$id_magasin.'\' class=\'favoris\' href=\"javascript:gm(\'removefavoris\','.$id_magasin.');\"> Retirer des favoris'; else echo '<a id=\'mag_'.$id_magasin.'\' class=\'pourfavoris\' href=\"javascript:gm(\'favoris\','.$id_magasin.');\"> Mettre en favoris'; ?></a></div>";
								
									var marker_<?php echo $donnees['id']; ?> = new google.maps.Marker({
										position: new google.maps.LatLng(<?php echo $donnees['latLng']; ?>),
										icon: "img/marker_ferme_<?php echo $donnees['cat']; ?>.png",
										map: map,
										draggable:false,
										content:html,
										title:"<?php echo $donnees['nom']; ?>"
									});
									
									google.maps.event.addListener(marker_<?php echo $donnees['id']; ?>, 'click', function() {
								 
									   /* close the previous info-window */
									   closeInfos();
									 
									   /* the marker's content gets attached to the info-window: */
									   var info = new google.maps.InfoWindow({content: this.content});
									 
									   /* trigger the infobox's open function */
									   info.open(map,this);
									 
									   /* keep the handle, in order to close it on next click event */
									   infos[0]=info;
									 
									});
									 
									/* ... or one may optionally bind the map on-click event as well */
									google.maps.event.addListener(map, 'click', function() {
									   closeInfos();
									});							
									<?php
									
				}
				
		
		
		
		$reponse = $bdd->query("SELECT * FROM drovi_magasins WHERE nom LIKE '%$commerce%' AND $dayweek IS NULL AND $dayweeknext IS NULL");
				
				while($donnees=$reponse->fetch()) {
					
					$id_magasin=$donnees['id'];
					$id_user=$_SESSION['drovi'];
								
							$reponsefavoris = $bdd->query("SELECT * FROM drovi_favoris WHERE id_magasin='$id_magasin' AND id_user='$id_user'");
								
							$rowfavoris = $reponsefavoris->fetch();
							
							$signaler= $bdd->query("SELECT id FROM drovi_report WHERE id_magasin='$id_magasin' AND id_user='$id_user' AND date=CURRENT_DATE");
							$rowsignaler=$signaler->fetch();
									
							$signaler= $bdd->query("SELECT id FROM drovi_report WHERE id_magasin='$id_magasin' AND date=CURRENT_DATE");
							$signalernmb=$signaler->rowCount();

				
					
							if($_SESSION['drovi']) {
								if($_SESSION['drovi_xp']<10) 
								$modifier="javascript:popup('Tu n\\\'as pas assez d\\\'expérience');"; 
								else 
								$modifier= "modifier.php?id=$id_magasin";
								} else {
								$modifier= "javascript:popup('Tu n\\\'es pas connecté');";} ?>
								
								
											var html = "<div class='info' style='max-height:600px'><strong><?php echo $donnees['nom']; ?></strong> <br><br> <em><?php echo $donnees['adresse']; ?> </em><br> <span class='cat'><?php if($donnees['cat']=='nightshop') echo "Night Shop"; else echo $donnees['cat']; ?></span> <em><?php if($donnees['description']) echo "-".$donnees['description']; ?></em> <br><br> <? if($donneesconges['horaire']) echo '<span style=\'color:#e74c3c\'>Cet horaire est exceptionnel</span><br>'; ?> <strong>N'ouvre pas dans les prochains jours</strong> <?php if($signalernmb>5) { echo '<br><span style=\'color:#e74c3c\'>Cet horaire semble faux</span>'; } else { if($signalernmb>=1) {echo '<br><span>Cet horaire a été signalé '.$signalernmb.' fois</span>';} } ?> <br><br> <a class='modifier' href=\"<? echo $modifier; ?>\">Modifier cet horaire</a><?php if($rowsignaler[0]) echo '<a class=\'dejasignaler\' href=\"javascript:gm(\'signaler\','.$id_magasin.');\">Tu as signalé cet horaire</a>'; else echo '<a class=\'signaler\' id=\'sign_'.$id_magasin.'\' href=\"javascript:gm(\'signaler\','.$id_magasin.');\"> Signaler cet horaire</a>'; ?> <?php if($rowfavoris[0]) echo '<a id=\'mag_'.$id_magasin.'\' class=\'favoris\' href=\"javascript:gm(\'removefavoris\','.$id_magasin.');\"> Retirer des favoris'; else echo '<a id=\'mag_'.$id_magasin.'\' class=\'pourfavoris\' href=\"javascript:gm(\'favoris\','.$id_magasin.');\"> Mettre en favoris'; ?></a></div>";
								
									var marker_<?php echo $donnees['id']; ?> = new google.maps.Marker({
										position: new google.maps.LatLng(<?php echo $donnees['latLng']; ?>),
										icon: "img/marker_ferme_<?php echo $donnees['cat']; ?>.png",
										map: map,
										draggable:false,
										content:html,
										title:"<?php echo $donnees['nom']; ?>"
									});
									
									google.maps.event.addListener(marker_<?php echo $donnees['id']; ?>, 'click', function() {
								 
									   /* close the previous info-window */
									   closeInfos();
									 
									   /* the marker's content gets attached to the info-window: */
									   var info = new google.maps.InfoWindow({content: this.content});
									 
									   /* trigger the infobox's open function */
									   info.open(map,this);
									 
									   /* keep the handle, in order to close it on next click event */
									   infos[0]=info;
									 
									});
									 
									/* ... or one may optionally bind the map on-click event as well */
									google.maps.event.addListener(map, 'click', function() {
									   closeInfos();
									});							
									<?php
									
				}
				
		
				$reponse = $bdd->query("SELECT * FROM drovi_magasins WHERE nom LIKE '%$commerce%' AND 1 IS NULL AND 2 IS NULL AND 3 IS NULL AND 4 IS NULL AND 5 IS NULL AND 6 IS NULL AND 0 IS NULL");
				
				while($donnees=$reponse->fetch()) {
					
					$id_magasin=$donnees['id'];
					$id_user=$_SESSION['drovi'];
								
							$reponsefavoris = $bdd->query("SELECT * FROM drovi_favoris WHERE id_magasin='$id_magasin' AND id_user='$id_user'");
								
							$rowfavoris = $reponsefavoris->fetch();
							
							$signaler= $bdd->query("SELECT id FROM drovi_report WHERE id_magasin='$id_magasin' AND id_user='$id_user' AND date=CURRENT_DATE");
							$rowsignaler=$signaler->fetch();
									
							$signaler= $bdd->query("SELECT id FROM drovi_report WHERE id_magasin='$id_magasin' AND date=CURRENT_DATE");
							$signalernmb=$signaler->rowCount();

				
							if($_SESSION['drovi']) {
								if($_SESSION['drovi_xp']<10) 
								$modifier="javascript:popup('Tu n\\\'as pas assez d\\\'expérience');"; 
								else 
								$modifier= "modifier.php?id=$id_magasin";
								} else {
								$modifier= "javascript:popup('Tu n\\\'es pas connecté');";} ?>
								
								
								
											var html = "<div class='info' style='max-height:600px'><strong><?php echo $donnees['nom']; ?></strong> <br><br> <em><?php echo $donnees['adresse']; ?> </em><br> <span class='cat'><?php if($donnees['cat']=='nightshop') echo "Night Shop"; else echo $donnees['cat']; ?></span> <em><?php if($donnees['description']) echo "-".$donnees['description']; ?></em> <br><br> <? if($donneesconges['horaire']) echo '<span style=\'color:#e74c3c\'>Cet horaire est exceptionnel</span><br>'; ?> <strong>Le magasin est fermé</strong> <?php if($signalernmb>5) { echo '<br><span style=\'color:#e74c3c\'>Cet horaire semble faux</span>'; } else { if($signalernmb>=1) {echo '<br><span>Cet horaire a été signalé '.$signalernmb.' fois</span>';} } ?> <br><br> <a class='modifier' href=\"<? echo $modifier; ?>\">Modifier cet horaire</a><?php if($rowsignaler[0]) echo '<a class=\'dejasignaler\' href=\"javascript:gm(\'signaler\','.$id_magasin.');\">Tu as signalé cet horaire</a>'; else echo '<a class=\'signaler\' id=\'sign_'.$id_magasin.'\' href=\"javascript:gm(\'signaler\','.$id_magasin.');\"> Signaler cet horaire</a>'; ?> <?php if($rowfavoris[0]) echo '<a id=\'mag_'.$id_magasin.'\' class=\'favoris\' href=\"javascript:gm(\'removefavoris\','.$id_magasin.');\"> Retirer des favoris'; else echo '<a id=\'mag_'.$id_magasin.'\' class=\'pourfavoris\' href=\"javascript:gm(\'favoris\','.$id_magasin.');\"> Mettre en favoris'; ?></a></div>";
								
									var marker_<?php echo $donnees['id']; ?> = new google.maps.Marker({
										position: new google.maps.LatLng(<?php echo $donnees['latLng']; ?>),
										icon: "img/marker_ferme_<?php echo $donnees['cat']; ?>.png",
										map: map,
										draggable:false,
										content:html,
										title:"<?php echo $donnees['nom']; ?>"
									});
									
									google.maps.event.addListener(marker_<?php echo $donnees['id']; ?>, 'click', function() {
								 
									   /* close the previous info-window */
									   closeInfos();
									 
									   /* the marker's content gets attached to the info-window: */
									   var info = new google.maps.InfoWindow({content: this.content});
									 
									   /* trigger the infobox's open function */
									   info.open(map,this);
									 
									   /* keep the handle, in order to close it on next click event */
									   infos[0]=info;
									 
									});
									 
									/* ... or one may optionally bind the map on-click event as well */
									google.maps.event.addListener(map, 'click', function() {
									   closeInfos();
									});							
									<?php
									
				}
				}

				
			}
				
			
			?>
			
			<?
				$latlng_choice=$_GET['latlng_choice'];
					
					if($latlng_choice) {
						echo "var latlng = new google.maps.LatLng($latlng_choice);";
					} else {
						echo "var latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);";
					}
				
				?>

				
			map.panTo(latlng);
		
		}
		
		function closeInfos(){
 
		   if(infos.length > 0){
		 
		      /* detach the info-window from the marker ... undocumented in the API docs */
		      infos[0].set("marker", null);
		 
		      /* and close it */
		      infos[0].close();
		 
		      /* blank the array */
		      infos.length = 0;
		   }
		}
		
		
		
			// Fonction de callback en cas d’erreur
			function erreurPosition(error) {
				var info = "Erreur lors de la géolocalisation : ";
				switch(error.code) {
				case error.TIMEOUT:
					info += "Timeout !";
				break;
				case error.PERMISSION_DENIED:
					info += "Vous n’avez pas donné la permission";
				break;
				case error.POSITION_UNAVAILABLE:
					info += "La position n’a pu être déterminée";
				break;
				case error.UNKNOWN_ERROR:
					info += "Erreur inconnue";
				break;
				}
				document.getElementById("maposition").innerHTML = info;
			}
		
		
			
		
			navigator.geolocation.getCurrentPosition(affichePosition,erreurPosition);
			
		
		} else {
		
			alert("Ce navigateur ne supporte pas la géolocalisation");
		
		}
		
		
		
		
    </script>


<!--   _______________________       SCRIPT JQUERY POUR LA HAUTEUR DE LA MAP    _______________________________      -->

   <script type="text/javascript">
   
   $(document).ready(function(){
		
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
	    	var y = x-140+"px";
			$('#map').height(y);
			$('#overlay').height(x);
			$('#popupforfavoris ul').css("max-height", x-160+"px");
	
			
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
			
			$(window).on('resize', function(){ 
				
				var testopenfiltres = $('#filtres').height();
				
				if (testopenfiltres!=0) openFiltres();
			
				var x = $( window ).height();
		    	var y = x-140+"px";
				$('#map').height(y);
				$('#overlay').height(x);
				$('#popupforfavoris ul').css("max-height", x-160+"px");
		
				
				var z = (x-(20*w))/w;	
				var prc = z * (1 * (10 / 100));	
				$('#menu li a').css("padding", z-prc+"px 0 "+prc+"px");
				
				if(z-prc<=115){
					$("#menu li a").css("text-indent", "-9999px");
				} else {
					$("#menu li a").css("text-indent", "0px");
				}
				
				if(x<=300){
					$("#menu li a").css("text-indent", "0px");
					$('#menu li a').css("padding", z/2+"px 0px");
				}
			});
			
			function replace(id, sens) {
			
				if(sens == 'favoris') {
					$('#mag_'+id).removeClass('pourfavoris').addClass('favoris');
					$('#mag_'+id).attr('href', "javascript:gm('removefavoris', "+id+");");
					$('#mag_'+id).html('Retirer des favoris');
				}
				if(sens == 'pourfavoris') {
					$('#mag_'+id).removeClass('favoris').addClass('pourfavoris');
					$('#mag_'+id).attr('href', "javascript:gm('favoris', "+id+");");
					$('#mag_'+id).html('Mettre en favoris');
				}
				
				if(sens == 'signaler') {
					$('#sign_'+id).removeClass('signaler').addClass('dejasignaler');
					$('#sign_'+id).html('Tu as signalé cet horaire');
				}
			
				
			}
			
		/*
	function write_marker(nom, adresse, cat, description, conges_horaire, timeclose, signalernmb, modifier, rowsignaler, id_magasin, rowfavoris, latlng){
				
				if(nom!=""){
				
				if(cat=='nightshop') cat="Night Shop";
				if(description) description = "-"+description;
				if(conges_horaire) conges_horaire="<span style=\'color:#e74c3c\'>Cet horaire est exceptionnel</span><br>";
				if(signalernmb>5) signalernmb5='<br><span style=\'color:#e74c3c\'>Cet horaire semble faux</span>';
				if(signalernmb>=1) signalernmb='<br><span>Cet horaire a été signalé '+ signalernmb +' fois</span>';
				if(rowsignaler) rowsignaler='<a class=\'dejasignaler\' href=\"javascript:gm(\'signaler\','+id_magasin+');\">Tu as signalé cet horaire</a>';
				if(!rowsignaler) rowsignaler='<a class=\'signaler\' id=\'sign_'+id_magasin+'\' href=\"javascript:gm(\'signaler\','+id_magasin+');\"> Signaler cet horaire</a>';
				if(rowfavoris) rowfavoris='<a id=\'mag_"+id_magasin+"\' class=\'favoris\' href=\"javascript:gm(\'removefavoris\','+id_magasin+');\"> Retirer des favoris</a>';
				if(!rowfavoris) rowfavoris='<a id=\'mag_"+id_magasin+"\' class=\'pourfavoris\' href=\"javascript:gm(\'favoris\',"+id_magasin+"\"> Mettre en favoris</a>';
					
					var html = "<div class='info'><strong>"+nom+"</strong> <br><br> <em>"+adresse+" </em><br> <span class='cat'>"+ cat+"</span> <em>"+description+"</em> <br><br> "+conges_horaire+" <strong>Ouvert jusque "+timeclose+"</strong>" + signalernmb5+ signalernmb +"<br><br> <a class='modifier' href=\""+modifier+"\">Modifier cet horaire</a> "+rowsignaler + rowfavoris"</div>";
										
										var marker_+id_magasin = new google.maps.Marker({
											position: new google.maps.LatLng(latlng),
											icon: "img/marker_"+cat+".png",
											map: map,
											draggable:false,
											content:html,
											title:nom
										});
										
										google.maps.event.addListener(marker_+id_magasin, 'click', function() {
										 
										   
										   closeInfos();
										 
										  
										   var info = new google.maps.InfoWindow({content: this.content});
										 
										   
										   info.open(map,this);
										 
										   
										   infos[0]=info;
										 
										});
										 
										
										google.maps.event.addListener(map, 'click', function() {
										   closeInfos();
										});
					}
				} 
			
*/
				
    </script>



</body>
</html>

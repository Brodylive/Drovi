<?php

session_start();

		// ini_set('display_errors', 1);
		// error_reporting(E_ALL);

try {
	$bdd = new PDO('mysql:host=localhost;dbname=jenniferdenis', 'jenniferdenis', 'SjwYCnv2tt29BqLd');
}

catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
}




$manage = $bdd->query("DELETE FROM drovi_report WHERE date NOT IN (CURRENT_DATE)");
$manage = $bdd->query("DELETE FROM drovi_conges WHERE date < (CURRENT_DATE)");


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
	
	
	<title>Drovi</title>
	
		<meta name="apple-mobile-web-app-title" content="Drovi">
		
	<link rel="stylesheet" type="text/css" href="css/reset.css">
	<link type="text/css" rel="stylesheet" href="css/style.css" />

	<link type="text/css" rel="stylesheet" href="src/css/jquery.mmenu.css" />

	
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
				
		?> &#9650;";
			}
		}
		
		
	</script>





    <script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js?ver=1.7.2'></script>
    <script type="text/javascript" src="src/js/jquery.mmenu.js"></script>
		
		<script type="text/javascript">
			$(function() {
				$('nav#menu').mmenu();
			});
		</script>
		

      
      
      <script type="text/javascript">
     <!--



function multiClass(eltId) {
	
	arrLinkId = new Array('_0','_1','_2','_3');
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
	function getCookieVal(offset) {
	var endstr=document.cookie.indexOf (";", offset);
	if (endstr==-1)
      		endstr=document.cookie.length;
	return unescape(document.cookie.substring(offset, endstr));
}

	function GetCookie (name) {
		var arg=name+"=";
		var alen=arg.length;
		var clen=document.cookie.length;
		var i=0;
		while (i<clen) {
			var j=i+alen;
			if (document.cookie.substring(i, j)==arg)
	                        return getCookieVal (j);
	                i=document.cookie.indexOf(" ",i)+1;
	                        if (i==0) break;
	       }
		return null;
	}


      </script>
      
      
		
		    <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAgrj58PbXr2YriiRDqbnL1RSqrCjdkglBijPNIIYrqkVvD1R4QxRl47Yh2D_0C1l5KXQJGrbkSDvXFA"
      type="text/javascript"></script>
    
</head>
<body>

<?

	if($_GET['action']=='deco') {
			$_SESSION['drovi']='';
			$_SESSION['drovi_xp']='';
			
			echo "<script>popup('Tu va être déconnecté...') setTimeout(function(){window.location.reload();},3000);</script>";
		}


?>

	
<div id="page">

	<div id="popupfornew">
	<div id="menu_0" class="on content">
			<h1>Drovi</h1>
			<h2>Bienvenue sur la bêta</h2>
			<a href="javascript:hidepopup();" class="fermer">Fermer</a>
				
			<div class="scrollpopup">
				<strong>Trouve un commerce <br> ici et maintenant</strong>
				<img src="img/intro1.png" style="">	
				<p>Grâce à Drovi, tu peux trouver le commerce que tu cherches ouvert <br> là où tu te trouves</p>
				<a href="#" id="_1" class="ghost" onclick="multiClass(this.id);" alt="suite1">Comment faire une recherche?</a>	
			</div>
		
			
		</div>
		
		<div id="menu_1" class="off content">
			<h1>Drovi</h1>
			<h2>Bienvenue sur la bêta</h2>
			<a href="javascript:hidepopup();" class="fermer">Fermer</a>
				
			<div class="scrollpopup">
				
				<p>Tu peux choisir une heure <br> de la journée en particulier</p>
				<img src="img/rechercheheure.png">
				<p>Choisis un filtre (catégorie) <br> en particulier à visualiser</p>
				<img src="img/intro2.png">
				<p>Si tu cherches un commerce en particulier va sur la page recherche<br> et taper le nom du commerce</p>
				<img src="img/recherchecommerce.png" width="280px">
				<a href="#" id="_2" class="ghost" onclick="multiClass(this.id);" alt="suite1">Et c'est tout?</a>	
			</div>
		
			
		</div>
			
		<div id="menu_2" class="off content">
			<h1>Drovi</h1>
			<h2>Bienvenue sur la bêta</h2>
			<a href="javascript:hidepopup();" class="fermer">Fermer</a>
			
			<div class="scrollpopup">	
				<img src="img/intro3.png" style="float:right;margin:20px 10px 10px 0;">	
				<p style="margin-top:10px;">Garde des commerces <br> à portée de main, <br>ajoute-les en favoris <br>ou signale les <br> horaires incorrects</p>
				<strong>Mais pour cela tu dois <br> être connecté!</strong>
				<img src="img/intro4.png">
		
				<a href="#" id="_3" class="current" onclick="multiClass(this.id);" alt="suite2">Pourquoi s'inscrire?</a>
				<a href="inscription.php" onclick="hidepopup();">Je m'inscris!</a>
			</div>
			
		</div>
		
		<div id="menu_3" class="off content">
			<h1>Drovi</h1>
			<h2>Bienvenue sur la bêta</h2>
			<a href="javascript:hidepopup();" class="fermer">Fermer</a>
			
			<div class="scrollpopup">
				<p>Tu pourra participer <br> au fonctionnement de Drovi <br> en modifiant ou ajoutant un horaire</p>
				<p>Tu aura des points d'expérience, <br> à partir de 10 points <br>tu aura toutes les fonctionnalités.</p>
				<img src="img/intro6.png" style="text-align:center;">
				
				<strong>Bienvenue dans la <br> communauté Drovi!</strong>
		
				<a href="#" id="_0" class="current" style="display:none;" onclick="multiClass(this.id);" alt="debut">Retourner au début</a>
				<a href="#" onclick="hidepopup();">Ok, merci!</a>
			</div>
			
		</div>
	</div>
	<div id="overlay" onclick="$('#popupfornew, #overlay, #popupfortop').hide();"></div>

<script type="text/javascript">

	function hidepopup() { 
	
		document.cookie='drovi_new=1; expires=Thu, 1 Jan 2015 12:00:00 GMT';
		$('#popupfornew, #overlay').hide();
		
	}
	
	var drovi_new=GetCookie("drovi_new");
	
	if(drovi_new){
		$('#popupfornew, #overlay').hide();
	}


</script>
 
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
	

		
	
	<div id="content">	

	
		<div id="rechercheheure">
		
			<form method="post">
			<h2>
			<?php 
				
				if($_GET['filtre'] ) { 
					
					if($_GET['filtre']=='nightshop') {
						echo "Night Shops";
					} else {
					echo "<span>".$_GET['filtre']."s</span>"; 
					}
				} else { 
					echo "Commerces"; 
				} 
				
			?>
			 ouverts à </h2>
				<input type="text" name="timesearch" id="timesearch" value="<?php 
				
				if($_POST['timesearch'] && preg_match('#[0-2][0-9]:[0-5][0-9]#', $_POST['timesearch']) ) { 
					echo $_POST['timesearch']; 
				} else { 
					echo date('H:i'); 
				} 
				
				?>">
			
				<input type="submit" value="Chercher">
			
			</form>
		
		</div>
	
	
	
	
	
	
	
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



		

<!--   _______________________       FILTRES    _______________________________      -->

	
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
			<li id="alimentaire" <? if($_GET['filtre']=='alimentaire') echo "class='current'"; ?>><a href="?action=filtrer&filtre=alimentaire">Alimentaire</a></li>
			<li id="horeca" <? if($_GET['filtre']=='horeca') echo "class='current'"; ?>><a href="?action=filtrer&filtre=horeca">Horeca</a></li>
			<li id="nightshop" <? if($_GET['filtre']=='nightshop') echo "class='current'"; ?>><a href="?action=filtrer&filtre=nightshop">Night Shop</a></li>
			<li id="boutique" <? if($_GET['filtre']=='boutique') echo "class='current'"; ?>><a href="?action=filtrer&filtre=boutique">Boutique</a></li>
			<li id="pharmacie" <? if($_GET['filtre']=='pharmacie') echo "class='current'"; ?>><a href="?action=filtrer&filtre=pharmacie">Pharmacie</a></li>
			<li id="autre" <? if($_GET['filtre']=='autre') echo "class='current'"; ?>><a href="?action=filtrer&filtre=autre">Autre</a></li>
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

    function gm(action, id) {
    
    	
		xhr.open("GET","gm.php?action="+action+"&id="+id,true);
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
		
				// On instancie un nouvel objet LatLng pour Google Maps
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
				
				
		
		
			<?php
			
			$daydate=date('Y-m-d');
			
				
		
			if($_GET['action']=='filtrer') {
		
				$filtre=$_GET['filtre'];
		
				$dayweek=date('w');
		
				$reponse = $bdd->query("SELECT * FROM drovi_magasins WHERE cat='$filtre' AND $dayweek IS NOT NULL");
			
		
				while ($donnees = $reponse->fetch()){
				
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
							
								$nom=$donnees['nom'];
								
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
								
//echo("alert('$signalernmb');");

								if($_SESSION['drovi']) {
								if($_SESSION['drovi_xp']<10) 
								$modifier="javascript:popup('Tu n\\\'as pas assez d\\\'expérience');"; 
								else 
								$modifier= "modifier.php?id=$id_magasin";
								} else {
								$modifier= "javascript:popup('Tu n\\\'es pas connecté');";} ?>
																
										
										var html = "<div class='info'><strong><?php echo $donnees['nom']; ?></strong> <br><br> <em><?php echo $donnees['adresse']; ?> </em><br> <span class='cat'><?php if($donnees['cat']=='nightshop') echo "Night Shop"; else echo $donnees['cat']; ?></span> <em><?php if($donnees['description']) echo "- ".$donnees['description']; ?></em> <br><br> <? if($donneesconges['horaire']) echo '<span style=\'color:#e74c3c\'>Cet horaire est exceptionnel</span><br>'; ?> <strong>Ouvert jusque  <?php echo $timeclose; ?></strong> <?php if($signalernmb>5) { echo '<br><span style=\'color:#e74c3c\'>Cet horaire semble faux</span>'; } else { if($signalernmb>=1) {echo '<br><span>Cet horaire a été signalé '.$signalernmb.' fois</span>';} } ?> <br><br> <a class='modifier' href=\"<? echo $modifier; ?>\">Modifier cet horaire</a> <?php if($rowsignaler[0]) echo '<a class=\'dejasignaler\' href=\"javascript:gm(\'signaler\','.$id_magasin.');\">Tu as signalé cet horaire</a>'; else echo '<a class=\'signaler\' id=\'sign_'.$id_magasin.'\' href=\"javascript:gm(\'signaler\','.$id_magasin.');\"> Signaler cet horaire</a>'; ?> <?php if($rowfavoris[0]) echo '<a id=\'mag_'.$id_magasin.'\' class=\'favoris\' href=\"javascript:gm(\'removefavoris\','.$id_magasin.');\"> Retirer des favoris'; else echo '<a id=\'mag_'.$id_magasin.'\' class=\'pourfavoris\' href=\"javascript:gm(\'favoris\','.$id_magasin.'\"> Mettre en favoris'; ?></a></div>";
										
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
			 			
								
			 		
							} /*FIN IF*/
			 		
						} /*FIN FOREACH*/
			 		

					} else {
					
						$timeopen=explode(' to ', $subject);
					
							if($_POST['timesearch']) {
								$timesearch=$_POST['timesearch'].":00";
							} else {
								$timesearch=date('H:i:s');
							}
		
						if($timesearch >= $timeopen[0] && $timesearch < $timeopen[1]) {
							
							$nom=$donnees['nom'];
							
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
//								echo("alert('$signalernmb');");
							
							
								if($_SESSION['drovi']) {
								if($_SESSION['drovi_xp']<10) 
								$modifier="javascript:popup('Tu n\\\'as pas assez d\\\'expérience');"; 
								else 
								$modifier= "modifier.php?id=$id_magasin";
								} else {
								$modifier= "javascript:popup('Tu n\\\'es pas connecté');";} ?>

									
									var html = "<div class='info'><strong><?php echo $donnees['nom']; ?></strong> <br><br> <em><?php echo $donnees['adresse']; ?> </em><br> <span class='cat'><?php if($donnees['cat']=='nightshop') echo "Night Shop"; else echo $donnees['cat']; ?></span> <em><?php if($donnees['description']) echo "- ".$donnees['description']; ?></em> <br><br> <? if($donneesconges['horaire']) echo '<span style=\'color:#e74c3c\'>Cet horaire est exceptionnel</span><br>'; if($timeopen[0]=='00:00:00' && $timeopen[1]=='24:00:00') { echo "<strong>Ouvert 24/24h</strong>"; } else {  echo "<strong>Ouvert jusque ".$timeclose."</strong>"; }  if($signalernmb>5) { echo '<br><span style=\'color:#e74c3c\'>Cet horaire semble faux</span>'; } else { if($signalernmb>=1) {echo '<br><span>Cet horaire a été signalé '.$signalernmb.' fois</span>';} } ?> <br><br> <a class='modifier' href=\"<? echo $modifier; ?>\">Modifier cet horaire</a> <?php if($rowsignaler[0]) echo '<a class=\'dejasignaler\' href=\"javascript:gm(\'signaler\','.$id_magasin.');\">Tu as signalé cet horaire</a>'; else echo '<a class=\'signaler\' id=\'sign_'.$id_magasin.'\' href=\"javascript:gm(\'signaler\','.$id_magasin.');\"> Signaler cet horaire</a>'; ?> <?php if($rowfavoris[0]) echo '<a id=\'mag_'.$id_magasin.'\' class=\'favoris\' href=\"javascript:gm(\'removefavoris\','.$id_magasin.');\"> Retirer des favoris'; else echo '<a id=\'mag_'.$id_magasin.'\' class=\'pourfavoris\' href=\"javascript:gm(\'favoris\','.$id_magasin.');\"> Mettre en favoris'; ?></a></div>";
										
									
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
						} /* FIN IF */
					
					} /* FIN ELSE */
					
				} /* FIN WHILE */
				
			} else { 
		
				$dayweek=date('w');
		
		/* 		$daydate=date('d m Y');		 */
		
				$reponse = $bdd->query("SELECT * FROM drovi_magasins WHERE $dayweek IS NOT NULL");
		
				
				while ($donnees = $reponse->fetch()){
				
					$nom=$donnees['nom'];
									
					$conges = $bdd->query("SELECT * FROM drovi_conges WHERE DATE='$daydate' AND nom_magasin='$nom'");	
					
											
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
//								echo("alert('$signalernmb');");
								
								
								if($_SESSION['drovi']) {
								if($_SESSION['drovi_xp']<10) 
								$modifier="javascript:popup('Tu n\\\'as pas assez d\\\'expérience');"; 
								else 
								$modifier= "modifier.php?id=$id_magasin";
								} else {
								$modifier= "javascript:popup('Tu n\\\'es pas connecté');";} ?>
								
								var html = "<div class='info'><strong><?php echo $donnees['nom']; ?></strong> <br><br> <em><?php echo $donnees['adresse']; ?> </em><br> <span class='cat'><?php if($donnees['cat']=='nightshop') echo "Night Shop"; else echo $donnees['cat']; ?></span> <em><?php if($donnees['description']) echo "- ".$donnees['description']; ?></em> <br><br> <? if($donneesconges['horaire']) echo '<span style=\'color:#e74c3c\'>Cet horaire est exceptionnel</span><br>'; ?> <strong>Ouvert jusque  <?php echo $timeclose; ?></strong>  <?php if($signalernmb>5) { echo '<br><span style=\'color:#e74c3c\'>Cet horaire semble faux</span>'; } else { if($signalernmb>=1) {echo '<br><span>Cet horaire a été signalé '.$signalernmb.' fois</span>';} } ?> <br><br> <a class='modifier' href=\"<? echo $modifier; ?>\">Modifier cet horaire</a> <?php if($rowsignaler[0]) echo '<a class=\'dejasignaler\' href=\"javascript:gm(\'signaler\','.$id_magasin.');\">Tu as signalé cet horaire</a>'; else echo '<a class=\'signaler\' id=\'sign_'.$id_magasin.'\' href=\"javascript:gm(\'signaler\','.$id_magasin.');\"> Signaler cet horaire</a>'; ?> <?php if($rowfavoris[0]) echo '<a id=\'mag_'.$id_magasin.'\' class=\'favoris\' href=\"javascript:gm(\'removefavoris\','.$id_magasin.');\"> Retirer des favoris'; else echo '<a id=\'mag_'.$id_magasin.'\' class=\'pourfavoris\' href=\"javascript:gm(\'favoris\','.$id_magasin.');\"> Mettre en favoris'; ?></a></div>";
										
								
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
							
							} /*FIN IF*/
						
						} /*FIN FOREACH*/
		
					} else {
					
						$timeopen=explode(' to ', $subject);
						
							if($_POST['timesearch']) {
								$timesearch=$_POST['timesearch'].":00";
							} else {
								$timesearch=date('H:i:s');
							}
		
		
						if($timesearch >= $timeopen[0] && $timesearch < $timeopen[1]) {
								
							$nom=$donnees['nom'];
							
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
							
//							echo("alert('$signalernmb');");

							if($_SESSION['drovi']) {
								if($_SESSION['drovi_xp']<10) 
								$modifier="javascript:popup('Tu n\\\'as pas assez d\\\'expérience');"; 
								else 
								$modifier= "modifier.php?id=$id_magasin";
								} else {
								$modifier= "javascript:popup('Tu n\\\'es pas connecté');";} ?>

								var html = "<div class='info'><strong><?php echo $donnees['nom']; ?></strong> <br><br> <em><?php echo $donnees['adresse']; ?> </em><br> <span class='cat'><?php if($donnees['cat']=='nightshop') echo "Night Shop"; else echo $donnees['cat']; ?></span>  <em><?php if($donnees['description']) echo "- ".$donnees['description']; ?></em> <br><br> <? if($donneesconges['horaire']) echo '<span style=\'color:#e74c3c\'>Cet horaire est exceptionnel</span><br>'; if($timeopen[0]=='00:00:00' && $timeopen[1]=='24:00:00') { echo "<strong>Ouvert 24/24h</strong>"; } else {  echo "<strong>Ouvert jusque ".$timeclose."</strong>"; }  if($signalernmb>5) { echo '<br><span style=\'color:#e74c3c\'>Cet horaire semble faux</span>'; } else { if($signalernmb>=1) echo '<br><span>Cet horaire a été signalé '.$signalernmb.' fois</span>'; } ?> <br><br> <a class='modifier' href=\"<? echo $modifier; ?>\">Modifier cet horaire</a> <?php if($rowsignaler[0]) echo '<a class=\'dejasignaler\' href=\"javascript:gm(\'signaler\','.$id_magasin.');\">Tu as signalé cet horaire</a>'; else echo '<a class=\'signaler\' id=\'sign_'.$id_magasin.'\' href=\"javascript:gm(\'signaler\','.$id_magasin.');\"> Signaler cet horaire</a>'; ?> <?php if($rowfavoris[0]) echo '<a id=\'mag_'.$id_magasin.'\' class=\'favoris\' href=\"javascript:gm(\'removefavoris\','.$id_magasin.');\"> Retirer des favoris'; else echo '<a id=\'mag_'.$id_magasin.'\' class=\'pourfavoris\' href=\"javascript:gm(\'favoris\','.$id_magasin.');\"> Mettre en favoris'; ?></a></div>";		
										
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
							
							} /*FIN IF*/
	
					} /*FIN ELSE*/
				
				} /*FIN WHILE*/
			
			} /*FIN ELSE*/
		
		
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
			$('#popupfornew .scrollpopup').css("max-height", x-160+"px");
	
			
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
				$('#popupfornew .scrollpopup').css("max-height", x-160+"px");
		
				
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

		
		
    </script>



</body>
</html>

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
	<title>A propos | Drovi</title>
	
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
    
</head>
<body>


	
<div id="page">

<div id="overlay"  style="display:none;" onclick="$('#overlay, #popupfortop').hide();"></div>

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

		<h2>A propos de Drovi</h2>
		<div id="div_apropos">
		
			<p>Drovi est le <strong>travail de fin d'études 2014</strong> de Jennifer Denis, étudiante en <a href="http://dwm.re/" style="color:#333;" target="_blank"> webdesign et multimédia</a> à l'<a href="http://www.infographie-sup.be/" style="color:#333;" target="_blank">Esiaj Namur</a>.</p>
			<br>
			<p>Drovi a été conçut en <strong>HTML5, CCS3, PHP5, JS et jQuery 1.7.2</strong>. <br>Le développement du projet a duré 4 mois et a été créé sur la base de la problématique <strong>"Trouver un commerce ouvert là où on se trouve et à une heure précise de la journée"</strong>.<p>
			<br>
			<p>Le projet Drovi est <strong>gratuit</strong> (et le restera).</p>

			
			 <a href="http://jenniferdenis.be/blog/tfe" target="_blank" class="normal">Blog</a>
			 
			 <a href="http://jenniferdenis.be/tfe" target="_blank" class="normal">Informations relatives au tfe</a>			 
			
			<ul>
			 	<li><a href="https://github.com/brodylive/drovi" target="_blank" id="github">Drovi sur Github</a>
			</li>
				<li><a href="https://twitter.com/drovi" target="_blank" id="twitter">Drovi sur Twitter</a>
			</li>
			
				<li><a href="#" id="mail">Drovi sur Github</a>
			</li>
			 </ul>
			 
			<a href="index.php" onclick="javascript:document.cookie='drovi_new=; expires=Thu, 1 Jan 2014 12:00:00 GMT';" id="link404" style="clear:both;">Rejouer le tutoriel</a>

		
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
			$('#popupfornew .scrollpopup').css("max-height", y);
	
			
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
			
			
			var i = "info";
			var d = "drovi.be";
			var a = "@";
			
			var secret = i+a+d;
			
			$('#mail').attr("href","mailto:"+secret);
			
			$(window).on('resize', function(){ 
				
							
				var x = $( window ).height();
		    	var y = x-140+"px";
				$('#map').height(y);
				$('#overlay').height(x);
				$('#popupfornew .scrollpopup').css("max-height", y);
		
				
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
</script>

</body>
</html>

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
	<meta charset="ISO">

	<link rel="shortcut icon" type="image/png" href="img/iconedrovi.png" />
  	<link rel="icon" type="image/png" href="img/iconedrovi.png" />
  	
  	<!--meta name="viewport" content="user-scalable=no, initial-scale=1" /-->
	<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=no"/>
	
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="mobile-web-app-capable" content="yes">
	
	
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	
	<link rel="apple-touch-icon" href="img/icontouchdrovi.png" />
	<link rel="apple-touch-startup-image" href="img/iconstartupdrovi.png">

	<title>Oubli de mot de passe | Drovi</title>
	
	<meta name="apple-mobile-web-app-title" content="Drovi">
	
	<link rel="stylesheet" type="text/css" href="css/reset.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
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
		
		if($_GET['action']=='deco') {
			$_SESSION['drovi']='';
			$_SESSION['drovi_xp']='';
			
			echo "<script>popup('Tu va être déconnecté...') setTimeout(function(){window.location.reload();},3000);</script>";
		}
		?>
		
	
		<h1><a href="index.php" title="Retour à l'accueil">Drovi</a></h1>
	
	</header>
	
	
	<p id='popup'></p>

	
	<div id="content">
	
		<?
			if($_SESSION['drovi']) {
			
				?>
				
				<script type="text/javascript">
					window.location.href='compte.php';
				</script>
				
				<?
				
			}
			
			?>
				<h2 class="inscription">Changer de mot de passe</h2>
		<div class="inscription">	
			
			<form method="post" onsubmit="return false">	
		
				<label for="mdp">Ton nouveau mot de passe</label>
				<input type="password" id="mdp" placeholder="Super mot de passe">
					
				<label for="conf_mdp">Confirme ton nouveau mot de passe</label>
				<input type="password" id="conf_mdp" placeholder="Super mot de passe">
				
				<input type="submit" value="Changer de mot de passe" onclick="gm('changermdp_oubli');">
					
			</form>
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
	
	

</div>


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

    function gm(action) {
    
    	if(action == 'changermdp_oubli'){
	    	var password=document.getElementById("mdp").value;
			var conf_password=document.getElementById("conf_mdp").value;
			var id= <? if($_GET['id']) { echo $_GET['id'];} else {echo "NULL";}; ?>;
			
			xhr.open("GET","gm.php?action="+action+"&id="+id+"&password="+password+"&conf_password="+conf_password,true);
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

    	
    	
    	var x = $( window ).height(); 
    	var y = $('div.inscription').height()+60;
    	
    	if(x>y){
	    	$("div.inscription").css("min-height", x-160+"px");

    	}
    	
    	
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
	    	
    	
    	
    	$(window).on('resize', function(event) {
	    	var x = $( window ).height(); 
	    	var y = $('div.inscription').height()+60;
	    	
	    	if(x>y){
		    	$("div.inscription").css("min-height", x-160+"px");
	
	    	} 
	    	
	    	
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
    	
    	
	    
	    
	    $( "#mdp" ).change(function() {
	    	
			if($("#mdp").val().length <= 5){
				$("#mdp").removeClass("ok");
				$("#mdp").css("background", "#e74c3c");
				$('#email').hover(function(){$(this).css("color", "#fff");});
				popup('Ton mot de passe doit contenir 6 caractères minimum');	
			} else {
				$("#mdp").addClass("ok");
			}
		
	    });
	    
	    $( "#conf_mdp" ).change(function() {
	    	
			if($("#conf_mdp").val() != $("#mdp").val()){
				$("#mdp, #conf_mdp").removeClass("ok");
				$("#mdp, #conf_mdp").css("background", "#e74c3c");
				$('#email').hover(function(){$(this).css("color", "#fff");});
				popup('Les mots de passe ne correspondent pas!');	
			} else {
				$("#conf_mdp, #mdp").addClass("ok");
			}
		
	    });

	    
	    


    </script>

	

</body>
</html>
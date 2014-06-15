<?php

		// ini_set('display_errors', 1);
		// error_reporting(E_ALL);

try
{
	$bdd = new PDO('mysql:host=localhost;dbname=DB', 'DB', 'MDP');
}
catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}


session_start();


$id=$_SESSION['drovi'];

		$donneesuser = $bdd->query("SELECT * FROM drovi_users WHERE id='$id'");
					
		$row = $donneesuser->fetch();
		
		$_SESSION['drovi_xp']=$row[4];
		$_SESSION['drovi_nom']=$row[1];
		
		

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

	<title>Compte | Drovi</title>
	
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
		
		

<script type="text/javascript">
<!--



function multiClass(eltId) {
	arrLinkId = new Array('_4','_5');
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
			<a href="?action=deco" id="deconnexion" title="D�connexion">Ton compte</a>
			<p class="popin ofmenu <? echo $stylechanged; ?>" id="decoinfos">D�connexion du compte</p>
			<a href="compte.php" id="nomuser" style="text-decoration:none;margin-top:8px;margin-right:10px;float:right;">Salut <? echo $nomuser; ?>!</a>
		<?
		} else {
		?>
			<a href="inscription.php" id="connexion" title="Inscris-toi ou connecte-toi">Inscris-toi ou connecte-toi</a>
			<p class="popin ofmenu" id="coinfos">Connecte-toi ou inscris-toi</p>
		<?
			
		}
		?>
	
		<h1><a href="index.php" title="Un commerce ouvert ici et maintenant">Drovi</a></h1>
	
	</header>
	

	<p id='popup'></p>
	
	
	<div id="content">
	

	<?php
	
	
		if($_GET['action']=='deco') {
			$_SESSION['drovi']='';
			$_SESSION['drovi_xp']='';
			
			echo "<script>popup('Tu va �tre d�connect�...') setTimeout(function(){window.location.reload();},3000);</script>";
		}
		
		
		if($_POST['action']=='changer') {
			
			$id=$_SESSION['drovi'];
			$username=$_POST['username'];
			$email=$_POST['email'];
			
			$change= $bdd->query("UPDATE drovi_users SET username='$username', email='$email' WHERE id=$id");
			
			
			
			echo "<script>window.location.href='compte.php';</script>";
		}
		

	
		$id=$_SESSION['drovi'];

		$donneesuser = $bdd->query("SELECT * FROM drovi_users WHERE id='$id'");
					
		$row = $donneesuser->fetch();
		
		$_SESSION['drovi_xp']=$row[4];
		
	
			if(!$_SESSION['drovi']) {
			
				?>
				
				<script type="text/javascript">
					window.location.href='inscription.php';
				</script>
				
				<?
				
			}
			
			?>
	
	
	


	<div id="menu_4" class="on content">
		<h2 class="inscription">Ton compte</h2>
		<div class="inscription">	
			
		<form method="post" id="votrecompte">
		
			<label>Ton pseudo</label>
			
			<input type="text" name="username" value="<?php echo $row[1]; ?>">
			
			
			<label>Ton email</label>
			
			<input type="text" name="email" value="<?php echo $row[2]; ?>">
			
			<label>Ton niveau</label>
			
			<input type="text" id="xp" readonly="readonly" value="<?php if(!$row[4]) echo 0; else echo $row[4]; ?> XP">
			
			<p class="popin" id="xpinfos">A partir de <strong>10 XP</strong> tu pourra ajouter un commerce et son horaire.</p>
			
			<input type="hidden" name="action" value="changer">
			<input type="submit" value="Changer mes informations">
			
					
		</form>
	
		<a href="#" id="_5" class="ghost" onclick="multiClass(this.id)" alt="changer son mot de passe">Changer ton mot de passe</a>
		<a href="supprimer.php">Supprimer ton compte</a>
		
		<a href="?action=deco" id="deco">Te d�connecter</a>
	
		</div>
	</div>
		
	<div id="menu_5" class="off content">
		<h2 class="inscription">Changer de mot de passe</h2>
		<div class="inscription">	
			
		<form method="post" onsubmit="return false">
		
			<label for="ancien_mdp">Ton ancien mot de passe</label>
			
			<input type="password" id="ancien_mdp" placeholder="Ancien mot de passe">
			
			
			<label for="nouveau_mdp">Ton nouveau mot de passe</label>
			
			<input type="password" id="nouveau_mdp" placeholder="Nouveau mot de passe">
			
			<label for="conf_nouveau_mdp">Confirme ton nouveau mot de passe</label>
			
			<input type="password" id="conf_nouveau_mdp" placeholder="Nouveau mot de passe">
			
			<input type="submit" value="Changer mon mot de passe" onclick="gm('changermdp_compte');">
			
					
		</form>
			
		<a href="#" id="_4" class="current" onclick="multiClass(this.id)" alt="mon compte">Revenir � tes info</a>
		
		<a href="supprimer.php">Supprimer ton compte</a>
	
		</div>
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
	    	echo "<p style='padding:20px 10px;text-align:center;'>Toi aussi participe � Drovi, inscris-toi et gagne de l'exp�rience!</p>";
    	} else {
    	
    	if($ok) {
	    	echo "<p style='padding:20px 10px;text-align:center;'><strong>FELICITATIONS!<strong></p>";
    	} else {    	
	    	echo "<p style='padding:20px 10px;'><strong>Ajoute</strong> des favoris et des commerces, <strong>modifie</strong> les commerces qui ont un horaire incorrect pour <strong>gagner de l'exp�rience</strong> et arriver dans le <strong>top 3</strong>!</p>";
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
	    return null; // non support�
	}

	xhr=createXhrObject();

    function gm(action) {
    
    	if(action == 'changermdp_compte'){
    		var old_password=document.getElementById("ancien_mdp").value;
	    	var password=document.getElementById("nouveau_mdp").value;
			var conf_password=document.getElementById("conf_nouveau_mdp").value;
			
			old_password=old_password.replace(/\s/, "");
			password=password.replace(/\s/, "");
			conf_password=conf_password.replace(/\s/, "");
					
			xhr.open("GET","gm.php?action="+action+"&old_password="+old_password+"&password="+password+"&conf_password="+conf_password,true);
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
    	

    	
    	$(document).ready(function(){
    	
    	var xpinfos = $("#xpinfos").height();
		$("#xpinfos").css("margin-top", "-"+(xpinfos+120)+"px");

    	$("#xp, #xpinfos").click(function(event){
    		var z = $("#xpinfos");
    		if(z.css("opacity")==="0") {
	    		z.css({"opacity": "1", "left": "auto"});
    		} else {
	    		z.css({"opacity": "0", "left": "-600px"});
    		}

	    })
	    })
	    
	    
	    
	    
    	
    		    
	    $( "#nouveau_mdp" ).change(function() {
	    	
			if($("#nouveau_mdp").val().length <= 5){
				$("#nouveau_mdp").removeClass("ok");
				$("#nouveau_mdp").css("background", "#e74c3c");
				$('#nouveau_mdp').hover(function(){$(this).css("color", "#fff");});
				popup('Ton mot de passe doit contenir 6 caract�res minimum');	
			} else {
				$("#nouveau_mdp").addClass("ok");
			}
		
	    });
	    
	    $( "#conf_nouveau_mdp" ).change(function() {
	    	
			if($("#conf_nouveau_mdp").val() != $("#nouveau_mdp").val()){
				$("#nouveau_mdp, #conf_nouveau_mdp").removeClass("ok");
				$("#nouveau_mdp, #conf_nouveau_mdp").css("background", "#e74c3c");
				$('#nouveau_mdp, #conf_nouveau_mdp').hover(function(){$(this).css("color", "#fff");});
				popup('Les mots de passe ne correspondent pas!');	
			} else {
				$("#conf_nouveau_mdp").addClass("ok");
			}
		
	    });
	    
	    

	    
	    

		
    </script>

	

</body>
</html>

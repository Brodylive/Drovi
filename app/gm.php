

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



if($_SESSION['drovi']) {
	



//             FAVORIS	

	if($_GET['action']=='favoris') {

	$id_magasin=$_GET['id'];
	$id_user=$_SESSION['drovi'];


			
		$user = $bdd->query("SELECT username FROM drovi_users WHERE id='$id_user'");
		$row=$user->fetch();
		
		$username=$row['username'];
		
		
		$magasins = $bdd->query("SELECT nom FROM drovi_magasins WHERE id='$id_magasin'");
		$row=$magasins->fetch();
		
		$magasin=$row['nom'];
		
		$favoris= $bdd->query("SELECT * FROM drovi_favoris WHERE id_magasin='$id_magasin' AND id_user='$id_user'");
		$row=$favoris->fetch();
		
			if(!$row[0]) {
				
				$favoris= $bdd->query("INSERT INTO drovi_favoris (magasin, id_magasin, utilisateur, id_user) VALUES ('$magasin', '$id_magasin','$username', '$id_user')");
				
				echo "replace($id_magasin, 'favoris'); popup('$magasin a été ajouté à tes favoris');";
			
				$addlevel= $bdd->query("SELECT niveau FROM drovi_users WHERE id='$id_user'");
				$row=$addlevel->fetch();
			
				$lvl=$row['niveau'];
				$lvlup=$lvl + 5;
			
				$addlevel= $bdd->query("UPDATE drovi_users SET niveau='$lvlup' WHERE id='$id_user'");
				
				$_SESSION['drovi_xp']=$lvlup;
	
			} else {
				echo "popup('$magasin est déjà dans tes favoris');";
			}
			
			
	} 
	

	//            REMOVE FAVORIS



	if($_GET['action']=='removefavoris') {
	$id_magasin=$_GET['id'];
	$id_user=$_SESSION['drovi'];

		
		$favoris= $bdd->query("DELETE FROM drovi_favoris WHERE id_magasin='$id_magasin' AND id_user='$id_user'");
		
		$addlevel= $bdd->query("SELECT niveau FROM drovi_users WHERE id='$id_user'");
		$row=$addlevel->fetch();
		
		$lvl=$row['niveau'];
		$lvlup=$lvl - 5;
		
		$addlevel= $bdd->query("UPDATE drovi_users SET niveau='$lvlup' WHERE id='$id_user'");
		
		$_SESSION['drovi_xp']=$lvlup;
		
		echo "replace($id_magasin, 'pourfavoris');popup('Favoris effacé!');";

	
	} 







	//           SIGNALER


	if($_GET['action']=='signaler') {
	$id_magasin=$_GET['id'];
	$id_user=$_SESSION['drovi'];

		
		
	$magasins = $bdd->query("SELECT nom FROM drovi_magasins WHERE id='$id_magasin'");
	$row=$magasins->fetch();
		
	$magasin=$row['nom'];
		
	$signaler= $bdd->query("SELECT * FROM drovi_report WHERE id_magasin='$id_magasin' AND id_user='$id_user'");
	$row=$signaler->fetch();
		
		if(!$row[0]) {
				
			$signaler= $bdd->query("INSERT INTO drovi_report (id_user, id_magasin, nom_magasin, date) VALUES ('$id_user', '$id_magasin','$magasin', CURRENT_DATE)");
		
			$addlevel= $bdd->query("SELECT niveau FROM drovi_users WHERE id='$id_user'");
			$row=$addlevel->fetch();
		
			$lvl=$row['niveau'];
			$lvlup=$lvl + 7;
		
			$addlevel= $bdd->query("UPDATE drovi_users SET niveau='$lvlup' WHERE id='$id_user'");
			
			$_SESSION['drovi_xp']=$lvlup;
			
			echo "popup('$magasin a été signalé ayant un horaire erroné');replace($id_magasin, 'signaler');";

		} else {
			echo "popup('Tu as déjà signalé $magasin');";
		}
	
	} 
	
	if($_GET['action']=='changermdp_compte') {
	
	
		$id=$_SESSION['drovi'];
		$ancien_mdp=$_GET['old_password'];
		$mdp=$_GET['password'];
		$conf_mdp=$_GET['conf_password'];
	
		$searchuser = $bdd->query("SELECT * FROM drovi_users WHERE id='$id' AND password=password('$ancien_mdp')");
		$row=$searchuser->fetch();
									
		if(!$row['id']) {echo "popup('Tu ne connais pas ton mot de passe actuel? <br> Impossible de le modifier alors...');";} else {
			
			if(strlen($mdp)>5) {
												
				if($mdp==$conf_mdp) {
					
					$updateuser = $bdd->query("UPDATE drovi_users SET password=password('$mdp') WHERE id='$id'");
					
					$username=$row['username'];	
					$email=$row['email'];								
										
					$to = $email;
					$subject = 'Nouveau mot de passe sur Drovi';

					$headers = "From: info@drovi.be\n";
					$headers.= "Content-type: text/html";


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
									Tu viens de modifier tes identifiants sur <a href='http://jenniferdenis.be/tfe/prototype/' style='text-decoration: none; color:#ddd;'> Drovi</a>
									Voici un r&eacute;capitulatif de tes nouveaux identifiants :</p>

									<p style='margin-bottom: 30px;'>
										Pseudo :<span style='color:#ddd;'>&nbsp;$username&nbsp;</span><br />
										Mot de passe :<span style='color:#ddd;'>&nbsp;$mdp</span></p>
																
							</td>
							<td style='color:#fff;  border-bottom-style: solid; border-bottom-color: #3498db; border-bottom-width: 3px;' width='200'>
								<h1 style='font-size: 18px; text-align: center;margin-top: 30px;''>
									Besoin d&#39;aide?</h1>
								<p style='background-color: #3498db; padding: 10px 10px; text-align: center; border-radius:5px;'>
									Contacte le webmaster <br> jennifer.brody.denis@gmail.com</p>
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
									<a href='http://jenniferdenis.be/tfe/prototype/supprimer.php?id=$id'>Si vous souhaitez vous d&eacute;sinscrire, c'est par ici!</a></p>
									
						</td>
						</tr>
					</tbody>
				</table>
				";
					mail($to, $subject, $message, $headers);
					
					echo "popup('Le changement a bien été effectué!'); setTimeout(function(){window.location.reload();},3000);";
				
				} else {echo "popup('Les mots de passe ne correspondent pas!');";}
				
			} else {echo "popup('Ton mot de passe doit contenir 6 caractères ou plus!');";}



		}



	}
	
	if($_GET['action']=='nomcommercedispo') {
		$nom=$_GET['nom'];
		$searchuser = $bdd->query("SELECT * FROM drovi_magasins WHERE nom='$nom'");
		$row=$searchuser->fetch();
					
		if($row[id]) {echo "popup('Ce commerce existe déjà!');wrong_input('#nom');";}
	}
	
	if($_GET['action']=='adressecommercedispo') {
		$adresse=$_GET['adresse'];
		$searchuser = $bdd->query("SELECT * FROM drovi_magasins WHERE adresse='$adresse'");
		$row=$searchuser->fetch();
					
		if($row[id]) {echo "popup('Ce adresse existe déjà pour un commerce!');wrong_input('#adresse');";}
	}


} 

if(!$_SESSION['drovi']) {

	

// CONNEXION


		if ($_GET['action']=='connexion') {
			
			
			$username=$_GET['name'];
			$mdp=$_GET['password'];
			

				
				if ($username && $mdp) {
				
					$connectinguser = $bdd->query("SELECT * FROM drovi_users WHERE username='$username' AND password=password('$mdp')");
					
					$row=$connectinguser->fetch();
					
					if($row[id]) {

						$_SESSION['drovi']=$row[id];
						$_SESSION['drovi_xp']=$row[niveau];
						$id=$_SESSION['drovi'];
						
						$addlevel= $bdd->query("SELECT niveau FROM drovi_users WHERE id='$id'");
						$row=$addlevel->fetch();
		
						$lvl=$row['niveau'];
						$lvlup=$lvl + 1;
		
						$addlevel= $bdd->query("UPDATE drovi_users SET niveau='$lvlup' WHERE id='$id'");
						
						$_SESSION['drovi_xp']=$lvlup;
						
						echo "popup('Tu es désormais connecté!'); setTimeout(function(){window.location.href='compte.php';},3000);";
						
					} else {
						echo "popup('Tu n\'es pas encore inscrit <br> ou tu t\'es trompé dans tes identifiants...');";
					}	
					
				
				} else {
					
					echo "popup('Tu n\'as pas tout rempli...');";
					
				}
				
		}
		
		if($_GET['action']=='usernamedispo') {
			$username=$_GET['username'];
			$searchuser = $bdd->query("SELECT * FROM drovi_users WHERE username='$username'");
			$row=$searchuser->fetch();
					
			if($row[id]) {echo "popup('Tu as déjà un compte!');wrong_input('#username'); ";}
		}
		
		if($_GET['action']=='emaildispo') {
			$email=$_GET['email'];
			$searchuser = $bdd->query("SELECT * FROM drovi_users WHERE email='$email'");
			$row=$searchuser->fetch();
					
			if($row[id]) {echo "popup('Tu as déjà un compte!');wrong_input('#email');";}
		}
		
		
		
		if($_GET['action']=='inscription') {
			
			$username=$_GET['username'];
			$mdp=$_GET['mdp'];
			$conf_mdp=$_GET['conf_mdp'];
			$email=$_GET['email'];
			
			

			if ($username && $mdp && $email && $conf_mdp) {
				
					
				if(strlen($username)>3) {
					
					$searchuser = $bdd->query("SELECT * FROM drovi_users WHERE username='$username'");
					$row=$searchuser->fetch();
					
					if($row[id]) {echo "popup('Tu as déjà un compte!');";} else {
					
						if(strlen($mdp)>5) {
						
							if($mdp==$conf_mdp) {
						
								if(preg_match('/^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]{2,}\.[a-zA-Z]{2,4}$/',$email)) {
								
									$searchuser = $bdd->query("SELECT * FROM drovi_users WHERE email='$email'");
									$row=$searchuser->fetch();
									
									if($row[id]) {echo "popup('Tu as déjà un compte!')";} else {
								
										$addinguser = $bdd->query("INSERT INTO drovi_users (username, email, password, date) VALUES ('$username', '$email',password('$mdp'), CURRENT_DATE)");
										
										$searchinguser = $bdd->query("SELECT id FROM drovi_users WHERE email='$email'");
										$row=$searchinguser->fetch();
										$_SESSION['drovi']=$row[id];
										
										
										$to = $email;
										$subject = 'Bienvenue sur Drovi';

										$headers = "From: info@drovi.be\n";
										$headers.= "Content-type: text/html";


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
									Merci de t'&ecirc;tre inscrit sur la <a href='http://jenniferdenis.be/tfe/prototype/' style='text-decoration: none; color:#ddd;'>b&ecirc;ta Drovi</a></p>

									<p><a href='http://jenniferdenis.be/tfe/prototype/inscription.php' style='font-size:18px; color:#ddd; text-decoration:none; font-weight:bold;'>Clique ici pour te connecter </a></p>
									<p style='margin-bottom: 30px;'>
										Pseudo :<span style='color:#ddd;'>&nbsp;$username&nbsp;</span><br />
										Adresse email :<span style='color:#ddd;'>&nbsp;$email&nbsp;</span><br />
										Mot de passe :<span style='color:#ddd;'>&nbsp;$mdp</span></p>
							
							</td>
							<td style='color:#fff;  border-bottom-style: solid; border-bottom-color: #3498db; border-bottom-width: 3px;' width='200'>
								<h1 style='font-size: 18px; text-align: center;''>
									Besoin d&#39;aide?</h1>
								<p style='background-color: #3498db; padding: 10px 10px; text-align: center; border-radius:5px;'>
									Contacte le webmaster <br> jennifer.brody.denis@gmail.com</p>
							</td>
						</tr>
						<tr>
							<td colspan='2' style='color:#fff; border-bottom-style: dashed; border-bottom-color: rgb(255, 255, 255); border-bottom-width: 1px;'>
								<h1 style='font-size: 18px; font-weight: normal;'>
									Cherche un commerce l&agrave; o&ugrave; tu es!</h1>
								<p style='margin:20px auto;'>
									En arrivant sur Drovi, tu as directement l&agrave; carte avec une ic&ocirc;ne orange (c&#39;est ta position), toutes les autres ic&ocirc;nes sont les commerces ouverts. Clique en bas sur la fl&egrave;ches pour choisir un filtre afin de ne voir sur la carte que le type de commerce qui t&#39;int&eacute;resse. Tu peux &eacute;galement changer l&#39;heure de recherche de la journ&eacute;e en cours.</p>
							</td>
						</tr>
						<tr>
							<td colspan='2' style='color:#fff; border-bottom-style: dashed; border-bottom-color: rgb(255, 255, 255); border-bottom-width: 1px;'>
								<h1 style='font-size: 18px; font-weight: normal;'>
									Garde tes commerces favoris &agrave; port&eacute;e de main!</h1>
								<p style='margin:20px auto;'>
									Ajoute autant de commerces que tu le souhaite &agrave; tes favoris! En allant sur l&#39;onglet favoris, tu pourra regarder si il est ouvert ou ferm&eacute; et dans ce cas voir la prochaine ouverture! Tu peux supprimer un favoris &agrave; tout moment.</p>
							</td>
						</tr>
						<tr>
							<td colspan='2' style='color:#fff; border-bottom-style: dashed; border-bottom-color: rgb(255, 255, 255); border-bottom-width: 1px;'>
								<h1 style='font-size: 18px; font-weight: normal;'>
									Signale un horaire incorrect</h1>
								<p style='margin:20px auto;'>
									Si le commerce est indiqu&eacute; ouvert et qu&#39;il est en r&eacute;alit&eacute; ferm&eacute;, signale-le pour les autres utilisateurs, lorsque plusieurs utilisateurs auront confirm&eacute;, tout le monde pourra voir que ce commerce n&#39;a pas un bon horaire pour la journ&eacute;e en cours.</p>
							</td>
						</tr>
						<tr>
							<td colspan='2' style='color:#fff;'>
								<h1 style='font-size: 18px; font-weight: normal;'>
									Ajouter un horaire</h1>
								<p style='margin:20px auto;'>
									Lorsque tu aura fait tes preuves sur Drovi, tu pourra ajouter un commerce avec son horaire ou changer l&#39;horaire d&#39;un commerce. Mais avant tu dois d&#39;abord ajouter des favoris, te connecter r&egrave;guli&eacute;rement et signaler quand des horaires sont faux. Pour voir o&ugrave; tu en es va dans l&#39;onglet compte! </p>
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
									<a href='http://jenniferdenis.be/tfe/prototype/supprimer.php?id=$id'>Si vous souhaitez vous d&eacute;sinscrire, c'est par ici!</a></p>
									
						</td>
						</tr>
					</tbody>
				</table>

				";
										mail($to, $subject, $message, $headers);

									
										echo "popup('Ton compte est créé, <br> tu es désormais connecté!'); setTimeout(function(){window.location.href='compte.php';},3000);";
										
										
									}
							
								} else {echo "popup('Ton email n\'est pas valide!');";}
								
							} else {echo "popup('Les mots de passe ne correspondent pas!');";}
							
							
						} else {echo "popup('Ton mot de passe doit contenir 6 caractères ou plus!');";}
						
					}	
				} else {echo "popup('Ton pseudo est trop court!');";}
					
				
			} else {	
				echo "popup('Tout n\'est pas rempli...');";
			}


				
								
		}
		
	if($_GET['action']=='oubli'){
		$email=$_GET['email'];
		
		
		if(preg_match('/^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]{2,}\.[a-zA-Z]{2,4}$/',$email)) {
								
			$searchuser = $bdd->query("SELECT * FROM drovi_users WHERE email='$email'");
			$row=$searchuser->fetch();
									
			if(!$row[id]) {echo "popup('Tu n\'as pas de compte!')";} else {
								
				$username=$row['username'];
				$id=$row['id'];										
										
				$to = $email;
				$subject = 'Mot de passe perdu sur Drovi';

				$headers = "From: info@drovi.be\n";
				$headers.= "Content-type: text/html";


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
									Tu as perdu ton mot de passe sur <a href='http://jenniferdenis.be/tfe/prototype/' style='text-decoration: none; color:#ddd;'> Drovi</a>?</p>

									<p style='font-weight:bold;'>La seule fois o&ugrave; nous acc&eacute;dons &agrave; ton mot de passe est lors de l&#39;inscription. Apr&egrave;s il est crypt&eacute; et effac&eacute; en clair...</p>
																
							</td>
							<td style='color:#fff;  border-bottom-style: solid; border-bottom-color: #3498db; border-bottom-width: 3px;' width='200'>
								<h1 style='font-size: 18px; text-align: center;margin-top: 30px;''>
									Besoin d&#39;aide?</h1>
								<p style='background-color: #3498db; padding: 10px 10px; text-align: center; border-radius:5px;'>
									Contacte le webmaster <br> jennifer.brody.denis@gmail.com</p>
							</td>
						</tr>
						<tr>
							<td colspan='2' style='color:#fff;'>
								<h1 style='font-size: 18px; font-weight: normal;'>
									Comment retrouver ton mot de passe?</h1>
								<p style='margin:20px auto;'>
								Initialise ton mot de passe via cette URL : <br><br><a href='http://jenniferdenis.be/tfe/prototype/oubli.php?id=$id' style='text-decoration: none; color:#ddd;'>http://jenniferdenis.be/tfe/prototype/oubli.php?id=$id</a><br><br>
								Une fois ton mot de passe actualis&eacute;, nous t&#39;enverrons un email avec ton nouveau mot de passe. Veille &agrave; ne pas le perdre cette fois-ci...
								</p>
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
									<a href='http://jenniferdenis.be/tfe/prototype/supprimer.php?id=$id'>Si vous souhaitez vous d&eacute;sinscrire, c'est par ici!</a></p>
									
						</td>
						</tr>
					</tbody>
				</table>
				";
		     mail($to, $subject, $message, $headers);

									
										echo "popup('Un email a été envoyé à ton adresse, patience...'); setTimeout(function(){window.location.reload();},5000);
";
									}
							
			} else {echo "popup('Ce n\'est pas une adresse email!');";}
		
	}
	
	if($_GET['action']=='changermdp_oubli') {
	
	
		$id=$_GET['id'];
		$mdp=$_GET['password'];
		$conf_mdp=$_GET['conf_password'];
	
		$searchuser = $bdd->query("SELECT * FROM drovi_users WHERE id='$id'");
		$row=$searchuser->fetch();
									
		if(!$row[id]) {echo "popup('J\'ai l\'impression que tu n\'as rien à faire ici... <br> Tu n\'as pas de compte ou tu joue avec l\'URL.');";} else {
			
			if(strlen($mdp)>5) {
												
				if($mdp==$conf_mdp) {
					
					$updateuser = $bdd->query("UPDATE drovi_users SET password=password('$mdp') WHERE id='$id'");
					
					$username=$row['username'];	
					$email=$row['email'];								
										
					$to = $email;
					$subject = 'Nouveau mot de passe sur Drovi';

					$headers = "From: info@drovi.be\n";
					$headers.= "Content-type: text/html";


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
									Voici tes nouveaux identifiants sur <a href='http://jenniferdenis.be/tfe/prototype/' style='text-decoration: none; color:#ddd;'> Drovi</a></p>

									<p style='margin-bottom: 30px;'>
										Pseudo :<span style='color:#ddd;'>&nbsp;$username&nbsp;</span><br />
										Mot de passe :<span style='color:#ddd;'>&nbsp;$mdp</span><br><br>
										Ne les perds plus!</p>
																
							</td>
							<td style='color:#fff;  border-bottom-style: solid; border-bottom-color: #3498db; border-bottom-width: 3px;' width='200'>
								<h1 style='font-size: 18px; text-align: center;margin-top: 30px;''>
									Besoin d&#39;aide?</h1>
								<p style='background-color: #3498db; padding: 10px 10px; text-align: center; border-radius:5px;'>
									Contacte le webmaster <br> jennifer.brody.denis@gmail.com</p>
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
									<a href='http://jenniferdenis.be/tfe/prototype/supprimer.php?id=$id'>Si vous souhaitez vous d&eacute;sinscrire, c'est par ici!</a></p>
									
						</td>
						</tr>
					</tbody>
				</table>
				";
					mail($to, $subject, $message, $headers);
					
					echo "popup('Le changement a bien été effectué, <br> tu peux te connecter à nouveau!'); setTimeout(function(){window.location.href='inscription.php';},5000);";
				
				} else {echo "popup('Les mots de passe ne correspondent pas!');";}
				
			} else {echo "popup('Ton mot de passe doit contenir 6 caractères ou plus!');";}



		}



	}
	
				
				
				
	if($_GET['action']=='favoris' || $_GET['action']=='signaler' || $_GET['action']=='removefavoris') {
	
		echo "popup('<a href=\'inscription.php\'>Tu n\'es pas connecté! <br><br> Inscris-toi ou connecte toi ici !</a>');";

	}
	
	
}



if($_GET['action']=='supprimer') {
	$id=$_GET['id'];
	$mdp=$_GET['password'];
	
	$searchuser = $bdd->query("SELECT * FROM drovi_users WHERE id='$id' AND password=password('$mdp')");
	$row=$searchuser->fetch();
									
	if(!$row[id]) {echo "popup('Il y a une erreur... <br> Connais-tu ton mot de passe?');";} else {
	
		$deleteuser = $bdd->query("DELETE FROM drovi_users WHERE id='$id' AND password=password('$mdp')");
		
		$_SESSION['drovi']='';
		$_SESSION['drovi_xp']='';
		
		echo "popup('Ton compte a bien été supprimé!'); setTimeout(function(){window.location.href='index.php';},5000);";

	
	}

}
	











?>

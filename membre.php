<?php

	$message = '';		// Init à vide d'un message


	// Si l'user arrive ici sans s'être logué auparavant (malin!), on le redirige vers l'écran de connexion
	if (!isset($_SESSION['id_session']))
	{
		header("Location:index.php");
		exit();
	}

	
	
// ------------------------------------------------------------------ Màj des infos de l'user ------------------------------------------------------------------ //
	if ((isset($_GET['action'])) && ($_GET['action'] == "update"))
	{
		// Stockage des données reçues par POST
		$pseudo  = mysql_real_escape_string($_POST['pseudo']);
		$mdp     = mysql_real_escape_string($_POST['mdp']);
		$confMdp = mysql_real_escape_string($_POST['confMdp']);
		$mail    = mysql_real_escape_string($_POST['mail']);
		$sexe    = mysql_real_escape_string($_POST['sexe']);

		// Si le mot de passe n'est pas vide
		if (!empty($mdp))
		{
			if (!empty($mdp))
			{
				// Si les deux mots de passe concordent
				if ($mdp == $confMdp)
				{
					// Si le mail n'est pas vide
					if (!empty($mail))	
					{
						// On écrit la requête de mise à jour de la BDD
						$reqUpdate="update users set pseudo = '".$pseudo."', mdp = '".$mdp."', sexe = '".$sexe."', 
									mail='".$mail."' where users.id_user = '".$_SESSION['id_session']."'";
						

						// Execution de la requête de mise à jour, message en fonction de la réussite ou non
						if ((mysql_query($reqUpdate)) or die($reqUpdate))
						{					
							$_SESSION['membre_pseudo']  = $pseudo;						
							$message = 'Vos informations ont bien été mises à jour.';
							header("Location:index.php");
							exit();
						}
						else
							$message = 'Vos informations n\'ont pas pu être mises à jour';
					}
					else
						$message = 'Veuillez entrer un e-mail.';			
				}
				else
					$message = 'Les deux mots de passe ne sont pas identiques.';
			}
			else
				$message = 'Veuillez entrer un mot de passe.';
		}
		else
			$message = 'Veuillez entrer un pseudo';
	}
	
	
	
	
	
	// Si l'user clique sur désinscription, on le supprime de la BD
	if ((isset($_GET['action'])) && ($_GET['action'] == "supp"))
	{
		$requeteSupp="delete FROM users WHERE id_user = '".$_SESSION['id_session']."'";

		// Destruction de la session + exécution de la requête de suppression + redirection en fonction de la réussite de la requête
		if (mysql_query($requeteSupp))		
		{
		
			$requeteSuppPiouwers = "DELETe FROM piouwers WHERE id_user_piouwer = '".$_SESSION['id_session']."' OR id_user_piouwed = '".$_SESSION['id_session']."'";
			mysql_query($requeteSuppPiouwers);
			
			
			// On vide le tableau $_SESSION puis on détruit la session
			$_SESSION = array();
			session_destroy();

			header("Location:index.php");
			exit();
		}
		else
			$message = 'Votre désinscription a écouée.';
	}



	// Requete pour obtenir les infos de l'user, en dernier au cas où l'user a mis à jour des champs
	$requete = "SELECT users.id_user, users.pseudo, users.mdp, mail, sexe
				FROM users
				WHERE id_user = ".$_SESSION['id_session']."";


	$resultatMySQL = mysql_query($requete);
	$infosUser     = mysql_fetch_assoc($resultatMySQL);
?>


	<!-- Coeur du bloc -->
	<div id="petitCentre">

		<h1>Votre espace membre</h1>

		<hr>

		<p class="alinea"> > Ici, vous pouvez consulter/modifier vos informations personelles ou encore vous désincrire ici :</p>
		
		<!-- Bouton de désinscription -->
		<center><a href="index.php?page=membre&action=supp">Se désinscrire</a></center>
		<br/>


		<center>

		<table CELLPADDING="7px" style="border:1px dashed black;">
			<form name ="propos" action="index.php?page=membre&action=update" method="POST">

			<tr> 
				<th>
					Pseudo :
				</th>
				<td>
					<input type="text" name="pseudo" value ='<?php echo $infosUser['pseudo']; ?>' required/>
				</td>
			</tr>


			<tr> 
				<th>
					Sexe : 
				</th>
				<td>
					<?php 
						// Si l'user est une fille, on met le bouton radio F en checked
						if ($infosUser['sexe'] == 'F')
						{
							echo '<input type ="radio" name="sexe" value ="M" />Homme
							<input type ="radio" name="sexe" value ="F"checked/>Femme';
						}

						// Sinon, c'est le bouton M qui est checked
						else
						{
							echo '<input type ="radio" name="sexe" value ="M"checked/>Homme
							<input type ="radio" name="sexe" value ="F"/>Femme';
						}
					?>
				</td>
			</tr>


			<tr> 
				<th>
					Mot de passe : 
				</th>
				<td>
					<input type ="password" name ="mdp" value ='<?php echo $infosUser['mdp']; ?>' required/>
				</td>
			</tr>


			<tr> 
				<th>
					Confirmez le mot de passe : 
				</th>
				<td>
					<input type="password" name="confMdp" value ='<?php echo $infosUser['mdp']; ?>' required/>
				</td>
			</tr>


			<tr> 
				<th>
					Adresse mail : 
				</th>
				<td>
					<input type ="text" name ="mail" value='<?php echo $infosUser['mail']; ?>'/>
				</td>
			</tr>


			<tr> 
				<td colspan	="2">
					<br/>
					<center>
						<input type ="reset" value="Annuler" name ="raz"/>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="submit" value="Valider les modifications" name="save"/> 
					</center>
				</td>
			</tr>

			</form>

		</table>


		<br/><br/>

		</center>

	</div>
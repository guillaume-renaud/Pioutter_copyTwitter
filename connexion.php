<?php
	session_start();

	// Connexion à mySQL et sélection de la BDD
	$connexion = mysql_connect('localhost','root','root');
	mysql_select_db('pioutter', $connexion);


	// On initialise des variables à vide
	$pseudoRecup = '';			
	$message     = '';


	// Si l'user a cliqué sur connexion, on effectue la requete de connexion
	if(isset($_POST['connexion']))
	{
		// On récupère le login et le mdp entrés par le visiteur
		$pseudoPOST = mysql_real_escape_string($_POST['pseudo']);
		$mdpPOST    = mysql_real_escape_string($_POST['mdp']);

		if ((!empty($pseudoPOST)) && (!empty($mdpPOST)))
		{
			// Requête des infos de l'utilisateur ayant un login correspondant à celui entré
			$requete = "SELECT users.id_user, users.login, users.mdp, count(users.id_user) as nombre, users.pseudo
						FROM users
						WHERE login = '$pseudoPOST'";

			// Exécution de la requête et stockage du résultat dans le tableau $resultat
			$resultatSQL = mysql_query($requete);
			$resultat    = mysql_fetch_assoc($resultatSQL);


			// Si on a un résultat (nombre > 1), c'est que l'user existe
			if ($resultat['nombre'] == 1)
			{
				// Check de la cohérence des mots de passe
				if ($resultat['mdp'] == $mdpPOST)
				{
					// Si tout est ok, l'utilisateur peut se connecter et on stocke ses infos en $_SESSION
					$_SESSION['id_session']     = $resultat['id_user'];
					$_SESSION['membre_login']  = $resultat['login'];
					$_SESSION['membre_pseudo']  = $resultat['pseudo'];
					$_SESSION['style']  = "pouss";
					
					// Si l'user est l'admin, on crée une variable privilege dans laquelle on insère admin
					if ($resultat['id'] == 1)
						$_SESSION['privilege'] = "admin";

					// On redirige ensuite l'user vers l'accueil en passant un argument indiquant que l'user vient de se loguer
					header("Location:index.php?log=ok");
					exit();
				}

				// Si le mot de passe ne correspond pas, on affiche un message et on stocke le pseudo pour le remettre dans le champ puisque celui-ci est ok
				else
				{
					$message     = "Mot de passe incorrect.";
					$pseudoRecup = $pseudoPOST;
				}
			}
		
			// Si aucun résultat, c'est que le login entré n'existe pas
			else
			{
				$message = "Désolé, l'utilisateur $pseudoPOST est inconnu.";
			}
		}
		else
			$message = "Veuillez renseigner tous les champs.";
	}
	
	
	
	
// --------------- Inscription -----------------------
	$message='';		// Initialisation du message

	if ((isset($_POST)) && (!empty($_POST['save'])) && ($_POST['save']=='Enregistrer'))
	{
		$login=mysql_real_escape_string($_POST['login']);
		$pseudo=mysql_real_escape_string($_POST['pseudo']);
		$mdp=mysql_real_escape_string($_POST['mdp']);
		$confMdp=mysql_real_escape_string($_POST['confMdp']);
		$mail=mysql_real_escape_string($_POST['mail']);
		$sexe=$_POST['sexe'];

		if (!empty($login))
		{
			if (!empty($pseudo))
			{
				if (strlen($mdp)>5)
				{
					if ($mdp==$confMdp)
					{
						
						$reqInsert="insert into users (login, pseudo, mdp, mail, sexe) 
									values ('".$login."', '".$pseudo."', '".$mdp."', '".$mail."', '".$sexe."')";


						if(mysql_query($reqInsert))
							$message='Vous êtes enregistré(e)';

							
						else 
						{
							mysql_query($reqInsert) or die (mysql_error());
							$message='Problème d\'enregistrement';
						}
					}
					else
						$message='Le mot de passe est différent de la confirmation.';
				}
				else
					$message='Le mot de passe doit contenir un minimum de 6 caractères.';
			}
			else
				$message='Le login est obligatoire.';
		}
	}
?>

	
	
<!DOCTYPE html>

<html>

<head>
    <link rel="stylesheet" href="
	<?php 
		if (isset($_SESSION['style']))
			$style = $_SESSION['style'];
		
		else
			$style = "pouss";
	

		echo $style;
		echo ".css";?>" />
		
		
		
	<title>Pioutter</title>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

</head>


<body>


<?php include_once "header.php"; ?>


<!-- Div principale, le centre du site -->
<div id="grosCentre">


	<!-- Coeur du bloc -->
	<div id="connexion">

	<h1>Connexion</h1>

	<hr>

	<h1><?php echo $message; ?></h1>
	<center>

	<table CELLPADDING="5px">

		<form name ="connexion" action="#" method="POST">

		<tr> 
			<td>
				Login: 
			</td>
			<td>
				<input type ="text" name="pseudo"/>
			</td>
		</tr>


		<tr> 
			<td>
			Mot de passe : 
			</td>
			<td>
				<input type ="password" name ="mdp" />
			</td>
		</tr>



		<tr> 
			<td colspan	="2">
			
				<center><input type="submit" value="Connexion" name="connexion"/></center>

			</td>

		</tr>


		</form>

	</table>

	</center>

	</div>
	
<?php
	if (!isset($_POST['save']))
	{
		echo '<div id="connexion">';
			include_once "inscription.php";

		echo '</div>';
	}
?>

</div>


<!-- Inclusion du footer -->
<?php include_once "footer.php"; ?>




</body>
</html>

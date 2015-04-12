<?php
	session_start();

	// Connexion à mySQL et sélection de la BDD
	$connexion = mysql_connect('localhost','root','root');
	mysql_select_db('pioutter', $connexion);
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
	<script type="text/javascript">
		// Fonction de comptage du nombre de caractères disponibles pour les piouts 
		function reste(texte)
		{
			var nbEspaces = texte.split(' ').length - 1;

			// Le nb de caractères restant est égal à 140 - taille du texte (y compris les espaces) + le nb d'espaces
			var restants = 140 - texte.length + nbEspaces; 
			
			document.getElementById('caracteres').innerHTML = restants;
			
			// Si le nb de caractères restants est inférieur à 0 on met le texte en gras et rouge
			if (restants < 0)
			{
				document.getElementById('caracteres').innerHTML = '<b><font color="red">'+restants+'</font></b>';
				document.getElementById('hexa').disabled = true;
			}	
			else if (restants == 140)
				document.getElementById('hexa').disabled = true;
			else
				document.getElementById('hexa').disabled = false;
		}
		
		// Fonction permettant de mettre le pseudo de celui à qui est adressé la réponse
		function repondre(pseudo, user, idconvers)
		{
			document.getElementById('piouter').innerHTML = '@'+pseudo+' ';
			alert("Entrez votre réponse dans le formulaire 'Piouter' situé à gauche.");
			//changement de l'action liée au formulaire de piout
			document.getElementById('formPiout').action = 'index.php?action=reponse&user='+user+'&idconvers='+idconvers; 
		}
	</script>	
	
	
</head>
<body>

<!-- Inclusion du header -->
<?php include_once "header.php"; ?>

<div id ="central">
	<div id="panneauGauche">
		<!-- Inclusion de l'encart "espace membre" -->
		<?php include_once "espaceMembre.php"; ?>
		
		<!-- Inclusion de l'encart "piouter" -->
		<?php include_once "piouter.php"; ?>
	</div>
	
	<!-- Coeur du bloc du site -->
	<div id="centre">
		<?php
			if(isset($_GET['page']))
				include($_GET['page'].'.php');
			else
				include('main.php');
		?>
	</div>
</div>

<!-- Inclusion du footer -->
<?php include_once "footer.php"; ?>

<!-- Déclaration de la fonction -->
<?php
function affiche($type, &$ligne, &$bool, $resRequete)
{
	// Calcul de l'écart de temps (en secondes) selon piout ou repiout
	if($type == "piout")
		$ecartTemps = round(time() - strtotime($ligne['datepiout']));
	else
		$ecartTemps = round(time() - strtotime($ligne['date_repiout']));
	
	// Selection de l'unité de temps
	switch ($ecartTemps) 
	{
		case ($ecartTemps < 60):			// Inférieur à 60 secondes, on laisse tel quel
			$uniteTemps = ' seconde(s).';
			break;
			
		case (($ecartTemps >= 60) && ($ecartTemps < 3600)):			// Compris entre 1 minute et 1 heure
			$ecartTemps = round($ecartTemps / 60);
			$uniteTemps = ' minute(s).';	
			break;
		
		case ($ecartTemps >= 3600 && $ecartTemps < 86400):			// Compris entre 1 heure et 24 heures
			$ecartTemps = round($ecartTemps / (60*60)) ;
			$uniteTemps = ' heure(s).';
			break;
			
		case ($ecartTemps >= 86400):								// Supérieur à 24 heures
			$ecartTemps = round($ecartTemps / (24*60*60));			
			$uniteTemps = ' jour(s).';
			break;
			
		default:
			break;
	}
	
	// Div d'affichage de chaque piout/repiout
	echo '<div id="piouts"><p>';
	
	// Si piout affichage du pseudo de l'utilisateur qui poste le message
	if($type == "piout")
		echo '<b>'.$ligne['pseudo'];
	// Si repiout affichage du pseudo de l'utilisateur de base et de celui qui le repiout 
	else
	{
		echo '<i>Piouter original : '.$ligne['pseudo_base'];
		echo '</i><br/><b>Repiouté par '.$ligne['pseudo_repiout'];
	}

	// Affichage de la date de poste
	echo ' il y a '.$ecartTemps . $uniteTemps.'</b><br/><br/>';
	echo $ligne['contenu'];
	echo '<br/><br/>';
	
	//Affichage du lien permettant de visualiser la conversation à laquelle appartient le piout
	if ($ligne['id_piout_convers'] != NULL)
	{
		echo '<b><i><a href=index.php?page=conversation&id='.$ligne['id_piout_convers'].'>Afficher la conversation</a></i></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	}
	
	if ($ligne['id_user'] == $_SESSION['id_session'])
		echo '<b><i><a href=index.php?page=main&action=suppPiout&id='.$ligne['id_piout'].'>Supprimer</a></i></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	
	
	$afficher = true;
	
	// Si c'est un repiout posté par l'utilisateur connecté
	if ((isset($ligne['id_user_repiout'])) && ($ligne['id_user_repiout'] == $_SESSION['id_session']))
		$afficher = false;
	
	
	if ((!isset($ligne['id_user_repiout'])) && ($ligne['id_user'] == $_SESSION['id_session']))
		$afficher = false;
		
		
	if ((isset($ligne['id_user_repiout'])) && ($ligne['id_user_repiout'] == $_SESSION['id_session']))
		echo '<b><i><a href=index.php?page=main&action=suppRepiout&id='.$ligne['id_repiout'].'>Supprimer</a></i></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';

	
	
	if ($afficher == true)
	{
		// Lien permettant de repiouter le piout
		echo '<b><i><a href=index.php?action=repiout&id='.$ligne['id_piout'].'&user='.$ligne['id_user'].'>Repiouter</a></i></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		
		// Mise en place des paramètres de la réponse selon piout ou repiout
		if($type == "piout")
		{
			$pseudo = $ligne['pseudo'];
			$id_user = $ligne['id_user'];

			// Si le piout n'appartient pas à une conversation, elle est créée et correspond à l'ID du piout
			if (($ligne['id_piout_convers'] == 0) && ($ligne['id_piout_convers'] == NULL))
				$id_convers = $ligne['id_piout'];
			// Sinon on récupère l'ID de la conversation correspondant à ce piout
			else
				$id_convers = $ligne['id_piout_convers'];		
		}
		else
		{
			$pseudo = $ligne['pseudo_repiout'];
			$id_user = $ligne['id_user_repiout'];
			$id_convers = $ligne['id_repiout'];
		}
		
		// Lien permettant de répondre à un piout/repiout (la réponse sera ajoutée à la conversation correspondante)
		// onclick : code javascript permettant d'appeler la fonction "répondre" avec 3 paramètres
		echo '<b><i><a href=index.php?action=reponse&user='.$id_user.' onclick="javascript:repondre(\''.$pseudo.'\', \''.$id_user.'\', \''.$id_convers.'\');return false;">Répondre</a></i></b>';	
	}
	
	echo '<br/></p></div><br/>';
	// On passe au piout/repiout suivant
	if (($ligne = mysql_fetch_assoc($resRequete)) == false)
		$bool = false;
}
?>

</body>
</html>




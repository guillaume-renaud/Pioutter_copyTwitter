<head>
<META HTTP-EQUIV="Refresh" CONTENT="10; URL=index.php"> 


</head>

 <?php
	// Si l'user arrive ici sans s'être logué auparavant (malin!), on le redirige vers l'écran de connexion
	if (!isset($_SESSION['id_session']))
	{
		header("Location:connexion.php");
		exit();
	}
	
	
// --------------------------------------------------------- Suppression d'un piout ----------------------------------------------------------------- //
	if ((isset($_GET['action'])) && ($_GET['action'] == "suppPiout"))
	{
		$requeteSuppr = "DELETE FROM piout WHERE id_piout = ".$_GET['id']."";
		
		mysql_query($requeteSuppr);
	}
	
	if ((isset($_GET['action'])) && ($_GET['action'] == "suppRepiout"))
	{
		$requeteSuppr = "DELETE FROM repiout WHERE id_repiout = ".$_GET['id']."";
		
		mysql_query($requeteSuppr);
	}








	// Si l'user clique sur déconnexion, on le déconnecte
	if ((isset($_GET['action'])) && ($_GET['action'] == "deco"))
	{
		// On vide le tableau $_SESSION puis on détruit la session
		$_SESSION = array();
		session_destroy();

		header("Location:index.php");
		exit();
	}
	
	
	// Traitement de l'envoi d'un piout
	if ((isset($_POST['confirm'])) && ($_POST['confirm'] == "Piouter !") && (isset($_GET['action']) != "reponse"))
	{
		$contenu = mysql_real_escape_string($_POST['piout']);
		
		$reqInsert="INSERT INTO piout (id_user, contenu) values ('".$_SESSION['id_session']."', '".$contenu."')";
	
		$resReqInsert = mysql_query($reqInsert);
	}
	
	
	
	// Traitement des repiouts
	if ((isset($_GET['action'])) && ($_GET['action'] == "repiout"))
	{
		// Si l'user ne se répond pas à lui même on éxécute
		if ($_GET['user'] != $_SESSION['id_session'])
		{
			$reqInsertRep="INSERT INTO repiout (id_user_original, id_user_repiout, id_piout) values ('".$_GET['user']."', '".$_SESSION['id_session']."', '".$_GET['id']."')";
			
			mysql_query($reqInsertRep);
			
			header("Location:index.php");
		}
	}	
	
	// Traitement des réponses
	if ((isset($_GET['action'])) && ($_GET['action'] == "reponse"))
	{
		// Si l'user ne se répond pas à lui même on exécute
		if ($_GET['user'] != $_SESSION['id_session'])
		{
			$contenu = mysql_real_escape_string($_POST['piout']);
			$reqInsertReponse = "INSERT INTO piout (id_user, contenu, id_piout_convers) values ('".$_SESSION['id_session']."', '".$contenu."', '".$_GET['idconvers']."')";
			
			$reqUpdateReponsePiout = "UPDATE piout SET id_piout_convers = '".$_GET['idconvers']."' WHERE id_piout = '".$_GET['idconvers']."'";
			$reqUpdateReponseRepiout = "UPDATE repiout SET id_piout_convers = '".$_GET['idconvers']."' WHERE id_piout = '".$_GET['idconvers']."'";		
			
			mysql_query($reqInsertReponse);
			mysql_query($reqUpdateReponsePiout);
			mysql_query($reqUpdateReponseRepiout);
			header("Location:index.php");
		}
	}	
	
	
	
// ---------------------------------------------- Requete de selection des piouts -------------------------------------------------------- 
	$requeteFollow = "  SELECT id_user_piouwed
						FROM piouwers
						WHERE id_user_piouwer = ".$_SESSION['id_session']."";
						
						
	$resRequeteFollow = mysql_query($requeteFollow);
	
	if (mysql_num_rows($resRequeteFollow) != 0)
	{
		$requetePiout = "	SELECT distinct id_piout, piout.id_user, contenu, pseudo, datepiout, piout.id_piout_convers
							FROM (piout JOIN users on piout.id_user = users.id_user) JOIN piouwers on piouwers.id_user_piouwer = ".$_SESSION['id_session']."
							WHERE (piout.id_user = piouwers.id_user_piouwed) OR (piout.id_user = ".$_SESSION['id_session'].")
							ORDER BY datepiout DESC";

							
		$requeteRepiout = " SELECT distinct piout.id_piout_convers, repiout.id_repiout, repiout.id_piout, users1.pseudo as pseudo_repiout, users2.pseudo as pseudo_base, users2.id_user, date_repiout, contenu, users1.id_user as 'id_user_repiout'
							FROM (((repiout JOIN piout ON repiout.id_piout = piout.id_piout) JOIN users users1 ON repiout.id_user_repiout = users1.id_user) JOIN users users2 ON repiout.id_user_original = users2.id_user) JOIN piouwers on piouwers.id_user_piouwer = ".$_SESSION['id_session']."
							WHERE (repiout.id_user_repiout = piouwers.id_user_piouwed) OR (repiout.id_user_repiout = ".$_SESSION['id_session'].")
							ORDER BY date_repiout DESC";
	}
	else
	{
		$requetePiout=" SELECT distinct id_piout, piout.id_user, contenu, pseudo, datepiout, piout.id_piout_convers
						FROM piout JOIN users on piout.id_user = users.id_user
						WHERE piout.id_user = ".$_SESSION['id_session']."
						ORDER BY datepiout DESC";
						
		$requeteRepiout = " SELECT piout.id_piout_convers, repiout.id_repiout, repiout.id_piout, users1.pseudo as pseudo_repiout, users2.pseudo as pseudo_base, users2.id_user, date_repiout, contenu, users1.id_user as 'id_user_repiout'
							FROM (((repiout JOIN piout ON repiout.id_piout = piout.id_piout) JOIN users users1 ON repiout.id_user_repiout = users1.id_user) JOIN users users2 ON repiout.id_user_original = users2.id_user)
							WHERE id_user_repiout = ".$_SESSION['id_session']."
							ORDER BY date_repiout DESC";
	
	}



	$resRequetePiout = mysql_query($requetePiout) or die($requetePiout);	
	$resRequeteRepiout = mysql_query($requeteRepiout) or die($requeteRepiout);

	
	// On définit un fuseau horaire pour éviter les bugs de time()
	date_default_timezone_set("Europe/Paris");
	
?>
 
 <h1>Piouts</h1>
<?php
	$bool1 = true;
	$bool2 = true;			
	
	// Si il y a des piouts à afficher
	if (($lignePiout = mysql_fetch_assoc($resRequetePiout)) == false)
		$bool1 = false;
	
	// Si il y a des repiouts à afficher
	if (($ligneRepiout = mysql_fetch_assoc($resRequeteRepiout)) == false)
		$bool2 = false;		
	
	// Tant que l'on a encore quelque chose à afficher
	While ($bool1 || $bool2)
	{
		// Si les deux sont à vrai on teste les dates
		if ($bool1 && $bool2)
		{
			// Si le piout actuel est plus récent que le repiout actuel on affiche le piout
			if ($lignePiout['datepiout'] > $ligneRepiout['date_repiout'])
				affiche("piout", $lignePiout, $bool1, $resRequetePiout);
			// Sinon on affiche le repiout
			else
				affiche("repiout", $ligneRepiout, $bool2, $resRequeteRepiout);
		}
		else
		{
			// S'il reste que des piout
			if ($bool1)
				affiche("piout", $lignePiout, $bool1, $resRequetePiout);
			// Repiout
			else
				affiche("repiout", $ligneRepiout, $bool2, $resRequeteRepiout);
		}
	}
?>
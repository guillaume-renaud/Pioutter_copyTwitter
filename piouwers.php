<?php

	// Requete pour ne plus suivre une personne
	if ((isset($_GET['action'])) && ($_GET['action'] == 'unfollow'))
	{
		$requeteUnfollow = "DELETE FROM piouwers where id_user_piouwed = ".$_GET['id']."";
		
		mysql_query($requeteUnfollow);
	}

	
	$requetePiouwers = " SELECT id_user_piouwed, pseudo
				FROM piouwers JOIN users on piouwers.id_user_piouwed = users.id_user
				WHERE id_user_piouwer = ".$_SESSION['id_session']."";
				
				
	$resRequetePiouwers = mysql_query($requetePiouwers) or die($requetePiouwers);
	
	$countPiouwers = mysql_num_rows($resRequetePiouwers);
	
	
	$requetePiouwed = " SELECT id_user_piouwer, pseudo
				FROM piouwers JOIN users on piouwers.id_user_piouwer = users.id_user
				WHERE id_user_piouwed = ".$_SESSION['id_session']."";
				
				
	$resRequetePiouwed = mysql_query($requetePiouwed);
	
	$countPiouwed = mysql_num_rows($resRequetePiouwed);

?>





<?php
	echo '<center>';
	
	
	if ($countPiouwers > 0)
	{
		echo '<b>Voici les personnes que vous suivez :</b></br></br>';
		echo '<table border="1px solid black" cellspacing="0" cellpadding="10%">';
			while ($ligne = mysql_fetch_assoc($resRequetePiouwers))
			{
				echo '<tr>';
					echo "<td><b><center>".$ligne['pseudo']."</b>";
					echo '</td>';
					
					echo "<td><a href='index.php?page=piouwers&action=unfollow&id=".$ligne['id_user_piouwed']."'>Ne plus suivre</a>";
					echo '</td>';
				echo '</tr>';
			}

		echo '</table>';
	}
	else
		echo '<b>Vous ne suivez personne.</b>';
	
	
	if ($countPiouwed > 0)
	{
		echo '<b></br></br></br>Voici les personnes qui vous suivent :</b></br></br>';
		echo '<table border="1px solid black" cellspacing="0" cellpadding="10%">';
			while ($ligne2 = mysql_fetch_assoc($resRequetePiouwed))
			{
				echo '<tr>';
					echo "<td><center><b>".$ligne2['pseudo']."</b></center>";
					echo '</td>';
				echo '</tr>';
			}

		echo '</table>';
	}
	
	
	
	echo '</center>';
				
				
?>
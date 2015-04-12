<?php

	// Si on a validé le formulaire
	if ((isset($_POST['bouton_recherche'])) && ($_POST['bouton_recherche'] == 'Rechercher'))
	{ 
		if ((isset($_POST['pseudo'])) && ($_POST['pseudo'] != ""))
		{
			$recherche = preg_replace('#[^A-Za-z 0-9?!éàèùêç\#]#', '', mysql_real_escape_string($_POST['pseudo'])); // Sécurisation des variables

			$requeteRecherche = "SELECT id_user, pseudo 
								FROM users 
								WHERE pseudo like '%$recherche%' AND id_user != ".$_SESSION['id_session']."";
								
								
								
			$query = mysql_query($requeteRecherche) or die ($requeteRecherche);
			$count = mysql_num_rows($query);
			
			
			$requetePiouwers = "SELECT id_user_piouwed, pseudo 
					FROM piouwers join users on piouwers.id_user_piouwed = users.id_user
					WHERE id_user_piouwer = ".$_SESSION['id_session']."";
								
	
			$queryPiouwers = mysql_query($requetePiouwers) or die ($requetePiouwers);


			// Si au moins un résultat
			if($count >= 1)
			{
				if($count == 1)
					$search_output = $count." résultat pour <strong>".$recherche."</strong><br/><br/>";
					
				else
					$search_output = $count." résultats pour <strong>".$recherche."</strong><br/><br/>";
			}
			else
				$search_output = "0 résultat pour <strong>".$recherche."</strong>";
		}
		else
			$search_output = "Veuillez entrer un pseudo.";
	}
	
	
	if ((isset($_GET['action'])) && ($_GET['action'] == 'insert'))
	{
		$requeteInsert = "INSERT INTO piouwers (id_user_piouwer, id_user_piouwed) values ('".$_SESSION['id_session']."', '".$_GET['id']."')";
		
		mysql_query($requeteInsert);
	}
?>




<h1>Recherche</h1>
<hr/> 
<br/>



<!-- Section avec un type formulaire pour pouvoir rechercher un article déjà existant avec son titre -->
<center>
	<form name="form_recherche" action="#" method="POST" style='display:inline-block;'>
		<table border="0" cellspacing="0" cellpadding="5%">
			<tr>
				<th>Pseudo du piouter recherché :</th>
				<th><input type="text" name="pseudo" size="50"/></th>
			</tr>
		</table>
		
		<br/>
		
		<input type="submit" name="bouton_recherche" value="Rechercher"/> <!-- Bouton de validation de la recherche -->
	</form>
</center>
	
	
<div>

	<?php 
	
		if (isset($_POST['bouton_recherche']))
		{
			if(!empty($search_output))
				echo $search_output;
			
			if (isset($recherche))
			{
				echo '<center>';
				echo '<table border="1px solid black" cellspacing="0" cellpadding="10%">';
					while ($ligne = mysql_fetch_assoc($query))
					{
						$trouve = false;
						
						echo '<tr>';
							echo "<td><b>".$ligne['pseudo']."</b>";
							echo '</td>';
							
							while ($ligne2 = mysql_fetch_array($queryPiouwers))
								if ($ligne['pseudo'] == $ligne2['pseudo'])
									$trouve = true;

							if ($trouve != true)
								echo "<td><a href='index.php?page=recherche&action=insert&id=".$ligne['id_user']."'>Suivre</a>";
							
							else
								echo "<td>Suivi</a>";
								
							echo '</td>';
						echo '</tr>';
					}

				echo '</table>';
				echo '</center>';
			}	
		}






?>

</div>

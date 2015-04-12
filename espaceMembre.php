<?php
	// Connexion à la base de données
	$connexion = mysql_connect('localhost','root','root');
	mysql_select_db('pioutter',$connexion);		
	

	

	

?>



<!-- Derniers tests parus page 1 -->
<div id="postPiout">
	<center>
		<h1><?php echo $_SESSION['membre_pseudo']; ?></h1>
		
		<img src="Img/piou_avatar.jpg" width="50%"/>
		
		</br><a href="index.php?action=deco">Déconnexion</a>
	</center>
</div>
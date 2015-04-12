<?php
	if (isset($_SESSION['id_session']))
		$rubrique = '<li><a href="index.php?page=recherche">Recherche</a></li>
					<li><a href="index.php?page=membre">Espace membre</a></li>
					<li><a href="index.php?page=piouwers">Piouwers</a></li>
					<li><a href="index.php?page=styles">Switch CSS</a></li>';
	else
		$rubrique = '<li><a href="connexion.php">Connexion</a></li>';
		
?>
		
		
		
		
		<!-- Arrière plan fixe -->
<div id="background">
	<img src="Img\
	<?php 
		if (isset($_SESSION['id_session']))
			echo $_SESSION['style'];
			
		else
			echo 'pouss';
			
		echo '.jpg" width ="';
		echo '100%">';
	?>
	
</div>



<!-- Header -->
<div id="header">
	<img src="Img/ban_<?php 
		if (isset($_SESSION['style']))
			echo $_SESSION['style'];
		
		else
			echo 'pouss';
			
		echo '.jpg"';
	?>" width="100%"/>

</div>



<!-- Barre de menu -->
<div id="menu">
	<center>
		<ul id="nav">
			<li><a href="index.php">Accueil</a></li>
			<?php echo $rubrique; ?>
			
		</ul>
	</center>
</div>
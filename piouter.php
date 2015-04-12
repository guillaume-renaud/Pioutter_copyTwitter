<?php

	// Connexion à la base de données
	$connexion = mysql_connect('localhost','root','root');
	mysql_select_db('pioutter',$connexion);		
	

	

	

?>



<!-- Derniers tests parus page 1 -->
<div id="postPiout">
	<h1>Piouter</h1>
	

	<form id = "formPiout" name ="piouter" action="index.php" method="POST">
		
	<center>
	
	<textarea id="piouter" name ="piout" onkeyup="reste(this.value);"></textarea>
	<br/>
	<span id="caracteres">140</span> caractères restants
	<br/>
	<input id="hexa" disabled type="submit" name="confirm" value="Piouter !" style="margin-top:4%;"/>
	</center>
		
	</form>
</div>


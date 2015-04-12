<?php
	if (isset($_GET['style']))
	{
		$_SESSION['style'] = $_GET['style'];
		header("location:index.php");
	}



?>


<center>
	<a href="index.php?page=styles&style=nugg">Style Nugget</a><br/>
	<a href="index.php?page=styles&style=pouss">Style Poussin</a>
<center>


<?php

?>
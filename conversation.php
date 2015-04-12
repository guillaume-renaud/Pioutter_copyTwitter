<?php  
	$requeteConvers = "SELECT id_user, contenu, datepiout
						FROM piout
						WHERE id_piout_convers = '".$_GET['id']."'";
						
	/*$requeteConversRepiout = "SELECT id_user, contenu, datepiout
						FROM piout
						WHERE id_piout_convers = '".$_GET['id']."'";/**/
									
	$requeteConversRes = mysql_query($requeteConvers) or die ($requeteConvers);
	//$requeteConversRepioutRes = mysql_query($requeteConvers) or die ($requeteConvers);
?>


<h1>Conversation</h1>


<?php

	while($ligne = mysql_fetch_assoc($requeteConversRes))
	{
		echo $ligne['contenu'];
		echo '<br/>';
	
	
	
	
	}



?>
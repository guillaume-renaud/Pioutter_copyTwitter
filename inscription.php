<h1>Formulaire d'inscription</h1>
		<hr>
		<h2><center><?php echo $message; ?><center></h2>		<!-- Message d'erreur si problème dans les champs -->

		
<center>
<table CELLPADDING="7px">
	<form name ="inscrip" action="connexion.php" method="POST">
		<tr> 
			<td>
				Pseudo : 
			</td>
			<td>
				<input type ="text" name="pseudo" required/>
			</td>
		</tr>

		
		<tr> 
			<td>
				Login : 
			</td>
			<td>
				<input type ="text" name="login" required/>
			</td>
		</tr>
		
		
		<tr> 
			<td>
				Mot de passe : 
			</td>
			<td>
				<input type ="password" name ="mdp" required/>
			</td>
		</tr>


		<tr> 
			<td>
				Confirmez le mot de passe : 
			</td>
			<td>
				<input type="password" name="confMdp" required/>
			</td>
		</tr>


		<tr> 
			<td>
				Adresse mail : 
			</td>
			<td>
				<input type ="email" name="mail" required/>

			</td>
		</tr>


		<tr> 
			<td>
				Sexe : 
			</td>
			<td>
				<input type ="radio" name="sexe" value ="M" checked/>Homme
				<input type ="radio" name="sexe" value ="F"/>Femme
			</td>
		</tr>


		<tr> 
			<td colspan	="2">
				<center>
				<input type ="reset" value="Annuler" name ="raz"/>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="submit" value="Enregistrer" name="save"/> 
				</center>
			</td>

		</tr>

	</form>
</table>
</center>
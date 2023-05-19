<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<!-- liaison avec le fichier css pour le style -->
        <style><?php include '../css/film.css'; ?></style>
		<!-- titre de l'onglet -->
		<title>Cinéma Pathé Gaumont</title>
	</head>
	<body>
		<!-- Cela permet de créer une box pour tout ce qui en rapport avec la barre de navigation -->
    <div class=banner>
		<!-- Image en haut a droite du site -->
		<a href="index.php"><img class="logo" src="../Images/Pathe_logo.png"></a>
        <!-- Titre du site -->
		<h1 class="titre1">Cinéma Pathé Gaumont</h1><br>
        <img src="../Images/login.png" class="login" id="easter">
    </div>
	<div>
	<center><h3 class="note">Ceci est un faux site à but éducatif</h3></center>
	</div>
		<div class="navbar">
			<!-- Lien pour changer de page -->
			<a href="index.php" class="home">Accueil</a>
			<a href="film.php">Films</a>
			<a href="planning.php">Planning</a>
			<a href="reservation.php">Réservations</a>
			<a href="projection.php">Projection</a>

		</div>
		<div class="warp">
		<form method="post" action="film.php" class = form1>
		Titre : <input type='text' name='txttitre' /><br><br>
		Acteur : <input type="text" name="txtacteur"/><br><br>
		Réalisateur : <input type="text" name="txtrealisateur"/><br><br>
		Public :
		<select name="cbopublic">
		<?php
		//Connection avec la base de donnée
		$bdd = new PDO("mysql:host=localhost;dbname=id20735984_bdciedehkalfevre;charset=utf8", "id20735984_adrien", "KidrCc7x&CC5tzf75Db3");
		//Requête SQL
		$req = $bdd->prepare("select * from public");
		$req->execute();
		$leslignes = $req->fetchall();
		echo("<option value=''>---Veuillez séléctionner un public---</option>");
		//Boucle qui se repette tant qu'il reste des données à afficher
		foreach ($leslignes as $uneligne)
		{
			echo ("<option value='$uneligne[nopublic]'> $uneligne[libpublic] </option>");
		}
		$req->closeCursor();
		$bdd=null;
		?>
		</select>
		<br/><br/>
		Genre :
		<select name="cbogenre">
		<?php
		//Connection avec la base de donnée
		$bdd = new PDO("mysql:host=localhost;dbname=id20735984_bdciedehkalfevre;charset=utf8", "id20735984_adrien", "KidrCc7x&CC5tzf75Db3");
		//Requête SQL
		$req = $bdd->prepare("select * from genre");
		$req->execute();
		$leslignes = $req->fetchall();
		echo("<option value=''>---Veuillez séléctionner un genre---</option>");
		//Boucle qui se repette tant qu'il reste des données à afficher
		foreach ($leslignes as $uneligne)
		{
			echo ("<option value='$uneligne[nogenre]'> $uneligne[libgenre] </option>");
		}
		$req->closeCursor();
		$bdd=null;
		
		?>
		</div>
		</select><br><br>
		<input type="submit" name="btnvalider" class="accepte" value="Valider" />
		<input type="submit" name="btntout" class="accepte" style="margin-left: 20px;" value="Afficher tout les films" /></br>
		</form>
		<?php
		if (isset($_POST["btntout"]) == true)
		{
			//Connection avec la base de donnée
			$bdd = new PDO("mysql:host=localhost;dbname=id20735984_bdciedehkalfevre;charset=utf8", "id20735984_adrien", "KidrCc7x&CC5tzf75Db3");
			//htmlspecialchars est une sécurité pour contre injection SQL
			$_POST["txttitre"]=htmlspecialchars($_POST["txttitre"]);
			//Requête SQL
			$requete = ("select Distinct nofilm, film.*  from film natural join concerner natural join genre where titre like'%$_POST[txttitre]%'");
			$req = $bdd->prepare($requete);
			$req->execute();
			$leslignes = $req->fetchall();
			//Tableau pour afficher les données
			echo ("<table class ='tableau' border=1>");
			echo ("<tr>");
			//Catégories
			echo ("<th>Affiche</th>");
			echo ("<th>Titre</th>");
			echo ("<th>Auteur(s)</th>");
			echo ("<th>Réalisateur(s)</th>");
			echo ("<th>Synopsis</th>");
			echo ("<th>Durée(s)</th>");
			echo ("</tr>");
			echo("<tbody>");
			echo ("<tr>");
			//Boucle qui se repette tant qu'il reste des données à afficher
			foreach ($leslignes as $uneligne)
			{
				//Donnée dans le tableau
				echo ("<tbody>
				<tr>
				<td><img class='afficher' src='../Images/$uneligne[imgaffiche]'> </td>
				<td>$uneligne[titre] </td>
				<td>$uneligne[acteurs] </td>
				<td>$uneligne[realisateurs] </td>
				<td>$uneligne[synopsis] </td>
				<td>$uneligne[duree] </td>
				</tr>
				</tbody>");
			}

			echo ("</tr>");
			echo ("</tbody>");
			echo ("</table>");
			//fermeture de la base de donnée
			$req->closeCursor();
			$bdd=null;
		}
			if (isset($_POST["btnvalider"]) == true)
			{
				$bdd = new PDO("mysql:host=localhost;dbname=id20735984_bdciedehkalfevre;charset=utf8", "id20735984_adrien", "KidrCc7x&CC5tzf75Db3");


				if ($_POST["txttitre"]!="")
				{
					$_POST["txttitre"]=htmlspecialchars($_POST["txttitre"]);
					$requete = ("select Distinct nofilm, film.*  from film natural join concerner natural join genre");

					$_POST["txttitre"]=htmlspecialchars($_POST["txttitre"]);
					$requete=$requete . " where titre like '%$_POST[txttitre]%' ";
					if ($_POST["txtacteur"]!="")
					{
						$_POST["txtacteur"]=htmlspecialchars($_POST["txtacteur"]);
						$requete=$requete . " and acteurs like '%$_POST[txtacteur]%' ";
					}
					else if ($_POST["txtrealisateur"]!="")
					{
						$_POST["txtrealisateur"]=htmlspecialchars($_POST["txtrealisateur"]);
						$requete=$requete . " and realisateurs like'%$_POST[txtrealisateur]%' ";
					}
					else if ($_POST["cbopublic"]!="")
					{
						$_POST["cbopublic"]=htmlspecialchars($_POST["cbopublic"]);
						$requete=$requete . " and nopublic = '$_POST[cbopublic]' ";
					}
					else if ($_POST["cbogenre"]!="")
					{
						$_POST["cbogenre"]=htmlspecialchars($_POST["cbogenre"]);
						$requete=$requete . " and nogenre = '$_POST[cbogenre]' ";
					}
					else if (isset($_POST["btntout"])==true)
					{
					$_POST["txttitre"]=htmlspecialchars($_POST["txttitre"]);
					$requete=$requete . " where titre is null ";
					}
					$req = $bdd->prepare($requete);
					$req->execute();
					$leslignes = $req->fetchall();

				}
				else if ($_POST["txttitre"] == "")
				{
					$requete=("select Distinct nofilm, film.*  from film natural join concerner natural join genre where");

					if ($_POST["txtacteur"]!="")
					{
						if ($_POST["txtrealisateur"]!="")
						{
							$_POST["txtacteur"]=htmlspecialchars($_POST["txtacteur"]);
							$requete=$requete . " acteurs like '%$_POST[txtacteur]%' and realisateurs like'%$_POST[txtrealisateur]%'";
						}
						else
						{
							$_POST["txtacteur"]=htmlspecialchars($_POST["txtacteur"]);
							$requete=$requete . " acteurs like '%$_POST[txtacteur]%' ";
						}
					}
					else if ($_POST["txtrealisateur"]!="")
					{
						if ($_POST["cbopublic"]!="")
						{
							$_POST["txtrealisateur"]=htmlspecialchars($_POST["txtrealisateur"]);
							$requete=$requete . " realisateurs like'%$_POST[txtrealisateur]%' and nopublic = '$_POST[cbopublic]'";
						}
						else
						{
							$_POST["txtrealisateur"]=htmlspecialchars($_POST["txtrealisateur"]);
							$requete=$requete . " realisateurs like'%$_POST[txtrealisateur]%' ";
						}

					}
					else if ($_POST["cbopublic"]!="")
					{
						if ($_POST["cbogenre"]!="")
						{
							$_POST["cbopublic"]=htmlspecialchars($_POST["cbopublic"]);
							$requete=$requete . " nopublic = '$_POST[cbopublic]' and nogenre = '$_POST[cbogenre]'";
						}
						else
						{
							$_POST["cbopublic"]=htmlspecialchars($_POST["cbopublic"]);
							$requete=$requete . " nopublic = '$_POST[cbopublic]' ";
						}
					}
					else if ($_POST["cbogenre"]!="")
					{
						$_POST["cbogenre"]=htmlspecialchars($_POST["cbogenre"]);
						$requete=$requete . " nogenre = '$_POST[cbogenre]'";
					}
					else
					{
					$_POST["txttitre"]=htmlspecialchars($_POST["txttitre"]);
					$requete=$requete . " titre is null ";
					}
					if (isset($_POST["btntout"])==true)
					{
					$_POST["txttitre"]=htmlspecialchars($_POST["txttitre"]);
					$requete=$requete . " titre is null ";
					}
					$req = $bdd->prepare($requete);
					$req->execute();
					$leslignes = $req->fetchall();

				}
				if ($leslignes==false)
				{
					echo ("<br><h3><label style='margin-left: 20px;' >Le film demandé n'est pas disponible</label></h3>");
				}
				else
				{
				echo ("<table class ='tableau' border=1>");
				echo ("<tr>");
				echo ("<th>Affiche</th>");
				echo ("<th>Titre</th>");
				echo ("<th>Auteur(s)</th>");
				echo ("<th>Réalisateur(s)</th>");
				echo ("<th>Synopsis</th>");
				echo ("<th>Durée(s)</th>");
				echo ("</tr>");
				echo("<tbody>");
				echo ("<tr>");
					//Boucle qui se repette tant qu'il reste des données à afficher
					foreach ($leslignes as $uneligne)
					{

						echo ("<tbody>
						<tr>
						<td><img class='afficher' src='../Images/$uneligne[imgaffiche]'> </td>
						<td>$uneligne[titre] </td>
						<td>$uneligne[acteurs] </td>
						<td>$uneligne[realisateurs] </td>
						<td>$uneligne[synopsis] </td>
						<td>$uneligne[duree] </td>
						</tr>
						</tbody>");
					}
				echo ("</tr>");
				echo ("</tbody>");
				echo ("</table>");
				}
			//fermeture de la base de donnée
			$req->closeCursor();
			$bdd=null;
			}
		?>
		</div>
		<!-- un footer pour les contact -->
		<div class="last-social">
            <div class="texte-reseau">
            <p>Suivez nous sur les réseaux | </p>
        </div>
        
		<div class="reseaux-logo">
            <a href="https://fr-fr.facebook.com/" target="_blank"><ion-icon name="logo-facebook"></ion-icon></a>
            <a href="https://www.instagram.com/"><ion-icon name="logo-instagram"></ion-icon></a>
            <a href="https://twitter.com/"><ion-icon name="logo-twitter"></ion-icon></a>
            <a href="https://www.youtube.com/"><ion-icon name="logo-youtube"></ion-icon></a>
        </div>
			</div>
		<!-- Script pour affichage d'icone -->
        <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
	</body>
</html>
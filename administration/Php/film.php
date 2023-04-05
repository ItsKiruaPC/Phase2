<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
        <style><?php include '../css/film.css'; ?></style>
		<title>Cinéma Pathé Gaumont</title>
	</head>
	<body>
    <div class=banner>
        <img class="logo" src="../Images/Pathe_logo.png">
        <h1 class="titre1">Cinéma Pathé Gaumont</h1><br>
		<a href="projection.php"><img src="../Images/login.png" class="login"></a>
    </div>
		<div class="navbar">
			<a href="index.php" class="home">Accueil</a>
			<a href="film.php">Films</a>
			<a href="planning.php">Planning</a>
			<a href="reservation.php">Réservations</a>
			<a href="projection.php">Projection</a>
				<!-- <div class="dropdown">
					<button class="dropbtn">Plus</button>
				<div class="dropdown-content">
					<a href="#">Lien 1</a>
					<a href="#">Lien 2</a>
					<a href="#">Lien 3</a>
				</div>
				</div> -->
		</div>
		<div class="warp">
		<form method="post" action="film.php" class = form1>
		Titre : <input type="text" name="txttitre" /></br></br>
		Acteur : <input type="text" name="txtacteur"/></br></br>
		Réalisateur : <input type="text" name="txtrealisateur"/></br></br>
		Public :
		<select name="cbopublic">
		<?php
		$bdd = new PDO("mysql:host=localhost;dbname=bdciedehkalfevre;charset=utf8", "root", "");
		$req = $bdd->prepare("select * from public");
		$req->execute();
		$leslignes = $req->fetchall();
		echo("<option value=''>---Veuillez séléctionner un public---</option>");
		foreach ($leslignes as $uneligne)
		{
			echo ("<option value='$uneligne[nopublic]'> $uneligne[libpublic] </option>");
		}
		$req->closeCursor();
		$bdd=null;
		?>
		</select>
		</br></br>
		Genre :
		<select name="cbogenre">
		<?php
		$bdd = new PDO("mysql:host=localhost;dbname=bdciedehkalfevre;charset=utf8", "root", "");
		$req = $bdd->prepare("select * from genre");
		$req->execute();
		$leslignes = $req->fetchall();
		echo("<option value=''>---Veuillez séléctionner un genre---</option>");
		foreach ($leslignes as $uneligne)
		{
			echo ("<option value='$uneligne[nogenre]'> $uneligne[libgenre] </option>");
		}
		$req->closeCursor();
		$bdd=null;
		
		?>
		</div>
		</select>
		<input type="submit" name="btnvalider" value="Valider" /></br>
		</form>
		<?php
			if (isset($_POST["btnvalider"]) == true)
			{
				$bdd = new PDO("mysql:host=localhost;dbname=bdciedehkalfevre;charset=utf8", "root", "");
				$requete = "select Distinct nofilm, film.*  from film natural join concerner natural join genre where titre like '$_POST[txttitre]%'";
				if ($_POST["txtacteur"]!="")
				{
					$requete=$requete . " and acteurs like'%$_POST[txtacteur]%' ";
				}
				if ($_POST["txtrealisateur"]!="")
				{
					$requete=$requete . " and realisateurs like'%$_POST[txtrealisateur]%' ";
				}
				if ($_POST["cbopublic"]!="")
				{
					$requete=$requete . " and nopublic = '$_POST[cbopublic]' ";
				}
				if ($_POST["cbogenre"]!="")
				{
					$requete=$requete . " and nogenre = '$_POST[cbogenre]' ";
				}
        		$req = $bdd->prepare($requete);
				$req->execute();
				$leslignes = $req->fetchall();
				echo ("<table class ='tableau' border=1>");
				echo ("<tr>");
					echo ("<th>Titre</th>");
					echo ("<th>Auteur(s)</th>");
					echo ("<th>Réalisateur(s)</th>");
					echo ("<th>Synopsis</th>");
					echo ("<th>Durée(s)</th>");
					echo ("</tr>");
					echo("<tbody>");
					echo ("<tr>");
				foreach ($leslignes as $uneligne)
				{

					echo ("<tbody>
					<tr>
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
				$req->closeCursor();
				$bdd=null;
			}
		?>
		</div>
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
        <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
	</body>
</html>
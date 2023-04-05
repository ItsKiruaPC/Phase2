<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
        <style><?php include '../css/planning.css'; ?></style>
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
		<form class = form1 method="post" action="planning.php">
		<center>Veuillez renseigner une date de planning : <input type="date" name="txtdate" />
		<input type="submit" name="btnvalider" value="Valider" /></br></center>
		</form>

		<?php
			if (isset($_POST["btnvalider"]) == true && $_POST["txtdate"] != "")
			{
				$bdd = new PDO("mysql:host=localhost;dbname=bdciedehkalfevre;charset=utf8", "root", "");
				$requete = "select * from projection natural join film where dateproj='$_POST[txtdate]'";
        		$req = $bdd->prepare($requete);
				$req->execute();
				$leslignes = $req->fetchall();
				echo ("<center><table class ='tableau' border=1>");
				echo ("<tr>");
					echo ("<th>Titre</th>");
					echo ("<th>Salle</th>");
					echo ("<th>Horaire</th>");
					echo ("</tr>");
					echo("<tbody>");
					echo ("<tr>");
				foreach ($leslignes as $uneligne)
				{

					echo ("<tbody>
					<tr>
					<td>$uneligne[titre] </td>
					<td>$uneligne[nosalle] </td>
					<td>$uneligne[dateproj] </td>
					</tr>
					</tbody>");
				}
				echo ("</tr>");
				echo ("</tbody>");
				echo ("</table></center>");
				$req->closeCursor();
				$bdd=null;
			}
		?>
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
<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
        <style><?php include '../css/style.css'; ?></style>
		<title>Cinéma Pathé Gaumont</title>
	</head>
	<body>
    <div class=banner>
        <a href="index.php"><img class="logo" src="../Images/Pathe_logo.png"></a>
        <h1 class="titre1">Cinéma Pathé Gaumont</h1><br>
        <a href="projection.php"><img src="../Images/login.png" class="login"></a>
    </div>
		<div class="navbar">
			<a href="index.php" class="home">Accueil</a>
			<a href="film.php">Films</a>
			<a href="planning.php">Planning</a>
			<a href="reservation.php">Réservations</a>
			<a href="projection.php">Projection</a>
		</div>
		<div class="boite">
		<?php
				$bdd = new PDO("mysql:host=localhost;dbname=bdciedehkalfevre;charset=utf8", "root", "");
				$requete = "select Distinct nofilm, film.*  from film natural join concerner natural join genre";
        		$req = $bdd->prepare($requete);
				$req->execute();
				$leslignes = $req->fetchall();
				foreach ($leslignes as $uneligne)
				{
					?>

					<div class="box1">
					<div class="minibox1">

					<?php

					echo ("<a href='$uneligne[infofilm]' target='_blank'><img class='afficher' src='../Images/$uneligne[imgaffiche]' ></a>");
					echo ("<h1>$uneligne[titre]</h1></a><br>");
					echo ("<p><h2>Réalisateurs:</h2> $uneligne[realisateurs]</p><br/>");
					echo ("<p><h2>Acteurs:</h2> $uneligne[acteurs]</p><br/>");
					echo ("<p><h2>Durée:</h2> $uneligne[duree]</p><br/>");
					echo ("<p>$uneligne[synopsis]</p>");
					
					?>
					</div>
					</div>

					<?php
				}
				$req->closeCursor();
				$bdd=null;
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
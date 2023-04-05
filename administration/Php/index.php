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
				<!-- <div class="dropdown">
					<button class="dropbtn">Plus</button>
				<div class="dropdown-content">
					<a href="#">Lien 1</a>
					<a href="#">Lien 2</a>
					<a href="#">Lien 3</a>
				</div>
				</div> -->
		</div>
		<div class="blur"></div>
		<div class="boite">
		<?php
				$bdd = new PDO("mysql:host=localhost;dbname=bdciedehkalfevre;charset=utf8", "root", "");
				$requete = "select Distinct nofilm, film.*  from film natural join concerner natural join genre";
        		$req = $bdd->prepare($requete);
				$req->execute();
				$leslignes = $req->fetchall();
				$i=1;
				foreach ($leslignes as $uneligne)
				{
					?>
					<div class="box1">
					<div class="minibox1">

					<?php
					echo("<a href='https://cas.eclat-bfc.fr/login'><img class='afficher' src='../Images/$uneligne[imgaffiche]' ></a>");
					echo ("<h1>$uneligne[titre]</h1></a><br>");
					echo ("<p>Acteurs: $uneligne[acteurs]</p>");
					echo ("<p>Réalisateurs: $uneligne[realisateurs]</p>");
					echo ("<p>Durée: $uneligne[duree]</p>");
					echo ("<p>$uneligne[synopsis]</p>");
					?>
					</div>
					</div>
					<?php
					$i=$i+1;
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
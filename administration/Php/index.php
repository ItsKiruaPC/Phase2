<!doctype html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<!-- liaison avec le fichier css pour le style -->
        <link rel="stylesheet" href="../css/style.css">
        <?php include('connexion.php');?>
		<link rel="icon" href="../Images/Pathe_logo.png">
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<!-- titre de l'onglet -->
		<title>Cinéma Pathé Gaumont</title>
	</head>
	<body>
		<!-- Cela permet de créer une box pour tout ce qui en rapport avec la barre de navigation -->
    <div class=banner>
		<!-- Image en haut a droite du site -->
        <a href=""><img class="logo" src="../Images/Pathe_logo.png"></a>
		<!-- Titre du site -->
        <h1 class="titre1" id="easter">Cinéma Pathé Gaumont</h1><br>
        <a href="projection.php"><img src="../Images/login.png" class="login"></a><!--<a href="connection.php">!-->
    </div>
	<div>
	<center><h3 class="note">Ceci est un faux site à but éducatif</h3></center>
	</div>
		<div class="navbar">
			<!-- Lien pour changer de page -->
			<a href="" class="home">Accueil</a>
			<a href="film.php">Films</a>
			<a href="planning.php">Planning</a>
			<a href="reservation.php">Réservations</a>
		</div>
		<div class="boite">
		<?php
				//Connection avec la base de donnée
				
				//Requête SQL
				$requete = "select Distinct nofilm, film.*  from film natural join concerner natural join genre";
        		$req = $bdd->prepare($requete);
				$req->execute();
				$leslignes = $req->fetchall();
				//Boucle qui se repette tant qu'il reste des données à afficher
				foreach ($leslignes as $uneligne)
				{
					?>
					<!-- Afficher les films dans des "boite" -->
					<div class="box1">
					<?php
					?><div class="afficher"><?php
					echo ("<a href='$uneligne[infofilm]' target='_blank'><img src='../Images/$uneligne[imgaffiche]' ></a>");
					?></div><div class="minibox1"><?php
					echo ("<h1>$uneligne[titre]</h1><br>");
					//Affiche réalisateurs
					echo ("<h2>Réalisateurs:</h2><p> $uneligne[realisateurs]</p><br/>");
					//Affiche acteurs
					echo ("<h2>Acteurs:</h2><p> $uneligne[acteurs]</p><br/>");
					//Affiche durée
					echo ("<h2>Durée:</h2><p> $uneligne[duree]</p><br/>");
					//Affiche synopsis
					echo ("<h2>Synopsis: </h2><p> $uneligne[synopsis]</p>");
					?></div><?php
					?>
					</div>
					<?php
				}
				$req->closeCursor();
				include('deconnexion.php');
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
		<script src="../Js/app.js"></script>
	</body>
</html>
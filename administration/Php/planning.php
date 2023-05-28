<!doctype html>
<html lang="fr">
	<!-- Partie pas réellement visible (head) -->
	<head>
		<meta charset="utf-8">
		<!-- liaison avec le fichier css pour le style -->
        <link rel="stylesheet" href="../css/planning.css">
        <?php include('connexion.php');?>
		<link rel="icon" href="../Images/Pathe_logo.png">
		<!-- titre de l'onglet -->
		<title>Cinéma Pathé Gaumont</title>
	</head>
	<!-- Le corps du site -->
	<body>
		<!-- Cela permet de créer une box pour tout ce qui en rapport avec la barre de navigation -->
    <div class=banner>
		<!-- Image en haut a droite du site -->
		<a href="index.php"><img class="logo" src="../Images/Pathe_logo.png"></a>
        <!-- Titre du site -->
		<h1 class="titre1" id="easter">Cinéma Pathé Gaumont</h1><br>
        <a href="projection.php"><img src="../Images/login.png" class="login"></a><!--<a href="connection.php">!-->
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
		</div>
		<!-- Création d'un form pour les projection ayant des réservation -->
		<form class= form1 method="post" action="planning.php">
		<!-- Balise pouir centrer le texte-->
		<center>Veuillez renseigner une date de planning : <input type="date" name="txtdate" />
		<input type="submit" name="btnvalider" value="Valider" /><br></center>
		</form>

		<?php
			if (isset($_POST["btnvalider"]) == true && $_POST["txtdate"] != "")
			{
				//Connection avec la base de donnée
				
				//htmlspecialchars est une sécurité pour contre injection SQL
				$_POST["txtdate"]=htmlspecialchars($_POST["txtdate"]);
				//Requête SQL
				$requete = "select * from projection natural join film where dateproj='$_POST[txtdate]' order by dateproj, heureproj";
        		$req = $bdd->prepare($requete);
				$req->execute();
				$leslignes = $req->fetchall();
				//Tableau avec les catégories
				echo ("<center><table class ='tableau' border=1>");
				echo ("<tr>");
				echo ("<th>Affiche</th>");
				echo ("<th>Titre</th>");
				echo ("<th>Salle</th>");
				echo ("<th>Date</th>");
				echo ("<th>Horaire</th>");
				echo ("</tr>");
				echo("<tbody>");
				echo ("<tr>");
				//Boucle qui se repette tant qu'il reste des données à afficher
				foreach ($leslignes as $uneligne)
				{
					//Données dans le tableau
					echo ("<tbody>
					<tr>
					<td><img class='afficher' src='../Images/$uneligne[imgaffiche]'></td>
					<td>$uneligne[titre] </td>
					<td>$uneligne[nosalle] </td>
					<td>$uneligne[dateproj] </td>
					<td>$uneligne[heureproj] </td>
					</tr>
					</tbody>");
				}
				echo ("</tr>");
				echo ("</tbody>");
				echo ("</table></center>");
				//fermeture de la base de donnée
				$req->closeCursor();
				include('deconnexion.php');
			}
		?>
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
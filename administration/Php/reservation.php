<!doctype html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
        <!-- liaison avec le fichier css pour le style -->
        <style><?php include '../css/reservation.css'; ?></style>
        <link rel="icon" href="../Images/Pathe_logo.png">
		<!-- titre de l'onglet -->
        <title>Cinéma Pathé Gaumont</title>
	</head>
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
        <div class="warp">
        <!-- Création du form -->
        <form method="post" action="reservation.php" class="forme">
        <select name="cbofilm" style="background-color:#262A2B; color:white">
		<?php
        //Connection avec la base de donnée
		$bdd = new PDO("mysql:host=localhost;dbname=bdciedehkalfevre;charset=utf8", "root", "");
		
        //Requête SQL
        $req = $bdd->prepare("select distinct titre, projection.nofilm from film natural join projection");
		$req->execute();
		$leslignes = $req->fetchall();
		echo("<option value='' disabled>---Veuillez séléctionner un film---</option>");
		//Boucle qui se repette tant qu'il reste des données à afficher
        foreach ($leslignes as $uneligne)
		{
            if (isset($_POST["cbofilm"])==true && $_POST["cbofilm"]==$uneligne["nofilm"])
            {
                echo("<option value='$uneligne[nofilm]' selected>$uneligne[titre]</option>");
            }
            else
            {
                echo("<option value='$uneligne[nofilm]'>$uneligne[titre]</option>");
            }
        }
        //fermeture de la base de donnée
		$req->closeCursor();
		$bdd=null;
		?>
        <input type='submit' name='btncherche' value='Chercher' style="background-color:#7B7B7B; color:white"/></br>
		</select>
        </br></br>

        <?php
        if (isset($_POST["btncherche"])==true)
        {
            //Connection avec la base de donnée
            $bdd = new PDO("mysql:host=localhost;dbname=bdciedehkalfevre;charset=utf8", "root", "");
            $_POST["cbofilm"]=htmlspecialchars($_POST["cbofilm"]);
            //Requête SQL
            $req = $bdd->prepare("select(select nbplaces from salle natural join projection where noproj='$_POST[cbofilm]') - COALESCE((select SUM(nbplaceresa) from reservation where noproj='$_POST[cbofilm]'),0) as 'Nombres de places'");
            $reponse = $req->execute();
            $leslignes = $req->fetchColumn();

            
            if ($leslignes == 0)
            {
                echo ("Quel dommage le film a été victime de son succée ¯\_(ツ)_/¯");
            }
            else
            {
                echo("<form method='post' action='reservation.php' class = form1>
                Nom : <input type='text' name='txtnom' style='background-color:#7B7B7B; color:white'/></br></br>
                Nombre de places : <input type='number' name='txtplace' value='1' min='1' max='$leslignes' style='background-color:#7B7B7B; color:white'/></br></br>");
                echo ("Place restantes : $leslignes");
            }
            //fermeture de la base de donnée
            $req->closeCursor();
            $bdd=null;
        }
        ?>
        </br></br>

        <?php
        if (isset($_POST["btncherche"])==true)
        {
            if ($leslignes == 0){}
            else
            {
            echo ("Veuillez séléctionner la date qui vous convient : ");
            echo ("<select name='cboseance' style='background-color:#7B7B7B; color:white'>");

            //Connection avec la base de donnée
            $bdd = new PDO("mysql:host=localhost;dbname=bdciedehkalfevre;charset=utf8", "root", "");
            $_POST["cbofilm"]=htmlspecialchars($_POST["cbofilm"]);
            //Requête SQL
            $req = $bdd->prepare("select * from projection where nofilm='$_POST[cbofilm]'");
            $req->execute();
            $leslignes = $req->fetchall();

            echo("<option value=''>---Veuillez séléctionner une séance---</option>");
            //Boucle qui se repette tant qu'il reste des données à afficher
            foreach ($leslignes as $uneligne)
            {
                echo ("<option value='$uneligne[dateproj]'>$uneligne[dateproj]</option>");
            }
            //fermeture de la base de donnée
            $req->closeCursor();
            $bdd=null;

            echo ("</select>
                    <input type='submit' name='btnvalider' value='Valider'/></br>");
        }
    }
            //Programme pour créer un mot de passe a 6 caractère random
            $comb = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
            $shfl = str_shuffle($comb);
            $pwd = substr($shfl,0,6);
        ?></div><?php
        if (isset($_POST["btnvalider"]) == true)
        {
            $bdd = new PDO("mysql:host=localhost;dbname=bdciedehkalfevre;charset=utf8", "root", "");
            $_POST["cbofilm"]=htmlspecialchars($_POST["cbofilm"]);
            //Requête SQL
            $req = $bdd->prepare("select(select nbplaces from salle natural join projection where noproj='$_POST[cbofilm]') - COALESCE((select SUM(nbplaceresa) from reservation where noproj='$_POST[cbofilm]'),0) as 'Nombres de places'");
            $reponse = $req->execute();
            $leslignes = $req->fetchColumn();
            if($_POST["txtplace"]>$leslignes)
            {
                echo("<h3>Bien essayé mais ca marche pas</h3>");
            }
            else
            {
                //Connection avec la base de donnée
            $bdd = new PDO("mysql:host=localhost;dbname=bdciedehkalfevre;charset=utf8", "root", "");
            $dateann = date("Y-m-d");
            //Requête SQL
            $req = $bdd->prepare("insert into reservation (mdpresa, nomclient, dateresa, nbplaceresa, noproj) values (:pwd, :nom, :seance, :place, :film)");
            $_POST["txtnom"]=htmlspecialchars($_POST["txtnom"]);
            $_POST["cboseance"]=htmlspecialchars($_POST["cboseance"]);
            $_POST["txtplace"]=htmlspecialchars($_POST["txtplace"]);
            $_POST["cbofilm"]=htmlspecialchars($_POST["cbofilm"]);
            $req->bindParam(':pwd',$pwd, PDO::PARAM_STR);
            $req->bindParam(':nom',$_POST["txtnom"], PDO::PARAM_STR);
            $req->bindParam(':seance',$_POST["cboseance"], PDO::PARAM_STR);
            $req->bindParam(':place',$_POST["txtplace"], PDO::PARAM_INT);
            $req->bindParam(':film',$_POST["cbofilm"], PDO::PARAM_INT);
            $reponse = $req->execute();

            if ($reponse == true)
            {
                echo ("<h1 style='text-align:center;'>Réservation effectuer avec succès</h1></br></br>");
            }
            else
            {
                echo("Echec, la réservation n'a pas été éffectuer</br>");
            }

            //Connection avec la base de donnée
            $bdd = new PDO("mysql:host=localhost;dbname=bdciedehkalfevre;charset=utf8", "root", "");
            //Requête SQL
            $req = $bdd->prepare("select mdpresa, MAX(noresa) as reservation from reservation");
            $req->execute();
            $uneligne = $req->fetch();

            echo ("<table class='tableau' border=1 style='margin:0 auto;'>");
            echo ("<thead>");
            echo ("<tr>");
            echo ("<th>Numéro de Réservation</th>");
            echo ("<th>Mot de passe</th>");
            echo ("</tr>");
            echo ("</thead>");
            echo ("<tbody>");
            echo ("
            <tr>
            <td>$uneligne[reservation] </td>
            <td>$uneligne[mdpresa] </td>
            </tr>");
            echo ("</tbody>");
            echo ("</table></br></br>");

            $_POST["cbofilm"]=htmlspecialchars($_POST["cbofilm"]);
            //Requête SQL
            $req = $bdd->prepare("select titre from film natural join reservation where noproj='$_POST[cbofilm]'");
            $req->execute();
            $uneligne = $req->fetch();
            //Partie pour le QRcode
            include('../phpqrcode/qrlib.php');
            $text="Film : $uneligne[titre]
            \nNom : $_POST[txtnom]
            \nMot de Passe : $pwd";
            $folder="../Images/";
            $file_name="qr.png";
            $file_name=$folder.$file_name;
            QRcode::png($text,$file_name);
            echo"<center><img src='../Images/qr.png'></center>";
            //fermeture de la base de donnée
            $req->closeCursor();
            $bdd=null;
            }
        }
        ?>
        </form>
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
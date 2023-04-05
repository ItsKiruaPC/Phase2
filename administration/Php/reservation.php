<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
        <style><?php include '../css/reservation.css'; ?></style>
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
        <form method="post" action="reservation.php" class="forme">

        <select name="cbofilm" style="background-color:#262A2B; color:white">
		<?php
		$bdd = new PDO("mysql:host=localhost;dbname=bdciedehkalfevre;charset=utf8", "root", "");
		$req = $bdd->prepare("select * from projection natural join film");
		$req->execute();
		$leslignes = $req->fetchall();
        echo ("<form>");
		echo("<option value='' disabled>---Veuillez séléctionner un film---</option>");
		foreach ($leslignes as $uneligne)
		{
            if (isset($_POST["cbofilm"])==true && $_POST["cbofilm"]==$uneligne["noproj"])
                echo("<option value='$uneligne[noproj]' selected>$uneligne[titre]</option>");
            else
                echo("<option value='$uneligne[noproj]'>$uneligne[titre]</option>");
        }
		$req->closeCursor();
		$bdd=null;
		?>
        <input type='submit' name='btncherche' value='Chercher' style="background-color:#7B7B7B; color:white"/></br>
		</select>
        </br></br>

        <?php
        if (isset($_POST["btncherche"])==true)
        {
            echo("<form method='post' action='reservation.php' class = form1>
            Nom : <input type='text' name='txtnom' style='background-color:#7B7B7B; color:white'/></br></br>
            Nombre de places : <input type='number' name='txtplace' value='1' min='1' style='background-color:#7B7B7B; color:white'/></br></br>");
            echo ("Place restantes : ");

            $bdd = new PDO("mysql:host=localhost;dbname=bdciedehkalfevre;charset=utf8", "root", "");
            $req = $bdd->prepare("select(select nbplaces from salle natural join projection where noproj='$_POST[cbofilm]') - COALESCE((select SUM(nbplaceresa) from reservation where noproj='$_POST[cbofilm]'),0) as 'Nombres de places'");
            $reponse = $req->execute();
            $leslignes = $req->fetchColumn();
            echo $leslignes;
            $req->closeCursor();
            $bdd=null;
        }
        ?>
        </br></br>

        <?php
        if (isset($_POST["btncherche"])==true)
        {
            echo ("Veuillez séléctionner la date qui vous convient : ");
            echo ("<select name='cboseance' style='background-color:#7B7B7B; color:white'>");


            $bdd = new PDO("mysql:host=localhost;dbname=bdciedehkalfevre;charset=utf8", "root", "");
            $req = $bdd->prepare("select * from projection where noproj='$_POST[cbofilm]'");
            $req->execute();
            $leslignes = $req->fetchall();

            echo("<option value=''>---Veuillez séléctionner une séance---</option>");

            foreach ($leslignes as $uneligne)
            {
                echo ("<option value='$uneligne[dateproj]'>$uneligne[dateproj]</option>");
            }
            $req->closeCursor();
            $bdd=null;

            echo ("</select>
                    <input type='submit' name='btnvalider' value='Valider'/></br>
                   </form>");
        }

                $comb = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
                $shfl = str_shuffle($comb);
                $pwd = substr($shfl,0,6);
        ?></div><?php
		if (isset($_POST["btnvalider"]) == true)
			{
				$bdd = new PDO("mysql:host=localhost;dbname=bdciedehkalfevre;charset=utf8", "root", "");
				$dateann = date("Y-m-d");
                $req = $bdd->prepare("insert into reservation (mdpresa, nomclient, dateresa, nbplaceresa, noproj) values (:pwd, :nom, :seance, :place, :film)");
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
                    echo("Echec, la réservation n'a pas été éffectuer</br>");

				$req->closeCursor();
				$bdd=null;
                
			}

        if (isset($_POST["btnvalider"]) == true)
        {
            $bdd = new PDO("mysql:host=localhost;dbname=bdciedehkalfevre;charset=utf8", "root", "");
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

            $req = $bdd->prepare("select titre from film natural join reservation where noproj='$_POST[cbofilm]'");
            $req->execute();
            $uneligne = $req->fetch();
            include('../phpqrcode/qrlib.php');
            $text="Film : $uneligne[titre]
Nom : $_POST[txtnom]
Mot de Passe : $pwd";
            $folder="../Images/";
            $file_name="qr.png";
            $file_name=$folder.$file_name;
            QRcode::png($text,$file_name);
            echo"<center><img src='../Images/qr.png'></center>";
            $req->closeCursor();
            $bdd=null;
        }
        ?>
        </form>
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
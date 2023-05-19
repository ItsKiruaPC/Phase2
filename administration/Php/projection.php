<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <!-- liaison avec le fichier css pour le style -->
        <style><?php include '../css/projection.css'; ?></style>
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
        <div class="navbar">
            <!-- Lien pour changer de page -->
            <a href="index.php" class="home">Accueil</a>
            <a href="film.php">Films</a>
            <a href="planning.php">Planning</a>
            <a href="reservation.php">Réservations</a>
            <a href="projection.php">Projection</a>
        </div>
        <div class="boite1">
            <div class="box1">
            <!-- Création du form -->
            <form method="post" action="projection.php" class="form1">
            <!-- Centrer le texte -->
            <center>Films</center></br>
            <center><select name="cbofilm" style="background-color:#262A2B; color:white" required></center>
                    <?php
                    //Connection avec la base de donnée
                    $bdd = new PDO("mysql:host=localhost;dbname=id20735984_bdciedehkalfevre;charset=utf8", "id20735984_adrien", "KidrCc7x&CC5tzf75Db3");
                    //Requête SQL
                    $req = $bdd->prepare("select distinct titre, film.* from film natural join concerner");
                    $req->execute();
                    $leslignes = $req->fetchall();
                    echo("<option value=''>-------Veuillez séléctionner un film-------</option>");
                    foreach ($leslignes as $uneligne)
                    {
                        if (isset($_POST["cbofilm"])==true && $_POST["cbofilm"]==$uneligne["nofilm"])
                            echo("<option value='$uneligne[nofilm]'  selected>$uneligne[titre]</option>");
                        else
                            echo("<option value='$uneligne[nofilm]'>$uneligne[titre]</option>");
                    }
                    //fermeture de la base de donnée
                    $req->closeCursor();
                    $bdd=null;
                    ?>
                </select>
                </br></br>
                Salles :
                <select name="cbosalle" style="background-color:#262A2B; color:white" required>
                    <?php
                    //Connection avec la base de donnée
                    $bdd = new PDO("mysql:host=localhost;dbname=id20735984_bdciedehkalfevre;charset=utf8", "id20735984_adrien", "KidrCc7x&CC5tzf75Db3");
                    //Requête SQL
                    $req = $bdd->prepare("select * from salle");
                    $req->execute();
                    $leslignes = $req->fetchall();
                    foreach ($leslignes as $uneligne)
                    {
                        //Permet de garder le bouton appuiyer même après refresh
                        if (isset($_POST["cbosalle"])==true && $_POST["cbosalle"]==$uneligne["nosalle"])
                            echo("<option value='$uneligne[nosalle]' selected>$uneligne[nosalle]</option>");
                        else
                            echo("<option value='$uneligne[nosalle]'>$uneligne[nosalle]</option>");
                    }
                    //fermeture de la base de donnée
                    $req->closeCursor();
                    $bdd=null;
                    ?>
                </select>
                </br></br>
                Date : <input type="date" name="txtdate" required/></br></br>
                Heure : <input type="time" name="txtheure" /></br></br>
                Synopsis : </br><textarea name="txtinfo" rows="5" cols="31"></textarea></br></br>
                <input class="ajoutbtn" type="submit" name="btnvalider" value="Ajouter"/>
                <input class="supbtn" type="submit" name="btnsupprimer" value="Supprimer"/>
                </form>
                <?php
                    if (isset($_POST["btnvalider"]) == true)
                    {
                        //Connection avec la base de donnée
                        $bdd = new PDO("mysql:host=localhost;dbname=id20735984_bdciedehkalfevre;charset=utf8", "id20735984_adrien", "KidrCc7x&CC5tzf75Db3");
                        //Requête SQL
                        $req = $bdd->prepare("insert into projection (nofilm, nosalle, dateproj, heureproj, infoproj) values (:film, :salle, :date, :heure, :synop)");
                        //htmlspecialchars est une sécurité pour contre injection php html css et js
                        $_POST["cbofilm"]=htmlspecialchars($_POST["cbofilm"]);
                        $_POST["cbosalle"]=htmlspecialchars($_POST["cbosalle"]);
                        $_POST["txtdate"]=htmlspecialchars($_POST["txtdate"]);
                        $_POST["txtheure"]=htmlspecialchars($_POST["txtheure"]);
                        $_POST["txtinfo"]=htmlspecialchars($_POST["txtinfo"]);
                        //bindParam est aussi une sécurité contre les injection SQL
                        $req->bindParam(':film',$_POST["cbofilm"], PDO::PARAM_INT);
                        $req->bindParam(':salle',$_POST["cbosalle"], PDO::PARAM_STR);
                        $req->bindParam(':date',$_POST["txtdate"], PDO::PARAM_STR);
                        $req->bindParam(':heure',$_POST["txtheure"], PDO::PARAM_STR);
                        $req->bindParam(':synop',$_POST["txtinfo"], PDO::PARAM_STR);
                        $reponse = $req->execute();

                        if ($reponse == true)
                        {
                            echo ("</br></br><h1 style='text-align:center;'>Projection ajouter avec succès</h1></br></br>");
                        }
                        else
                        {
                            echo("</br></br>Echec, la projection n'a pas été ajouter</br>");
                        }
                        //fermeture de la base de donnée
                        $req->closeCursor();
                        $bdd=null;
                    }
                    
                    
                    if (isset($_POST["btnsupprimer"]) == true)
                    {
                        //Connection avec la base de donnée
                        $bdd = new PDO("mysql:host=localhost;dbname=id20735984_bdciedehkalfevre;charset=utf8", "id20735984_adrien", "KidrCc7x&CC5tzf75Db3");
                        //Requête SQL
                        $req = $bdd->prepare("delete from projection where nofilm=:film and nosalle=:salle and dateproj=:date and heureproj=:heure");
                        //htmlspecialchars est une sécurité pour contre injection php html css et js
                        $_POST["cbofilm"]=htmlspecialchars($_POST["cbofilm"]);
                        $_POST["cbosalle"]=htmlspecialchars($_POST["cbosalle"]);
                        $_POST["txtdate"]=htmlspecialchars($_POST["txtdate"]);
                        $_POST["txtheure"]=htmlspecialchars($_POST["txtheure"]);
                        //bindParam est aussi une sécurité contre les injection SQL
                        $req->bindParam(':film',$_POST["cbofilm"], PDO::PARAM_INT);
                        $req->bindParam(':salle',$_POST["cbosalle"], PDO::PARAM_STR);
                        $req->bindParam(':date',$_POST["txtdate"], PDO::PARAM_STR);
                        $req->bindParam(':heure',$_POST["txtheure"], PDO::PARAM_STR);
                        $reponse = $req->execute();

                        if ($reponse == true)
                        {
                            echo ("</br></br><h1 style='text-align:center;'>Projection supprimer avec succès</h1></br></br>");
                        }
                        else
                        {
                            echo("</br></br>Echec, la projection n'a pas été supprimer</br>");
                        }
                        //fermeture de la base de donnée
                        $req->closeCursor();
                        $bdd=null;
                    }
                    ?>
            </div>
            <!--description-->
            <div class="box2">
            <?php
            if (isset($_POST["btnvalider"]) == true || isset($_POST["btnsupprimer"]) == true || isset($_POST["btnvalider"])==false)
            {
                //Connection avec la base de donnée
                $bdd = new PDO("mysql:host=localhost;dbname=id20735984_bdciedehkalfevre;charset=utf8", "id20735984_adrien", "KidrCc7x&CC5tzf75Db3");
                //Requête SQL
                $requete = "select * from film natural join salle natural join projection order by dateproj";
                $req = $bdd->prepare($requete);
                $req->execute();
                $leslignes = $req->fetchall();
                echo ("<center><table class ='tableau' border=1>");
                echo ("<tr>");
                echo("<th>Affiche</th>");
                echo ("<th>Titre</th>");
                echo ("<th>Salle</th>");
                echo ("<th>Date</th>");
                echo ("<th>Horaire</th>");
                echo ("<th>Info</th>");
                echo ("</tr>");
                echo("<tbody>");
                echo ("<tr>");

                foreach ($leslignes as $uneligne)
                {
                    echo ("<tbody>
                    <tr class='ligne'>
                    <td><img class='afficher' src='../Images/$uneligne[imgaffiche]'></td>
                    <td>$uneligne[titre] </td>
                    <td>$uneligne[nosalle] </td>
                    <td>$uneligne[dateproj] </td>
                    <td>$uneligne[heureproj] </td>
                    <td>$uneligne[infoproj] </td>
                    </tr>
                    </tbody>");
                }

                echo ("</tr>");
                echo ("</tbody>");
                echo ("</table></center>");
                //fermeture de la base de donnée
                $req->closeCursor();
                $bdd=null;
            }

        ?>
                
                    
            </div>
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
        <!-- Script Javascript (easter egg) -->
        <script src="../Js/app.js"></script>
    </body>
</html>

<?php
    session_start();

include("fonction.php");

    if(isset($_POST['mail']) AND isset($_POST['password'])){ // si mail et mdp rempli
        $mail = strip_tags($_POST['mail']); 
        $password = strip_tags($_POST['password']);


        $fichier = 'comptes.csv';
            // ouverture du fichier et verification mdp et mail pour se connecter
            $comptes = fopen($fichier, "r");  // j'ouvre le fichier csv en lecture
            
            while($tab=fgetcsv($comptes,1024,';')){ // je parcours mon fichier 
                if($password == $tab[4] && $mail == $tab[3] ){ // si le mdp et le mail son trouvé 
                    $_SESSION['mail'] = $mail;  // je set une session a TRUE
                    $_SESSION['photo'] = $tab[5];
                    $_SESSION['prenom'] = $tab[1];
                    header("location:formulaire-admin.php"); // ensuite je le redirige sur le formulaire 
                }else{
                    $wrong = 'mauvais identifiant';
                }
            
            }
            fclose($comptes);  // fermeture fichier
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>connexion</title>
</head>
<body class ="form-login">
    <?php
        if(isset($wrong)){  // si ma variable $wrong est créee , j'affiche le message
            echo('<p style="color:red;">'.$wrong.'</p>');
        }
    ?>
        
        <form  action="login.php" method = "POST">
        <h1>Espace de connexion</h1>

            <div>
                <label for="mail">E-mail</label>
                <input type="email" name="mail" id="mail">
            </div>
        
            <div>
                <label for="password">Mot de passe</label>
                <input type="password" name="password" id="password">
            </div>
    
           <div>
                <input type="submit" name="connexion" id="connexion" value ="Connexion">
            </div>
        
            
        </form>


</body>
</html>


<?php
session_start();
include('fonction.php');

        $civilite ="";
        $nom = "";       
        $prenom = "";
        $password ="";
        $mail = "";
        $photo = "";

        $erreur = "";
        $fichier = 'comptes.csv';


    if(!empty($_POST)){   // si mes inputs ne sont pas vide
        $civilite = strip_tags($_POST["civilite"]); // je recupere les infos de mon formulaire
        $nom = strip_tags($_POST["nom"]);               
        $prenom = strip_tags($_POST["prenom"]);
        $password = strip_tags($_POST["password"]);   
        $mail = strip_tags($_POST["mail"]);
        $photo = changeNamePicture($_FILES['photo'],$nom); // recupere la photo et change le nom directement grace a la fction
        $infophoto = pathinfo($_FILES['photo']['name']);
        $fichier = 'comptes.csv';
            
        $users = array(       // creation d'un tableau contenant les infos rentrées par l'utilisateur  
            array(
                "civilite" => $civilite,
                "nom" => $nom,
                "prenom" => $prenom,
                "mail" => $mail,
                "password" => $password,
                "photo" => $photo
            ),
        );


    
        if($civilite == NULL OR $nom == "" OR $prenom == "" OR $password == "" OR $mail == "" OR $photo == ""){
                $erreur = "vous devez remplir tout les champs";
        }
        if(!verif_mdp($password)){
            $erreur = "Votre mot de passe doit contenir au moins une majuscule  et un chiffre";

        }
        
        if($mail != ""){
                if(filter_var($mail,FILTER_VALIDATE_EMAIL) == false){
                    $erreur = 'mail invalide';
                }else{
                    $comptes = fopen($fichier, "r");  // j'ouvre le fichier csv en lecture

                    while($tab=fgetcsv($comptes,1024,';')){ // je parcours mon fichier 
                        if($mail == $tab[3] ){ // si le mdp et le mail son trouvé 
                            $erreur = "mail deja existant";
                            fclose($comptes);
                        }
                    }
                }
        }
        if($infophoto['extension'] != 'jpg'){
            $erreur = "votre photo n'est pas au bon format";
        }
        
        if($erreur == ""){
            getPicture($_FILES['photo'],$nom);
            putInCsv($users,$fichier);
        }

        
    }

    $comptes = fopen($fichier, "r");  // j'ouvre le fichier csv en lecture

    while($tab=fgetcsv($comptes,1024,';')){ // je parcours mon fichier 
        $data[] = $tab;

        
    }
    fclose($comptes);

    if(isset($_GET["rang"])){
        $index = $_GET["rang"];
        if(isset($data[$index])){
            unset($data[$index]);

            $comptes = fopen($fichier, "w");  // j'ouvre le fichier csv en lecture
            foreach($data as $field){
                fputcsv($comptes,$field,';');
            }
            fclose($comptes);
            

        }
    }


    
    



if(isset($_SESSION['mail'])){
    if(($erreur == "")){


        $civilite ="";
        $nom = "";       
        $prenom = "";
        $password ="";
        $mail = "";
        $photo = "";


    }


echo('<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
    <header>
    <div>
    <h1> bienvenue </h1>
    <figure>
        <img src ="photos/'.$_SESSION["photo"].'">
    </figure>
   </div>
    <a href = "logout.php">Déconnexion</a>
    </header>');
    

    echo('
    <div class="formulaire">
    ');

    if ($erreur != ""){
        echo("<p style = color:red;>".$erreur."</p>"); // affiche l'erreur si un condition est pas respecter
    }
    echo('<form action="formulaire-admin.php" method="POST"  enctype="multipart/form-data">
    <div>
        <label for="civilite">Civilité</label>
        Madame
        <input type="radio" name = "civilite"  value = "1" required>
        Monsieur
        <input type="radio" name = "civilite" value = "2" required>
    </div>

    <div>
        <label for="nom">nom</label>
         <input type="text" name="nom" id="nom" required value = '.$nom.'>
    </div>

    <div>
        <label for="prenom">prenom</label>
        <input type="text" name="prenom" id="prenom" required value = '.$prenom.' >
    </div>

    <div>
        <label for="mail">E-mail</label>
        <input type="email" name="mail" id="mail" required value = '.$mail.'>
    </div>

    <div>
        <label for="password">Mot de pass</label>
        <input type="password" name="password" id="password" required value = '.$password.'>
    </div>


    <div>
        <label for="photo">photo de profil</label>
        <input type="file" name="photo" id="photo" accept =".jpg" required value = '.$photo.' >
    </div>



    <div>
        <input type="submit" name="submit" value="inscription">
    </div>

</form>
</div>

    <h2> Tableau d\'utilisateur</h2>
<main>
');

createArray($fichier);

echo('
</main>
<div class ="btn-bottom">
<a href = "test_wysiwig.php">Creez une page web personalisée </a>
</div>
</body>
</html>');
}else{
    header("location:login.php"); // si isconnected  n'est pas true , renvoi sur le login
}
?>

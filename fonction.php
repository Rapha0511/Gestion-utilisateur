<?php

    function putInCsv($tabUtilisateur,$fichier){ // mettre utiliateur dans le csv

        // $civilite = $_POST["civilite"];
        // $nom = $_POST['nom'];
        // $prenom = $_POST['prenom'];
        // $mail = $_POST['mail'];
        // $password = $_POST['password'];
        // $photo = $_FILES['photo']['name'];

            $compte = fopen($fichier,"a") or die("unable to open file");
                
            foreach($tabUtilisateur as $user){
                fputcsv($compte,$user,";");
                
            }
        
            if(!fclose($compte)){
                return("erreur fclose");
        
                }
            
        }


            function changeNamePicture($picture,$nom){ // fonction pour changer le nom de la photo
                $infophoto = pathinfo($picture['name']); 
                $extension_upload = $infophoto['extension']; // je recupere l'extension 
                $with_accent = array("à","î","ï","é","ë","ê","è"," ");  // tableau avec les accents
                $without_accent = array("a","i","i","e","e","e","e",""); // tableau sans accents
                $namePicture = "photo-".$nom.".".$extension_upload;  // creation d'un variable pour stocker le nouveau nom 
                $namePicture = str_replace($with_accent,$without_accent,$namePicture); // remplace les accents par les sans accents dans la variable namepicture
                return $namePicture; // retourne la variable namepicrure avec le nouveau nom
            }



        function getPicture($picture,$nom){ // fonction pour stocker la photo dans le dossier

            $infophoto = pathinfo($picture['name']); // decompose le nom de la photo
            $extension_upload = $infophoto['extension']; // recupere l'extension 
            if(isset($picture) AND $picture['error'] == 0){ 
    
                $extension_autorisees = array("jpg"); // tableau avec les extensions que j'autorise
                if(in_array($extension_upload,$extension_autorisees)){ // si mon extension est dans le tableau
                    move_uploaded_file($picture['tmp_name'], 'photos/' . basename(changeNamePicture($picture,$nom)));
                }
            }

        }
        
        function createArray($fichier){   // fonction de creation du tableau

            $rang = 0;

            $comptes = fopen($fichier, "r");
            while($tab =fgetcsv($comptes,1024,';')){ // je parcours mon fichier et stock les infos dans la variable $tab
                    echo('<article>
                <figure>
                    <img  src = photos/'.$tab[5].'>
                </figure>
                <p>'.$tab[1].'</p>
                <p>'.$tab[2].'</p>
                <p>'.$tab[3].'</p> 
                ');           
                
                if($_SESSION['mail'] == 'admin@eemi.com'){
                    echo('<a href="formulaire-admin.php?delete&rang='.$rang.'">delete</a>');

                }
    
            echo('</article>');

            

            $rang++;
            
        }
        fclose($comptes);


        }

        function verif_mdp($password){

            $test = 0;

            $tableau = array("0","1","2","3","4","5","6","7","8","9");
        
            foreach($tableau as $chiffre){
                if(strpos($password,$chiffre) !==false){
                    $test = 1;
                }                       // c'est le meme principe pour les caracteres speciaux , mais la j'ai des bugs de dernieres minutes c'est un peu tendax
            }

            if(strlen($password) < 8){
                return (false);
            }elseif(is_numeric($password)){
                return (false);
            }elseif(strtolower($password) == $password){
                return (false);
            }elseif(strtoupper($password) ==  $password){
                return (false);
            }elseif($test == 0){
                return(false);
            }else{
                return (true);
            }
        }

        

?>
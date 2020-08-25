<?php
session_start();
$name = "";
$title = "";
$titre ="";
$descriptions ="";
$text = "";
//$error = "";

if(!empty($_POST)){
    $name = $_POST['nom'];
    $title = $_POST['titre'];
    $titre = $_POST['h1'];
    $descriptions = $_POST['descriptions'];
    $text = $_POST['text'];

    if($name == "" or $title == "" or $titre == "" or $descriptions == "" or $text == ""){
      $error = "merci de remplir tout les champs";
    }elseif(empty($error)){
          $name = str_replace(" ","",$name);

      $fichier = fopen($name.'.html','w') or die('unable to open file');
$content = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>'.$title.'</title>
    <meta name="description" content="'.$descriptions.'" />
</head>
<body>
    <h1>'.$titre.'</h1>
    <p>'.$text.'</p>
</body>
</html>';

fwrite($fichier,$content);
fclose($fichier);
rename($name.'.html', 'html/'.$name.'.html');
    }
    

    
}



if(isset($_SESSION['mail'])){
 

echo('<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="style.css">

<script src="https://cdn.tiny.cloud/1/xebuf12c7gwnj85e9juomjqw07485imufrdzr2ci7bv7sm8w/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
  <script>
    tinymce.init({
    selector: \'textarea\',
      plugins: \'a11ychecker advcode casechange formatpainter linkchecker lists checklist media mediaembed pageembed permanentpen powerpaste table advtable tinycomments tinymcespellchecker\',
      toolbar: \'a11ycheck addcomment showcomments casechange checklist code formatpainter pageembed permanentpen table\',
      toolbar_drawer: \'floating\',
      tinycomments_mode: \'embedded\',
      tinycomments_author: \'Author name\',
    });
  </script>
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

if(!empty($error)){
  echo('<p style = "color:red;">'.$error.'</p>');
}

echo('<form method = \'POST\' action= \'test_wysiwig.php\' style = "width: 90%; margin: auto;">

<div>
        <label for="">Nom du fichier</label>
        <input type="text" name="nom" id="nom"> 
</div>

<div>
    <label for="">Titre</label>
    <input type="text" name="titre" id="titre" >
</div>

<div>
    <label for="">Description</label>
    <input type="text" name="descriptions" id="description">
</div>

<div>
    <label for="">H1</label>
    <input type="text" name="h1" id="h1">
</div>
<div>
<textarea name = "text">
    Welcome to your TinyMCE premium trial!
  </textarea>
</div>

<div>
    <input type="submit" class = "submitpage" value =\'generer\'>
</div>

</form>
<a href = "formulaire-admin.php" class="retour">Retour a l\'accueil</a>
</body>


</html>');
  }else{
    header('location:login.php');
  }

?>

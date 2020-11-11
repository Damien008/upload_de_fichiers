<?php
    
    $uploadDir = 'uploads/';
    $file = basename($_FILES['images']['name']);
    $taille_maxi = 1000000;
    $taille = filesize($_FILES['images']['tmp_name']);
    $extensions = array('.png', '.gif', '.jpg');
    $extension = strrchr($_FILES['images']['name'], '.');



    if(!in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau
            {
                $erreur = 'Vous devez uploader un fichier de type png, gif ou jpg';
            }
        
    if($taille>$taille_maxi)
    {
        $erreur = 'Le fichier est trop gros...';
    } 
    
    if(!isset($erreur)) //S'il n'y a pas d'erreur, on upload
    {
         //On formate le nom du fichier ici...
         
         $extension = pathinfo($_FILES['images']['name'], PATHINFO_EXTENSION);
         // A unique name is concatenated with a dot and the $extention avec l'extension récupérée
         $file = uniqid() . '.' .$extension;
         if(move_uploaded_file($_FILES['images']['tmp_name'], $uploadDir . $file)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
         {
              echo 'Upload effectué avec succès !';
         }
         else //Sinon (la fonction renvoie FALSE).
         {
              echo 'Echec de l\'upload !';
         }
    }
    else
    {
         echo $erreur;
    }
    if(isset($_GET['delete']) && !empty($_GET['delete']))
    {
        $fileToDelete = __DIR__.'/uploads/'.$_GET['delete'];
        if(file_exists($fileToDelete))
        {
            unlink($fileToDelete);
        }
    }

?>


<!doctype html>
<html>
<head>

</head>
<body>
<form action="" method="post" enctype="multipart/form-data">
    <label for="imageUpload">Upload an profile image</label>    
    <input type="file" name="images" id="imageUpload" mutliple="multiple" />
    <button>Send</button>
</form>
</body>
</html>



<?php

if(is_dir(__DIR__ . '/uploads'))
    {
        $images = new FilesystemIterator(dirname(__FILE__) . '/uploads');
        foreach($images as $image)
        {
            echo'<li>
                    <figure>
                        <img src="uploads/' . $image->getFilename() . ' " style="height: 100px; width: auto;">
                        <figcaption>Uploaded '.date("Y-m-d H:i:s", filemtime('uploads/'.$image->getFilename())).'</figcaption>
                    </figure>
                    <a href="?delete='.$image->getFilename().'">Delete file <em>'.$image->getFilename().'</em></a>
                </li>';
        }
    }
?>
 
 



<?php
    require 'database.php';

    $nameError = $descriptionError = $priceError = $categoryError = $imageError = $name = $description = $price = $category = $image = "";

    if(!empty($_post))//si le poste n'est pas vide ca veut dire que c'est pas mon premier passage mais le deuxieme
    {
        $name = checkInput($_post['name']);//dans le contenu de la super globale post (qui est un array), on recupere l'entree dont le name vaut name
        $description = checkInput($_post['description']);
        $price = checkInput($_post['price']);
        $category = checkInput($_post['category']);
        $image = checkInput($_FILES['image']['name']);//on recupere les input de type file avec la super globale $_files
        //image est le nom de la variable et name est la parcequ'o veut recuperer son nom
        $imagePath = '../images/'.basename($image);//on recuperer le chemin de l'image en allant dans le dossier images et en selectionnant celui qui porte le nom considerer
        $imageExtension = pathinfo($imagePath, PATHINFO_EXTENSION);//on recupere l'extension de l'image
        $isSuccess = true;//si on rencontre une erreur apres une verification, on la met a false, ie que l'ensemble du formulaire a un problme
        $isUploadSuccess = false;//pour savois si en particulier l'upload de l'image a ete un succes

        if(empty($name))
        {
            $nameError = "Ce champ ne doit pas etre vide";
            $isSuccess = false;//ie que l'ensemble du formulaire a un problme
        }

        if(empty($description))
        {
            $descriptionError = "Ce champ ne pas etre vide";
            $isSuccess = false;//ie que l'ensemble du formulaire a un problme
        }
        if(empty($price))
        {
            $priceError = "Ce champ ne pas etre vide";
            $isSuccess = false;//ie que l'ensemble du formulaire a un problme
        }
        if(empty($category))
        {
            $categoryError = "Ce champ ne pas etre vide";
            $isSuccess = false;//ie que l'ensemble du formulaire a un problme
        }
        if(empty($image))
        {
            $imageError = "Ce champ ne pas etre vide";
            $isSuccess = false;//ie que l'ensemble du formulaire a un problme
        }
        else
        {
            $isUploadSuccess=true;
            if($imageExtension !="jpg" && $imageExtension !="png" && $imageExtension !="jpeg" && $imageExtension !="gif")
            {
                $imageError = "les fichiers autorises sont: .jpg, .jpeg, .png, .gif";
                $isUploadSuccess=false;
            }
            if(file_exists($imagePath))
            {
                $imageError="le fichier existe deja";
                $isUploadSuccess=false;
            }
            if($_FILES["image"]["size"] > 500000)
            {
                $imageError="le fichier ne doit pas depasser 500kb";
                $isUploadSuccess=false;
            }
            if($isUploadSuccess)
            {
                if(!move_uploaded_file($_FILES["image"]["tmp_name"],$imagePath))
                {
                    //la fonction move_uploaded_file prend l'image et la met dans le chemin $imagepath et renvoit true si elle a reussi
                    $imageError = "il y'a eu une erreur lors de l'upload";
                    $isUploadSuccess = false;
                }
            }
        }


        if($isSucces && $isUploadSuccess)
        {
            $db=Database::connect();
            $statement = $db->prepare("insert into items (name, description, price, category, image) values (?,?,?,?,?)");
            $statement->execute(array($name, $description, $price, $category, $image));
            Database::disconnect();
            header("Location: index.php");// <=> change moi l'adresse et mets moi index.php
        }

    }




    function checkInput($data)//cette fonction permet de verifier l'information receuillit de l'exterieur (il s'agit ici du id) au cas ou qlq etait mal intentionner, donc avec cette fonction on nettoie la donnee en qlq sorte et puis on la retourne en etant certain mtn qu'il n'ya plus de probleme
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;

    }

?>

<!doctype html>
<html lang="en">
  <head>
    <title>Burger Code</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Holtwood+One+SC&display=swap" rel="stylesheet">
    <!--<link href='http://fonts.googleapis.com/css?family=Holtwood+One+SC' rel='stylesheet' type='text/css'>-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../css/style.css">

 
  </head>
  <body>
      
   
        <h1 class="text-logo"><i class="fa-solid fa-utensils"></i><span> Burger Code </span><i class="fa-solid fa-utensils"></i></h1>

        <div class="container admin">
            <div class="row">
                
                <h1><strong>Ajouter un item</strong></h1>
                <br>
                <form action="insert.php" method="post" role="form" class="form" enctype="multipart/form-data"><!--vue qu'on va uploader une image, on rajoute l'attribut enctype-->

                    <div>
                        <label for="name" class="form-label">Nom : </label><!--l'attribut for sert a ce que si on clique sur le labe ca nous amene directement sur le input-->
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nom" value="<?php echo $name; ?>">
                        <span class="help-inline"><?php echo $nameError; ?></span><!--la class help-inline que nous creons nous sert aa mettre les erreur de remplissage du formulaire en rouge-->
                    </div><br>
                    <div>
                        <label for="description" class="form-label">Description : </label>
                        <input type="text" class="form-control" id="description" name="description" placeholder="Description" value="<?php echo $description; ?>">
                        <span class="help-inline"><?php echo $descriptionError; ?></span>
                    </div><br>
                    <div>
                        <label for="price" class="form-label">Prix (en €) : </label>
                        <input type="number" step="0.01" class="form-control" id="price" name="price" placeholder="Prix" value="<?php echo $price; ?>">
                        <span class="help-inline"><?php echo $priceError; ?></span>
                    </div><br>
                    <div>
                        <label for="category" class="form-label">Categorie : </label>
                        <select name="category" id="category" class="form-control">
                            <?php
                                $db = Database::connect();
                                foreach($db->query('select * from categories') as $row)
                                {
                                    echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                                    //ce que  l'utilisateur va voir c'est $row['name'] donc le nom de la categorie mais nous ce qu'on va recuperer pour la sauvegarde c'est l'id donc c'est pourquoi on met l'id dans l'attribut value et le nom entre les balises option
                                }

                                Database::disconnect();
                            ?>
                        </select>
                        <span class="help-inline"><?php echo $categoryError; ?></span>
                    </div>
                    <br>
                    <div>
                        <label for="image" class="form-label">Selectionner une image : </label>
                        <input type="file" id="image" name="image">
                        <span class="help-inline"><?php echo $imageError; ?></span>
                    </div>
                    <br>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-success"><i class="fa-sharp fa-solid fa-pencil"></i> Ajouter </button>
                        <a href="index.php" class="btn btn-primary"><i class="fas fa-arrow-left"></i>  Retour</a>
                    </div>
                    

                </form>
                
            </div>
        </div>

  </body>
</html>

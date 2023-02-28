<?php

    require 'database.php';

    if(!empty($_GET['id']))//on recupere la donne fournit sous le nom 'id' lors de l'appel a cette page
    {
        $id = checkInput($_GET['id']);
    }


    $db = Database::connect();
    try
    {
        $statement = $db->query("SELECT items.id, items.name, items.description, items.price, items.image, categories.name as category 
        from items left join categories  on items.category=categories.id where items.id = $id");
    }
    catch(PDOException $e)
    {
    die('ERROR : '.$e->getMessage());
    }

    //$statement->execute(array($id));
    $item = $statement->fetch();

    Database::disconnect();


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
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Holtwood+One+SC&display=swap" rel="stylesheet">
        <!--<link href='http://fonts.googleapis.com/css?family=Holtwood+One+SC' rel='stylesheet' type='text/css'>-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
        <link rel="stylesheet" href="../css/style.css">

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>

    </head>
    <body>
        <h1 class="text-logo"><i class="fa-solid fa-utensils"></i><span> Burger Code </span><i class="fa-solid fa-utensils"></i></h1>

        <div class="container admin">
            <div class="row">
                <div class="col-sm-6">
                    <h1><strong>Voir un item</strong></h1>
                    <br>
                    <form action="">
                        <div class="form-group">
                            <label for="">Nom : </label> <?php echo $item['name']; ?>
                        </div><br>
                        <div class="form-group">
                            <label for="">Description : </label> <?php echo $item['description']; ?>
                        </div><br>
                        <div class="form-group">
                            <label for="">Prix : </label> <?php echo '<td>'.number_format((float)$item['price'],2,'.','').'</td>'; ?>
                        </div><br>
                        <div class="form-group">
                            <label for="">Categorie : </label> <?php echo $item['category']; ?>
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="">Image : </label> <?php echo $item['image']; ?>
                        </div>
                        <br>
                        <div class="form-actions">
                        <a href="index.php" class="btn btn-primary"><i class="fas fa-arrow-left"></i>  Retour</a>
                        </div>
                        

                    </form>
                </div>
                
                <div class="col-sm-6 site">
                    <div class="img-thumnbnail">
                        <img src="<?php echo '../images/'.$item['image']; ?>" alt="" class="img-fluid">
                        <div class="price"><?php echo number_format((float)$item['price'], 2, '.', '') . ' €'; ?></div>
                        <div class="caption">
                            <h4><?php echo $item['name']; ?></h4>
                            <p><?php echo $item['description']; ?></p>
                            <a href="#" class="btn btn-order" role="button"><i class="fa-solid fa-cart-shopping"></i> Commander</a>
                        </div>
                    </div>
                </div>   
            </div>
        </div>
    </body>
</html>

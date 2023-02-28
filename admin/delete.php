<?php
    require 'database.php';

    if(!empty($_GET['id']))
    {
        $id=checkInput($_GET['id']);
    }

    if(!empty($_POST))
    {
        $id=checkInput($_POST['id']);

        $db=Database::connect();
        $statement=$db->prepare("delete from items where id=?");
        $statement->execute(array($id));
        Database::disconnect();
        header("Location: index.php");
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
                
                <h1><strong>Supprimer un item</strong></h1>
                <br>
                <form action="delete.php" method="post" role="form" class="form" >

                <input type="hidden" name="id" value="<?php echo $id ?>">
                   
                <p class="alert alert-warning">Estes-vous sur de vouloir supprimer ?</p>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-warning"><i class="fa-sharp fa-solid fa-pencil"></i> Oui </button>
                        <a href="index.php" class="btn btn-default"><i class="fas fa-arrow-left"></i>  Non</a>
                    </div>
                    

                </form>
                
            </div>
        </div>

  </body>
</html>

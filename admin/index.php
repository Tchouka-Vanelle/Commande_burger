<!doctype html>
<html lang="en">
  <head>
    <title>Burger Code</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css">
    <link href='http://fonts.googleapis.com/css?family=Holtwood+One+SC' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../css/style.css">
  </head>

  <body>
        <h1 class="text-logo"><i class="fa-solid fa-utensils"></i><span> Burger Code </span><i class="fa-solid fa-utensils"></i></h1>
        <div class="container admin">
            <div class="row">
                <h1><strong>Liste des Items  </strong><a href="insert.php" class="btn btn-success btn-lg"><i class="fa-solid fa-plus"></i>  ajouter</a></h1>
                <table class="table table-striped table-bordered">
                    <thead>
                         <tr>
                            <th>Nom</th>
                            <th>Description</th>
                            <th>Prix</th>
                            <th>Categorie</th>
                            <th>Actions</th>
                         </tr>
                    </thead>
                    <tbody>

                        <?php
                            require 'database.php';//la difference entre require et include c'est que si le fichier n'existe pas, alors il arrete tout
                            $db=Database::connect();
                            $statement = $db->query('SELECT items.id, items.name, items.description, items.price, categories.name as category 
                            from items left join categories  on items.category=categories.id order by items.id desc');

                            
                            while($item = $statement->fetch())
                            {

                                echo '<tr>';
                                echo '<td>'.$item['name'].'</td>';
                                echo '<td>'.$item['description'].'</td>';
                                echo '<td>'.number_format((float)$item['price'],2,'.','').'</td>';
                                echo '<td>'.$item['category'].'</td>';
                            
                                echo '<td width=324>';
                                        echo '<a href="view.php?id='. $item['id'] .'" class="btn btn-secondary"><i class="fa-solid fa-eye"></i> Voir</a> ';
                                        echo '<a href="update.php?id='. $item['id'] .'" class="btn btn-primary"><i class="fa-sharp fa-solid fa-pencil"></i> Modifier</a> ';
                                        echo '<a href="delete.php?id='. $item['id'] .'" class="btn btn-danger"><i class="fa-solid fa-xmark"></i> Supprimer</a> ';
                                echo '</td>';
                                echo '</tr>';

                            }

                        Database::disconnect();
                        ?>

                        

                    </tbody>

                </table>

                

            </div>
        </div>

  </body>
</html>
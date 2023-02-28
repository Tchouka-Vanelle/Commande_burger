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
    <link rel="stylesheet" href="css/style.css">

    

    

  </head>
  <body>
      
    <div class="container site">
        <h1 class="text-logo"><i class="fa-solid fa-utensils"></i><span> Burger Code </span><i class="fa-solid fa-utensils"></i></h1>

        <?php

            require 'admin/database.php';
            $db=Database::connect();
            $cat=$db->query('select * from categories');

            echo '<nav>
                <ul class="nav nav-pills" role="tablist">';
                while($row=$cat->fetch())
                {
                    if($row['id']=='1')
                        echo '<li class="nav-item" role="presentation"><a class="nav-link active" data-bs-toggle="pill" data-bs-target="#tab'.$row['id'].'" 
                         role="tab">'.$row['name'].'</a></li>';
                    else
                        echo '<li class="nav-item" role="presentation"><a class="nav-link" data-bs-toggle="pill" data-bs-target="#tab'.$row['id'].'" 
                         role="tab">'.$row['name'].'</a></li>';
                }
            echo '</ul>
            </nav>';
            
            $cat=$db->query('select * from categories');
            echo '<div class="tab-content">';
            while($row=$cat->fetch())
                {
                    $r=$db->prepare("select * from items where items.category=?");
                    $r->execute(array($row['id']));
                    if($row['id']=='1')
                        echo '<div class="tab-pane active" id="tab'.$row['id'].'" role="tabpanel">';
                    else
                        echo '<div class="tab-pane" id="tab'.$row['id'].'" role="tabpanel">';
                    echo '<div class="row">';

                    while($item=$r->fetch())
                    {
                        echo '<div class="col-md-6 col-lg-4">
                                <div class="img-thumbnail">
                                    <img src="images/' . $item['image'] . '" class="img-fluid" alt="...">
                                    <div class="price">' . number_format($item['price'], 2, '.', ''). ' €</div>
                                    <div class="caption">
                                        <h4>' . $item['name'] . '</h4>
                                        <p>' . $item['description'] . '</p>
                                        <a href="#" class="btn btn-order" role="button"><span class="bi-cart-fill"></span> Commander</a>
                                    </div>
                                </div>
                            </div>';
                    }
                    
                    echo '</div>
                        </div>';
                }
            Database::disconnect();
        echo '</div>';
        ?>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>

<?php 
include 'DB/dbConnection.php';
include './user.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">

    <title>Home</title>
</head>

<body>
    <?php include 'navbar.php';?>
    <main>

        <ul id="myTable">
            <?php  
                $category = !empty($_GET['category']) ? $_GET['category'] : NULL;
//code to execute if category selected -> diplay all the movies in this category
              if(isset($category)){
                $sqlCategory = "SELECT film_title, film.film_id, category_name FROM `film` join film_category on film.film_id = film_category.film_id join category on film_category.category_id = category.category_id where category.category_name = '$category'";
                $result = $dbConnection->query($sqlCategory);
                    //display all movies
                    while($row = $result->fetch(PDO::FETCH_OBJ)){
                      echo  "<li>
                      <div><figure>
                      <a href=moviedetail.php?movieId=".$row->film_id.">
                      <img src='images/academy_dinosaur.jpeg' alt=$row->film_title>
                      </a>
                      <figcaption>".$row->film_title."</figcaption>
                      <figcaption>".$row->category_name."</figcaption>
                  </figure>
                  </div>
                </li>";
                    }
              }
//code to execute if an input is typed to the search bar
              elseif(isset($_GET['search'])){
                $input=isset($_GET['search'])? $_GET['search']:"";
            $sql = "SELECT * FROM `film` join film_category on film.film_id = film_category.film_id join category on film_category.category_id = category.category_id WHERE `film_title` like '$input%' or `film_title` like '%$input' ";
            $answer = $dbConnection->query($sql);
            //display all movies
            while($row = $answer->fetch(PDO::FETCH_OBJ)){
                    echo "<li>
                    <div><figure>
                    <a href=moviedetail.php?movieId=".$row->film_id.">
                    <img src='images/academy_dinosaur.jpeg' alt=$row->film_title>
                    </a>
                    <figcaption>".$row->film_title."</figcaption>
                    <figcaption>".$row->category_name."</figcaption>
                </figure>
                </div>
                </li>";}
              
            }
//code to execute by default on the landing page
              else{
                  // Page was not reloaded via a button press
                  
                  $index=isset($_POST['more'])?$_SESSION['index']:0; 
                  //movies categorised and displayed
        $sql = "select film.film_title, film.film_id, film.description, film.year_released, category.category_name from film join film_category on film.film_id = film_category.film_id join category on film_category.category_id = category.category_id  limit $index,20";
        $answer = $dbConnection->query($sql);
        while($row = $answer->fetch(PDO::FETCH_OBJ)){
            echo "<li>
            <div><figure>
            <a href=moviedetail.php?movieId=".$row->film_id.">
            <img src='images/academy_dinosaur.jpeg' alt=$row->film_title>
            </a>
            <figcaption>".$row->film_title."</figcaption>
            <figcaption>".$row->category_name."</figcaption>
        </figure>
        </div>
        </li>";}
              }
        ?>
        </ul>
        <form method='POST'>
            <input name='more' type="submit" value='View more'>
            <?php $_SESSION['index']+=100; ?>
        </form>

    </main>
    <?php include 'footer.php';?>
    <script src="js/navbar.js"></script>
</body>

</html>
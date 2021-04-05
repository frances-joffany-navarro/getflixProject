<?php include 'DB/dbConnection.php';?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home</title>

</head>

<body>
  <?php include 'navbar.php';?>
  <main>
    <ul id="myTable">
      <?php  
         $category = !empty($_GET['category']) ? $_GET['category'] : NULL;
      // $category= $_GET['category'];
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
      else{
          //movies categorised and displayed
$sql = "select film.film_title, film.film_id, film.description, film.year_released, category.category_name from film join film_category on film.film_id = film_category.film_id join category on film_category.category_id = category.category_id";
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
  </main>

<?php include 'footer.php';?>
<script src="js/navbar.js"></script>
</body>

</html>

<?php
    // DB CONNECTION
    try {
        $conn = new PDO('mysql:host=localhost;dbname=getflix;charset=utf8', 'root', '');
    } catch (Exception $e) {
        die('Error : ' . $e->getMessage());
    };?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search</title>
    <link rel="stylesheet" href="styleSearchFilter.css">
</head>
<body>
<input type="text" id="myInput" placeholder="Search for movie titles..">

<!--crete a list for movies-->
<ul id="myTable">
  <?php
  //select movies by joining tables in DB 
$sql = "select film.film_title, film.film_id, film.description, film.year_released, category.category_name from film join film_category on film.film_id = film_category.film_id join category on film_category.category_id = category.category_id";
// make a query to fetch requested titles as an object
    $answer = $conn->query($sql);
    //display all movies
    while($row = $answer->fetch(PDO::FETCH_OBJ)){
        //fetch film_id, film_title and category_name and display in a list item containing a div with the picture and description for each movie
        // <a> tag passes the id of the movie we click on to the descriptions page to display only this item
        echo "<li>
        <div><figure>
        <a href=moviedetail.php?movieId=".$row->film_id.">
        <img src='sample.jpg' alt=$row->film_title>
        </a>
        <figcaption>".$row->film_title."</figcaption>
        <figcaption>".$row->category_name."</figcaption>
    </figure>
    </div>
  </li>";}?>
</ul>

    <script src="scriptSearchFilter.js"></script>
</body>
</html>
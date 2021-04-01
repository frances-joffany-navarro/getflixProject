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
    <link rel="stylesheet" href="style.css">
</head>
<body>
<input type="text" id="myInput" placeholder="Search for movie titles..">

<ul id="myTable">
  <!-- <tr class="header">
    <th style="width:25%;">Title</th>
  </tr> -->

  <?php
  //movies categorised and displayed
$sql = "select film.film_title, film.description, film.year_released, category.category_name from film join film_category on film.film_id = film_category.film_id join category on film_category.category_id = category.category_id";
    $answer = $conn->query($sql);
    while($row = $answer->fetch(PDO::FETCH_OBJ)){
        echo "<li>
        <div><figure>
        <a href=http://localhost/Search/moviedetail.php?>
        <img src='sample.jpg' alt=$row->film_title>
        </a>
        <figcaption>".$row->film_title."</figcaption>
        <figcaption>".$row->category_name."</figcaption>
    </figure>
    </div>
  </li>";}?>
</ul>

    <script src="script.js"></script>
</body>
</html>
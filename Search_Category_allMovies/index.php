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

<table id="myTable">
  <tr class="header">
    <th style="width:25%;">Title</th>
    <th style="width:25%;">Description</th>
    <th style="width:25%;">Category</th>
    <th style="width:25%;">Year released</th>
  </tr>

  <?php
  //movies categorised and displayed
$sql = "select film.film_title, film.description, film.year_released, category.category_name from film join film_category on film.film_id = film_category.film_id join category on film_category.category_id = category.category_id";
    $answer = $conn->query($sql);
    while($row = $answer->fetch(PDO::FETCH_OBJ)){
        echo "<tr>
    <td>".$row->film_title."</td>
    <td>".$row->description."</td>
    <td>".$row->category_name."</td>
    <td>".$row->year_released."</td>
  </tr>";}?>
</table>

    <script src="script.js"></script>
</body>
</html>
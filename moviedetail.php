<?php
// Connect to DB
include './DB/dbConnection.php';

if (!isset($_GET['movieId']) || !is_numeric($_GET['movieId'])) {
    echo "<p><strong>MOVIE NOT FOUND</strong></p>";
    return;
}

$movieId = $_GET['movieId'];

//Delete row from comments
try {
    if (isset($_GET['commentId'])) {
        $idComment = $_GET['commentId'];
        $deleteRow = "DELETE FROM comments WHERE comment_id=$idComment";
        $dbConnection->exec($deleteRow);

        header("Refresh:0; url=moviedetail.php?movieId=$movieId");
    }
} catch (PDOException $exception) {
    echo $deleteRow . "\n" . $exception->getMessage();
}

//Retrieve movie details from DB

try {
    $responseMovies = $dbConnection->query("SELECT film.film_id, film_title, description, year_released, category_name 
FROM film  as film
JOIN film_category as filmcategory ON film.film_id = filmcategory.film_id
JOIN category as category ON filmcategory.category_id = category.category_id
WHERE film.film_id = $movieId");
    //get row
    $data = $responseMovies->fetch();
    if ($data == false) {
        echo "<p><strong>MOVIE NOT FOUND</strong></p>";
        return;
    }

    //get data
    $yearReleased = $data['year_released'];
    $categoryName = $data['category_name'];
    $description = $data['description'];

    $responseMovies->closeCursor();
} catch (PDOException $exception) {
    echo $exception->getMessage();
}


//MESSAGES
//verify variables are not empty
if (isset($_POST['comment'])) {
    // INSERT DATA IN DB
    $comment = $_POST['comment'];
    $userId = 1; //todo: replace with session user
    $insertSql = "INSERT INTO comments (`comment`, `user_id`) VALUES('$comment', $userId)";

    try {
        $result = $dbConnection->exec($insertSql);
    } catch (PDOException $exception) {
        echo $exception->getMessage();
    }
    header("Refresh:0; url=moviedetail.php?movieId=$movieId");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie details</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <div class="container mt-4">
        <!-- Display movie -->
        <div class="row" ;>
            <div class="col-8">
                <h3><?php echo ($data['film_title']) ?></h3>
                <article>
                    <p>Synopsis: <?php echo ($description) ?></p>
                    <br><br>

                    <p>Genre: <?php echo ($categoryName) ?></p>
                    <p>Year: <?php echo ($yearReleased) ?></p>
                </article>
            </div>
            <div class="col-4">
                <img src="./academy_dinosaur.jpeg" alt="academy_dinosaur" class="rounded float-right img-fluid">
            </div>
            <div class="col-3 offset-9">
                <a class="btn btn-info" href="https://www.youtube.com/watch?v=P10p7ALXkcU&ab_channel=Cocomelon-NurseryRhymes" role="button">Watch the trailer</a>
            </div>

        </div>

        <br><br>
        <hr>
        <form action="" method="post">
            <p><label for="comment">Comments:</label></p>
            <textarea id="comment" name="comment" rows="4" cols="50" placeholder="Write a comment" required></textarea>
            <br><br>
            <input type="submit" value="Submit">
        </form>

        <!-- CREATE TABLE -->
        <table class="table mt-4">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Name</th>
                    <th>Comment</th>
                    <th>Delete</th>
                </tr>
            </thead>

            <?php
            //Retrieve last messages
            $responseMessages = $dbConnection->query('SELECT comment_id, comment, created_at, users.first_name
            FROM comments as comments 
            JOIN users as users ON users.id = comments.user_id
            ORDER BY created_at DESC LIMIT 0, 10');

            while ($data = $responseMessages->fetch()) {
                $comment = $data['comment'];
                $date = $data['created_at'];
                $name = $data['first_name'];
                $commentId = $data['comment_id'];
            ?>
                <tbody>
                    <tr>
                        <td> <?php echo ($date) ?></td>
                        <td> <?php echo ($name) ?> </td>
                        <td> <?php echo ($comment) ?></td>
                        <td>
                            <a href="moviedetail.php?movieId=<?php echo$movieId?>&commentId=<?php echo $commentId ?>">
                                <i class='fa fa-trash'></i>
                            </a>
                        </td>
                    </tr>
                </tbody>

            <?php
            }

            $responseMessages->closeCursor();
            ?>
        </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
</body>

</html>
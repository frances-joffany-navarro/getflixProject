<?php
// Connect to DB
include './DB/dbConnection.php';
include './user.php';
include './permissions.php';
session_start();

$isUserLogged = isset($_SESSION['user']);
$user = $isUserLogged ? $_SESSION['user'] : null;

// verify if exists an id for the movie and if it's a nr.
if (!isset($_GET['movieId']) || !is_numeric($_GET['movieId'])) {
    echo "<p><strong>MOVIE NOT FOUND</strong></p>";
    return;
}

$movieId = $_GET['movieId'];

// Delete row from comments
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

// Retrieve movie details from DB

try {
    $responseMovies = $dbConnection->query("SELECT film.film_id, film_title, description, year_released, category_name, 
    videos.video_id, videos.title
FROM film  as film
JOIN film_category as filmcategory ON film.film_id = filmcategory.film_id
JOIN category as category ON filmcategory.category_id = category.category_id
LEFT JOIN videos as videos ON film.trailer_id = videos.id
WHERE film.film_id = $movieId");
    // get row
    if ($responseMovies == false) {
        echo "<p><strong>MOVIE NOT FOUND</strong></p>";
        return;
    }
    $data = $responseMovies->fetch();
    if ($data == false) {
        echo "<p><strong>MOVIE NOT FOUND</strong></p>";
        return;
    }

    // get data
    $yearReleased = $data['year_released'];
    $categoryName = $data['category_name'];
    $description = $data['description'];
    $trailerId = $data['video_id'];
    $videoTitle = $data['title'];

    $responseMovies->closeCursor();
} catch (PDOException $exception) {
    echo $exception->getMessage();
}

//MESSAGES
$isCommentAdded = isset($_POST['comment']);
if ($isCommentAdded) {
    // INSERT DATA IN DB
    $comment = $_POST['comment'];
    $insertSql = "INSERT INTO comments (`comment`, `user_id`, `film_id` ) VALUES('$comment', $user->id, $movieId)";

    try {
        $result = $dbConnection->exec($insertSql);
    } catch (PDOException $exception) {
        echo $exception->getMessage();
    }
    header("Refresh:0; url=moviedetail.php?movieId=$movieId");
}

include 'navbar.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie details</title>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous"> -->
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"> -->
    <link rel="stylesheet" href="./css/moviedetail.css">
</head>

<body>
    <div class="container mt-4 text-start">
        <!-- Display movie -->
        <div class="row mb-4" ;>
            <div class="col-12 col-sm-6">
                <h3 class="mb-4"><?php echo $data['film_title'] ?></h3>

                <article>
                    <p class="mt-2"><strong>Synopsis:</strong> <?php echo $description ?></p>
                    <br><br>

                    <p><strong>Genre:</strong> <?php echo $categoryName ?></p>
                    <p><strong>Year:</strong> <?php echo $yearReleased ?></p>
                </article>
            </div>
            <div class="col-12 col-sm-6">
                <div class="ratio ratio-16x9">
                    <iframe class="" src="https://www.youtube.com/embed/<?php echo $trailerId ?>" title="<?php echo $videoTitle ?>" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
                    </iframe>
                </div>
            </div>
        </div>

        <p><label><strong>Comments</strong></label></p>
        <?php
        if ($isUserLogged) {
            $responsePermissions = $dbConnection->query("SELECT permissions.description
            FROM user_roles as userRoles 
            JOIN role_permissions as rolePermissions ON userRoles.role_id = rolePermissions.role_id
            JOIN permissions as permissions ON rolePermissions.permission_id = permissions.id
            WHERE user_id=$user->id");

            $userPermissions = $responsePermissions->fetchAll(PDO::FETCH_COLUMN, 0);

            $canUserAddComment = in_array(Permissions::ADD_COMMENT, $userPermissions);

            $canUserDeleteComment = in_array(Permissions::DELETE_COMMENT, $userPermissions);

            if ($canUserAddComment) { ?>
                <form action="" method="post" class="mt-4">
                    <textarea id="comment" name="comment" rows="3" cols="40" placeholder="Write a comment" required></textarea>
                    <input class="mt-4 d-block btn btn-outline-success" id="postButton" type="submit" value="Post">
                </form>
        <?php
            }
        }
        ?>

        <!-- CREATE TABLE -->

        <table class="table mt-4 mb-4">
            <?php if ($isCommentAdded) { ?>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Name</th>
                        <th>Comment</th>
                        <?php if ($isUserLogged) { ?>
                            <th>Delete</th>
                        <?php } ?>
                    </tr>
                </thead>
            <?php } ?>

            <?php
            //Retrieve last messages
            $responseMessages = $dbConnection->query("SELECT comment_id, comments.film_id, comment, created_at, comments.user_id, 
            users.first_name,
            userRoles.user_id
            FROM comments as comments 
            JOIN users as users ON users.id = comments.user_id
            LEFT JOIN user_roles as userRoles ON comments.user_id = userRoles.user_id
            WHERE comments.film_id=$movieId
            ORDER BY created_at DESC LIMIT 0, 10");

            while ($data = $responseMessages->fetch()) {
                $comment = $data['comment'];
                $createdDate = $data['created_at'];
                $firstName = $data['first_name'];
                $commentId = $data['comment_id'];
                $commentUserId = $data['user_id'];

            ?>
                <tbody>
                    <tr>
                        <td> <?php echo $createdDate ?></td>
                        <td> <?php echo $firstName ?> </td>
                        <td> <?php echo $comment ?></td>
                        <td>
                            <?php
                            $isOwnComment = $isUserLogged && $commentUserId == $user->id;
                            $canDeleteComment = $isUserLogged && ($canUserDeleteComment || $isOwnComment);

                            if ($canDeleteComment) {
                            ?>
                                <a href="moviedetail.php?movieId=<?php echo $movieId ?>&commentId=<?php echo $commentId ?>">
                                    <i id="delete" class='fa fa-trash'></i>
                                </a>
                            <?php
                            }
                            ?>
                        </td>
                    </tr>
                </tbody>

            <?php
            }

            $responseMessages->closeCursor();
            ?>
        </table>
    </div>

    <?php include 'footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script> -->
</body>

</html>
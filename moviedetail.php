<?php
// Connect to DB
include './DB/dbConnection.php';
include './user.php';
include './permissions.php';
session_start();

//verify user is logged
$isUserLogged = isset($_SESSION['user']);
$user = $isUserLogged ? $_SESSION['user'] : null;

// verify if exists an id for the movie and if it's a nr.
if (!isset($_GET['movieId']) || !is_numeric($_GET['movieId'])) {
    echo "<p><strong>MOVIE NOT FOUND</strong></p>";
    return;
}

//declare variable with the id of the movie from link
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

    //verify if movie is not found
    if ($responseMovies == false) {
        echo "<p><strong>MOVIE NOT FOUND</strong></p>";
        return;
    }

    // get row
    $data = $responseMovies->fetch();

    //verify if movie is not found
    if ($data == false) {
        echo "<p><strong>MOVIE NOT FOUND</strong></p>";
        return;
    }

    // store data into vars
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

//verify comment was added
$isCommentAdded = isset($_POST['comment']);

if ($isCommentAdded) {

    $comment = $_POST['comment'];

    // INSERT DATA IN DB
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
    <meta name=description content="Display the details of a selected movie">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie details</title>
    <link rel="stylesheet" href="./css/moviedetail.css">
</head>

<body>
    <div class="container text-start">
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

        <?php
        //verify if user is logged
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

        <!-- CREATE COMMENT LIST -->
        <?php
        //Retrieve last comments
        $responseComments = $dbConnection->query("SELECT comment_id, comments.film_id, comment, created_at, comments.user_id, 
        users.first_name,
        userRoles.user_id
        FROM comments as comments 
        JOIN users as users ON users.id = comments.user_id
        LEFT JOIN user_roles as userRoles ON comments.user_id = userRoles.user_id
        WHERE comments.film_id=$movieId
        ORDER BY created_at DESC LIMIT 0, 10");

        $hasComments = $responseComments->rowCount() > 0;

        if ($hasComments) { ?>

            <ul class="list-group ul-comments mt-4 px-4 mx-auto">

                <li class="list-group-item comment-list mb-3">
                    <p>
                        <label>
                            <strong>Comments</strong>
                        </label>
                    </p>
                </li>

                <?php
                while ($data = $responseComments->fetch()) {
                    $comment = $data['comment'];
                    $createdDate = date_create($data['created_at']);
                    $date = date_format($createdDate, 'jS F Y');
                    $firstName = $data['first_name'];
                    $commentId = $data['comment_id'];
                    $commentUserId = $data['user_id'];

                ?>
                    <li class="list-group-item comment-list comment-name">
                        <b><?php echo $firstName ?> </b>commented
                        <i class="comment-date"> * <?php echo $date ?></i>

                        <?php
                        $isOwnComment = $isUserLogged && $commentUserId == $user->id;
                        $canDeleteComment = $isUserLogged && ($canUserDeleteComment || $isOwnComment);

                        if ($canDeleteComment) {
                        ?>
                            <a href="moviedetail.php?movieId=<?php echo $movieId ?>&commentId=<?php echo $commentId ?>">
                                <i class='fa fa-trash fs-6 delete-icon'></i>
                            </a>
                        <?php
                        }
                        ?>

                    </li>

                    <li class="list-group-item comment-list fs-6 mb-3">
                        <?php echo $comment ?>
                        <hr>
                    </li>
                <?php
                }
                $responseComments->closeCursor();
                ?>
            </ul>
        <?php } ?>
    </div>

    <?php include 'footer.php'; ?>
</body>

</html>
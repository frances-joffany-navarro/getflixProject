<?php include "DB/DBConnection.php"; ?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="css/style.css">

<header class="mb-5">
  <nav class="navbar navbar-expand-lg fixed-top mb-3">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php"><img src="images/logoGetFlix.png" alt="GetFlix Logo"></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="index.php">Home</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Movies by Genre
            </a>
            <ul tabindex="0" id="dropdown" class="dropdown-menu pre-scrollable" aria-labelledby="navbarDropdown">
              <?php
              $sql = "SELECT category_name FROM `category`";
              $answer = $dbConnection->query($sql);
              //display all movies
              while ($row = $answer->fetch(PDO::FETCH_OBJ)) {
                echo "<li><a class=dropdown-item href=index.php?category=" . $row->category_name . ">" . $row->category_name . "</a></li>";
              } ?>
            </ul>
          </li>
        </ul>
        <form class="d-flex my-2 " id="searchBar">
          <input class="form-control me-2" type="search" autocomplete="on" name="search" id="myInput" value="<?php echo !empty($_GET['search']) ? $_GET['search'] : NULL; ?>" placeholder="Search title/category" aria-label="Recipient's username">
          <button class="btn btn-outline-success me-md-2" type="button" name="search" id="button-addon2">Search</button>
        </form>
        <!-- Start of Linking of pages -->
        <ul class="navbar-nav mb-lg-0">
          <?php
          if (!isset($_SESSION['user'])) { ?>
            <div class="d-grid" id="accountButton">
              <button type="submit" class="btn btn-primary"><a href="indexBis.php" style="color:white;text-decoration:none;">Sign in</a></button>
            </div>
          <?php
          } else {
            $user = $_SESSION['user'];
          ?>
            <li class="nav-item">
              <div class="d-grid dropdown">
                <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                  <?php echo "$user->firstName $user->lastName"; ?>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                  <li><a class="dropdown-item" href="newLanding.php">Profile</a></li>
                  <li>
                    <hr class="dropdown-divider">
                  </li>
                  <li><a class="dropdown-item" href="deconnexion.php">Signout</a></li>
                </ul>
              </div>
            </li>
          <?php } ?>
          <!-- End of Linking of pages -->
      </div>
    </div>
  </nav>
</header>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
<script src="js\searchInput.js"></script>
<script src="js\scriptSearchFilter.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
<?php include "DB/DBConnection.php";?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
<link rel="stylesheet" href="css/style2.css">

<header>
    <p><img src="images/logoGetFlix.png" alt="GetFlix Logo"></p>
            <div class="topnav">
                    <a class="active" href="#home">Home</a>
                    <a href="#movies">Movies</a>
                    <a href="#series">Series</a>
                    <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Movies by Genre
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
             <?php
          $sql = "SELECT category_name FROM `category`";
          $answer = $dbConnection->query($sql);
    //display all movies
    while($row = $answer->fetch(PDO::FETCH_OBJ)){
        echo    "<li><a class=dropdown-item href=finalIndex.php?category=".$row->category_name.">".$row->category_name."</a></li>";}?>
          </ul>
        </li>
        <div class="col-auto" id="accountButton">
                          <button type="submit" class="btn btn-primary mb-3"><a href="profil.php" style="color:white;text-decoration:none;">Your Account</a></button>

        </div>
                    <div class="input-group mb-3" id="searchBar">
                    <input type="text" id="myInput" value="<?php echo !empty($_GET['search']) ? $_GET['search'] : NULL;?>" class="form-control" placeholder="Title/category" aria-label="Recipient's username" aria-describedby="button-addon2">
                        <button class="btn btn-outline-secondary" type="button" name="submit" id="button-addon2">Search</button>
                      </div>
                       
                    
            </div>
        </header>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
<script src="js\searchInput.js"></script>
<script src="js\scriptSearchFilter.js"></script>

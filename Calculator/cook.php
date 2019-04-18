<!DOCTYPE html>

<?php require_once('../inc/header.php');
$username = 'root';
$password = 'root';
$db = 'bdowolf_database';
$host = 'localhost';
$port = 8890;

$mysqli = new mysqli("localhost", "root", "root", "bdowolf_database", 8890);
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;

}
  $query = "SELECT  name FROM items";

  if ($result = $mysqli->query($query)) {

      /* fetch associative array */
      while ($row = $result->fetch_assoc()) {
           echo "<h1>" .$row["name"]. "</h1>";
      }

      /* free result set */
      $result->free();
  }

  /* close connection */
  $mysqli->close();


?>


  <body>
    <?php require_once('../inc/navigation.php');?>


    <div id="calc_jum" class="jumbotron ">
      <h1 class="display-4 text-center">Cook Calculator</h1>
      <p class="h5 text-center">What are you looking to cook?</p>

      <div id="calc_search_bar" class="col-md-8">
      <div class="input-group mt-5">
        <input type="text" class="form-control" placeholder="Search" aria-label="cook search" aria-describedby="basic-addon2">
        <div class="input-group-append">
          <button class="btn btn-outline-secondary" type="button">
            <i class="fa fa-search"></i>
          </button>
        </div>
      </div>
      </div>
    </div>





    <div id="main_content" class="container-fluid bg-dark">

      <table class="table table-bordered text-center bg-light">
        <thead>
          <tr>
            <th scope="col col-4">#</th>
            <th scope="col col-4">Name</th>
            <th scope="col col-4">Materials</th>
          </tr>
        </thead>
        <tbody>
          <tr>
        </tbody>
      </table>

    </div>





    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="../js/app.js"></script>

  </body>
</html>

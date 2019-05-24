<!DOCTYPE html>

<?php require_once('../inc/header.php');

if(isset($_GET['id'])){
  include 'connectToDatabase.php';
  $ID = mysqli_real_escape_string($conn, $_GET['id']);

  $sql = "SELECT * FROM processing_recipes_table WHERE recipe_id = '$ID' ";
  $result = mysqli_query($conn, $sql) or die("Bad Query: $sql");
  $row = mysqli_fetch_array($result);
  $test = $row['sub_materials_id'];
  $subSql = "SELECT * FROM processing_sub_materials_table S, processing_recipes_table R
 WHERE S.sub_materials_id = $test";
 $numOfNotNull = "SELECT SUM(IF(material2_quantity IS NOT NULL, 1, 0)) AS count FROM processing_sub_materials_table";
  $subResult = mysqli_query($conn, $subSql) or die("Bad Query: $subSql");
  $subRow = mysqli_fetch_array($subResult);

}else{
  header('Location: process.php');
}

?>


  <body>
    <?php require_once('../inc/navigation.php');?>


    <div class="jumbotron ">
      <h1 class="display-4 text-center"><?php echo $row['recipe_name']  ?></h1>
      <div id="recipeImage"><?php echo '<img src="' .$row['recipe_image']. '" class="rounded mx-auto d-block" height="50" >' ?></div>

      <div id="recipe_materials" class="container-fluid">
        <table class="table table-bordered text-center bg-light">
          <tbody>
            <tr>
              <td id="imageRow"><?php   ?></td>
              <td><?php echo SUM  ?></td>
              <td id="quantityRow"><?php ?></td>
            </tr>
          </tbody>
        </table>

      </div>
    </div>





    <div id="main_content" class="container-fluid bg-dark">
      <table class="table table-bordered text-center bg-light">
        <thead>
          <tr>
            <th scope="col col-4">Image</th>
            <th scope="col col-4">Name</th>
          </tr>
        </thead>
        <tbody>



        </tbody>
      </table>

    </div>





    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="../js/app.js"></script>

  </body>
</html>

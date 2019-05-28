<!DOCTYPE html>

<?php require_once('../inc/header.php');
  require ('../inc/connectToDatabase.php');
if(isset($_GET['id'])){
  $ID = mysqli_real_escape_string($conn, $_GET['id']);

  $sql = "SELECT * FROM cooking_recipes_table WHERE recipe_id = '$ID' ";
  $result = mysqli_query($conn, $sql) or die("Bad Query: $sql");
  $row = mysqli_fetch_array($result);
  $subID = $row['sub_materials_id'];


  $subSql = "SELECT material1_quantity,
  material1_id,
  material2_quantity,
  material2_id,
  material3_quantity,
  material3_id,
  material4_quantity,
  material4_id,
  material5_quantity,
  material5_id
  FROM cooking_sub_materials_table
  WHERE sub_materials_id = $subID";
$subResult = mysqli_query($conn, $subSql) or die("Bad Query: $subSql");
$subRow = mysqli_fetch_array($subResult);

$nullSql = "SELECT
  ((CASE WHEN material1_quantity IS NOT NULL THEN 1 ELSE 0 END)
  + (CASE WHEN material1_id IS NOT NULL THEN 1 ELSE 0 END)
  + (CASE WHEN material2_quantity IS NOT NULL THEN 1 ELSE 0 END)
  + (CASE WHEN material2_id IS NOT NULL THEN 1 ELSE 0 END)
  + (CASE WHEN material3_quantity IS NOT NULL THEN 1 ELSE 0 END)
  + (CASE WHEN material3_id IS NOT NULL THEN 1 ELSE 0 END)
  + (CASE WHEN material4_quantity IS NOT NULL THEN 1 ELSE 0 END)
  + (CASE WHEN material4_id IS NOT NULL THEN 1 ELSE 0 END)
  + (CASE WHEN material5_quantity IS NOT NULL THEN 1 ELSE 0 END)
  + (CASE WHEN material5_id IS NOT NULL THEN 1 ELSE 0 END)) AS sum_of_nulls
FROM cooking_sub_materials_table
  WHERE sub_materials_id = $subID";
  $nullResult = mysqli_query($conn, $nullSql) or die("Bad Query: $nullSql");
  $nullRow = mysqli_fetch_array($nullResult);


   function getMaterialID($sent_material_id, $connection){

    $materialSql = "SELECT * FROM materials_table WHERE material_id = $sent_material_id";
    $materialResult = mysqli_query($connection, $materialSql) or die("Bad Query: $materialSql");
    $materialRow = mysqli_fetch_array($materialResult);
    return $materialRow['material_name'];
   }
   function getMaterialImage($sent_material_id, $connection){

    $materialSql = "SELECT * FROM materials_table WHERE material_id = $sent_material_id";
    $materialResult = mysqli_query($connection, $materialSql) or die("Bad Query: $materialSql");
    $materialRow = mysqli_fetch_array($materialResult);
    return $materialRow['material_image'];
   }


}else{
  header('Location: process.php');
}

?>


  <body>
    <?php require_once('../inc/navigation.php');?>
    <div id="proc_rates" class="container-fluid bg-dark">
      <div id="proc_rates_row" class="row">
        <div id="craft_quantity" class"col-sm-4">
          <div class="d-inline-block">
            <p>Craft Quantity:</p>
          </div>
          <div class="d-inline-block">
            <input type="number" name="quantity" min="1" max="999999" value="1">
          </div>
        </div>
      <div id="tier1_proc" class"col-sm-4">
        <div class="d-inline-block">
          <p>Tier 1 Proc Rate:</p>
        </div>
        <div class="d-inline-block">
          <input type="number" name="quantity" min="1" max="999999" value="2.5" step="0.1">
        </div>

    </div>
      <!-- <div id="tier2_proc" class"col-sm-4">
        <div class="d-inline-block">
          <p>Tier 2 Proc Rate:</p>
        </div>
        <div class="d-inline-block">
          <input type="number" name="quantity" min="0" max="999999" value="0.05">
        </div>
    </div> -->

    </div>
  </div>

    <div class="jumbotron ">
      <h1 class="display-4 text-center"><?php echo $row['recipe_name']  ?></h1>
      <div id="recipeImage"><?php echo '<img src="' .$row['recipe_image']. '" class="rounded mx-auto d-block" height="50" >' ?></div>

      <div id="recipe_materials" class="container-fluid">
        <table class="table table-borderless text-center">
          <tbody>
            <?php

            for ($x = 0; $x < $nullRow['sum_of_nulls']; $x+=2) {

              $y = $x +1;
                echo '<tr>
                <td><img src="'
                .getMaterialImage($subRow[$y], $conn).
                '"  height="30"></td><td>'
                .getMaterialID($subRow[$y], $conn).
                '</td><td>'
                .$subRow[$x].
                '</td>
                </tr>';
            //echo getMaterialID($subRow[1]);


          //  <tr>
            //echo   "<td id="imageRow">  </td>"
            //   <td></td>
            //   <td id="quantityRow"></td>
        //  </tr>
  }
            ?>

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





    <script  src="https://code.jquery.com/jquery-3.4.1.js"  integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="../js/detailsScript.js"></script>

  </body>
</html>

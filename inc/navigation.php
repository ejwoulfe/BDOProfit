<?php
include 'connectToDatabase.php';
if(isset($_POST['nav_search_button'])){
  $nav_search_value=$_POST['nav_search_bar'];
  $nav_sql_query = "SELECT recipe_id, recipe_name, 'cooking_recipes_table' AS table_name FROM cooking_recipes_table WHERE recipe_name LIKE '$nav_search_value'
  UNION
  SELECT recipe_id, recipe_name, 'alchemy_recipes_table' AS table_name FROM alchemy_recipes_table WHERE recipe_name LIKE '$nav_search_value'
  UNION
  SELECT recipe_id, recipe_name, 'processing_recipes_table' AS table_name FROM processing_recipes_table WHERE recipe_name LIKE '$nav_search_value'";
  $nav_result = mysqli_query($conn, $nav_sql_query);
  while ($nav_row = mysqli_fetch_assoc($nav_result)) {
    if($nav_row['table_name']=='cooking_recipes_table'){
      header('Location: ../Calculator/cookingDetails.php?id=' .$nav_row['recipe_id']);
    }else if($nav_row['table_name']=='processing_recipes_table'){
      header('Location: ../Calculator/processingDetails.php?id=' .$nav_row['recipe_id']);
    }else if($nav_row['table_name']=='alchemy_recipes_table'){
      header('Location: ../Calculator/alchemyDetails.php?id=' .$nav_row['recipe_id']);
    }
  }
}
?>
<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg">
  <div id="navigation" class="container-fluid">
    
    
    <div id="logo" class="col-2" >
      <a class="navbar-brand" href="../index.php">BDOWolf</a>
    </div>
    
    
    <div class="col-6 mt-4 mb-4">
      <form class="form-inline" action="" method="POST">
        <div id="nav_form" class="input-group mb-3">
          <input name="nav_search_bar" type="text" class="form-control" placeholder="Find Recipe" aria-label="cook search" aria-describedby="basic-addon2">
          <div class="input-group-append">
            <button class="btn btn-outline-secondary" type="submit" name="nav_search_button">
              <i class="fa fa-search"></i>
            </button>
          </div>
        </div>
      </form>
    </div>
    
    
    
    <div id="test_container"  class="col-sm-4 ml-auto pr-0">
      <button id="collapse_button" class="navbar-toggler mb-2 float-right" type="button" data-toggle="collapse" data-target="#navbarList" aria-controls="navbarList" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fa fa-bars mt-2" style="color: white"></i>
      </button>
      <div  id="collapse_list_container"class="float-right">
        <div class="collapse navbar-collapse flex-grow-0 text-right flex-wrap ml-auto" id="navbarList">
          <ul id="ul_container" class="navbar-nav ml-auto">
            <li class="nav-item">
              <a id="cooking_button" class="nav-link" href="../Calculator/cook.php">Cooking</a>
            </li>
            <li class="nav-item">
              <a id="processing_button" class="nav-link"href="../Calculator/process.php">Processing</a>
            </li>
            <li class="nav-item">
              <a id="alchemy_button"  class="nav-link"href="../Calculator/alchemy.php">Alchemy</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</nav>
<!-- Navigation Bar End -->

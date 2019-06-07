<?php
if(isset($_POST['recipe_name'])){
  require '../connectToDatabase.php';
  $recipesPerPage = 100;
  $search_value = trim($_POST['recipe_name']);
  $search_value_filter = filter_var($search_value, FILTER_SANITIZE_STRING);
  $page = $_POST['page'] - 1;
  $firstLimit = ($page * $recipesPerPage);
  
  $pages_query = "SELECT * FROM alchemy_recipes_table WHERE recipe_name LIKE '%{$search_value_filter}%'";
  $pages_result = mysqli_query($conn, $pages_query);
  $totalRecipes=mysqli_num_rows($pages_result);
  $totalPages= ceil($totalRecipes/$recipesPerPage);
  

  function paginationDiv($totalPages){
  for($i = 1; $i <= $totalPages; $i++){
    
    $output .= "<span class='pagination_link' style='cursor:pointer;' id='" .$i. "'>" .$i."</span>";
  }
  return '<div id="pagination_controls" ">' .$output. '</div>';
}


function tbodyDiv($search_value_filter, $firstLimit, $recipesPerPage, $conn){
  // echo '<tbody id="calculator_tbody">';
  $sql_query = "SELECT * FROM alchemy_recipes_table WHERE recipe_name LIKE '%{$search_value_filter}%' LIMIT $firstLimit, $recipesPerPage";
    $result = mysqli_query($conn, $sql_query);
    while ($row = mysqli_fetch_assoc($result)) {

      
      $trOutput .= '<tr><td style="width: 10%" class="img_row"><img src="' .$row["recipe_image"]. '" height="30" ></td>' .
      "<td><div class='overlay'><a class='name_row' href='alchemyDetails.php?id={$row['recipe_id']}'>" .$row["recipe_name"]. "</div></td></tr>";
  
  }
  return '<tbody id="calculator_tbody" class="rounded">' .$trOutput. '</tbody>';
  // echo '</tbody>';
}
function createTableBody(){
    
  return '<table id="calculator_table" class="table table-borderless text-center">';
}


  if($totalRecipes == 0){
    echo '<h5 style="color: #FA7D10">No Results for ' .$search_value_filter. '</h5>';
  }
  echo paginationDiv($totalPages);
  echo createTableBody();
  echo tbodyDiv($search_value_filter, $firstLimit, $recipesPerPage, $conn);

  
}

?>

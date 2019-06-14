<?php
if(isset($_POST['recipe_name'])){
  // Connect to database.
  require '../../../Includes/connectToDatabase.php';
  
  // At most we only want to display 100 recipes at a time to help optimization.
  $recipesPerPage = 100;
  
  // Assign the searched term to a variable, trim it and filter it.
  $search_value = trim($_POST['recipe_name']);
  $search_value_filter = filter_var($search_value, FILTER_SANITIZE_STRING);
  
  // The page variable will be used for gathering the correct row in MYSQL database. -1 from the incoming page to get the first LIMIT number for our query.
  $page = $_POST['page'] - 1;
  $firstLimit = ($page * $recipesPerPage);
  $currentPage = $page + 1;
  
  // Get all the data from the table, based on the search term.
  $pages_query = "SELECT * FROM alchemy_recipes_table WHERE recipe_name LIKE '%{$search_value_filter}%'";
  $pages_result = mysqli_query($conn, $pages_query);
  $totalRecipes=mysqli_num_rows($pages_result);
  // Get the number of total pages that will be needed for our pagination, always round up.
  $totalPages= ceil($totalRecipes/$recipesPerPage);
  
  
  // Function that will dynamically create the first (top of table) pagionation tabs.
  function firstPaginationDiv($totalPages, $currentPage){
    // If statement to check the number of total pages, if it's more than 1.  We will need pagination. Else, we do not.
    if($totalPages>1){
      for($i = 1; $i <= $totalPages; $i++){
        // Add some css to let the user know which page they are on.
        if($i == $currentPage){
          $output .= "<span class='pagination_link' style='cursor:pointer; color: #FA7D10; background-color: #282726; bottom: -10px;' id='" .$i. "'>" .$i."</span>";
        }else{
          $output .= "<span class='pagination_link' style='cursor:pointer;' id='" .$i. "'>" .$i."</span>";
        } // End else
      } // End nested if
    } // End if
    // Return the whole HTML of the pagination control, with the correct amount of tabs needed that are within the $output variable.
    return '<div id="pagination_controls" ">' .$output. '</div>';
  }
  
  // Function that will dynamically create the second (bottom of the table) pagination tabs.
  function secondPaginationDiv($totalPages, $currentPage){
    if($totalPages>1){
      for($i = 1; $i <= $totalPages; $i++){
        // Add some css to let the user know which page they are on.
        if($i == $currentPage){
          $output .= "<span class='second_pagination_link' style='cursor:pointer; color: #FA7D10; background-color: #282726; position: relative; padding-top: 3px; border-radius: 0px 0px 10px 10px; top: 8.5px;' id='" .$i. "'>" .$i."</span>";
        }else{
          $output .= "<span class='second_pagination_link' style='cursor:pointer;' id='" .$i. "'>" .$i."</span>";
        } // End else
      } // End nested if
    } // End if
    // Return the whole HTML of the pagination control, with the correct amount of tabs needed that are within the $output variable.
    return '<div id="pagination_controls_2" ">' .$output. '</div>';
  }
  
  
  
  
  /* Function that will dynamically create the content inside the table body that holds the results of the MYSQL query.
  * The parameters being sent in will be the user's defined search term,
  * the first and second breakpoints for the LIMIT needed for the query, and the database connection.
  */
  function tbodyDiv($search_value_filter, $firstLimit, $recipesPerPage, $conn){
    // Query to grab all the required fields.
    $sql_query = "SELECT * FROM alchemy_recipes_table WHERE recipe_name LIKE '%{$search_value_filter}%' LIMIT $firstLimit, $recipesPerPage";
    $result = mysqli_query($conn, $sql_query);
    while ($row = mysqli_fetch_assoc($result)) {
      // Variable that will hold the dynamically made html, in this case it will be each row of the table body.
      $trOutput .= '<tr><td style="width: 10%" class="img_row"><img src="../' .$row["recipe_image"]. '" height="30" ></td>' .
      "<td><div class='overlay'><a class='name_row' href='../../Calculator/Recipe Page/alchemy_recipe.php?id={$row['recipe_id']}'>" .$row["recipe_name"]. "</div></td></tr>";
      
    }
    // Return the HTML of the contents that will be placed inside the table body.
    return '<tbody id="calculator_tbody" class="rounded">' .$trOutput. '</tbody></table>';
  }
  
  // Function that creates the table body in HTML.
  function createTableBody(){
    
    return '<table id="calculator_table" class="table table-borderless text-center">';
  }
  
  // If statement to check if the results of  the query are 0, if so then no recipes are found. Display it to the user in HTML.
  if($totalRecipes == 0){
    echo '<h5 style="color: #FA7D10">No Results for ' .$search_value_filter. '</h5>';
  }
  // Echo all required html to the page.
  echo firstPaginationDiv($totalPages, $currentPage);
  echo createTableBody();
  echo tbodyDiv($search_value_filter, $firstLimit, $recipesPerPage, $conn);
  
  // If statement forthe second  pagination, we will only need the bottom pagination if there are more than  60 recipe items displayed on the current page.
  if($totalRecipes > 60){
    echo secondPaginationDiv($totalPages, $currentPage);
  } // End if
}

?>

<?php
include('connectToDatabase.php');
if(isset($_POST['q'])){
  // Trim and filer the incoming query.
  $nav_search_value = trim($_POST['q']);
  $nav_search_value_filter = filter_var($nav_search_value, FILTER_SANITIZE_STRING);

  /* Query to search all three recipe databases for the current user's search value.
  * If we find something, grab the IDs, names, and images of that recipe.
  * Also, we need to know which recipe table its coming from so if the user clicks on the link,
  * it will take them to the appropriate recipe calculator page.
  */
  $nav_sql_query = "SELECT recipe_id, recipe_name, recipe_image, 'cooking_recipes_table' AS  table_name FROM cooking_recipes_table WHERE recipe_name LIKE '%{$nav_search_value}%'
  UNION
  SELECT recipe_id, recipe_name, recipe_image, 'alchemy_recipes_table' AS  table_name FROM alchemy_recipes_table WHERE recipe_name LIKE '%{$nav_search_value}%'
  UNION
  SELECT recipe_id, recipe_name, recipe_image, 'processing_recipes_table' AS  table_name FROM processing_recipes_table WHERE recipe_name LIKE '%{$nav_search_value}%'";

  $nav_result = mysqli_query($conn, $nav_sql_query);

  // On succesful search, display the recipes image, name, and provide a link that on click, will take them tothe recipes page for calculations.
  if(mysqli_num_rows($nav_result) > 0){
  while ($nav_row = mysqli_fetch_assoc($nav_result)) {$nav_row['table_name'];
    // We do several if statements check which table the recipe is coming from so we can provide the correct php page.
    if($nav_row['table_name']=='cooking_recipes_table'){
    $output .= '<li class="list_item"><span class="dropdown_list_overlay"><img src="../' .$nav_row['recipe_image']. '" height="30" >' . "<a href='/Calculator/Recipe Page/cooking_recipe.php?id={$nav_row['recipe_id']}'>" .$nav_row["recipe_name"]. "</a></span></li>";
  }else if($nav_row['table_name']=='alchemy_recipes_table'){
    $output .= '<li class="list_item"><span class="dropdown_list_overlay"><img src="../' .$nav_row['recipe_image']. '" height="30" >' . "<a href='/Calculator/Recipe Page/alchemy_recipe.php?id={$nav_row['recipe_id']}'>" .$nav_row["recipe_name"]. "</a></span></li>";
  }else if($nav_row['table_name']=='processing_recipes_table'){
    $output .= '<li class="list_item"><span class="dropdown_list_overlay"><img src="../' .$nav_row['recipe_image']. '" height="30" >' . "<a href='/Calculator/Recipe Page/processing_recipe.php?id={$nav_row['recipe_id']}'>" .$nav_row["recipe_name"]. "</a></span></li>";
  }
  }
}else{
  // If not recipes are found, display a message.
    $output .= '<p> Recipe Not Found </p>';
}
echo $output;
}
?>

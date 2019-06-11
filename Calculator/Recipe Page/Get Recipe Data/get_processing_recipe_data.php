<?php
if(isset($_GET['id'])){
  $ID = mysqli_real_escape_string($conn, $_GET['id']);

  $sql = "SELECT * FROM processing_recipes_table WHERE recipe_id = '$ID' ";
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
  material5_id,
  rewards_id
  FROM processing_sub_materials_table
  WHERE sub_materials_id = $subID";
  $subResult = mysqli_query($conn, $subSql) or die("Bad Query: $subSql");
  $subRow = mysqli_fetch_array($subResult);

  $rewardID = $subRow['rewards_id'];
  $rewardSql = "SELECT material1_quantity,
  material1_id,
  material2_quantity,
  material2_id
  FROM processing_rewards_table
  WHERE reward_id = $rewardID";
  $rewardResult = mysqli_query($conn, $rewardSql) or die("Bad Query: $rewardSql");
  $rewardRow = mysqli_fetch_array($rewardResult);
  $rewardAmountSql = "SELECT
  ((CASE WHEN material1_quantity IS NOT NULL THEN 1 ELSE 0 END)
  + (CASE WHEN material1_id IS NOT NULL THEN 1 ELSE 0 END)
  + (CASE WHEN material2_quantity IS NOT NULL THEN 1 ELSE 0 END)
  + (CASE WHEN material2_id IS NOT NULL THEN 1 ELSE 0 END)) AS sum_of_rewards
  FROM processing_rewards_table
  WHERE reward_id = $rewardID";

  $rewardAmountResult = mysqli_query($conn, $rewardAmountSql) or die("Bad Query: $rewardAmountSql");
  $rewardAmountRow = mysqli_fetch_array($rewardAmountResult);

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
  FROM processing_sub_materials_table
  WHERE sub_materials_id = $subID";
  $nullResult = mysqli_query($conn, $nullSql) or die("Bad Query: $nullSql");
  $nullRow = mysqli_fetch_array($nullResult);


  function getMaterialID($sent_material_id, $connection){

    $materialSql = "SELECT material_name FROM materials_table WHERE material_id = $sent_material_id";
    $materialResult = mysqli_query($connection, $materialSql) or die("Bad Query: $materialSql");
    $materialRow = mysqli_fetch_array($materialResult);
    return $materialRow['material_name'];
  }
  function getMaterialImage($sent_material_id, $connection){

    $materialSql = "SELECT material_image FROM materials_table WHERE material_id = $sent_material_id";
    $materialResult = mysqli_query($connection, $materialSql) or die("Bad Query: $materialSql");
    $materialRow = mysqli_fetch_array($materialResult);
    return $materialRow['material_image'];
  }
}

?>
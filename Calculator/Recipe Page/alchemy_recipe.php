<!DOCTYPE html>

<?php require '../../Includes/header.php';
require '../../Includes/connectToDatabase.php';
require ('Get Recipe Data/get_alchemy_recipe_data.php');
?>
<body>
  <?php require '../../Includes/navigation.php';?>

  <!-- Container for Craft Quantity, Tier 1 Proc Rate (2.5),and Tier 3 Proc Rate (0.3) -->
  <div id="proc_rates" class="container-fluid bg-dark">
    <!-- Row -->
    <div id="proc_rates_row" class="row">

      <!-- Craft Quantity Container -->
      <div id="craft_quantity" class"col-sm-4">
        <div class="d-inline-block">
          <p>Craft Quantity:</p>
        </div>
        <div class="d-inline-block">
          <input id="craft_quantity_input" class="test" type="number" min="1" max="999999" value="1" data-toggle="tooltip" data-placement="bottom" title="Enter a number from 0 to 999,999">
        </div>
      </div>

      <!-- Tier 1 Proc Container -->
      <div id="tier1_proc" class"col-sm-4">
        <div class="d-inline-block">
          <p>Tier 1 Proc Rate:</p>
        </div>
        <div class="d-inline-block">
          <p id="tier1_proc_rate">2.5</p>
        </div>
      </div>

      <!-- Tier 2 Proc Container -->
      <div id="tier2_proc" class"col-sm-4">
        <div class="d-inline-block">
          <p>Tier 2 Proc Rate:</p>
        </div>
        <div class="d-inline-block">
          <p id="tier2_proc_rate">0.3</p>
        </div>
      </div>

    </div>
  </div>

  <!-- Jumbotron -->
  <div id="details_jum" class="jumbotron">
    <!-- Title of Recipe -->
    <h1 class="display-4 text-center">
      <?php echo $row['recipe_name']  ?>
    </h1>
    <!-- Image of Recipe -->
    <div id="recipeImage">
      <?php echo '<img src="../' .$row['recipe_image']. '" class="rounded mx-auto d-block" height="50" >' ?>
    </div>
    <!-- Row for the recipe sub materials -->
    <div class="row">
      <div id="recipe_materials" class="flex_table container-fluid col-lg-6">
        <table class="table table-borderless text-center">
          <tbody>
            <!-- PHP to display the recipes sub material image, name, and the quantity. -->
            <?php
            for ($x = 0; $x < $nullRow['sum_of_sub_materials']; $x+=2) {
              $y = $x +1;
              echo '<tr>
              <td class="text-center"><img src="../'
              .getMaterialImage($subRow[$y], $conn).
              '"  height="30"></td"><td id="material_name" >'
              .getMaterialName($subRow[$y], $conn).
              '</td><td id="recipe_quantity" class="quantity text-right">'
              .$subRow[$x].
              '</td>
              </tr>';
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Container for the Calculations -->
  <div id="calculations_container" class="container-fluid bg-dark">
    <!-- Row for both tables -->
    <div class="row">
      <!-- Column for the costs table -->
      <div id="costs_col" class="col-lg-6">
        <div id="costs_table_container">
          <div class="title_container text-center">
            <h5 class="table_title">Materials Costs</h5>
          </div>
          <!-- Table for the sub materials costs -->
          <table id="costs_table" class="table table-borderless">
            <thead>
              <th class="image_head col-1">

              </th>
              <th class="text-center col-2">
                Material
              </th>
              <th class="text-left col-3">
                Cost Per
              </th>
              <th class="text-center col-2">
                Quantity
              </th>
              <th id="total_cost_head" class="text-center col-4">
                Total Cost
              </th>
            </thead>
            <tbody>
              <!-- For loop to iterate through the total amount of sub materials and make a row containing the materials image, cost, their quantity, and a calculated total cost. -->
              <?php
              $count = 1;
              for ($x = 0; $x < $nullRow['sum_of_sub_materials']; $x+=2) {
                $strCount = strval($count);
                $cost_row = "row_" . $strCount;
                $cost_field = "cost_input_row_" . $strCount;
                $cost_quantity = "cost_quantity_row_" . $strCount;
                $total_cost = "total_cost_row_" . $strCount;
                $y = $x +1;
                echo '<tr id="' . $cost_row .   '">
                <td class="image_row text-center col-1"><img src="../'
                .getMaterialImage($subRow[$y], $conn).
                '"  height="30"></td><td class="text-center col-2">'
                .getMaterialName($subRow[$y], $conn).
                '</td><td class="align-middle col-3">
                <input id="' . $cost_field .   '" type="number" min="1" max="9999999999" value="" data-toggle="tooltip" data-placement="bottom" title="Enter a number from 0 to 99,999,999,999">
                </td><td id="' . $cost_quantity .   '" class="quantity text-center col-2">'
                .$subRow[$x].
                '</td>
                <td id="' . $total_cost .   '" class="text-right col-4")">0</td>
                </tr>';
                $count+=1;
              }
              ?>
              <!-- Final row for that accumulated total costs of all rows -->
              <tr id="recipe_total_cost_row">
                <td class="image_row align-middle text-center col-1">
                </td>
                <td id="total_cost_text" class="align-middle text-right col-3">
                  Materials Total Cost:
                </td>
                <td class="align-middle text-left col-2">
                </td>
                <td class="align-middle col-1">
                </td>
                <td id="total_recipe_cost" class="text-right col-4">
                  0
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="table_bottom">
        </div>
      </div>
      <!-- End Column for Costs Table -->

      <!-- Column for the Profits table -->
      <div id="profits_col" class="col-lg-6">
        <div id="profits_table_container">
          <div class="title_container">
            <h5 class="table_title text-center">Profits</h5>
          </div>
          <!-- Table for the sub materials profits -->
          <table id="profits_table" class="table table-borderless">
            <thead>
              <th class="image_head text-center col-1">
              </th>
              <th class="text-center col-2">
                Quantity
              </th>
              <th class="text-left col-2">
                Reward
              </th>
              <th class="text-left col-3">
                MP Price
              </th>
              <th id="total_cost_head" class="text-center col-4">
                Profit
              </th>
            </thead>
            <tbody>
              <!-- For loop to iterate through the total amount of sub materials and make a row containing the materials image, cost, their quantity, and a calculated total cost. -->
              <?php
              $count = 1;
              for ($i = 0; $i < $rewardAmountRow['sum_of_rewards']; $i+=2) {
                $strCount = strval($count);
                $profit_row = "row_" . $strCount;
                $profit_field = "profit_input_row_" . $strCount;
                $profit_quantity = "profit_quantity_row_" . $strCount;
                $total_profit = "total_profit_row_" . $strCount;
                $y = $i +1;
                echo '<tr id="' . $profit_row .   '">
                <td class="image_row align-middle text-center col-1"><img src="../'
                .getMaterialImage($rewardRow[$y], $conn).
                '"  height="30"></td>
                <td id="' . $profit_quantity .   '" class="reward_quantity text-center col-2")">0</td>
                <td class="align-middle text-left col-2">'
                .getMaterialName($rewardRow[$y], $conn).
                '</td><td class="align-middle col-3">
                <input id="' . $profit_field .   '" type="number" min="1" max="9999999999" value="" data-toggle="tooltip" data-placement="bottom" title="Enter a number from 0 to 99,999,999,999">
                </td>
                <td id="' . $total_profit .   '" class="text-right col-4")">0</td>';
                $count+=1;
              }
              ?>
              <!-- Final row for that accumulated total profits of all rows -->
              <tr>
                <td class="image_row col-1">
                </td>
                <td id="total_profit_text" class="align-middle text-right col-3">
                  Recipe Total Profit:
                </td>
                <td class="col-2">
                </td>
                <td class="col-1">
                </td>
                <td id="total_recipe_profit" class="align-middle text-right col-4">
                  0
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="table_bottom">
        </div>
      </div>
      <!-- End Column for Profits Table -->


    </div>
    <!-- End of Row -->
  </div>
  <!-- End of Container -->





  <script  src="https://code.jquery.com/jquery-3.4.1.js"  integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="recipe_calculator.js"></script>


</body>
</html>

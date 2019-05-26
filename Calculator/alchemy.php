<!DOCTYPE html>

<?php require_once('../inc/header.php');?>


  <body>
    <?php require_once('../inc/navigation.php');?>


    <div id="calc_jum" class="jumbotron ">
      <h1 class="display-4 text-center">Alchemy Calculator</h1>
      <p class="h5 text-center">What are you looking to mix?</p>

      <div id="calc_search_bar" class="col-md-8">
      <!-- <div class="input-group mt-5"> -->
        <form id="searh_bar_and_button" action="" method="POST">
        <input name="searchBar" type="text" class="form-control" placeholder="Search" aria-label="cook search" aria-describedby="basic-addon2">
        <div class="input-group-btn">
          <button class="btn btn-outline-secondary" type="submit" name="searchButton">
            <i class="fa fa-search"></i>
          </button>
        </div>
      </form>
      <!-- </div> -->
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



          <?php
          include 'connectToDatabase.php';

          if(isset($_POST['searchButton'])){
          $search_value=$_POST['searchBar'];
          $sql_query = "SELECT * FROM alchemy_recipes_table WHERE recipe_name LIKE '%".$search_value."%'";
          $result = mysqli_query($conn, $sql_query);
          while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr><td><img src="' .$row['recipe_image']. '" height="30" ></td>';
            echo "<td><a href='alchemyDetails.php?id={$row['recipe_id']}'>" .$row['recipe_name']. '</td>';
          }
          if($result==false){
            echo "<td> No Items Found </td>";
          }
        }



           ?>






        </tbody>
      </table>

    </div>





    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="../js/app.js"></script>

  </body>
</html>

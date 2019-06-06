<!DOCTYPE html>

<?php require_once('../inc/header.php');?>


<body>
  <?php require_once('../inc/navigation.php');?>


  <div id="calc_jum" class="jumbotron ">
    <h1 class="display-4 text-center">Processing Calculator</h1>
    <p class="h5 text-center">What are you looking to process?</p>
    <div id="calc_search_bar" class="col-md-8">
      <form action="" class="form-inline">
        <div class="input-group mb-3">
          <input id="bar" type="text" class="form-control" placeholder="Search" aria-label="cook search" aria-describedby="basic-addon2">
          <!-- <div class="input-group-append">
            <button id="btn" class="btn btn-outline-secondary" type="submit">
              <i class="fa fa-search"></i>
            </button>
          </div> -->
        </div>
      </form>
    </div>
  </div>

  <div id="calculator_main_content" style="display:  none" class="container-fluid bg-dark">
    <table id="calculator_table" class="table table-bordered text-center">
      <thead>
        <tr>
          <th style="width:10%" scope="col col-4">Image</th>
          <th scope="col col-4">Name</th>
        </tr>
      </thead>
      <tbody id="calculator_tbody">







      </tbody>
    </table>

  </div>




  <script  src="https://code.jquery.com/jquery-3.4.1.js"  integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="../js/Calc/process_search.js"></script>
</body>
</html>

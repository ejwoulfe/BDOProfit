<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg">
  <div id="navigation" class="container-fluid">

    <!-- Logo -->
    <div id="logo" class="col-2" >
      <a class="navbar-brand" href="../../index.php">BDOWolf</a>
    </div>
    <!-- Logo End -->

    <!-- Search Bar -->
    <div class="col-6 mt-4 mb-4">
      <form class="form-inline" action="" method="POST">
        <div id="nav_form" class="input-group mb-3">
          <input id="nav_search_bar" name="nav_search_bar" type="text" class="form-control" placeholder="Find Recipe" aria-label="cook search" aria-describedby="basic-addon2">
          <div class="dropdown-menu" id="response"></div>
          <div class="input-group-append">
            <button class="btn btn-outline-secondary" type="submit" name="nav_search_button">
              <i class="fa fa-search"></i>
            </button>
          </div>
        </div>
      </form>
    </div>
    <!-- Search Bar End -->

    <!-- Link Items -->
    <div id="collapse_container"  class="col-sm-4 ml-auto pr-0">
      <button id="collapse_button" class="navbar-toggler mb-2 float-right" type="button" data-toggle="collapse" data-target="#navbarList" aria-controls="navbarList" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fa fa-bars mt-2" style="color: white"></i>
      </button>
      <div  id="collapse_list_container"class="float-right">
        <div class="collapse navbar-collapse flex-grow-0 text-right flex-wrap ml-auto" id="navbarList">
          <ul id="ul_container" class="navbar-nav ml-auto">
            <li class="nav-item">
              <a id="cooking_button" class="nav-link" a href="../../Calculator/Search Page/cooking_recipes.php">Cooking</a>
            </li>
            <li class="nav-item">
              <a id="processing_button" class="nav-link" a href="../../Calculator/Search Page/processing_recipes.php">Processing</a>
            </li>
            <li class="nav-item">
              <a id="alchemy_button"  class="nav-link" a href="../../Calculator/Search Page/alchemy_recipes.php">Alchemy</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <!-- Link Items End -->
  </div>
</nav>
<!-- Navigation Bar End -->


<!-- Scripts -->
<script  src="https://code.jquery.com/jquery-3.4.1.js"  integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
<script type="text/javascript">
$(document).ready(function() {
  /* As user types in the navigation search bar, after 3 letters we start searching our database for like recipe names.
  * We search using an ajax object to send a POST to our search php file.
  * If search is successful, display the data underneath the search bar, else  we can display an error message or hide it.
  */
  $("#nav_search_bar").keyup(function() {
    let query = $("#nav_search_bar").val();
    if(query.length > 2){
      $.ajax({
        url:'../../Includes/search.php',
        method: 'POST',
        data: {
          q: query
        },
        success: function(data){
          $('#response').html(data);
          dropDownDisplay(true);
        },
        error: function(data){
          console.log(data);
        }
    });
  }else{
    dropDownDisplay(false);
  }
  });

// Function to hide or show the drop down menu.
function dropDownDisplay(status){
  if(status===true){
    $('#response').dropdown('show')
  }else if(status === false){
    $('#response').dropdown('hide')
  }
}

// Event Handlers
$("#response").on("click", function(){
  let link = event.target.getElementsByTagName("a");
  window.location.href = (link.item(0).href);
});

/* Using bootstraps shown event, if the drop down is currently being shown
* and the user clicks anything but the dropdown,
* we can just hide the display so it isn't in their way.
*/
$('#nav_form').on('shown.bs.dropdown', function (e) {
  $('body').click(function(event) {
    dropDownDisplay(false);
});
});

});

</script>
<!-- Scripts End-->

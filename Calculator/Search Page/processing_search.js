
/* Whenever the user opens a recipe search page, it will initialize it as an "ALL" search, meaning it will show all recipes for that crafting type.
* It will start the user on page 1.
*/
document.addEventListener("DOMContentLoaded", function(){
  findRecipe(1);
});

// Event handler for the search bar
$('#bar').on('keyup', function(event){
  /* If statement to disable to enter key, this will prevent the default of refreshing the page to submit the form.
  * But since we are doing an ajax method, we will dynamically display the recipes based on the user search term.
  */
  if((event.which === 13 || event.keyCode === 13) && event.target !== ''){
    event.preventDefault();
  }
  // Every new search will start on the first page.
  delayedSearch();
  
});

// Function to add a delay to the search, to avoid too many requests coming in. It is set as 0.5 seconds, for now.
function delayedSearch() {
  let delayTimer;
  clearTimeout(delayTimer);
  delayTimer = setTimeout(function() {
    findRecipe(1);
  }, 500);
  
}

/* Function for hiding the second(bottom of the page) Pagination.
* If a table length is short enuogh, that the user doesn't need to scroll much, we don't need a second pagination option.
* Only for tables that are displaying 60 or greater items will we show the second pagination link.
*/
function hideSecondPagination(){
  let numOfTableRows = document.getElementsByTagName('tr').length;
  if(numOfTableRows < 60){
    $('.second_pagination_link').hide();
  }
}

// Function that will handle the server side POST request when the user is entering a recipe name or changing the pagination page.
function findRecipe(page){
  let recipe = document.getElementById("bar").value;
  let pageNumber = page;
  var xhr;
  if (window.XMLHttpRequest) { // Mozilla, Safari, ...
    xhr = new XMLHttpRequest();
  } else if (window.ActiveXObject) { // IE 8 and older
    xhr = new ActiveXObject("Microsoft.XMLHTTP");
  }
  // The data needed is the current recipe search term and which page the data needs to fill.
  let data = "recipe_name="+recipe+"&page="+pageNumber;
  xhr.open("POST", "Search Tables/processing_search_table.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.send(data);
  
  xhr.onreadystatechange = display_data;
  // When POST is sucessful and data is ready, we fill the table with all the related recipes based on the search term.
  function display_data() {
    if (xhr.readyState == 4) {
      if (xhr.status == 200) {
        document.getElementById("calculator_main_content").innerHTML = xhr.responseText;
        addEventListener();
        hideSecondPagination();
      } else {
        alert('There was a problem with the request.');
      }
    }
  }
}

// Function for event listeners of the pagination links.
function addEventListener(){
  $('.pagination_link').click(function(){
    let page = parseInt(event.target.innerHTML);
    findRecipe(page)
  });
  
  $('.second_pagination_link').click(function(){
    let page = parseInt(event.target.innerHTML);
    findRecipe(page);
    // When the user clicks on a page in the second pagination, we add a smooth scroll to the top of the table, so they can start from there.
    $('html').scrollTop(0);
    if (this.hash !== "") {
      // Prevent default anchor click behavior
      event.preventDefault();
      
      // Store hash
      var hash = this.hash;
      
      // Using jQuery's animate() method to add smooth page scroll
      $('html, body').animate({
        scrollTop: $('html').offset().top
      }, 0, function(){
        
        // Add hash (#) to URL when done scrolling (default click behavior)
        window.location.hash = hash;
      });
    } // End if
  });
}

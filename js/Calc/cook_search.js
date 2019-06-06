var delayTimer;
$('#bar').on('keypress', function(event){

 if((event.which === 13 || event.keyCode === 13) && event.target !== ''){
      event.preventDefault();
    }
      doSearch(event.target.value);

});


function doSearch(text) {
    clearTimeout(delayTimer);
    delayTimer = setTimeout(function() {
        findRecipe(1);
    }, 1000); // Will do the ajax stuff after 1000 ms, or 1 s

}


function findRecipe(page){
  let recipe = document.getElementById("bar").value;
  let pageNumber = page;
  var xhr;
  if (window.XMLHttpRequest) { // Mozilla, Safari, ...
    xhr = new XMLHttpRequest();
  } else if (window.ActiveXObject) { // IE 8 and older
    xhr = new ActiveXObject("Microsoft.XMLHTTP");
  }
  let data = "recipe_name="+recipe+"&page="+pageNumber;
  xhr.open("POST", "../../inc/Search/cook_search.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  console.log(data);
  xhr.send(data);

  xhr.onreadystatechange = display_data;
  	function display_data() {
  	 if (xhr.readyState == 4) {
        if (xhr.status == 200) {

         document.getElementById("calculator_tbody").innerHTML = xhr.responseText;
        } else {
          alert('There was a problem with the request.');
        }
       }
    }

}

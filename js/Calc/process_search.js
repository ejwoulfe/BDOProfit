

$('#bar').on('keydown', function(event){

    document.querySelector('#calculator_main_content').setAttribute("style", "display: block")
    if((event.which === 13 || event.keyCode === 13)){
      event.preventDefault();
    }else{
    findRecipe();
}
});

function findRecipe(){
  let recipe = document.getElementById("bar").value;
  var xhr;
  if (window.XMLHttpRequest) { // Mozilla, Safari, ...
    xhr = new XMLHttpRequest();
  } else if (window.ActiveXObject) { // IE 8 and older
    xhr = new ActiveXObject("Microsoft.XMLHTTP");
  }
  let data = "recipe_name=" + recipe;
  xhr.open("POST", "../../inc/Search/process_search.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
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

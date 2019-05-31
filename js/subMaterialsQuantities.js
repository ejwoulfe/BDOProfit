
$(document).ready(function () {

// Get all the sub materials quantities and store them into an array.
  const quantityElements = document.getElementsByClassName("quantity");
  const costQuantityElements = document.getElementsByClassName("cost_quantity");
  const quantities = [];
  for(var i=0; i<quantityElements.length; i++) {
    quantities.push(quantityElements[i].innerHTML);
  }

// Function to calculate the newly calulated quality for a specific sub material.
  function calculateNewQuantity(baseQuantity, desiredQuantity){
    let result = baseQuantity * desiredQuantity;
    return result;
  }

// Change the corresponding sub material html to the newly calulated quantity.
  function changeQuantities(craftQuantity){
    // Temp Array to hold all of the newly calculated quantities.
    let tempArr = [];
    for (var i = 0; i < quantities.length; i++) {
      tempArr.push(calculateNewQuantity(quantities[i],craftQuantity.value));
    }
    // For all the newly calculated quantites, go through and change the html of the corresponding quantity.
    for (var j = 0; j < tempArr.length; j++) {
      quantityElements[j].innerHTML = tempArr[j];
      costQuantityElements[j].innerHTML = tempArr[j];
    }
  }

// Variable to hold the value the user is entering.
  let craftQuantity = document.getElementById("craft_quantity_input");

//For every key change, apply the newly calculated quantites to the html.
  $(craftQuantity).bind('keyup input', function(){

    /* The quantity value can only be between 1 and 999999,
    * so if it's anything other than those values, don't calculate the new quantities.
    */
    if(craftQuantity.value==0 || craftQuantity.value.length==0 || craftQuantity.value<0 || craftQuantity.value>999999){
    }else{
      changeQuantities(craftQuantity);
    }

  });






});

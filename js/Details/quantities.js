$(document).ready(function () {

  // Get all the sub materials quantities and store them into an array.
  const costQuantityElements = document.getElementsByClassName("cost_quantity");
  const quantityElements = document.getElementsByClassName("quantity");

  function getSubMaterialsQuantities(){
  const quantitiesArr = [];

  for(var i=0; i<quantityElements.length; i++) {
    quantitiesArr.push(quantityElements[i].innerHTML);
  }
  return quantitiesArr;
}


  const recipe = {
    baseQuantities: getSubMaterialsQuantities(),
    totalCost: updateTotalCost()
    // totalCost: function() {
    //   let costElement = document.getElementById("total_recipe_cost").innerHTML;
    // }
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
    for (var i = 0; i < recipe.baseQuantities.length; i++) {
      tempArr.push(calculateNewQuantity(recipe.baseQuantities[i],craftQuantity.value));
    }
    // For all the newly calculated quantites, go through and change the html of the corresponding quantity.
    for (var j = 0; j < tempArr.length; j++) {
      quantityElements[j].innerHTML = tempArr[j];
      costQuantityElements[j].innerHTML = tempArr[j];
    }
  }


  function updateRowCost(){
    var rowNumber = event.target.id[event.target.id.length -1];
    let quantityAmount = document.getElementById("quantity_row_"+rowNumber).innerHTML;
    let materialCost = document.getElementById("input_field_row_"+rowNumber).value;
    let totalCost = document.getElementById("total_cost_row_"+rowNumber);
    let total = materialCost*quantityAmount;
    totalCost.innerHTML = total;
    updateTotalCost();
  }



function updateCosts(){
  for(let i =1; i<=quantityElements.length;i++){
    var rowNumber = i;
    let quantityAmount = document.getElementById("quantity_row_"+rowNumber).innerHTML;
    let materialCost = document.getElementById("input_field_row_"+rowNumber).value;
    let totalCost = document.getElementById("total_cost_row_"+rowNumber);
    let total = materialCost*quantityAmount;
    totalCost.innerHTML = total;
  }
  updateTotalCost();
}

function updateTotalCost(){
  let recipeTotal = 0;
  for(let i =1; i<=quantityElements.length;i++){
    var rowNumber = i;
    let quantityAmount = document.getElementById("quantity_row_"+rowNumber).innerHTML;
    let materialCost = document.getElementById("input_field_row_"+rowNumber).value;
    let totalCost = document.getElementById("total_cost_row_"+rowNumber);
    let total = materialCost*quantityAmount;
    recipeTotal+=total;
  }
  document.getElementById("total_recipe_cost").innerHTML = recipeTotal;

}


function changeInput(field){
  console.log();
  if(field.style.backgroundColor == ''){
    field.setAttribute("style", "background: transparent; border: none; color: transparent; outline: none; text-shadow: 0 0 0 #FA7D10;")
  }else if(field.style.backgroundColor == 'transparent'){
    field.setAttribute("style", "background: default; border: default; color: default; outline: default;")
  }
}

//For every key change, apply the newly calculated quantites to the html.
$('#craft_quantity_input').on('keypress', function(e){
  if(e.which === 13){
    let craftQuantity = document.getElementById('craft_quantity_input');
  /* The quantity value can only be between 1 and 999999,
  * so if it's anything other than those values, don't calculate the new quantities.
  */
  if(craftQuantity.value==0 || craftQuantity.value.length==0 || craftQuantity.value<0 || craftQuantity.value>999999){
  }else{
    changeQuantities(craftQuantity);
    updateCosts();
  }
}
});

  $('#costs_table tr input').on('keypress', function(e){
    if(e.which === 13){
      changeInput(this);
      updateRowCost();
  }
  });
  $('#costs_table tr input').on('click', function(){
    if(this.style.backgroundColor == 'transparent'){
    changeInput(this);
  }

  });


});

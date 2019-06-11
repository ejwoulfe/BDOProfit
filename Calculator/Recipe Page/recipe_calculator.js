 // Recipe Controller
let recipeController = (function() {

  let RecipeCosts = function(val, total){
    this.val = val;
    this.total = total;
  }
  let RecipeProfit = function(val, total){
    this.val = val;
    this.total = total;
  }
  let materialRows = $("input[id*='cost_input_row_']").length;
  let rewardsRows = $("input[id*='profit_input_row_']").length;
  const costsArr = [];
  const profitsArr = [];
  for (let i = 0; i < materialRows; i++) {
    costsArr.push(0);
  }
  for (let i = 0; i < rewardsRows; i++) {
    profitsArr.push(0);
  }
  let subQuant = document.getElementsByClassName('quantity');
  let proc1 = document.getElementById('tier1_proc_rate').innerHTML;
  let proc2 = document.getElementById('tier2_proc_rate').innerHTML;
  const baseSubQuantities = [];
  const baseRewardQuantities = [];
  for (let i = 0; i < subQuant.length; i++) {
    baseSubQuantities.push(subQuant[i].innerHTML);
  }
  baseRewardQuantities.push(proc1);
  if(rewardsRows > 1){
    baseRewardQuantities.push(proc2);
  }


  let data = {
    allItems: {
      cost: costsArr,
      profit: profitsArr
    },
    totals: {
      cost: 0,
      profit: 0
    },
    pureProfit: 0
  }
  let calculateTotal = function(type){
    let sum = 0;
    data.allItems[type].forEach(function(index){
      if(isNaN(index.total)){
        sum+=0;
      }else if(!isNaN(index.total)){
        sum+= index.total;
      }
    })
    data.totals[type] = sum;
  }

  return{
    addItem: function(type, row, val, total){
      let newItem;
      if(type === 'cost'){
        newItem = new RecipeCosts(val, total)
      }else if(type === 'profit'){
        newItem = new RecipeProfit(val, total)
      }
      data.allItems[type].splice(row-1, 1, newItem);
      return newItem;
    },
    calculateTotals: function(type){
      // Calculate total cost of sub materials and total sale price of the recipe
      calculateTotal(type);

      // Calculate total profit
      data.pureProfit = data.totals.profit - data.totals.cost;
    },
    getTotals: function(){
      return {
        costsTotal: data.totals.cost,
        profitsTotal: data.pureProfit
      };
    },
    calculateSubQuantities: function(multiplier){
      let newQuantities = [];
      for (let i = 0; i < baseSubQuantities.length; i++) {
        newQuantities.splice(i, 1, baseSubQuantities[i] * multiplier);
      }
      return newQuantities;
    },
    calculateRewardQuantities: function(multiplier){
      let newRewardQuantities = [];
      for (let i = 0; i < baseRewardQuantities.length; i++) {
        newRewardQuantities.splice(i, 1, baseRewardQuantities[i] * multiplier);
      }
      return newRewardQuantities;
    },
    numOfCostRows: materialRows,
    numOfProfitRows: rewardsRows
  }



})();


// UI Controller
let UIController = (function()  {

  function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  }

  return{
    getInput: function(type, id){
      let quant = document.querySelector(`#row_${id} #${type}_quantity_row_${id}`).innerHTML;
      let cost = document.querySelector(`#row_${id} #${type}_input_row_${id}`).value;
      return{
        quantity: quant,
        cost: cost,
        totalCost: Number(Math.round((parseFloat(quant) * parseInt(cost))+'e'+0)+'e-'+0)
      }
    },
    updateRowTotal: function(type, id, total){
      if(isNaN(total)){
        total = 0;
      }
      document.querySelector(`#row_${id} #total_${type}_row_${id}`).innerHTML = numberWithCommas(total);
    },
    updateTableTotals: function(costsTotal, profitsTotal){
      document.querySelector('#total_recipe_cost').innerHTML = numberWithCommas(costsTotal);
      document.querySelector('#total_recipe_profit').innerHTML = numberWithCommas(profitsTotal);
    },
    updateSubQuantities: function(quantities){
      let quant = document.getElementsByClassName('quantity');
      for(let i = 0; i < quantities.length; i++)
      {
        quant.item(i).innerHTML = quantities[i];
      }
    },
    updateRewardQuantities: function(quantities){

      for (let i = 0; i < quantities.length; i++) {
        document.querySelector('#profit_quantity_row_'+(i+1)).innerHTML = Number(Math.round(quantities[i]+'e'+2)+'e-'+2);
      }
    },
    changeInput: function(field){
      if(field.style.backgroundColor == ''){
        field.setAttribute("style", "background: transparent; border: none; color: transparent; outline: none; text-shadow: 0 0 0 #FA7D10;")
      }else if(field.style.backgroundColor == 'transparent'){
        field.setAttribute("style", "background: default; border: default; color: default; outline: default;")
      }
    },
    validateInput: function(input){
      let check = false;
      if (input === '') {
        input === 0;
      }
      if(!isNaN(input) && input.match(/^[0-9]+$/) && input < 99999999999){
        check = true;
      }else{
        check = false;
      }

      return check;
    }
  }
})();

// Details App Controller
let appController = (function(recipeCtrl, UICtrl)  {





  let setupEventListeners = function(){
    // When user presses enter on an input field in the costs table.
    $("input[id*='cost_input_row_']").on('keypress', function(event){
      if((event.which === 13 || event.keyCode === 13) && UICtrl.validateInput(event.target.value)){
        let rowNumber = event.target.id[event.target.id.length -1];
        ctrlAddRowCost(rowNumber);
        UICtrl.changeInput(event.target);
        event.target.blur();
      } else if((event.which === 13 || event.keyCode === 13) && !UICtrl.validateInput(event.target.value)){
        let rowNumber = event.target.id[event.target.id.length -1];
        $(`#cost_input_row_${rowNumber}`).tooltip('show');
        setTimeout(function(){
        $(`#cost_input_row_${rowNumber}`).tooltip('hide');
    }, 2000);
      }

    });

    $("input[id*='cost_input_row_']").on('click', function(event){
      if(event.target.style.backgroundColor == 'transparent'){
        UICtrl.changeInput(event.target);
      }

    });

    $("input[id*='cost_input_row_']").focus(function() {
      if(event.target.style.backgroundColor == 'transparent'){
        UICtrl.changeInput(event.target);
      }
});

    $("input[id*='profit_input_row_']").on('keypress', function(event){
      if((event.which === 13 || event.keyCode === 13) && UICtrl.validateInput(event.target.value)){
        let rowNumber = event.target.id[event.target.id.length -1];
        ctrlAddRowProfit(rowNumber);
        UICtrl.changeInput(event.target);
        event.target.blur();
      } else if((event.which === 13 || event.keyCode === 13) && !UICtrl.validateInput(event.target.value)){
        let rowNumber = event.target.id[event.target.id.length -1];
        $(`#profit_input_row_${rowNumber}`).tooltip('show');
        setTimeout(function(){
        $(`#profit_input_row_${rowNumber}`).tooltip('hide');
    }, 2000);
      }
    });

    $("input[id*='profit_input_row_']").on('click', function(event){
      if(event.target.style.backgroundColor == 'transparent'){
        UICtrl.changeInput(event.target);
      }

    });

    $("input[id*='profit_input_row_']").focus(function() {
      if(event.target.style.backgroundColor == 'transparent'){
        UICtrl.changeInput(event.target);
      }
});

    $("#craft_quantity_input").on('keypress', function(event){
      if((event.which === 13 || event.keyCode === 13) && UICtrl.validateInput(event.target.value)){
        ctrlAddQuantities(recipeCtrl.calculateSubQuantities(event.target.value), recipeCtrl.calculateRewardQuantities(event.target.value));
      } else if((event.which === 13 || event.keyCode === 13) && !UICtrl.validateInput(event.target.value)){
        $("#craft_quantity_input").tooltip('show');
        setTimeout(function(){
        $("#craft_quantity_input").tooltip('hide');
    }, 2000);
      }

    });

  };
  let checkRewardsRows = function(){
    if(recipeCtrl.numOfProfitRows === 1){
      document.querySelector('#tier2_proc').setAttribute("style", "display: none;");
    }
  }
  let initializeRewardQuantity = function(){
    for (let i = 1; i <= recipeCtrl.numOfProfitRows; i++) {
      document.querySelector(`#profit_quantity_row_${i}`).innerHTML = document.querySelector(`#tier${i}_proc_rate`).innerHTML;
    }

  }
  let ctrlAddRowCost = function(rowNumber){
    let input, newItem;

    // Get the field input data.
    input = UICtrl.getInput('cost', rowNumber);

    if(UICtrl.validateInput(input.cost)){

      //Add  item to recipe controller
      newItem = recipeCtrl.addItem('cost', rowNumber, input.cost, input.totalCost);

      UICtrl.updateRowTotal('cost', rowNumber, input.totalCost);
      recipeCtrl.calculateTotals('cost');
      UICtrl.updateTableTotals(recipeCtrl.getTotals().costsTotal, recipeCtrl.getTotals().profitsTotal);
    }

  };

  let ctrlAddRowProfit = function(rowNumber){
    let input, newItem;
    // Get the field input data.
    input = UICtrl.getInput('profit', rowNumber);
    if(UICtrl.validateInput(input.cost)){

      newItem = recipeCtrl.addItem('profit', rowNumber, input.cost, input.totalCost);

      UICtrl.updateRowTotal('profit', rowNumber, input.totalCost);
      recipeCtrl.calculateTotals('profit');
      UICtrl.updateTableTotals(recipeCtrl.getTotals().costsTotal, recipeCtrl.getTotals().profitsTotal);

    }
  };

  let ctrlAddQuantities = function(newSubQuantities, newRewardQuantities){
    UICtrl.updateSubQuantities(newSubQuantities);
    UICtrl.updateRewardQuantities(newRewardQuantities);
    for (let i = 1; i <= recipeCtrl.numOfCostRows; i++) {
      ctrlAddRowCost(i);
    }
    for (let z = 1; z <= recipeCtrl.numOfProfitRows; z++) {
      ctrlAddRowProfit(z);
    }


  };
  let ctrlAddProcRates = function(){


  };


  return{
    init: function() {
      setupEventListeners();
      checkRewardsRows();
      initializeRewardQuantity();
    }

  }

})(recipeController, UIController);

appController.init();

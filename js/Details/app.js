// Recipe Controller
var recipeController = (function() {

  var RecipeCosts = function(val, total){
    this.val = val;
    this.total = total;
  }
  var RecipeProfit = function(val, total){
    this.val = val;
    this.total = total;
  }
  var materialRows = $("input[id*='cost_input_row_']").length;
  var rewardsRows = $("input[id*='profit_input_row_']").length;
  var costsArr = [];
  var profitsArr = [];
  for (var i = 0; i < materialRows; i++) {
    costsArr.push(0);
  }
  for (var i = 0; i < rewardsRows; i++) {
    profitsArr.push(0);
  }
  var data = {
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
  var calculateTotal = function(type){
    var sum = 0;
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
      var newItem;
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
    }
  }



})();


// UI Controller
var UIController = (function()  {

  document.querySelector('#profit_quantity_row_1').innerHTML = document.querySelector('#t1_input').value;

  function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  }

  return{
    getInput: function(type, id){
      var quant = document.querySelector('#row_'+id +' #'+type+'_quantity_row_'+id).innerHTML;
      var cost = document.querySelector('#row_'+id +' #'+type+'_input_row_'+id).value;
      return{
        quantity: quant,
        cost: cost,
        totalCost: parseInt(parseFloat(quant) * parseInt(cost))
      }
    },
    updateRowTotal: function(type, id, total){
      document.querySelector('#row_'+id +' #total_'+type+'_row_'+id).innerHTML = numberWithCommas(total);
    },
    updateTableTotals: function(costsTotal, profitsTotal){
      document.querySelector('#total_recipe_cost').innerHTML = numberWithCommas(costsTotal);
      document.querySelector('#total_recipe_profit').innerHTML = numberWithCommas(profitsTotal);
    },
    updateQuantities: function(multiplier){
      var quant = document.getElementsByClassName('quantity');
      for(var i = 0; i < quant.length; i++)
      {
        quant.item(i).innerHTML *= multiplier;
      }

    }
  }
})();


// Details App Controller
var appController = (function(recipeCtrl, UICtrl)  {





  var setupEventListeners = function(){
    // When user presses enter on an input field in the costs table.
    $("input[id*='cost_input_row_']").on('keypress', function(event){
      if(event.which === 13 || event.keyCode === 13){
        var rowNumber = event.target.id[event.target.id.length -1];
        ctrlAddRowCost(rowNumber);
      }

    });

    $("input[id*='profit_input_row_']").on('keypress', function(event){
      if(event.which === 13 || event.keyCode === 13){
        var rowNumber = event.target.id[event.target.id.length -1];
        ctrlAddRowProfit(rowNumber);
      }

    });
    $("#craft_quantity_input").on('keypress', function(event){
      if(event.which === 13 || event.keyCode === 13){
        UICtrl.updateQuantities(event.target.value);
      }

    });

  };

  var ctrlAddRowCost = function(rowNumber){
    var input, newItem;

    // Get the field input data.
    input = UICtrl.getInput('cost', rowNumber);
    console.log(input);

    if(!isNaN(input.cost)){

      //Add  item to recipe controller
      newItem = recipeCtrl.addItem('cost', rowNumber, input.cost, input.totalCost);

      UICtrl.updateRowTotal('cost', rowNumber, input.totalCost);
      recipeCtrl.calculateTotals('cost');
      UICtrl.updateTableTotals(recipeCtrl.getTotals().costsTotal, recipeCtrl.getTotals().profitsTotal);
    }

  };

  var ctrlAddRowProfit = function(rowNumber){
    var input, newItem;
    // Get the field input data.
    input = UICtrl.getInput('profit', rowNumber);
    console.log(input);
    if(!isNaN(input.cost)){

      newItem = recipeCtrl.addItem('profit', rowNumber, input.cost, input.totalCost);

      UICtrl.updateRowTotal('profit', rowNumber, input.totalCost);
      recipeCtrl.calculateTotals('profit');
      UICtrl.updateTableTotals(recipeCtrl.getTotals().costsTotal, recipeCtrl.getTotals().profitsTotal);

    }
  };


  return{
    init: function() {
      setupEventListeners();
    }

  }

})(recipeController, UIController);

appController.init();

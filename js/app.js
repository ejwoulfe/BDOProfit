
$(document).ready(function () {

  var isExpanded = $('#collapse_button').attr("aria-expanded");

  $(isExpanded).on('shown.bs.collapse', function () {
         console.log("Pressed.");
     });

});

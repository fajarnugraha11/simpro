/**
* jQuery Plugin for formatting thousand number to has separator
* @version 1.0
* @requires jQuery 1.4 or later and autoNumeric (http://www.decorplanit.com/plugin/)
*
* Copyright (c) 2015 Lucky
* Licensed under the GPL license:
* http://www.gnu.org/licenses/gpl.html
*/
(function($) {
  function initNumeric(element, options) {
    // Format all selected elements to have thousand separator.
    element.autoNumeric('init', options);
  }

  function cleanNumeric(element) {
    // Get closest form element.
    element.closest("form").submit(function() {
      element.each(function(index) {
        // Clean all value to be pure number before submitting.
        $(this).val($(this).autoNumeric('get'));
      });
      return true;
    });
  }

  $.fn.lazzynumeric = function (opts) {
    var options = {
      aSep: ",",
      aDec: "."
    };
    $.extend(options, opts);
    
    return this.each(function() {
      var element = $(this);

      initNumeric(element, options);
      cleanNumeric(element);
    });
  }
})(jQuery);
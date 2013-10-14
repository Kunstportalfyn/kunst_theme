/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

(function($) {
  $(document).ready(function() {
    addExpandable();
    adjustMenu();
  });
  
  $(window).resize(function() {
    adjustMenu();
  });
  
  function addExpandable() {
    var div = '<div class="expandable"><i class="icon-caret-right"> </i></div>';
    var $aArr = $("#block-menu-block-1 ul.menu > li");
    if($aArr.length === 0) $aArr = $("#rm-removed ul.menu > li");
    $aArr.each(function(i, a){
      $a = $(a).find(">a");
      console.log($a.html());
      $a.html(div + $a.html());
    });
  }
  
  function adjustMenu(e) {
    if($(window).width() > 767) {
      $("#block-menu-block-1 ul.menu > li").mouseenter(function(e) {
        $(this).find("> ul > li").stop(true, true).slideDown(100);
        $(this).find("> a > div > i").attr("class", "icon-caret-down");
      });
      $("#block-menu-block-1 ul.menu > li").mouseleave(function(e) {
        $(this).find("ul li").stop(true, true).slideUp(100);
        $(this).find("> a > div > i").attr("class", "icon-caret-right");
      });
    }
    else {
      // Mobile
      $("#block-menu-block-1 ul.menu > li").unbind();
      $("#rm-removed li").attr("style","");
    }
  }
})(jQuery);

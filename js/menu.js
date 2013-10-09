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
    var div = '<div class="expandable"><i class="icon-caret-down"> </i></div>';
    var $aArr = $("#block-menu-block-1 > div.content > div > ul.menu > li");
    if($aArr.length === 0) $aArr = $("#rm-removed > div.content > div > ul.menu > li");
    $aArr.each(function(i, a){
      $a = $(a).find(">a");
      console.log($a.html());
      $a.html($a.html() + div);
    });
  }
  
  function adjustMenu(e) {
    if($(window).width() > 767) {
      $("#block-menu-block-1 ul.menu > li").mouseenter(function(e) {
        $(this).find("ul li").stop(true, true).slideDown(100);
      });
      $("#block-menu-block-1 ul.menu > li").mouseleave(function(e) {
        $(this).find("ul li").stop(true, true).slideUp(100);
      });
      //console.log("Wide");
    }
    else {
      //console.log("Mobile");
      $("#block-menu-block-1 ul.menu > li").unbind();
      $("#rm-removed li").attr("style","");
    }
  }
})(jQuery);

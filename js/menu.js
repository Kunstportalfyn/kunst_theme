/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

(function($) {
  $(document).ready(function(){
    adjustMenu();
  });
  
  $(window).resize(function(){
    adjustMenu();
  });
  
  function adjustMenu() {
    if($(window).width() > 767) {
      $("#block-menu-block-1 ul.menu > li").mouseenter(function(){
        $(this).find("ul li").slideDown(100);
      });
      $("#block-menu-block-1 ul.menu > li").mouseleave(function(){
        $(this).find("ul li").slideUp(100);
      });
      console.log("Wide");
    }
    else {
      console.log("Mobile");
      $("#block-menu-block-1 ul.menu > li").unbind();
      //$("#rm-removed li").css("display", "list-item");
      $("#rm-removed li").attr("style","");
    }
  }
})(jQuery);

/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

(function($) {
  $(document).ready(function() {
    window.$mainMenu = new Array();
    addExpandable();
    adjustMenu();
  });
  
  $(window).resize(function() {
    adjustMenu();
  });
  
  function addExpandable() {
    var div = '<div class="expandable-indicator"><i class="icon-caret-right"> </i></div>';
    var $aArr = $("#block-menu-block-1 ul.menu > li");
    if($aArr.length === 0) $aArr = $("ul#rm-removed > li");
    $aArr.each(function(i, a){
      $a = $(a).find(">a");
      //console.log($a.html());
      $a.html(div + $a.html());
    });
  }
  
  function adjustMenu(e) {
    $("#block-menu-block-1 ul li ul.menu > li.expanded > a").unbind();
    $("#block-menu-block-1 > div > div > ul.menu > li.expanded").unbind();
    if($(window).width() > 767) {
      $("#block-menu-block-1 > div > div > ul.menu > li.expanded").mouseenter(function(e) {
        //console.log("Triggered on: mouseenter-> " + $(this).attr("class"));
        $(this).find("> ul > li").stop(true, true).slideDown(100);
        $(this).find("> a > div > i").attr("class", "icon-caret-down");
      });
      $("#block-menu-block-1 ul li ul.menu > li.expanded > a").click(function(e) {
        //console.log("Triggered on: click-> " + $(this).parent().attr("class"));
        var item = $(this).parent().find("[class*='menu-mlid-']").attr("class");
        var itemId = getMenuItemClass(item);
        e.preventDefault();
        e.stopPropagation();
        if(window.$mainMenu[itemId] !== true) {
          $(this).parent().find("> ul > li").stop(true, true).slideDown(100);
          $(this).find("> div > i").attr("class", "icon-caret-down");
          window.$mainMenu[itemId] = true;
        }
        else {
          $(this).parent().find("> ul > li").stop(true, true).slideUp(100);
          $(this).find("> div > i").attr("class", "icon-caret-right");
          window.$mainMenu[itemId] = false;
        }
      });
      $("#block-menu-block-1 > div > div > ul.menu > li.expanded").mouseleave(function(e) {
        var item = $(this).find("[class*='menu-mlid-']").attr("class");
        var itemId = getMenuItemClass(item);
        $(this).find("> ul > li").stop(true, true).slideUp(100);
        $(this).find("> a > div > i").attr("class", "icon-caret-right");
        window.$mainMenu[itemId] = false;
      });
    }
    else {
      // Mobile
      // $("#block-menu-block-1 ul.menu > li").unbind();
      $("#rm-removed li").attr("style","");
    }
  }
  
  function getMenuItemClass(item) {
    var sItem = item.split(" ");
    for(i = 0; i < sItem.length; i++) {
      if(sItem[i].substr(0,10) == "menu-mlid-") return sItem[i];
    }
    return false;
  }
})(jQuery);

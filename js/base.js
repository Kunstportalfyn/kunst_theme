/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
(function($){
  $.fn.loginBox = function(){
    login();
    $("#edit-name").focus();
  };

  var loginForm = "";

  function login() {
    if($("#block-user-login .login-wrapper").css("display") === "none") {
      loginFormShow();
    } else {
      loginFormHide();
    }
  }

  function loginFormWrap() {
    loginForm = '<div class="login-wrapper">' + $('#block-user-login').html() + '</div>';
    $('#block-user-login').html(loginForm);
  }

  function loginFormHide() {
    $('#block-user-login .login-wrapper').hide();
  }

  function loginFormShow() {
    $('#block-user-login .login-wrapper').show();
  }

  function showLoginButton(){
    var onclick = "jQuery.fn.loginBox()";
    var html = '<button type="button" onclick="' + onclick + '">' + Drupal.t("Login") + '</button>';
    $('#block-search-form').prepend(html);
  }
  
  function showLogoutButton(){
    var url = "/user/logout";
    var html = '<a href="' + url + '"><button name="log-out-button" type="button" title="' + Drupal.t("Logout") + '"><i class="icon-signout"> </i></button></a>';
    var url = "/user/";
    html += '<a href="' + url + '"><button name="logged-in-user" type="button" title="' + Drupal.t("User") + '"><i class="icon-user"> </i></button></a>';
    $('#block-search-form').prepend(html);
  }

  var tmp = false;

  /**
   * 
   * Responsive adjustments to the width of the searchfield.
   */
  function setSearchFieldWidth() {
    var ddt = $( window ).width();
    if(ddt < 750) {
      var boxWidth = $("#header").width();
      var editBoxWidth = boxWidth - 148;
      $(".region-header #block-search-form .form-item-search-block-form .form-text").width(editBoxWidth);
      tmp = true;
    } else {
      if(tmp === true) {
        $(".region-header #block-search-form .form-item-search-block-form .form-text").attr('style', "");
      }
    }
  }
  
  /**
   * 
   * Replaces next/prev buttons in the galleria carousel with font-awesome icons
   */
  function galleriaFix() {
    //console.log("galleriaFix start");
    //console.log($(".galleria-image-nav-left").length);
    $(".galleria-image-nav-right").html('<i class="icon-chevron-right"> </i>');
    $(".galleria-image-nav-left").html('<i class="icon-chevron-left"> </i>');
    //console.log($(".galleria-image-nav-left").html());
  }
  
  /**
   * 
   * Moves the rss title below the image on kunsten.nu
   * An ugly hack, but it works.
   */
  function rssFix() {
    $.each( $(".rssblock-itemlist .blocklist-item"), function(index, value) {
      if($(value).find(".rss-description").html()) {
        $tmp = $(value).find(".rss-link");
        $tmp.clone().appendTo($(value).find(".rss-description a img").parent());
        $tmp.remove();
      }
    });
  }
  
  /**
   * 
   * Equalizes the heights of the bottom-block blocks
   */
  function bottomBlockFix() {
    $("#bottom-block-wrap .bottom-block").attr("style","");
    var $max = getMaxHeight($("#bottom-block-wrap .bottom-block"));
    $("#bottom-block-wrap .bottom-block").height($max);
  }
  
  /**
   * 
   * Equalizes the heights of the footer-block blocks
   */
  function footerBlockFix() {
    $("#footer-block-wrap .footer-block > div").attr("style","");
    var $max = getMaxHeight($("#footer-block-wrap .footer-block > div"));
    $("#footer-block-wrap .footer-block > div").height($max);
  }
  
  function getMaxHeight(obj) {
    if(!obj) return false;
    if(obj.length === 0) return false;
    var $max = 0;
    for(i = 0; i < obj.length; i++) {
      if($(obj[i]).height() > $max) $max = $(obj[i]).height();
    }
    return $max;
  }

  /**
   * Activates scripts when ready
   */
  $().ready(function(){
    loginFormWrap();
    galleriaFix();
    //rssFix();
    bottomBlockFix();
    footerBlockFix();
    // check if user is logged in
    if($("#block-user-login").length) {
      showLoginButton();
    }
    else {
      showLogoutButton();
    }
    setSearchFieldWidth();
  });
  
  /**
   * Runs on every window resize
   */
  $(window).resize(function() {
    setSearchFieldWidth();
    bottomBlockFix();
    footerBlockFix();
  });
})(jQuery);

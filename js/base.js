/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
(function($){
  $.fn.loginBox = function(){
    login();
  };

  var loginForm = "";

  function login() {
    if($("#block-user-login .login-wrapper").css("display") == "none") {
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

  function setSearchFieldWidth() {
    var ddt = $( window ).width();
    if(ddt < 768) {
      var boxWidth = $("#header").width();
      var editBoxWidth = boxWidth - 140;
      $(".region-header #block-search-form .form-item-search-block-form .form-text").width(editBoxWidth);
      tmp = true;
    } else {
      if(tmp === true) {
        $(".region-header #block-search-form .form-item-search-block-form .form-text").attr('style', "");
      }
    }
  }

  $().ready(function(){
    loginFormWrap();
    // check if user is logged in
    if($("#block-user-login").length) {
      showLoginButton();
    }
    else {
      showLogoutButton();
    }
    setSearchFieldWidth();
  });
  
  $(window).resize(function() {
    setSearchFieldWidth();
  });
})(jQuery);

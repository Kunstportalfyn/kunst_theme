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
    var onclick = "location.href='/user/logout'";
    var html = '<button name="log-out-button" type="button" onclick="' + onclick + '" title="' + Drupal.t("Logout") + '"><i class="icon-signout"> </i></button>';
    var onclick = "location.href='/user/'";
    html += '<button name="logged-in-user" type="button" onclick="' + onclick + '" title="' + Drupal.t("User") + '"><i class="icon-user"> </i></button>';
    $('#block-search-form').prepend(html);
  }

  var tmp = false;

  function setSearchFieldWidth() {
    if((d = $(window).width())<768) {
      var boxWidth = $("#header").outerWidth();
      var editBoxWidth = boxWidth - 130;
      $(".region-header #block-search-form .form-item-search-block-form .form-text").width(editBoxWidth);
      tmp = true;
    } else {
      if(tmp == true) {
        $(".region-header #block-search-form .form-item-search-block-form .form-text").attr('style', "");
      }
    }
    console.log(d);
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

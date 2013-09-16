/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
(function($){
  $.fn.loginBox = function(option){
    if (option == "login"){
      login();
    } else if(option = "logout"){
      logout();
    }
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
    var onclick = "jQuery.fn.loginBox('login')";
    var html = '<button type="button" onclick="' + onclick + '">' + Drupal.t("Login") + '</button>';
    $('#block-user-login').prepend(html).wrap('<div class="position_wrapper"/>');
  }

  $().ready(function(){
    loginFormWrap();
    showLoginButton();
  });
})(jQuery);

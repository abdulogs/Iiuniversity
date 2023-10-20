$("#login").submit(function(e) {
  e.preventDefault();
  var email = $("#email").val();
  var password = $("#password").val();
  var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;

  if (email == "" || email == null) {
    msgError("Please enter email address","#response");
    return false;
  } else if (reg.test(email) == false) {
    msgError( "Invalid email address","#response");
    return false;
  } else if (password == "" || password == null) {
    msgError("Please enter password","#response");
    return false;
  } else {
    $.ajax({
      url: "modules/account/login/data.php",
      type: "POST",
      cache: false,
      data: {
        email: email,
        password: password,
      },
      success: function(data) {
        $("#response").html(data);
      },
    });
  }
});

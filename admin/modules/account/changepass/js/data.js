$("#changepass").submit(function(e) {
  e.preventDefault();
  var password = $("#password").val();
  var cpassword = $("#cpassword").val();
  var uid = $("#uid").val();

  if (password == "" || password == null) {
    msgError("Please enter password", "#response");
    return false;
  } else if (cpassword == "" || cpassword == null) {
    msgError("Please enter confirm password", "#response");
    return false;
  } else if (password != cpassword) {
    msgError("Passwords not matched", "#response");
    return false;
  } else {
    $.ajax({
      url: "modules/account/changepass/data.php",
      type: "POST",
      cache: false,
      data: {
        password: password,
        uid: uid
      },
      success: function(data) {
        $("#response").html(data);
      },
    });
  }
});

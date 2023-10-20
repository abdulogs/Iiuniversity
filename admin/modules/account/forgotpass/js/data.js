$("#recovery").submit(function(e) {
  e.preventDefault();
  var email = $("#email").val();
  var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;

  if (email == "" || email == null) {
    msgError("Please enter email address","#response");
    return false;
  } else if (reg.test(email) == false) {
    msgError("Invalid email address","#response");
    return false;
  }  else {
    $.ajax({
      url: "modules/account/forgotpass/data.php",
      type: "POST",
      cache: false,
      data: {
        email: email,
      },
      success: function(data) {
        $("#response").html(data);
      },
    });
  }
});

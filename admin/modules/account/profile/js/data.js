$(document).on("submit","#profile", function(e) {
  e.preventDefault();
  $.ajax({
    url: "modules/account/profile/profile.php",
    type: 'post',
    data: new FormData(this),
    contentType: false,
    processData: false,
    cache: false,
    beforeSend: function() {
      $("#loading-bar").show();
      $("#profilesubmit").attr("disabled", true);
    },
    success: function(feedback) {
      $('#response').html(feedback);
    },
    complete: function() {
      $("#loading-bar").hide();
      $("#profilesubmit").attr("disabled", false);
    },
  });
});

$(document).on("submit","#pass", function(e) {
  e.preventDefault();
  $.ajax({
    url: "modules/account/profile/pass.php",
    type: 'post',
    data: new FormData(this),
    contentType: false,
    processData: false,
    cache: false,
    beforeSend: function() {
      $("#loading-bar").show();
      $("#passsubmit").attr("disabled", true);
    },
    success: function(feedback) {
      $('#response').html(feedback);
    },
    complete: function() {
      $("#loading-bar").hide();
      $("#passsubmit").attr("disabled", false);
    },
  });
});

$(document).on("submit","#basic", function(e) {
  e.preventDefault();
  $.ajax({
    url: "modules/account/profile/basic.php",
    type: 'post',
    data: new FormData(this),
    contentType: false,
    processData: false,
    cache: false,
    beforeSend: function() {
      $("#loading-bar").show();
      $("#basicsubmit").attr("disabled", true);
    },
    success: function(feedback) {
      $('#response').html(feedback);
    },
    complete: function() {
      $("#loading-bar").hide();
      $("#basicsubmit").attr("disabled", false);
    },
  });
});

function msgError(value = "", where = "") {
  var message = `
  <div class="custom-alert" role="alert">
  <div class="media custom-alert-body">
    <span class="ti-na custom-alert-icon-error"></span>
  <div class="media-body custom-alert-content">
    <h6 class="custom-alert-heading"><b>Opps!</b> you got an error</h6>
    <p class="custom-alert-subheading">${value}</p>
  </div>
  <button class="ti-close alert-close" onclick="parentNode.parentNode.parentNode.removeChild(parentNode.parentNode);"
  type="button" data-dismiss="alert"></button></p>
  </div>`;
  return $(where).html(message);
}

function successMsg(value = "", where = "") {
  var message = `
  <div class="custom-alert" role="alert">
  <div class="custom-alert-body">
    <span class="ti-check custom-alert-icon-success"></span>
  <div class="custom-alert-content">
    <h6 class="custom-alert-heading"><b>Congratulations!</b></h6>
    <p class="custom-alert-subheading">${value}</p>
  </div>
  <button class="ti-close alert-close" type="button" onclick="parentNode.parentNode.parentNode.removeChild(parentNode.parentNode);"
   data-dismiss="alert"></button></p>
  </div>`;
  return $(where).html(message);
}

function reload() {
  setTimeout(function() {
    location.reload();
  }, 1000);
}
function redirect(location) {
  window.open(location ,"_SELF");
}

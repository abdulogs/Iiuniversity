$(document).ready(function () {
  function loadData(page) {
    $.ajax({
      url: "modules/buildings/data.php",
      method: "POST",
      data: {
        page: page,
      },
      cache: false,
      beforeSend: function () {},
      success: function (data) {
        if (data) {
          $("#loader").remove();
          $("#pagination").remove();
          $("#data").append('<tr id="loader"></tr>');
          $("#data").append(data);
        } else {
          $("#loadmore").append("No more results");
          $("#loadmore").prop("disabled", true);
        }
      },
      complete: function () {},
    });
  }
  loadData();

  function loadFiltered(page) {
    var search = $("#search").val();
    var sort = $("#sort").val();
    var limit = $("#limit").val();
    $.ajax({
      url: "modules/buildings/data.php",
      method: "POST",
      data: {
        search: search,
        sort: sort,
        limit: limit,
        page: page,
      },
      cache: false,
      beforeSend: function () {
        $(".filter-btn").attr("disabled", true);
      },
      success: function (data) {
        if (data) {
          var replace = "";
          replace += data;
          $("#loader").remove();
          $("#pagination").remove();
          $("#data").append('<tr id="loader"></tr>');
          $("#data").append(replace);
        } else {
          $("#loadmore").append("No more results");
          $("#loadmore").prop("disabled", true);
        }
      },
      complete: function () {
        $(".filter-btn").attr("disabled", false);
      },
    });
  }

  $(document).on("submit", "#filter", function (e) {
    e.preventDefault();
    loadFiltered();
    $("#data").html("");
  });

  $(document).on("click", "#loadFiltered", function () {
    loadFiltered($(this).data("paging"));
  });

  $(document).on("click", "#loadmore", function () {
    loadData($(this).data("paging"));
  });
});

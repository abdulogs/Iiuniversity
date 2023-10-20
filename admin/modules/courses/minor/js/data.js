const loader = ` 
<td><div class="skeleton-loader" style="border-radius:5px;width:100%;height:10px;"></div></td>
<td><div class="skeleton-loader" style="border-radius:5px;width:100%;height:10px;"></div></td>
<td><div class="skeleton-loader" style="border-radius:5px;width:100%;height:10px;"></div></td>
<td><div class="skeleton-loader" style="border-radius:5px;width:100%;height:10px;"></div></td>
  `;

    $(document).ready(function() {
      function loadData(page) {
        $.ajax({
          url: "modules/courses/minor/data.php",
          method: "POST",
          data: {
            page: page
          },
          cache: false,
          beforeSend: function() {
            $('#loader').html(loader);
          },
          success: function(data) {
            if (data) {
              $('#loader').remove();
              $("#pagination").remove();
              $('#data').append('<tr id="loader"></tr>');
              $('#data').append(data);
            } else {
              $("#loadmore").append("No more results");
              $("#loadmore").prop("disabled", true);
            }
          },
          complete: function() {
            $('#loader').remove()
          },
        });
      }
      loadData();

      function loadFiltered(page) {
        var search = $("#search").val();
        var sort = $("#sort").val();
        var limit = $("#limit").val();
        $.ajax({
          url: "modules/courses/minor/data.php",
          method: "POST",
          data: {
            search: search,
            sort: sort,
            limit: limit,
            page: page
          },
          cache: false,
          beforeSend: function() {
            $('#loader').html(loader);
            $(".filter-btn").attr("disabled",true);
          },
          success: function(data) {
            if (data) {
              var replace = "";
              replace += data;
              $('#loader').remove();
              $("#pagination").remove();
              $('#data').append('<tr id="loader"></tr>');
              $('#data').append(replace);
            } else {
              $("#loadmore").append("No more results");
              $("#loadmore").prop("disabled", true);
            }
          },
          complete: function() {
            $('#loader').remove()
            $(".filter-btn").attr("disabled",false);

          },
        });
      }

      $(document).on("submit", "#filter", function(e) {
        e.preventDefault();
        loadFiltered();
        $("#data").html("");
      });


      $(document).on("click", "#loadFiltered", function() {
        var pageId = $(this).data("paging");
        loadFiltered(pageId);
      });

      $(document).on("click", "#loadmore", function() {
        var pageId = $(this).data("paging");
        loadData(pageId);
      });

  // Create
  $(document).on('click', '.createBtn', function(e) {
    $.ajax({
      url: "modules/courses/minor/form.php",
      type: "POST",
      cache: false,
      beforeSend: function() {
        $("#loading-bar").show();
      },
      success: function(data) {
        $("#modalForm").modal("show");
        $("#form").html(data);
      },
      complete: function() {
        $("#loading-bar").hide();
      },
    });
  });

  $(document).on('submit', '#create', function(e) {
    e.preventDefault();
    $.ajax({
      url: "modules/courses/minor/create.php",
      type: 'post',
      data: new FormData(this),
      contentType: false,
      processData: false,
      cache: false,
      beforeSend: function() {
        $("#loading-bar").show();
        $("#btn-submit").attr("disabled", true);
      },
      success: function(data) {
        $('#response').html(data);
      },
      complete: function() {
        $("#loading-bar").hide();
        $("#btn-submit").attr("disabled", false);
      },
    });
  });

  // Create

  // Update
  $(document).on('click', '.updateBtn', function(e) {
    var id = $(this).data('id');
    $.ajax({
      url: "modules/courses/minor/form.php",
      type: "POST",
      data: {
        id: id
      },
      cache: false,
      beforeSend: function() {
        $("#loading-bar").show();
      },
      success: function(data) {
        $("#modalForm").modal("show");
        $("#form").html(data);
      },
      complete: function() {
        $("#loading-bar").hide();
      },
    });
  });

  $(document).on("submit", "#update", function(e) {
    e.preventDefault();
    $.ajax({
      url: "modules/courses/minor/update.php",
      type: 'post',
      data: new FormData(this),
      contentType: false,
      processData: false,
      cache: false,
      beforeSend: function() {
        $("#loading-bar").show();
        $("#btn-submit").attr("disabled", true);
      },
      success: function(feedback) {
        $('#response').html(feedback);
      },
      complete: function() {
        $("#loading-bar").hide();
        $("#btn-submit").attr("disabled", false);
      },
    });
  });
  // Update

  // Delete
  $(document).on('click', '.deletebBtn', function(e) {
    if (confirm("Do you really want to delete this!")) {
      var id = $(this).data('id');
      $.ajax({
        url: "modules/courses/minor/delete.php",
        type: 'post',
        data: {
          id: id
        },
        beforeSend: function() {
          $("#loading-bar").show();
        },
        success: function(feedback) {
          $('#response').html(feedback);
        },
        complete: function() {
          $("#loading-bar").hide();
        }
      });
    }
  });
  // Delete
});

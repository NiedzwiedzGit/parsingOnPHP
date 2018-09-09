$(document).ready(function() {
  $("#parsing").click(function(event) {
    event.preventDefault();
    var form = $("#parsingForm");
    $.ajax({
      type: "POST",
      url: form.attr("action"),
      data: form.serialize(),
      success: function(responce) {
        $("#firstTask").html(responce);
      }
    });

    $("#loadImg").addClass("show");
  });

  $("#createDBbtn").click(function(event) {
    event.preventDefault();
    var form = $("#createDBForm");
    $.ajax({
      type: "POST",
      url: form.attr("action"),
      data: form.serialize(),
      success: function(responce) {
        $("#nav-profile").html(responce);
      }
    });
  });
  var form = $("#createDBForm");
  $.ajax({
    type: "POST",
    url: form.attr("action"),
    data: form.serialize(),
    success: function(responce) {
      $("#nav-profile").html(responce);
    }
  });

  var form = $("#createDBFormDate");
  $.ajax({
    type: "POST",
    url: form.attr("action"),
    data: form.serialize(),
    success: function(responce) {
      $("#nav-contact").html(responce);
    }
  });
});

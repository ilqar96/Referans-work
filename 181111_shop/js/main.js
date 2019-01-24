$(document).ready(function() {
  $("nav a").click(function() {
    $("nav a").removeClass("active");
    $(this).addClass("active");
  });
});

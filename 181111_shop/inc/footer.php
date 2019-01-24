<div class="py-5 bg-primary w-25 text-center" id="complatedAction">
    <h4>Message</h4> 
</div>



<script>
    $(document).ready( function () {
        $('#myTable').DataTable();
        $("#myTable_wrapper").css("width","97%")
    } );

    function ActionComplated($text){
      $("#complatedAction h4").html($text)
      $("#complatedAction").animate({opacity:'0.9'},700);
      $("#complatedAction").animate({opacity:'0'},900);
    }
</script>


<script>
// Example starter JavaScript for disabling form submissions if there are invalid fields
(function() {
  'use strict';
  window.addEventListener('load', function() {
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();
</script>
    
</body>
</html>

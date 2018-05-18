       </div>
      <!-- /.container-fluid -->

    </div>
    <!-- /.content-wrapper -->

    <!-- Scroll to Top Button -->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fa fa-angle-up"></i>
    </a>

    <!-- Logout Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            Select "Logout" below if you are ready to end your current session.
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="logout.php">Logout</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript -->
    <script src="sb_admin/vendor/jquery/jquery.min.js"></script>
    <script src="sb_admin/vendor/popper/popper.min.js"></script>
    <script src="sb_admin/vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="sb_admin/vendor/jquery/jquery.form-validator.min.js"></script>
    <script src="sb_admin/vendor/passwordstrengthmeter/passwordStrengthMeter.js"></script>
    <script src="sb_admin/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="sb_admin/vendor/chart.js/Chart.min.js"></script>
    <script src="sb_admin/vendor/datatables/jquery.dataTables.js"></script>
    <script src="sb_admin/vendor/datatables/dataTables.bootstrap4.js"></script>
    <script src="sb_admin/js/moment.min.js"></script>
    <script src="sb_admin/js/daterangepicker.js"></script>
    <script src="sb_admin/js/aes.js"></script>

    <!-- Custom scripts for this template -->
    <script src="sb_admin/js/sb-admin.js" type="text/javascript"></script>




  <script>
  $(function() {
    // setup validate
    $.validate({
      modules : 'sanitize, security',
    });
   // $.validate(); call function here or in the page where it is used

  });
</script>


<!-- Password strength script --> 
<script>
  jQuery(document).ready(function() {
    $('#inputPassword').keyup(function(){$('#result').html(passwordStrength($('#inputPassword').val(),$('#inputUsername').val()))})
  })
</script>

<!-- Script to pass value to followup modal --> 
 <script>
    $(function () {
        $(".followupbutton").click(function () {
            var my_id_value = $(this).data('id');
            $(".modal-body #hiddenValue").val(my_id_value);
        })
    });
</script>

<script>
  $(function(){
    $('input[name="daterange"]').daterangepicker({
        "parentEl": "body",
        "showDropdowns": true,
        "opens": "right"
    });
  });
</script>

  </body>

</html>
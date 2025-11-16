

<!-- jQuery 2.2.0 -->
<script src="assets/bootstrap/js/jquery-1.12.0.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="assets/bootstrap/js/jquery.dataTables.min.js"></script>

<!-- AdminLTE App -->
<script src="assets/LTE/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<!-- page script -->

<script src="custom.js"></script>
 <script>
  $(function () {
    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": false,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });
  });
</script>

</body>
</html>
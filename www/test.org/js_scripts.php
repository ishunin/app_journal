<!-- jQuery -->
<script src="/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables -->
<script src="/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

<script src="/dist/js/gijgo.min.js"></script>
<!-- AdminLTE App -->
<script src="/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="/dist/js/demo.js"></script>
<!-- page script -->
<script src="/plugins/toastr/toastr.min.js"></script>
<script src="/dist/js/demo.js"></script>
<!-- InputMask -->
<script src="/dist/js/moment.min.js"></script>
<script src="/dist/js/jquery.inputmask.bundle.min.js"></script>
<script>
  $(function() {
    $("#example1").DataTable({
      "responsive": true,
      "autoWidth": false,
      "pagingType": "numbers",
    });

    $("#example1_b").DataTable({
      "responsive": true,
      "autoWidth": false,
      "pagingType": "numbers",
      "lengthMenu": [
        [5,10, 25, 50, -1],
        [5,10, 25, 50, "All"]
      ],
      "pageLength": 5,
    });


    $("#example1_k").DataTable({
      "responsive": true,
      "autoWidth": false,
      "pagingType": "numbers",
      "lengthMenu": [
        [5,10, 25, 50, -1],
        [5,10, 25, 50, "All"]
      ],
      "pageLength": 5,
    });



    $("#example1_one_disk").DataTable({
      "responsive": true,
      "autoWidth": false,
      "pagingType": "numbers",
      "order": [
        [10, "asc"]
      ],
    });

    $("#example1_templ").DataTable({
      "responsive": true,
      "autoWidth": false,
      "order": [
        [2, "asc"]
      ],
      "pagingType": "numbers",
    });


    $("#example1_history").DataTable({
      "responsive": true,
      "autoWidth": false,
      "order": [
        [10, "asc"]
      ],
      "pagingType": "numbers",
    });


    $("#example1_ob").DataTable({
      "responsive": true,
      "autoWidth": false,
      "order": [
        [9, "desc"]
      ],
      "pagingType": "numbers",
    });

    $("#example1_ob_storage").DataTable({
      "responsive": true,
      "autoWidth": false,
      "order": [
        [9, "desc"]
      ],
      "pagingType": "numbers",
    });

    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
      "pagingType": "numbers",
    });

    $("#example3").DataTable({
      "responsive": true,
      "autoWidth": false,
      "pagingType": "numbers",
    });

    $("#example_inc").DataTable({
      "responsive": true,
      "autoWidth": false,
      "pagingType": "numbers",
      "lengthMenu": [
        [10, 25, 50, -1],
        [10, 25, 50, "All"]
      ],
      "pageLength": 50,
      "order": [
        [7, "desc"]
      ],
    });

    $("#example_main").DataTable({
      "responsive": true,
      "autoWidth": false,
      "pagingType": "numbers",
      "lengthMenu": [
        [5,10, 25, 50, -1],
        [5,10, 25, 50, "All"]
      ],
      "pageLength": 5,
    });

  });
</script>

<script>
  $(function() {
    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('')
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', {
      'placeholder': 'mm/dd/yyyy'
    })
    delay_option()
  })
</script>

<script>
  function delay_option() {
    var objSel = document.getElementById("option_status");
    var objArea = document.getElementById("delay_date_div");
    var objDataP = document.getElementById("datepicker");
    if (objSel.selectedIndex == 1) {
      objArea.style.display = "block";
      objDataP.setAttribute("required", "");
    } else {
      objArea.style.display = "none";
      objDataP.value = "";
      objDataP.removeAttribute("required", "");
    }
  };
</script>


<script>
  $('#datepicker').datepicker({
    required: " * required: You must enter a destruction date",
    uiLibrary: 'bootstrap4'
  });
</script>

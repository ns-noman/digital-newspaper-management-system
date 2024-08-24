<!-- Sweet Alert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- jQuery -->
<script src="{{ asset('public/admin-assets') }}/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('public/admin-assets') }}/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>  $.widget.bridge('uibutton', $.ui.button) </script>
<!-- Bootstrap 4 -->
<script src="{{ asset('public/admin-assets') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- daterangepicker -->
<script src="{{ asset('public/admin-assets') }}/plugins/moment/moment.min.js"></script>
<script src="{{ asset('public/admin-assets') }}/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('public/admin-assets') }}/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="{{ asset('public/admin-assets') }}/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('public/admin-assets') }}/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="{{ asset('public/admin-assets') }}/dist/js/adminlte.js"></script>
<!-- DataTables  & Plugins -->
<script src="{{ asset('public/admin-assets') }}/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{ asset('public/admin-assets') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ asset('public/admin-assets') }}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{ asset('public/admin-assets') }}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="{{ asset('public/admin-assets') }}/plugins/jszip/jszip.min.js"></script>
<script src="{{ asset('public/admin-assets') }}/plugins/pdfmake/pdfmake.min.js"></script>
<script src="{{ asset('public/admin-assets') }}/plugins/pdfmake/vfs_fonts.js"></script>
<!-- Select2 -->
<script src="{{ asset('public/admin-assets') }}/plugins/select2/js/select2.full.min.js"></script>

<script>
    $(function() {
        $("#example1").DataTable({
            "responsive": false,
            "lengthChange": true,
            "autoWidth": true
        });
        $('.select2').select2();

    });
</script>

<script>
    $(document).ready(function(){
        $('.add-new').click(function(e) {
            e.preventDefault();
            window.location.replace($(this).attr('add-new'));
        });
    });
    function nsAjaxPost(url,data){
        return new Promise((resolve, reject) => {
        $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: url,
                data: data,
                type: 'POST',
                dataType: 'JSON',
                success: function(res){
                    resolve(res);
                },
                error: function(err) {
                    reject(err);
                }
            });
        });
    }
    function nsAjaxGet(url){
        return new Promise((resolve, reject) => {
        $.ajax({
                url: url,
                method: 'GET',
                dataType: 'JSON',
                success: function(res){
                    resolve(res);
                },
                error: function(err) {
                    reject(err);
                }
            });
        });
    }
</script>
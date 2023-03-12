        <script src="<?= base_url() ?>assets/js/modernizr.min.js"></script>
        <script>
          (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
          (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
          m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
          })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

          ga('create', 'UA-83057131-1', 'auto');
          ga('send', 'pageview');

        </script>
         <script>
            var resizefunc = [];
        </script>

        <!-- jQuery  -->
        <script src="<?= base_url() ?>plugins/select2/js/select2.min.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>assets/js/jquery.min.js"></script>
        <script src="<?= base_url() ?>assets/js/bootstrap.min.js"></script>
        <script src="<?= base_url() ?>assets/js/detect.js"></script>
        <script src="<?= base_url() ?>assets/js/fastclick.js"></script>
        <script src="<?= base_url() ?>assets/js/jquery.blockUI.js"></script>
        <script src="<?= base_url() ?>assets/js/waves.js"></script>
        <script src="<?= base_url() ?>assets/js/jquery.slimscroll.js"></script>
        <script src="<?= base_url() ?>assets/js/jquery.scrollTo.min.js"></script>
        <script src="<?= base_url() ?>plugins/switchery/switchery.min.js"></script>

        <script src="<?= base_url() ?>plugins/moment/moment.js"></script>
        <script src="<?= base_url() ?>plugins/timepicker/bootstrap-timepicker.js"></script>
        <script src="<?= base_url() ?>plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
        <script src="<?= base_url() ?>plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
        <script src="<?= base_url() ?>plugins/clockpicker/js/bootstrap-clockpicker.min.js"></script>
        <script src="<?= base_url() ?>plugins/bootstrap-daterangepicker/daterangepicker.js"></script>

        <script src="<?= base_url() ?>plugins/bootstrap-tagsinput/js/bootstrap-tagsinput.min.js"></script>
        <script type="text/javascript" src="<?= base_url() ?>plugins/multiselect/js/jquery.multi-select.js"></script>
        <script type="text/javascript" src="<?= base_url() ?>plugins/jquery-quicksearch/jquery.quicksearch.js"></script>
        <script src="<?= base_url() ?>plugins/select2/js/select2.min.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>plugins/bootstrap-touchspin/js/jquery.bootstrap-touchspin.min.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>plugins/bootstrap-maxlength/bootstrap-maxlength.min.js" type="text/javascript"></script>

        <script type="text/javascript" src="<?= base_url() ?>plugins/autocomplete/jquery.mockjax.js"></script>
<!--        <script type="text/javascript" src="--><?//= base_url() ?><!--plugins/autocomplete/jquery.autocomplete.min.js"></script>-->
        <script type="text/javascript" src="<?= base_url() ?>plugins/autocomplete/countries.js"></script>
<!--        <script type="text/javascript" src="--><?//= base_url() ?><!--assets/pages/jquery.autocomplete.init.js"></script>-->

        <script type="text/javascript" src="<?= base_url() ?>assets/pages/jquery.form-advanced.init.js"></script>

        <script src="<?= base_url() ?>plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="<?= base_url() ?>plugins/datatables/dataTables.bootstrap.js"></script>

        <script src="<?= base_url() ?>plugins/datatables/dataTables.buttons.min.js"></script>
        <script src="<?= base_url() ?>plugins/datatables/buttons.bootstrap.min.js"></script>
        <script src="<?= base_url() ?>plugins/datatables/jszip.min.js"></script>
        <script src="<?= base_url() ?>plugins/datatables/pdfmake.min.js"></script>
        <script src="<?= base_url() ?>plugins/datatables/vfs_fonts.js"></script>
        <script src="<?= base_url() ?>plugins/datatables/buttons.html5.min.js"></script>
        <script src="<?= base_url() ?>plugins/datatables/buttons.print.min.js"></script>
        <script src="<?= base_url() ?>plugins/datatables/dataTables.fixedHeader.min.js"></script>
        <script src="<?= base_url() ?>plugins/datatables/dataTables.keyTable.min.js"></script>
        <script src="<?= base_url() ?>plugins/datatables/dataTables.responsive.min.js"></script>
        <script src="<?= base_url() ?>plugins/datatables/responsive.bootstrap.min.js"></script>
        <script src="<?= base_url() ?>plugins/datatables/dataTables.scroller.min.js"></script>
        <script src="<?= base_url() ?>plugins/datatables/dataTables.colVis.js"></script>
        <script src="<?= base_url() ?>plugins/datatables/dataTables.fixedColumns.min.js"></script>

        <!-- init -->
        <script src="<?= base_url() ?>assets/pages/jquery.datatables.init.js"></script>
        <script src="<?= base_url() ?>plugins/bootstrap-sweetalert/sweet-alert.min.js"></script>
        <script src="<?= base_url() ?>assets/pages/jquery.sweet-alert.init.js"></script>

        <!-- App js -->
        <script src="<?= base_url() ?>assets/js/jquery.core.js"></script>
        <script src="<?= base_url() ?>assets/js/jquery.app.js"></script>

        <script type="text/javascript">
            $(document).ready(function () {
                $('#datatable').dataTable();
                $('#datatable-keytable').DataTable({keys: true});
                $('#datatable-responsive').DataTable();
                $('#datatable-colvid').DataTable({
                    "dom": 'C<"clear">lfrtip',
                    "colVis": {
                        "buttonText": "Change columns"
                    }
                });
                $('#datatable-scroller').DataTable({
                    ajax: "<?= base_url() ?>plugins/datatables/json/scroller-demo.json",
                    deferRender: true,
                    scrollY: 380,
                    scrollCollapse: true,
                    scroller: true
                });
                var table = $('#datatable-fixed-header').DataTable({fixedHeader: true});
                var table = $('#datatable-fixed-col').DataTable({
                    scrollY: "300px",
                    scrollX: true,
                    scrollCollapse: true,
                    paging: false,
                    fixedColumns: {
                        leftColumns: 1,
                        rightColumns: 1
                    }
                });
            });
            TableManageButtons.init();

        </script>

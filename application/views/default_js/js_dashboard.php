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
        <script src="<?= base_url() ?>assets/js/jquery.min.js"></script>
        <script src="<?= base_url() ?>assets/js/bootstrap.min.js"></script>
        <script src="<?= base_url() ?>assets/js/detect.js"></script>
        <script src="<?= base_url() ?>assets/js/fastclick.js"></script>
        <script src="<?= base_url() ?>assets/js/jquery.blockUI.js"></script>
        <script src="<?= base_url() ?>assets/js/waves.js"></script>
        <script src="<?= base_url() ?>assets/js/jquery.slimscroll.js"></script>
        <script src="<?= base_url() ?>assets/js/jquery.scrollTo.min.js"></script>
        <script src="<?= base_url() ?>plugins/switchery/switchery.min.js"></script>

        <!-- Counter js  -->
        <script src="<?= base_url() ?>plugins/select2/js/select2.min.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>plugins/waypoints/jquery.waypoints.min.js"></script>
        <script src="<?= base_url() ?>plugins/counterup/jquery.counterup.min.js"></script>

        <!-- Flot chart js -->
        <script src="<?= base_url() ?>plugins/flot-chart/jquery.flot.min.js"></script>
        <script src="<?= base_url() ?>plugins/flot-chart/jquery.flot.time.js"></script>
        <script src="<?= base_url() ?>plugins/flot-chart/jquery.flot.tooltip.min.js"></script>
        <script src="<?= base_url() ?>plugins/flot-chart/jquery.flot.resize.js"></script>
        <script src="<?= base_url() ?>plugins/flot-chart/jquery.flot.pie.js"></script>
        <script src="<?= base_url() ?>plugins/flot-chart/jquery.flot.selection.js"></script>
        <script src="<?= base_url() ?>plugins/flot-chart/jquery.flot.crosshair.js"></script>

        <script src="<?= base_url() ?>plugins/moment/moment.js"></script>
        <script src="<?= base_url() ?>plugins/bootstrap-daterangepicker/daterangepicker.js"></script>


        <!-- Dashboard init -->
        <script src="<?= base_url() ?>assets/pages/jquery.dashboard_2.js"></script>

        <!-- App js -->
        <script src="<?= base_url() ?>assets/js/jquery.core.js"></script>
        <script src="<?= base_url() ?>assets/js/jquery.app.js"></script>

        <script>
            $('#reportrange span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));
            $('#reportrange').daterangepicker({
                format: 'MM/DD/YYYY',
                startDate: moment().subtract(29, 'days'),
                endDate: moment(),
                minDate: '01/01/2012',
                maxDate: '12/31/2016',
                dateLimit: {
                    days: 60
                },
                showDropdowns: true,
                showWeekNumbers: true,
                timePicker: false,
                timePickerIncrement: 1,
                timePicker12Hour: true,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                opens: 'left',
                drops: 'down',
                buttonClasses: ['btn', 'btn-sm'],
                applyClass: 'btn-success',
                cancelClass: 'btn-default',
                separator: ' to ',
                locale: {
                    applyLabel: 'Submit',
                    cancelLabel: 'Cancel',
                    fromLabel: 'From',
                    toLabel: 'To',
                    customRangeLabel: 'Custom',
                    daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                    monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                    firstDay: 1
                }
            }, function (start, end, label) {
                console.log(start.toISOString(), end.toISOString(), label);
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            });
        </script>

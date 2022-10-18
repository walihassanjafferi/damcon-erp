
    <!-- BEGIN: Vendor JS-->
    <script src="{{ asset('app-assets/vendors/js/vendors.min.js') }}"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    {{-- <script src="{{ asset('app-assets/vendors/js/charts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/extensions/toastr.min.js') }}"></script> --}}
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="{{ asset('app-assets/js/core/app-menu.js') }}"></script>
    <script src="{{ asset('app-assets/js/core/app.js') }}"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    {{-- <script src="{{ asset('app-assets/js/scripts/pages/dashboard-ecommerce.js') }}"></script> --}}
    <!-- END: Page JS-->

     {{-- Begin Datatables css --}}
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>

    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>


    <!-- BEGIN: Page JS-->
    <script src="{{ asset('app-assets/js/scripts/tables/table-datatables-basic.js') }}"></script>
    <script src="{{ asset('app-assets/js/scripts/components/components-bs-toast.js') }}"></script>
    <!-- END: Page JS-->

     {{-- <script src="../../../app-assets/vendors/js/ui/jquery.sticky.js"></script>
      <script src="../../../app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js"></script>
      <script src="../../../app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js"></script>
      <script src="../../../app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js"></script>
      <script src="../../../app-assets/vendors/js/tables/datatable/responsive.bootstrap4.js"></script>
      <script src="../../../app-assets/vendors/js/tables/datatable/datatables.checkboxes.min.js"></script>
      <script src="../../../app-assets/vendors/js/tables/datatable/datatables.buttons.min.js"></script>
      <script src="../../../app-assets/vendors/js/tables/datatable/jszip.min.js"></script>
      <script src="../../../app-assets/vendors/js/tables/datatable/pdfmake.min.js"></script>
      <script src="../../../app-assets/vendors/js/tables/datatable/vfs_fonts.js"></script>
      <script src="../../../app-assets/vendors/js/tables/datatable/buttons.html5.min.js"></script>
      <script src="../../../app-assets/vendors/js/tables/datatable/buttons.print.min.js"></script>
      <script src="../../../app-assets/vendors/js/tables/datatable/dataTables.rowGroup.min.js"></script>
      <script src="../../../app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js"></script> --}}
     {{-- End Datatables css --}}

    {{-- sweet alerts --}}
    
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    {{-- select 2 --}}
    <script src="{{ asset('app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>
    <script src="{{ asset('app-assets/js/scripts/forms/form-select2.js') }}"></script>
    <script src="{{ asset('js/gijgo.min.js') }}"></script>

    <script>
        $(window).on('load', function() {
            if (feather) {
                feather.replace({
                    width: 14,
                    height: 14
                });
            }


            // overlay hceck
            $('.overlay').fadeOut();

            // Amount format
            function addCommas(str){
                // return str.replace(/^0+/, '').replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                var nStr = str + '';
                nStr = nStr.replace(/\,/g, "");
                x = nStr.split('.');
                x1 = x[0];
                x2 = x.length > 1 ? '.' + x[1] : '';
                var rgx = /(\d+)(\d{3})/;
                while (rgx.test(x1)) {
                    x1 = x1.replace(rgx, '$1' + ',' + '$2');
                }
                return (x1 + x2);

            
            }

            $('.amount_format').keyup(function (e){
                    var number = $(this).val();
                    $(this).val(addCommas(number));
            });

        });

        // show loader when ajax calls
       

        function AddReadMore() {
            var carLmt = 100;
            var readMoreTxt = " ... more";
            var readLessTxt = " less";

            $(".addReadMore").each(function() {
                if ($(this).find(".firstSec").length)
                    return;
                var allstr = $(this).text();
                if (allstr.length > carLmt) {
                    var firstSet = allstr.substring(0, carLmt);
                    var secdHalf = allstr.substring(carLmt, allstr.length);
                    var strtoadd = firstSet + "<span class='SecSec'>" + secdHalf + "</span><span class='readMore'  title='Click to Show More'>" + readMoreTxt + "</span><span class='readLess' title='Click to Show Less'>" + readLessTxt + "</span>";
                    $(this).html(strtoadd);
                }
            });
            $(document).on("click", ".readMore,.readLess", function() {
                $(this).closest(".addReadMore").toggleClass("showlesscontent showmorecontent");
            });
        }
        $(function() {
            AddReadMore();
        });
    </script>

    

{{-- @include('layout.sidebar-js') --}}



@extends('layout.main')


@section('css')

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

@endsection

@section('title')
    <title>Damcon ERP - Dashboard</title>
@endsection
@section('content')
    @if (Auth::user()->role->name == 'Admin')
        <div class="mt-2">
            @include('user.partials.partialdashboard.admindashboard')
        </div>
        {{-- <div class="overlay">
            <div class="overlay__inner">
                <div class="overlay__content"><span class="spinner"></span></div>
            </div>
        </div> --}}
    @endif

@endsection

@section('scripts')

    {{-- Date range picker --}}

    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"
        integrity="sha512-QSkVNOCYLtj73J4hbmVoOV6KVZuMluZlioC+trLpewV8qMjsWqlIQvkn1KGX2StWvPMdWGBqim1xlC8krl1EKQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js"></script>


    <script>
        // admin script only
        var role = '{!! Auth::user()->role->name !!}';

        if (role == 'Admin') {
            $(function() {


                // var project_id = $('#select_project_admin').val();
                var startDate = null;
                var endDate = null;
                loadDashboardData(startDate, endDate);

                // $('#select_project_admin').change(function(){

                //     var project_id = $('#select_project_admin').val();

                //     loadDashboardData(project_id);
                // });


                $('input[name="daterange"]').daterangepicker({
                    opens: 'left',
                    autoUpdateInput: false,
                    locale: {
                        cancelLabel: 'Clear'
                    }

                });

                $('input[name="daterange"]').on('apply.daterangepicker', function(ev, picker) {
                    $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format(
                        'DD-MM-YYYY'));

                    var startDate = picker.startDate.format('DD-MM-YYYY');
                    var endDate = picker.endDate.format('DD-MM-YYYY');
                    loadDashboardData(startDate, endDate);

                });

                $('input[name="daterange"]').on('cancel.daterangepicker', function(ev, picker) {
                    $(this).val('');
                });
            });

        }


        function loadDashboardData(startDate, endDate) {

            $.ajax({
                url: '{{ route('getadmindashboard') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    // "project_id": project_id
                    "startDate": startDate,
                    "endDate": endDate
                },
                method: 'post',
                success: function(data) {

                    if (data.startDate == null && data.endDate == null) {
                        console.log(data);
                        $('.total_project_count').text(data.project_count);
                        $('.current_active_customers').text(data.customer_count);
                        $('.current_active_suppliers').text(data.suppliers_count);
                        $('.current_active_investors').text(data.investor_count);
                        $('.current_active_employee').text(data.employee_count);
                        $('.total_asset_count').text(data.asset_count);
                        $('.advance_hr_payment').text('PKR ' + data.advance_hr_payment);
                        $('.directors_withdraw').text('PKR ' + data.director_withdraw);
                        //   // charts js
                        loadPiecharts(data.pie_chart_data);
                        loadBarChart(data.bar_chart_data);

                    } else {

                        $('.total_project_count').text(data.project_count);
                        $('.current_active_customers').text(data.customer_count);
                        $('.current_active_suppliers').text(data.suppliers_count);
                        $('.current_active_investors').text(data.investor_count);
                        $('.current_active_employee').text(data.employee_count);
                        $('.total_asset_count').text(data.asset_count);
                        $('.advance_hr_payment').text('PKR ' + data.advance_hr_payment);
                        $('.directors_withdraw').text('PKR ' + data.director_withdraw);
                        //   // charts js
                        loadPiecharts(data.pie_chart_data);
                        loadBarChart(data.bar_chart_data);
                    }


                },
                error: function(data) {
                    console.log(data);
                    alert('Scripts ERROR!')
                }
            });
        }

        function loadPiecharts(piedata) {

            let chartStatus = Chart.getChart("pieChart"); // <canvas> id
            if (chartStatus != undefined) {
                chartStatus.destroy();
            }




            var project_name = [],customers_count = [];
            piedata.forEach(element => {
                project_name.push(element.name,)
                customers_count.push(element.employee_count)
            });


            const data = {
                labels: project_name,
                datasets: [{
                    label: 'Customers',
                    data: customers_count,
                    backgroundColor: [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 205, 86)'
                    ],




                }]
            };

            const config = {
                type: 'doughnut',
                data: data,
            };

            const myChart = new Chart(
                document.getElementById('pieChart'),
                config
            );

        }

        function loadBarChart(barData) {


            let chartStatus = Chart.getChart("barChart"); // <canvas> id
            if (chartStatus != undefined) {
                chartStatus.destroy();
            }

            var invoice_count = [],
                invoice_amount = [],
                po_numbers = [], po_balance = [];
            barData.forEach(element => {
                invoice_count.push(element.invoice_count);
                invoice_amount.push(element.invoice_sum);
                po_balance.push(element.PO_balance);

                po_numbers.push('PO # : ' + element.Customer_po_number + ", Invoice Count : " + element
                    .invoice_count);
            });


            const labels = po_numbers;

            const data = {
                labels: labels,
                datasets: [{
                    label: "Customer PO Balance (PKR)",
                    data: po_balance,
                    barThickness: 70,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(201, 203, 207, 0.2)',
                        'rgba(255, 205, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(201, 203, 207, 0.2)'
                    ],
                    borderColor: [
                        'rgb(255, 99, 132)',
                        'rgb(255, 159, 64)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(54, 162, 235)',
                        'rgb(153, 102, 255)',
                        'rgb(201, 203, 207)'
                    ],
                    borderWidth: 1
                },
                {
                    label: "Invoice's Sum (PKR)",
                    data: invoice_amount,
                    barThickness: 70,
                    backgroundColor: [

                        'rgba(201, 203, 207, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(255, 205, 86, 0.2)',
                        'rgba(201, 203, 207, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                    ],
                    borderColor: [
                        'rgb(201, 203, 207)',
                        'rgb(153, 102, 255)',
                        'rgb(54, 162, 235)',
                        'rgb(75, 192, 192)',
                        'rgb(255, 205, 86)',
                        'rgb(255, 159, 64)',
                        'rgb(255, 99, 132)'

                    ],
                    borderWidth: 1
                }]
            };

            const config = {
                type: 'bar',
                data: data,
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                },
            };

            const myChart = new Chart(
                document.getElementById('barChart'),
                config
            );

        }
        // $('.overlay').delay("slow").fadeOut();
    </script>
@endsection

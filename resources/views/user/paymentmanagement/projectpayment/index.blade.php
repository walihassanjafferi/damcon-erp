@extends('layout.main')
@section('project_payment_sidebar') active @endsection
@section('title')
    <title>Damcon ERP - Project Payment</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{route('project_payment.index')}} @endsection
@section('main_btn_text') All Project Payments @endsection
{{-- back btn --}}
@section('css')
    <style>
        .table th, .table td {
            padding: 0.72rem 0.98rem;
        }
        #file_input{
            opacity: 0;
            position: absolute;
            pointer-events: none;
        }
    </style>
@endsection
@section('content')
    @include('alert.alert')

    <style>
        .dt-buttons{
            display: flex;
            height: 38px;
        }
        .dt-buttons button{
            margin: 0px 4px;
        }
    </style>
    <div class="card mb-4">
        <div class="card-body">
            <h4 class="card-title">Project Payments Management</h4>

            <a href="{{ route('project_payment.create') }}" class="create-btn"><i data-feather='plus'></i> Add </a>
            <?php $increment = 1; ?>

            <table class="table table-striped table-bordered custom-data-table table-responsive" style="width:100%" id="project-payment">

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Parent Category</th>
                        <th>Main Category</th>
                        <th>Sub Category</th>

                        <th>Bank Account</th>
                        <th>Transaction Date</th>
                        <th style="display: none">Transaction Date</th>
                        <th>Paid to Person</th>
                        <th>Amount</th>
                        <th>Action</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach($projectPayments as $key=>$item)
                    <tr id="row-{{$item->id}}">
                        <td>{{$increment}}</td>
                        <td> {{$item->title}}</td>
                        <td> {{isset($item->category->category_name) ? $item->category->category_name : ''}} </td>
                        <td> {{isset($item->main_category->category_name) ? $item->main_category->category_name : ''}} </td>
                        <td> {{isset($item->subCategory->category_name) ? $item->subCategory->category_name : ''}} </td>
                        <td> {{isset($item->bankAccount->name) ? $item->bankAccount->name.'('.$item->bankAccount->account_number.')' : ''}}</td>
                        <td> {{date('d-m-Y', strtotime($item->transaction_date))}}   </td>
                        <td style="display: none"> {{$item->transaction_date}}   </td>
                        <td> {{ucfirst($item->paid_person)}} </td>
                        <td> PKR. {{number_format($item->amount)}} </td>
                        <td>
                            <a  href="{{route('project_payment.show', encrypt($item->id))}}" ><i data-feather="eye" data-toggle="tooltip" data-placement="top" data-original-title="View"></i> </a> &nbsp;&nbsp;
                            <a  href="{{route('project_payment.edit',  encrypt($item->id))}}" ><i data-feather="edit" data-toggle="tooltip" data-placement="top" data-original-title="Edit"></i></a>
                            {{-- <a class="btn-delete text-primary" data-id="{{$item->id}}"><i class="trash-2-color mx-1 icons-size" data-feather='trash-2'></i></a> --}}
                        </td>

                    </tr>
                    <?php $increment++; ?> 
                    @endforeach
                </tbody>

            </table>

          
        </div>

   
    </div>

@endsection
@section('scripts')
    <script>
        $(document).ready( function () {


            var table =  $('#project-payment').DataTable({
                "drawCallback": function( settings ) {
                 feather.replace();
                 },
               
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'Project Payments',
                        className: 'btn btn-primary',
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4]
                        },
                        filename:"Project Payments",    
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'Project Payments',
                        className: 'btn btn-danger',
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4]
                        },
                        filename:"Project Payments",       
                    },
                    // {
                    //     extend: 'csv',
                    //     title: 'Data export',
                    //     className: 'btn btn-primary'    
                    // },
                ]
            });
                
        });
    </script>
@endsection



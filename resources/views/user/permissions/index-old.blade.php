@extends('layout.main')

@section('content')
@include('alert.alert')
<center><div id="js-alert"></div></center>    
<section id="multiple-column-form">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Create Permission</h4>
                </div>
                <div class="card-body">
                    <form>
                        <div class="row">
                            <div class="col-md-6 col-12" >
                                <div class="form-group">
                                    <label for="name">Permission Name</label>
                                    <input type="text" id="name" name="name" class="form-control" placeholder="Name" required/>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="slug">Permission Slug</label>
                                    <input type="text" id="slug" name="slug" class="form-control" placeholder="slug"  required/>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="button" class="btn btn-primary mr-1" onclick="addPermission(event)">Submit</button>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('user.partials.permission')



</section>

@endsection

@section('scripts')

    
<script type="text/javascript">


$(document).ready( function () {
    $('#permission_table').DataTable({
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'Data export',
                className: 'btn btn-primary'    
            },
            {
                extend: 'pdfHtml5',
                title: 'Data export',
                className: 'btn btn-danger'    
            }
        ]
    });             
} );   

    function addPermission(event){
        event.preventDefault();
        var name = $('#name').val();
        var slug = $('#slug').val();
        
        
        if(name && slug){
                $.ajax({
                url:'{{ route('permissions.store')}}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "name":name,
                    "slug":slug,
                },
                method: 'post',
                success: function(data) {
                
                    if(data.success)
                    {

                    $('#js-alert').html('<div class="alert alert-success col-6">' + data.message + '</div>').delay(3000).fadeIn('slow');

                    $('#js-alert').delay(3000).fadeOut('slow');


                    content = '';
                    content += '<tr>';
                    content += '<th scope="row">' + data.data.id +'</th>';
                    content += '<td>'+ data.data.name +'</td>';
                    content += '<td>'+ data.data.slug +'</td>';
                    content += '<td><a href="/permissions/edit/'+data.enc_key+'" ><i data-feather="edit"></i> Edit </a></td>';
                    content += '</tr>';
                        
                    $('#permission_table tbody tr:first').before(content);

                    }

                   $('#name').val(''); $('#slug').val('');
                
                },
                error: function(data)
                {
                    
                    var errors = data.responseJSON;

                    $('#js-alert').html('<div class="alert alert-warning col-6">' + errors.message + '</div>');
                    
                }
            });
        }
        
    }

 

</script>


@endsection


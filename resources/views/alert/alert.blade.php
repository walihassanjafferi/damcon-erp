<div class="row" style="margin-top: 20px">
    <div class="col-lg-2 col-md-2">
    </div>
    @if (Session::has('created'))
        <div class="col-lg-8 col-md-8 col-sm-12 text-center">
            <div class="alert alert-success">
                <b>
                    {{ session('created') }}
                </b>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    @elseif(Session::has('success'))
        <div class="col-lg-8 col-md-8 col-sm-12 text-center">
            <div class="alert alert-success">
                <b>
                    {{ session('success') }}
                </b>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    @elseif(Session::has('existed'))
        <div class="col-lg-8 col-md-8 col-sm-12 text-center">
            <div class="alert alert-warning">
                <b>
                    {{ session('existed') }}
                </b>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    @elseif(Session::has('warning'))
        <div class="col-lg-8 col-md-8 col-sm-12 text-center">
            <div class="alert alert-warning">
                <b>
                    {{ session('warning') }}
                </b>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    @elseif(Session::has('updated'))
        <div class="col-lg-8 col-md-8 col-sm-12 text-center">
            <div class="alert alert-success fade show">
                <b>
                    {{ session('updated') }}
                </b>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    @elseif(Session::has('error'))
        <div class="col-lg-8 col-md-8 col-sm-12 text-center">
            <div class="alert alert-danger">
                <b>
                    {{ session('error') }}
                </b>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    @elseif(Session::has('deleted'))
        <div class="col-lg-8 col-md-8 col-sm-12 text-center">
            <div class="alert alert-secondary">
                <b>
                    {{ session('deleted') }}
                </b>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    @endif
    <div class="col-lg-2 col-md-2">
    </div>
</div>

{{-- @if ($errors->any())
    
        
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger">{{ $error }}</div>
    @endforeach
        
    
@endif --}}
{{-- 
<script type="text/javascript">
    function showAlert(type, title, message) {

        Swal.fire({
            icon: type,
            title: title,
            text: message,
        })
    }
</script> --}}

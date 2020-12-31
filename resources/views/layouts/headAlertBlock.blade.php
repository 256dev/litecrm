@if (\Session::has('message'))
    <div class="alert alert-success alert-dismissible fade show text-center" role="alert" >
        <center>{!! \Session::get('message') !!}</center>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
@if (isset($errors))
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
            {{ $error }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endforeach
@endif
<div class="container my-0 my-md-1">
    <div class="mb-3"><h4 class="text-center">{{ $title }}</h4></div>
    <div class="row justify-content-between">
        @if ($create === 1)
            <div class="form-group has-icon shadow">
                <button type="button" class="btn btn-success" onclick="window.location.href=' {{ route($route) }}'">
                        <i class="fas fa-plus pr-2"></i>
                        {{ $buttom }}
                    </button>
            </div> 
        @endif

        <div class="form-group has-icon shadow">
            <span class="fas fa-search form-control-feedback search"></span>
            <input id="search-bar" type="text" class="form-control" placeholder="Search" data-type='{{ $type }}'>
        </div>
    </div>
</div>
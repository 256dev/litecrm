<div class="container py-3">
    @if (!isset($edit))
        <form action="{{ route($store_route) }}" method="POST">
    @else
        <form action="{{ route($update_route, $item->id) }}" method="POST">
        @method('PUT')
    @endif 
    @csrf
    <div class="row justify-content-center my-3">
        <div class="col-12 col-md-6 mb-2">
            <label for="name" class="m-fa-icon mb-2">{{ $lable }}</label>
            <input id="name" type="text" class="form-control {{ $errors->has($typename)?'is-invalid':'' }}" name="{{ $typename }}" value="{{ old($typename)??($item->name??'') }}">
            @error($typename)
                <div><small class="text-danger">{{ $message }}</small></div>
            @enderror
        </div>
        <div class="col-12 col-md-3 mb-2">
            <label for="main" class="m-fa-icon"><i class="fas fa-home"></i></label>
            <label for="priority">Приоритет</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <input aria-label="Показать в основном списке" 
                                id="main" type="checkbox" name="main" value="1" 
                                {{ (old('main') ? 'checked' : (isset($item) && $item->main? 'checked' : '')) }}
                        >
                    </div>
                </div>
                <input aria-label="Сортировка в основном списке" 
                        class="form-control {{ $errors->has('priority')?'is-invalid':'' }}" 
                        value="{{ old('priority')??($item->priority??'15') }}" step="1"
                        id="priority" type="number" min="1" max="5000" name="priority"
                >
            </div>
            @error('priority')
                <div><small class="text-danger">{{ $message }}</small></div>
            @enderror
        </div>
        <div class="col-12 col-md-9 text-md-center mb-2 mb-md-0">
            <label class="m-fa-icon mb-2">Комментарий</label>
            <textarea class="form-control {{ $errors->has('comment')?'is-invalid':'' }}" name="comment">{{ old('comment')??($item->comment??'') }}</textarea>
            @error('comment')
                <div><small class="text-danger">{{ $message }}</small></div>
            @enderror
        </div>
    </div>  
    <div class="row justify-content-center mt-4">
        <div class="form-group has-icon ">
            <button type="submit" class="btn btn-success">
                @if (!isset($edit))
                    <i class="fas fa-plus pr-2"></i>
                    Добавить
                @else
                    Сохранить
                @endif
            </button>
        </div>
    </div>  
    </form>
</div>
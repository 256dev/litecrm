<div class="col-md-12 col-lg-4">
    <div class="py-3">
        <div class="form-group">
            <label class="m-fa-icon mb-2">ФИО</label>
            <input type="text" class="form-control {{ $errors->has('name')?'is-invalid':'' }}" placeholder="ФИО" name="name" value="{{ old('name')??($customer->name??'') }}">
            @error('name')
                <div>
                    <small id="" class="text-danger">
                        {{ $message }}
                    </small> 
                </div>
            @enderror
        </div>
        <div class="form-group">
            <label class="m-fa-icon mb-2">Email</label>
            <input type="text" class="form-control {{ $errors->has('email')?'is-invalid':'' }}" placeholder="Email" name="email" value="{{ old('email')??($customer->email??'') }}">
            @error('email')
                <div>
                    <small id="" class="text-danger">
                        {{ $message }}
                    </small> 
                </div>
            @enderror
        </div>
        <div class="form-group">
            <label class="m-fa-icon mb-2">Статус</label>
            <input class="form-control {{ $errors->has('status')?'is-invalid':'' }}" type="text" name="status" placeholder="Статус" value="{{ old('status')??($customer->status??'') }}" maxlength="10">
            @error('status')
                <div>
                    <small id="" class="text-danger">
                        {{ $status }}
                    </small> 
                </div>
            @enderror
        </div>
        <div class="form-group">
            <label class="m-fa-icon mb-2">Комментарий</label>
            <textarea class="form-control {{ $errors->has('comment')?'is-invalid':'' }}" placeholder="Комментарий" name="comment">{{ old('comment')??($customer->comment??'') }}</textarea>
            @error('comment')
                <div>
                    <small id="" class="text-danger">
                        {{ $message }}
                    </small> 
                </div>
            @enderror
        </div> 
    </div>
</div>
<div class="col-md-12 col-lg-8">
    <div class="py-3">          
        <div class="form-group">
            <label class="m-fa-icon mb-2">Адрес</label>
            <input type="text" class="form-control {{ $errors->has('address')?'is-invalid':'' }}" placeholder="Адрес" name="address" value="{{ old('address')??($customer->address??'') }}">
            @error('address')
                <div>
                    <small id="" class="text-danger">
                        {{ $message }}
                    </small> 
                </div>
            @enderror
        </div>                
        <div class="form-group">
            <label class="m-fa-icon mb-2">Паспортные данные</label>
            <input type="text" class="form-control {{ $errors->has('passport')?'is-invalid':'' }}" placeholder="Паспортные данные" name="passport" value="{{ old('passport')??($customer->passport??'') }}">
            @error('passport')
                <div>
                    <small id="" class="text-danger">
                        {{ $message }}
                    </small> 
                </div>
            @enderror
        </div>
        <div id="phones" class="row justify-content-start">
            <div class="col-md-4 phone" > 
                <div class="form-group">
                    <label class="m-fa-icon mb-2">Телефон</label>
                    <input type="text" class="form-control {{ $errors->has('phone1')?'is-invalid':'' }}" placeholder="Телефон" name="phone1" value="{{ old('phone1')??($phones->get('0')->phone??'') }}">
                    @error('phone1')
                        <div>
                            <small class="text-danger">
                                {{ $message }}
                            </small> 
                        </div>
                    @enderror
                </div>
                <div class="form-check form-check-inline m-fa-icon">
                    <input id="telegramCheck1" type="checkbox" class="form-check-input" value="1" name="telegram1" {{ old('phone1')?(old('telegram1')?'checked':''):(empty($phones->get('0')->telegram)?'':'checked') }}>
                    <label class="form-check-label" for="telegramCheck1">
                        <img src="/css/img/telegram-icon.png" class="messenger-icon">
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <input id="viberCheck1" type="checkbox" class="form-check-input" value="1" name="viber1" {{ old('phone1')?(old('viber1')?'checked':''):(empty($phones->get('0')->viber)?'':'checked') }}>
                    <label class="form-check-label" for="viberCheck1">
                        <img src="/css/img/viber-icon.png" class="messenger-icon">
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <input id="whatsappCheck1" type="checkbox" class="form-check-input" value="1" name="whatsapp1" {{ old('phone1')?(old('whatsapp1')?'checked':''):(empty($phones->get('0')->whatsapp)?'':'checked') }}>
                    <label class="form-check-label" for="whatsappCheck1">
                        <img src="/css/img/whatsapp-icon.png" class="messenger-icon">
                    </label>
                </div>
            </div>
            @if ($errors->has('phone2') || $errors->has('phone3') || old('phone2') || old('phone3') || $phones->get('1') || $phones->get('2'))
            <div class="col-md-4 mt-2 mt-md-0 phone"> 
                <div class="form-group">
                    <label class="m-fa-icon mb-2">Телефон</label>
                    <input type="text" class="form-control {{ $errors->has('phone2')?'is-invalid':'' }}" placeholder="Телефон" name="phone2" value="{{ old('phone2')??($phones->get('1')->phone??'') }}">
                    @error('phone2')
                        <div>
                            <small class="text-danger">
                                {{ $message }}
                            </small> 
                        </div>
                    @enderror
                </div>
                <div class="form-check form-check-inline m-fa-icon">
                    <input id="telegramCheck2" type="checkbox" class="form-check-input" value="1" name="telegram2" {{ old('phone2')?(old('telegram2')?'checked':''):(empty($phones->get('1')->telegram)?'':'checked') }}>
                    <label class="form-check-label" for="telegramCheck2">
                        <img src="/css/img/telegram-icon.png" class="messenger-icon">
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <input id="viberCheck2" type="checkbox" class="form-check-input" value="1" name="viber2" {{ old('phone2')?(old('viber2')?'checked':''):(empty($phones->get('1')->viber)?'':'checked') }}>
                    <label class="form-check-label" for="viberCheck2">
                        <img src="/css/img/viber-icon.png" class="messenger-icon">
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <input id="whatsappCheck2" type="checkbox" class="form-check-input" value="1" name="whatsapp2" {{ old('phone2')?(old('whatsapp2')?'checked':''):(empty($phones->get('1')->whatsapp)?'':'checked') }}>
                    <label class="form-check-label" for="whatsappCheck2">
                        <img src="/css/img/whatsapp-icon.png" class="messenger-icon">
                    </label>
                </div>
            </div>
            @endif
            @if ($errors->has('phone3') || old('phone3') || $phones->get('2'))
            <div class="col-md-4 mt-2 mt-md-0 phone" > 
                <div class="form-group">
                    <label class="m-fa-icon mb-2">Телефон</label>
                    <input type="text" class="form-control {{ $errors->has('phone3')?'is-invalid':'' }}" placeholder="Телефон" name="phone3" value="{{ old('phone3')??($phones->get('2')->phone??'') }}">
                    @error('phone3')
                        <div>
                            <small class="text-danger">
                                {{ $message }}
                            </small> 
                        </div>
                    @enderror
                </div>
                <div class="form-check form-check-inline m-fa-icon">
                    <input id="telegramCheck3" type="checkbox" class="form-check-input" value="1" name="telegram3" {{ old('phone3')?(old('telegram3')?'checked':''):(empty($phones->get('2')->telegram)?'':'checked') }}>
                    <label class="form-check-label" for="telegramCheck3">
                        <img src="/css/img/telegram-icon.png" class="messenger-icon">
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <input id="viberCheck3" type="checkbox" class="form-check-input" value="1" name="viber3" {{ old('phone3')?(old('viber3')?'checked':''):(empty($phones->get('2')->viber)?'':'checked') }}>
                    <label class="form-check-label" for="viberCheck3">
                        <img src="/css/img/viber-icon.png" class="messenger-icon">
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <input id="whatsappCheck3" type="checkbox" class="form-check-input" value="1" name="whatsapp3" {{old('phone3')?(old('whatsapp3')?'checked':''):(empty($phones->get('2')->whatsapp)?'':'checked') }}>
                    <label class="form-check-label" for="whatsappCheck3">
                        <img src="/css/img/whatsapp-icon.png" class="messenger-icon">
                    </label>
                </div>
            </div>
            @else
            <div id="addPhone" class="col-md-4 mt-2 mt-md-0 mt-button"> 
                <button type="button" class="btn btn-success" onclick="addPhone()">
                    <i class="fas fa-plus pr-2"></i>
                    Добавить номер
                </button>
            </div>
            @endif
        </div>             
    </div>
</div>

<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'Поле :attribute может принимать значения: yes, on, 1, true',
    'active_url' => ':attribute не является допустимым URL.',
    'after' => ':attribute должно быть датой, более поздней, чем :date.',
    'after_or_equal' => ':attribute должно быть датой, более поздней или равной :date.',
    'alpha' => ':attribute должно содержать только латинские символы.',
    'alpha_dash' => ':attribute должно содержать только латинские символы, цифры, знаки подчёркивания и дефисы.',
    'alpha_num' => ':attribute должно содержать только латинские символы и цифры.',
    'array' => ':attribute должно быть массивом.',
    'before' => ':attribute должно быть датой, более ранней, чем :date.',
    'before_or_equal' => ':attribute должно быть датой, более ранней или равной :date.',
    'between' => [
        'numeric' => ':attribute должно быть числом в диапазоне от :min до :max.',
        'file' => ':attribute должно иметь размер от :min до :max килобайт.',
        'string' => ':attribute должно содержать от :min до :max символов.',
        'array' => ':attribute должно содержать от :min до :max элементов.',
    ],
    'boolean' => 'Поле :attribute должно быть true или false.',
    'confirmed' => ':attribute не совпадает.',
    'date' => ':attribute не является допустимой датой.',
    'date_equals' => ':attribute должно быть равно заданной дате :date.',
    'date_format' => ':attribute должно соответствовать формату :format.',
    'different' => ':attribute и :other должны быть разными.',
    'digits' => ':attribute не является числовым :digits.',
    'digits_between' => ':attribute должно иметь длину от :min до :max.',
    'dimensions' => ':attribute не допустимый размер изображения.',
    'distinct' => 'Поле :attribute имеет такое же значение.',
    'email' => ':attribute не является электронной почтой.',
    'ends_with' => ':attribute должно заканчиваться одним из указанных значений: :values',
    'exists' => 'Значение :attribute не является допустимым.',
    'file' => ':attribute должен быть файлом.',
    'filled' => 'Поле :attribute не должно быть пустым.',
    'gt' => [
        'numeric' => ':attribute должно быть больше, чем :value.',
        'file' => ':attribute должно быть больше, чем :value килобайт.',
        'string' => ':attribute должно иметь больше, чем :value символов.',
        'array' => ':attribute должно иметь больше, чем :value элементов.',
    ],
    'gte' => [
        'numeric' => ':attribute должно быть больше или равно :value.',
        'file' => ':attribute должно быть больше или равно :value килобайт.',
        'string' => ':attribute должно быть больше или равно :value символов.',
        'array' => ':attribute должен иметь :value элементов или более.',
    ],
    'image' => ':attribute должно быть изображением.',
    'in' => ':attribute не является допустимым.',
    'in_array' => 'Поле :attribute не существует в :other.',
    'integer' => ':attribute должно быть целочисленным значением.',
    'ip' => ':attribute должно являться допустимым IP адресом.',
    'ipv4' => ':attribute должно являться допустимым IPv4 адресом.',
    'ipv6' => ':attribute должно являться допустимым IPv6 адресом.',
    'json' => ':attribute должно являться допустимой JSON строкой.',
    'lt' => [
        'numeric' => ':attribute должно быть меньше, чем :value.',
        'file' => ':attribute должно быть меньше, чем :value kilobytes.',
        'string' => ':attribute должно быть меньше, чем :value characters.',
        'array' => ':attribute должно иметь не более :value элементов.',
    ],
    'lte' => [
        'numeric' => ':attribute должно быть меньше или равно :value.',
        'file' => ':attribute должен быть меньше или равно :value kilobytes.',
        'string' => ':attribute должен быть меньше либо равен :value символов.',
        'array' => 'The :attribute must not have more than :value items.',
    ],
    'max' => [
        'numeric' => ':attribute не может быть больше, чем :max.',
        'file' => ':attribute не может иметь размер более :max килобайт.',
        'string' => ':attribute  не может содержать более :max символов.',
        'array' => ':attribute  не может иметь более :max элементов.',
    ],
    'mimes' => ':attribute файл должен иметь тип: :values.',
    'mimetypes' => ':attribute файл должен соответствовать одному из типов: :values.',
    'min' => [
        'numeric' => ':attribute должен быть не менее :min.',
        'file' => ':attribute должен быть не менее :min килобайт.',
        'string' => ':attribute должен иметь не менее :min символов.',
        'array' => ':attribute должен иметь не менее :min элементов.',
    ],
    'not_in' => ':attribute не является допустимым.',
    'not_regex' => ':attribute недопустимый формат.',
    'numeric' => ':attribute должен быть числом.',
    'present' => 'Поле:attribute должно быть в данных ввода.',
    'regex' => ':attribute недопустимый формат.',
    'required' => 'Поле :attribute обязательно.',
    'required_if' => 'Поле :attribute обязательно, когда :other равно :value.',
    'required_unless' => 'Поле :attribute обязательно, когда :other не равно :values.',
    'required_with' => 'Поле :attribute обязательно, когда существует хотя бы одно из :values.',
    'required_with_all' => 'Поле :attribute обязательно, когда существуют все из :values.',
    'required_without' => 'Поле :attribute обязательно, когда не существует хотя бы одно из :values.',
    'required_without_all' => 'Поле :attribute обязательно, когда не существуют все из :values.',
    'same' => ':attribute и :other должны совпадать.',
    'size' => [
        'numeric' => ':attribute должно быть равно :size.',
        'file' => ':attribute должно иметь размер :size килобайт.',
        'string' => ':attribute должен иметь :size символов.',
        'array' => ':attribute должен содержать :size элементов.',
    ],
    'starts_with' => ':attribute должно начинаться с: :values',
    'string' => ':attribute должно быть строкой.',
    'timezone' => ':attribute недопустимый часовой пояс.',
    'unique' => 'Такое :attribute уже существует.',
    'uploaded' => ':attribute ошибка загрузки.',
    'url' => ':attribute неверный формат.',
    'uuid' => ':attribute недопустимый  UUID.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'name'          => 'Имя клиента',
        'username'      => 'Имя сотрудника',
        'phone1'        => 'Телефонный номер 1',
        'phone2'        => 'Телефонный номер 2',
        'phone3'        => 'Телефонный номер 3',
        'email'         => 'Имя электронная почты',
        'customer'      => 'Клиент',
        'engineer'      => 'Мастер',
        'role'          => 'Должность',
        'passport'      => 'Паспорт',
        'itin'          => 'ИНН',
        'address'       => 'Адрес',
        'hired_date'    => 'Дата приема',
        'fired_date'    => 'Дата уволнения',
        'order_comment' => 'Комментарий',
        'qualification' => 'Квалификация',
        'comment'       => 'Комментарий',
        'description'   => 'Описание',
        'password'      => 'Пароль',
        'password_confirmation' => 'Подтверждение пароля',

        'companyname'       => 'Название',
        'legalname'         => 'Юридическое название',
        'unitcode'          => 'Код отделения',
        'currency'          => 'Валюта',
        'repair_conditions' => 'Условия ремонта',

        'price'         => 'Цена',
        'discount'      => 'Скикда',
        'quantity'      => 'Количество',
        'infinity'      => 'Не ограничено',
        'sales'         => 'Продано',
        'selfpart'      => '',
        'priority'      => 'Приоритет',
        'main'          => 'Основной',

        'typedevice'    => 'Тип устройства',
        'date_contract' => 'Дата оформления',
        'time_contract' => 'Время оформления',
        'deadline'      => 'Срок',
        'agreed_price'  => '',
        'prepayment'    => 'Предоплата',
        'urgency'       => 'Срочность',
        'sn'            => 'Серийный номер',
        'model'         => 'Модель',
        'type'          => 'Тип',
        'manufacturer'  => 'Бренд',
        'conditions'    => 'Состояние',
        'equipments'    => 'Комплектация',
        'defects'       => 'Причина обращения',

        'typedevicename'  => 'Имя типа устройства',
        'manufacturername'=> 'Имя бренда',
        'equipmentname'   => 'Имя комплектации',
        'conditionname'   => 'Имя состояния',
        'defectname'      => 'Имя причины',
        'repairpartname'  => 'Имя запасной части',
        'statusname'      => 'Имя статуса',
        'servicename'     => 'Имя услуги',
    ],

];

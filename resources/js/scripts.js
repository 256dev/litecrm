$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function addPhone() {
    const items = $('#phones').children('.phone')
    const num = items.length
    if (num < 3) {
        let newPhone = `
                <div class="col-md-4 mt-2 mt-md-0 phone"> 
                    <div id="new-customer-phone${num + +1}" class="form-group">
                        <label class="m-fa-icon mb-2">Телефон</label>
                        <input type="text" class="form-control" placeholder="Телефон" name="phone${num + +1}">
                        <div class="d-none">
                            <small class="text-danger">
                            </small> 
                        </div>
                    </div>
                    <div class="form-check form-check-inline m-fa-icon">
                        <input id="telegramCheck${num + +1}" type="checkbox" class="form-check-input" value="1" name="telegram${num + +1}">
                        <label class="form-check-label" for="telegramCheck${num + +1}">
                            <img src="/css/img/telegram-icon.png" class="messenger-icon">
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input id="viberCheck${num + +1}" type="checkbox" class="form-check-input" value="1" name="viber${num + +1}">
                        <label class="form-check-label" for="viberCheck${num + +1}">
                            <img src="/css/img/viber-icon.png" class="messenger-icon">
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input id="whatsappCheck${num + +1}" type="checkbox" class="form-check-input" value="1" name="whatsapp${num + +1}">
                        <label class="form-check-label" for="whatsappCheck${num + +1}">
                            <img src="/css/img/whatsapp-icon.png" class="messenger-icon">
                        </label>
                    </div>
                </div>
                `
        items.last().after(newPhone)
        if (num == 2) {
            $('#addPhone').remove()
        }
    }
}

function addCustomerOrder(event, customer_id) {
    event.stopPropagation()
    window.location.href = customer_id
}

$(document).ready(() => {
    $('.search-customer').select2({
        ajax: {
            url: '/search/customer',
            type: 'POST',
            dataType: 'json',
            data:  params => {
                const query = { search: params.term }
                return query
            },
            processResults: response => {
                return {
                    results: $.map(response, function(item) {
                        return {
                            id: item.id,
                            text: item.name
                        }
                    })
                }
            }
        },
        width: '100%',
        minimumInputLength: 1, //Сделать вывод 15
        maximumInputLength: 50,
        placeholder: 'Поиск',
        language: 'ru',
    })

    $('.search-customer').on('select2:select', id => { 
        getCustomerInfo(id.target.value)
    })

    $('.search-sn').select2({
        ajax: {
            url: '/search/sn',
            type: 'POST',
            dataType: 'json',
            data: function (params) {
                const query = { search: params.term }
                return query
            },
            processResults: response => {
                return {
                    results: $.map(response, function(item) {
                        return { id: item.id, text: item.SN }
                    })
                };
            }
        },
        createTag : params => {
            return {
                id: `new_${params.term}`, 
                text: params.term,
                newTag: true
            }
        },
        tags: true,
        width: '100%',
        maximumInputLength: 32,
        language: 'ru',
    })

    $('.search-sn').on('select2:select', id => {
        const snid = id.target.value
        if (snid.search(/^new_/g) != 0) {
            $.ajax({
                url: '/info/sn',
                type: 'POST',
                dataType: 'json',
                data: { id: snid },
                success: response => {
                    if (response.modelId) {
                        let newModel = new Option(response.modelName, response.modelId, true, true)
                        $('.search-model').append(newModel).trigger('change')
                        let newTypeDevice = new Option(response.typeName, response.typeId, true, true)
                        $('.search-typedevice').append(newTypeDevice).trigger('change')
                        let newManufacturer = new Option(response.manufacturerName, response.manufacturerId, true, true)
                        $('.search-manufacturer').append(newManufacturer).trigger('change')
                        $('.defect').html('')    
                    }
                }
            })
        } else {
            $('.search-model').html('')
            $('.search-typedevice').val(null).trigger('change')
            $('.search-manufacturer').val(null).trigger('change')
            $('.defect').html('')
        }
    })

    $('.search-typedevice').select2({
        ajax: {
            url: '/search/typedevice',
            type: 'POST',
            dataType: 'json',
            data: params => {
                const query = { search: params.term }
                return query
            },
            processResults: response => {
                return {
                    results: $.map(response, function(item) {
                        return { 
                            id: item.id,
                            text: item.name 
                        }
                    })
                }
            }
        },
        createTag : params => {
            return {
                id: `new_${params.term}`,
                text: params.term,
                newTag: true
            }
        },
        tags: true,
        width: '100%',
        maximumInputLength: 50,
        language: 'ru',
    })

    $('.search-manufacturer').select2({
        ajax: {
            url: '/search/manufacturer',
            type: 'POST',
            dataType: 'json',
            data: params => {
                const query = { search: params.term }
                return query
            },
            processResults: response => {
                return {
                    results: $.map(response, function(item) {
                        return { 
                            id: item.id,
                            text: item.name 
                        }
                    })
                }
            }
        },
        createTag : params => {
            return {
                id: `new_${params.term}`,
                text: params.term,
                newTag: true
            }
        },
        tags: true,
        width: '100%',
        maximumInputLength: 50,
        language: 'ru',
    })

    $('.search-model').select2({
        ajax: {
            url: '/search/model',
            type: 'POST',
            dataType: 'json',
            data: params => {
                const query = { search: params.term }
                return query
            },
            processResults: response => {
                return {
                    results: $.map(response, function(item) {
                        return { 
                            id: item.id,
                            text: item.name 
                        }
                    })
                }
            }
        },
        createTag : params => {
            return {
                id: `new_${params.term}`,
                text: params.term,
                newTag: true
            }
        },
        tags: true,
        width: '100%',
        minimumInputLength: 1, //Сделать вывод 15
        maximumInputLength: 50,
        language: 'ru',
    })

    $('.search-model').on('select2:select', id => {
        const modelid = id.target.value
        if (modelid.search(/^new_/g) != 0) {
            $.ajax({
                url: '/info/model',
                type: 'POST',
                dataType: 'json',
                data: { id: modelid },
                success: response => {
                    if (response.typeId) {
                        let newTypeDevice = new Option(response.typeName, response.typeId, true, true)
                        $('.search-typedevice').append(newTypeDevice).trigger('change')
                        let newManufacturer = new Option(response.manufacturerName, response.manufacturerId, true, true)
                        $('.search-manufacturer').append(newManufacturer).trigger('change')
                    }
                }
            })
        } else {
            $('.search-typedevice').val(null).trigger('change')
            $('.search-manufacturer').val(null).trigger('change')
        }
    })

    $('.condition').select2({
        ajax: {
            url: '/search/condition',
            type: 'POST',
            dataType: 'json',
            data:  params => {
                const query = { search: params.term }
                return query
            },
            processResults: response => {
                return {
                    results: $.map(response, item => {
                        return { 
                            id: item.id,
                            text: item.name 
                        }
                    })
                }
            }
        },
        createTag : params => {
            return {
                id: `new_${params.term}`,
                text: params.term,
                newTag: true
            }
        },
        tags: true,
        width: '100%',
        maximumInputLength: 50,
        language: 'ru',
    })

    $('.equipment').select2({
        ajax: {
            url: '/search/equipment',
            type: 'POST',
            dataType: 'json',
            data:  params => { 
                const query = { search: params.term }
                return query
            },
            processResults: response => {
                return {
                    results: $.map(response, item => {
                        return {
                            id: item.id,
                            text: item.name 
                        }
                    })
                }
            }
        },
        createTag : params => {
            return {
                id: `new_${params.term}`,
                text: params.term,
                newTag: true
            }
        },
        tags: true,
        width: '100%',
        maximumInputLength: 50,
        language: 'ru',
    })

    $('.defect').select2({
        ajax: {
            url: '/search/defect',
            type: 'POST',
            dataType: 'json',
            data: params => { const query = { search: params.term }
                return query
            },
            processResults: response => {
                return {
                    results: $.map(response, item => {
                        return {
                            id: item.id,
                            text: item.name
                        }
                    })
                }
            }
        },
        createTag: params => {
            return {
                id: `new_${params.term}`,
                text: params.term,
                newTag: true
            }
        },
        tags: true,
        width: '100%',
        maximumInputLength: 50,
        language: 'ru',
    })

    $('.engineer').select2({
        width: '100%',
        language: 'ru',
    });

    $('.search-service').select2({
        ajax: {
            url: '/search/service',
            type: 'POST',
            dataType: 'json',
            data: params => {
                const query = { search: params.term }
                return query
            },
            processResults: response => {
                return {
                    results: $.map(response, item => {
                        return { 
                            id: item.id,
                            text: item.name }
                    })
                }
            }
        },
        createTag : params => { 
            return {
                id: `new_${params.term}`, 
                text: params.term,
                newTag: true
            } 
        },
        tags: true,
        width: '100%',
        maximumInputLength: 50,
        language: 'ru',
    })

    $('.search-service').on('select2:select', id => {
        $('#add-service-status').remove()
        $('.is-invalid').removeClass('is-invalid')
        $('.text-danger').html('')
        let serviceId = id.target.value
        if (serviceId.search(/^new_/g) != 0) {
            $.ajax({
                url: '/info/typeservice',
                type: 'POST',
                dataType: 'json',
                data: { id: serviceId },
                success: response => {
                    if (response.price) {
                        $('#service-price').val(response.price)
                        $('#service-description').html(response.description)    
                    }
                }
            })
        } else {
            $('#service-description').html('')
            $('#service-description').append('<textarea class="form-control" name="description"></textarea>')
        }
    })

    $('.search-repairpart').select2({
        ajax: {
            url: '/search/repairpart',
            type: 'POST',
            dataType: 'json',
            data: params => {
                const query = { search: params.term }
                return query
            },
            processResults: response => {
                return {
                    results: $.map(response, item => {
                        return { 
                            id: item.id,
                            text: item.name
                        }
                    })
                }
            }
        },
        createTag : params => { 
            return {
                id: `new_${params.term}`, 
                text: params.term,
                newTag: true
            } 
        },
        tags: true,
        width: '100%',
        maximumInputLength: 50,
        language: 'ru',
    })

    $('.search-repairpart').on('select2:select', id => {
        $('#add-repairpart-status').remove()
        $('.is-invalid').removeClass('is-invalid')
        $('.text-danger').html('')
        let serviceId = id.target.value
        if (serviceId.search(/^new_/g) != 0) {
            $.ajax({
                url: '/info/repairpart',
                type: 'POST',
                dataType: 'json',
                data: { id: serviceId },
                success: response => {
                    if (response.price) {
                        $('#repairpart-price').val(response.price)
                        $('#repairpart-description').html(response.description)
                    }
                }
            })
        } else {
            $('#repairpart-description').html('')
            $('#repairpart-description').append('<textarea class="form-control" name="description"></textarea>')
        }
    })

    $('.search-status').select2({
        ajax: {
            url: '/search/status',
            type: 'POST',
            dataType: 'json',
            processResults: response => {
                return {
                    results: $.map(response, item => {
                        return { 
                            id: item.id,
                            text: item.name
                        }
                    })
                }
            }
        },
        width: '100%',
        language: 'ru',
    })

    $('#role').select2({
        width: '100%',
        language: 'ru',
    })
})

$('#add-new-cutomer').on('click', () => { 
    $('#add-new-cutomer-form').ajaxSubmit({
        success: response => {
            $('#new-customer-status').remove()
            $('.is-invalid').removeClass('is-invalid')
            $('.text-danger').html('')
            if (response.status == 2) {
                for (const [key, value] of Object.entries(response.errors)) {
                    if (key == 'comment') {
                        $(`#new-customer-${key} textarea`).addClass('is-invalid')
                    } else {
                        $(`#new-customer-${key} input`).addClass('is-invalid')
                    }
                    $(`#new-customer-${key} div`).removeClass('d-none')
                    $(`#new-customer-${key} small`).html(value)
                }
                $('#new-customer').append(`<div id="new-customer-status" class="alert alert-${response.message[1]} col-12 text-center" role="alert">${response.message[0]}</div>`)
            }
            if (response.status == 1) {
                getCustomerInfo(response.id);
                $('#new-customer-name input').val('')
                $('#new-customer-email input').val('')
                $('#new-customer-comment input').val('')
                $('#new-customer-address input').val('')
                $('#new-customer-passport input').val('')
                $('#new-customer-phone1 input').val('')
                $('#addCustomer').modal('hide')
                $('#new-customer-added').prepend(`<div id="new-customer-status" class="alert alert-${response.message[1]} col-12 text-center" role="alert">${response.message[0]}</div>`)
                setTimeout(() => $('#new-customer-status').remove(), 5000)
            }
            if (response.status == 3) {
                console.log(response.error)
                $('#new-customer').append(`<div id="new-customer-status" class="alert alert-${response.message[1]} col-12 text-center" role="alert">${response.message[0]}</div>`)
            }
        },
        error: () => { 
            $('#new-customer-status').remove()
            $('#new-customer').append(`<div id="new-customer-status" class="alert alert-danger col-12 text-center" role="alert">Ошибка на стороне сервера</div>`)
        }
    })
})

$('#order-button').on('click', () => { 
    $('#order-form').ajaxSubmit({
        success: response => {
            $('#new-order-status').remove()
            $('.is-invalid').removeClass('is-invalid')
            $('.text-danger').html('')
            if (response.status == 2) {
                for (const [key, value] of Object.entries(response.errors)) {
                    if (key == 'order_comment') {
                        $(`#new-order-${key} textarea`).addClass('is-invalid');
                    } else if (key == 'sn' || key == 'model' || key == 'manufacturer' || key == 'typedevice') {
                        $(`#new-order-${key} select`).addClass('is-invalid')
                    } else if (key == 'date_contract' || key == 'time_contract') {
                        $(`#new-order-date div input`).addClass('is-invalid')
                        $(`#new-order-date div`).removeClass('d-none')
                        $(`#new-order-date small`).html(value)    
                    } else {
                        $(`#new-order-${key} input`).addClass('is-invalid')
                    }
                    $(`#new-order-${key} div`).removeClass('d-none')
                    $(`#new-order-${key} small`).html(value)
                }
                $('#new-order').append(`<div id="new-order-status" class="alert alert-danger text-center" role="alert">${response.message[0]}</div>`)
            }
            if (response.status == 1) {
                window.location.href=response.order_route
            }
            if (response.status == 3) {
                console.log(response.error)
                $('#new-order').append(`<div id="new-order-status" class="alert alert-danger text-center" role="alert">${response.message[0]}</div>`)
            }
        },
        error: () => { 
            $('#new-order-status').remove()
            $('#new-order').append(`<div id="new-order-status" class="alert alert-danger text-center" role="alert">Ошибка на стороне сервера</div>`) 
        }
    })
})

$('#add-service-buttom').on('click', () => {
    if (!$('.search-service').val()) {
        $('#add-service-status').remove()
        $(`#add-service-servicename div`).removeClass('d-none')
        $(`#add-service-servicename small`).html('Услуга не выбрана')
        $('#add-service').append('<div id="add-service-status" class="alert alert-danger text-center mt-1 mt-md-3" role="alert">Услуга не выбрана</div>')
    } else { 
        $('#add-service-form').ajaxSubmit({
            success: response => {
                $('#add-service-status').remove()
                $('.is-invalid').removeClass('is-invalid')
                $('.text-danger').html('')
                if (response.status == 2) {
                    for (const [key, value] of Object.entries(response.errors)) {
                        if (key == 'description') {
                            $(`#add-service-${key} textarea`).addClass('is-invalid')
                        } else if (key == 'servicename') {
                            $(`#add-service-${key} select`).addClass('is-invalid')
                        } else {
                            $(`#add-service-${key} input`).addClass('is-invalid')
                        }
                        $(`#add-service-${key} div`).removeClass('d-none')
                        $(`#add-service-${key} small`).html(value);
                    };
                    $('#add-service').append(`<div id="add-service-status" class="alert alert-${response.message[1]} text-center mt-1 mt-md-3" role="alert">${response.message[0]}</div>`)
                }
                if (response.status == 1) {
                    $('#add-service-block tbody').append(`
                        <tr id="service-${response.info.id}" class="pointer" onclick="updateService(${response.info.id});">
                            <td scope="row" class="align-middle">
                                ${response.info.name}
                            </td>
                            <td scope="row" class="align-middle text-center quantity">
                                ${parseFloat(response.info.quantity).toFixed(2)}
                            </td>
                            <td scope="row" class="align-middle text-center price">
                                ${parseFloat(response.info.price.item).toFixed(2)} ${response.info.currency}
                            </td>
                        </tr>
                    `)
                    $('#price-service').html(parseFloat(response.info.price.all).toFixed(2) + ' ' + response.info.currency)
                    $('#price-total').html(parseFloat(response.info.price.total).toFixed(2) + ' ' + response.info.currency)
                    $('#addService').modal('hide')
                    $('#add-service-block div').append(`<div id="add-service-status" class="d-inline px-4 py-1 border rounded alert-${response.message[1]} text-center" role="alert">${response.message[0]}</div>`)
                    setTimeout(() => $('#add-service-status').remove(), 5000)
                }
                if (response.status == 3) {
                    console.log(response.error)
                    $('#add-service').append(`<div id="add-service-status" class="alert alert-${response.message[1]} text-center mt-1 mt-md-3" role="alert">${response.message[0]}</div>`)
                }
            },
            error: () => { 
                $('#add-service-status').remove()
                $('#add-service').append('<div id="add-service-status" class="alert alert-danger text-center mt-1 mt-md-3" role="alert">Ошибка на стороне сервера</div>') 
            }
        })
    }   
})

function updateService(id) {
    let serviceId = id
    $.ajax({
        url: '/info/service',
        type: 'POST',
        dataType: 'json',
        data: { id: serviceId },
        success: response => {
            $('#upd-service-servicename p').html(response.name)
            $('#upd-service-price').val(response.price)
            $('#upd-service-quantity').val(response.quantity)
            $('#upd-service-description').html(response.description)
            $('#update-sevice-id').val(response.id)

        }
    })
    $('#updateService').modal('show');
}

$('#update-service-buttom').on('click', () => {
    $('#update-service-form').ajaxSubmit({
        type: 'PUT',
        dataType: 'json',
        success: response => {
            $('#update-status-service').remove()
            $('.is-invalid').removeClass('is-invalid')
            $('.text-danger').html('')
            if (response.status == 2) {
                for (const [key, value] of Object.entries(response.errors)) {
                    $(`#update-service-${key} input`).addClass('is-invalid')
                    $(`#update-service-${key} div`).removeClass('d-none')
                    $(`#update-service-${key} small`).html(value);
                };
                $('#update-service').append(`<div id="update-status-servic" class="alert alert-${response.message[1]} text-center mt-1 mt-md-3" role="alert">${response.message[0]}</div>`)
            }
            if (response.status == 1) {
                const tr = $(`#add-service-block tbody #service-${response.info.id}`)
                tr.find('.quantity').html(parseFloat(response.info.quantity).toFixed(2))
                tr.find('.price').html(parseFloat(response.info.price.item).toFixed(2) + ' ' + response.info.currency)
                $('#price-service').html(parseFloat(response.info.price.all).toFixed(2) + ' ' + response.info.currency)
                $('#price-total').html(parseFloat(response.info.price.total).toFixed(2) + ' ' + response.info.currency)
                $('#updateService').modal('hide')
                $('#add-service-block div').append(`<div id="add-service-status" class="d-inline px-4 py-1 border rounded alert-${response.message[1]} text-center" role="alert">${response.message[0]}</div>`)
                setTimeout(() => $('#add-service-status').remove(), 5000)
            }
            if (response.status == 3) {
                console.log(response.error)
                $('#update-service').append(`<div id="update-status-servic" class="alert alert-${response.message[1]} text-center mt-1 mt-md-3" role="alert">${response.message[0]}</div>`)
            }
        },
        error: () => { 
            $('#update-status-service').remove()
            $('#update-service').append('<div id="update-status-service" class="alert alert-danger text-center mt-1 mt-md-3" role="alert">Ошибка на стороне сервера</div>') 
        }
    })
})

$('#delete-service-buttom').on('click', () => {
    $('#update-service-form').ajaxSubmit({
        type: 'DELETE',
        dataType: 'json',
        success: response => {
            $('#update-status-service').remove()
            $('.is-invalid').removeClass('is-invalid')
            $('.text-danger').html('')
            if (response.status == 1) {
                $(`#add-service-block tbody #service-${response.info.id}`).remove()
                $('#price-service').html(parseFloat(response.info.price.all).toFixed(2) + ' ' + response.info.currency)
                $('#price-total').html(parseFloat(response.info.price.total).toFixed(2) + ' ' + response.info.currency)
                $('#updateService').modal('hide')
                $('#add-service-block div').append(`<div id="add-service-status" class="d-inline px-4 py-1 border rounded alert-${response.message[1]} text-center" role="alert">${response.message[0]}</div>`)
                setTimeout(() => $('#add-service-status').remove(), 5000)
            }
            if (response.status == 3) {
                console.log(response.error)
                $('#update-service').append(`<div id="update-status-servic" class="alert alert-${response.message[1]} text-center mt-1 mt-md-3" role="alert">${response.message[0]}</div>`)
            }
        },
        error: () => { 
            $('#update-status-service').remove()
            $('#update-service').append('<div id="update-status-service" class="alert alert-danger text-center mt-1 mt-md-3" role="alert">Ошибка на стороне сервера</div>') 
        }
    })
})

$('#add-repairpart-buttom').on('click', () => {
    if (!$('.search-repairpart').val()) {
        $('#add-repairpart-status').remove()
        $(`#add-repairpart-repairpartname div`).removeClass('d-none')
        $(`#add-repairpart-repairpartname small`).html('Материал не выбран')
        $('#add-repairpart').append('<div id="add-repairpart-status" class="alert alert-danger text-center mt-1 mt-md-3" role="alert">Запасная часть не выбрана</div>')
    } else { 
        $('#add-repairpart-form').ajaxSubmit({
            success: response => {
                $('#add-repairpart-status').remove()
                $('.is-invalid').removeClass('is-invalid')
                $('.text-danger').html('')
                if (response.status == 2) {
                    for (const [key, value] of Object.entries(response.errors)) {
                        if (key == 'description') {
                            $(`#add-repairpart-${key} textarea`).addClass('is-invalid')
                        } else if (key == 'repairpartname') {
                            $(`#add-repairpart-${key} select`).addClass('is-invalid')
                        } else {
                            $(`#add-repairpart-${key} input`).addClass('is-invalid')
                        }
                        $(`#add-repairpart-${key} div`).removeClass('d-none')
                        $(`#add-repairpart-${key} small`).html(value);
                    };
                    $('#add-repairpart').append(`<div id="add-repairpart-status" class="alert alert-${response.message[1]} text-center mt-1 mt-md-3" role="alert">${response.message[0]}</div>`)
                }
                if (response.status == 1) {
                    let selfpart
                    if (response.info.selfpart == 1) {
                        selfpart = '<i class="fas fa-check" aria-hidden="true"></i>'
                    } else {
                        selfpart = '<i class="fas fa-times" aria-hidden="true"></i>'
                    }
                    $('#add-repairpart-block tbody').append(`
                        <tr id="repairpart-${response.info.id}" class="pointer" onclick="updateRepairpart(${response.info.id});">
                            <td scope="row" class="align-middle">
                                ${response.info.name}
                            </td>
                            <td scope="row" class="align-middle text-center quantity">
                                ${parseFloat(response.info.quantity).toFixed(2)}
                            </td>
                            <td scope="row" class="align-middle text-center price">
                                ${parseFloat(response.info.price.item).toFixed(2)} ${response.info.currency}
                            </td>
                            <td scope="row" class="align-middle text-center selfpart">
                                ${selfpart}
                            </td>
                        </tr>
                    `)
                    $('#price-repairpart').html(parseFloat(response.info.price.all).toFixed(2) + ' ' + response.info.currency)
                    $('#price-total').html(parseFloat(response.info.price.total).toFixed(2) + ' ' + response.info.currency)
                    $('#addRepairPart').modal('hide');
                    $('#add-repairpart-block div').append(`<div id="add-repairpart-status" class="d-inline px-4 py-1 border rounded alert-${response.message[1]} col-12 text-center" role="alert">${response.message[0]}</div>`)
                    setTimeout(() => $('#add-repairpart-status').remove(), 5000)
                }
                if (response.status == 3) {
                    console.log(response.error)
                    $('#add-repairpart').append(`<div id="add-repairpart-status" class="alert alert-${response.message[1]} text-center mt-1 mt-md-3" role="alert">${response.message[0]}</div>`)
                }
            },
            error: () => { 
                $('#add-repairpart-status').remove()
                $('#add-repairpart').append('<div id="add-repairpart-status" class="alert alert-danger text-center mt-1 mt-md-3" role="alert">Ошибка на стороне сервера</div>') 
            }
        })
    }   
})

function updateRepairpart(id) {
    let serviceId = id
    $.ajax({
        url: '/info/repairpart',
        type: 'POST',
        dataType: 'json',
        data: { id: serviceId },
        success: response => {
            $('#upd-repairpart-repairpartname p').html(response.name)
            if (response.selfpart) {
                $('#upd-repairpart-selfpart').prop('checked', true);
            }
            $('#upd-repairpart-price').val(response.price)
            $('#upd-repairpart-quantity').val(response.quantity)
            $('#upd-repairpart-description').html(response.description)
            $('#update-repairpart-id').val(response.id)

        }
    })
    $('#updateRepairPart').modal('show');
}

$('#update-repairpart-buttom').on('click', () => {
    $('#update-repairpart-form').ajaxSubmit({
        type: 'PUT',
        dataType: 'json',
        success: response => {
            $('#update-status-repairpart').remove()
            $('.is-invalid').removeClass('is-invalid')
            $('.text-danger').html('')
            if (response.status == 2) {
                for (const [key, value] of Object.entries(response.errors)) {
                    $(`#update-repairpart-${key} input`).addClass('is-invalid')
                    $(`#update-repairpart-${key} div`).removeClass('d-none')
                    $(`#update-repairpart-${key} small`).html(value);
                };
                $('#update-repairpart').append(`<div id="update-status-repairpart" class="alert alert-${response.message[1]} text-center mt-1 mt-md-3" role="alert">${response.message[0]}</div>`)
            }
            if (response.status == 1) {
                const tr = $(`#add-repairpart-block tbody #repairpart-${response.info.id}`)
                let selfpart
                if (response.info.selfpart == 1) {
                    selfpart = '<i class="fas fa-check" aria-hidden="true"></i>'
                } else {
                    selfpart = '<i class="fas fa-times" aria-hidden="true"></i>'
                }
                tr.find('.selfpart').html(selfpart)
                tr.find('.quantity').html(parseFloat(response.info.quantity).toFixed(2))
                tr.find('.price').html(parseFloat(response.info.price.item).toFixed(2) + ' ' + response.info.currency)
                $('#price-repairpart').html(parseFloat(response.info.price.all).toFixed(2) + ' ' + response.info.currency)
                $('#price-total').html(parseFloat(response.info.price.total).toFixed(2)  + ' ' + response.info.currency)
                $('#updateRepairPart').modal('hide')
                $('#add-repairpart-block div').append(`<div id="add-repairpart-status" class="d-inline px-4 py-1 border rounded alert-${response.message[1]} text-center" role="alert">${response.message[0]}</div>`)
                setTimeout(() => $('#add-repairpart-status').remove(), 5000)
            }
            if (response.status == 3) {
                console.log(response.error)
                $('#update-repairpart').append(`<div id="update-status-repairpart" class="alert alert-${response.message[1]} text-center mt-1 mt-md-3" role="alert">${response.message[0]}</div>`)
            }
        },
        error: () => { 
            $('#update-status-repairpart').remove()
            $('#update-repairpart').append('<div id="update-status-repairpart" class="alert alert-danger text-center mt-1 mt-md-3" role="alert">Ошибка на стороне сервера</div>') 
        }
    })
})

$('#delete-repairpart-buttom').on('click', () => {
    $('#update-repairpart-form').ajaxSubmit({
        type: 'DELETE',
        dataType: 'json',
        success: response => {
            $('#update-status-repairpart').remove()
            $('.is-invalid').removeClass('is-invalid')
            $('.text-danger').html('')
            if (response.status == 1) {
                $(`#add-repairpart-block tbody #repairpart-${response.info.id}`).remove()
                $('#price-repairpart').html(parseFloat(response.info.price.all).toFixed(2) + ' ' + response.info.currency)
                $('#price-total').html(parseFloat(response.info.price.total).toFixed(2) + ' ' + response.info.currency)
                $('#updateRepairPart').modal('hide')
                $('#add-repairpart-block div').append(`<div id="add-repairpart-status" class="d-inline px-4 py-1 border rounded  alert-${response.message[1]} text-center" role="alert">${response.message[0]}</div>`)
                setTimeout(() => $('#add-repairpart-status').remove(), 5000)
            }
            if (response.status == 3) {
                console.log(response.error)
                $('#update-repairpart').append(`<div id="update-status-repairpart" class="alert alert-${response.message[1]} text-center mt-1 mt-md-3" role="alert">${response.message[0]}</div>`)
            }
        },
        error: () => { 
            $('#update-status-repairpart').remove()
            $('#update-repairpart').append('<div id="update-status-repairpart" class="alert alert-danger text-center mt-1 mt-md-3" role="alert">Ошибка на стороне сервера</div>') 
        }
    })
})

$('#add-status-buttom').on('click', () => {
    if (!$('.search-status').val()) {
        $('#add-status-status').remove()
        $(`#add-status-statusname div`).removeClass('d-none')
        $(`#add-status-statusname small`).html('Статус не выбран')
        $('#add-status').append('<div id="add-status-status" class="alert alert-danger text-center mt-1 mt-md-3" role="alert">Статус не выбран</div>')
    } else { 
        $('#add-status-form').ajaxSubmit({
            success: response => {
                $('#add-status-status').remove()
                $('.is-invalid').removeClass('is-invalid')
                $('.text-danger').html('')
                if (response.status == 2) {
                    for (const [key, value] of Object.entries(response.errors)) {
                        if (key == 'comment') {
                            $(`#add-status-${key} textarea`).addClass('is-invalid')
                        } else {
                            $(`#add-status-${key} select`).addClass('is-invalid')
                        } 
                        $(`#add-status-${key} div`).removeClass('d-none')
                        $(`#add-status-${key} small`).html(value);
                    };
                    $('#add-status').append(`<div id="add-status-status" class="alert alert-${response.message[1]} text-center mt-1 mt-md-3" role="alert">${response.message[0]}</div>`)
                }
                if (response.status == 1) {
                    $('#add-status-block h4').after(`
                        <div class="row justify-content-center pb-1">
                            <div class="col-4 col-sm-5 col-md-4 col-lg-4 pr-1">
                                <span class="status px-1 bg-${response.info.color}">${response.info.name}</span>
                            </div>
                            <div class="col-8 col-sm-5 col-md-4 col-lg-8 pl-1">
                                <span>${response.info.date}</span>
                            </div>
                        </div>
                    `)
                    $('#addStatus').modal('hide')
                    $('#add-status-block h4').append(`<div id="add-status-status" class="px-4 py-1 border rounded  alert-${response.message[1]} col-12 text-center" role="alert">${response.message[0]}</div>`)
                    setTimeout(() => $('#add-status-status').remove(), 5000)
                }
                if (response.status == 3) {
                    console.log(response.error)
                    $('#add-status').append(`<div id="add-status-status" class="alert alert-${response.message[1]} text-center mt-1 mt-md-3" role="alert">${response.message[0]}</div>`)
                }
            },
            error: () => { 
                $('#add-status-status').remove()
                $('#add-status').append('<div id="add-status-status" class="alert alert-danger text-center mt-1 mt-md-3" role="alert">Ошибка на стороне сервера</div>') 
            }
        })
    }   
})

$('#add-discount-buttom').on('click', () => {
    $('#add-discount-form').ajaxSubmit({
        success: response => {
            $('#add-status-discount').remove()
            $('.is-invalid').removeClass('is-invalid')
            $('.text-danger').html('')
            if (response.status == 2) {
                for (const [key, value] of Object.entries(response.errors)) {
                    $(`#add-discount-${key} input`).addClass('is-invalid')
                    $(`#add-discount-${key} div`).removeClass('d-none')
                    $(`#add-discount-${key} small`).html(value);
                };
                $('#add-discount').append(`<div id="add-status-discount" class="alert alert-${response.message[1]} text-center mt-1 mt-md-3" role="alert">${response.message[0]}</div>`)
            }
            if (response.status == 1) {
                $('#price-discount').html(parseFloat(response.info.discount).toFixed(2) + ' ' + response.info.currency)
                $('#price-total').html(parseFloat(response.info.total).toFixed(2) + ' ' + response.info.currency)
                $('#addDiscount').modal('hide')
                $('#add-discount-block').prepend(`<div id="add-status-discount" class="alert alert-${response.message[1]} col-12 text-center" role="alert">${response.message[0]}</div>`)
                setTimeout(() => $('#add-status-discount').remove(), 5000)
            }
            if (response.status == 3) {
                console.log(response.error)
                $('#add-discount').append(`<div id="add-status-discount" class="alert alert-${response.message[1]} text-center mt-1 mt-md-3" role="alert">${response.message[0]}</div>`)
            }
        },
        error: () => { 
            $('#add-status-discount').remove()
            $('#add-discount').append('<div id="add-status-discount" class="alert alert-danger text-center mt-1 mt-md-3" role="alert">Ошибка на стороне сервера</div>') 
        }
    })
})

$('#update-password-button').on('click', () => {
    $('#update-password-form').ajaxSubmit({
        dataType: 'json',
        success: response => {
            $('#update-password-status').remove()
            $('.is-invalid').removeClass('is-invalid')
            $('.text-danger').html('')
            if (response.status == 2) {
                for (const [key, value] of Object.entries(response.errors)) {
                    $(`#upd-${key} input`).addClass('is-invalid')
                    $(`#upd-${key} div`).removeClass('d-none')
                    $(`#upd-${key} small`).html(value);
                };
                $('#update-password').append(`<div id="update-password-status" class="alert alert-${response.message[1]} col-12 text-center mt-1 mt-md-3" role="alert">${response.message[0]}</div>`)
            }
            if (response.status == 1) {
                $('#update-password').append(`<div id="update-password-status" class="alert alert-${response.message[1]} col-12 text-center" role="alert">${response.message[0]}</div>`)
                setTimeout(() => {
                    $('#add-status-discount').remove()
                    $('#updatePassword').modal('hide')
                }, 2500)
            }
            if (response.status == 3) {
                console.log(response.error)
                $('#update-password').append(`<div id="update-password-status" class="alert alert-${response.message[1]} col-12 text-center mt-1 mt-md-3" role="alert">${response.message[0]}</div>`)
            }
        },
        error: () => { 
            $('#update-password').remove()
            $('#update-password').append('<div id="update-password-status" class="alert alert-danger col-12 text-center mt-1 mt-md-3" role="alert">Ошибка на стороне сервера</div>') 
        }
    })
})

function getCustomerInfo(id) {
    $.ajax({
        url: '/info/customer',
        type: "POST",
        data: { id: id },
        dataType: 'json',
        success: response => {
            console.log(response)
            if (response.status == 2) {}
            if (response.status == 1) {
                let phones = ''
                response.phones.forEach(item => {
                    phones += 
                    `<div>
                        <span class="align-middle">${item.phone}</span>
                        ${(item.telegram ? '<img src="/css/img/telegram-icon.png" class="messenger-icon">':'')}
                        ${(item.viber ? '<img src="/css/img/viber-icon.png" class="messenger-icon">':'')}
                        ${(item.whatsapp ? '<img src="/css/img/whatsapp-icon.png" class="messenger-icon">':'')}
                    </div>`
                })
                let orders = ''
                response.orders.forEach(item => {
                    defects = item.defects.map(defect => { return defect.name }).join(', ')
                    orders += 
                        `<tr onclick="getDeviceInfo(${item.id})">
                            <td class="align-middle text-center">
                                ${item.type}
                            </td>
                            <td class="align-middle text-center">
                                <span class="d-block border-bottom border-dark">${item.manufacturer}</span>
                                <span class="d-block">${item.model}</span>
                            </td>
                            <td>
                                ${defects}
                            </td>
                            <td class="align-middle text-center">
                                ${item.date} <span class="status px-1 bg-${item.color}">${item.status}</span>
                            </td>
                        </tr>`
                })
                $('#customer-name').html(`<a href="${response.route}">${response.name}</a>`)
                $('#customer-email').html(response.email ? response.email : '-')
                $('#customer-comment').html(response.comment ? response.comment : '-')
                $('#customer-status').html(response.status_info ? response.status_info : '-')
                $('#customer-phones').html(phones)
                $('#customer-orders').html(orders)
                $('#customer').val(response.id)                
            }
        }
    })
}

function getDeviceInfo(id) {
    $.ajax({
        url: '/info/device',
        type: "POST",
        data: {id: id},
        dataType: 'json',
        success: response => {
            if (response.status == 2) {}
            if (response.status == 1) {
                $('.defect').empty()
                response.defects.forEach(defect => {
                    let newDefect = new Option(defect.name, defect.id, true, true)
                    $('.defect').append(newDefect).trigger('change')
                })
                $('.equipment').empty()
                response.equipments.forEach(equipment => {
                    let newEquipment = new Option(equipment.name, equipment.id, true, true)
                    $('.equipment').append(newEquipment).trigger('change')
                });
                $('.condition').empty()
                response.conditions.forEach(condition => {
                    let newCondition = new Option(condition.name, condition.id, true, true)
                    $('.condition').append(newCondition).trigger('change')
                });
                $('.search-sn').html(`<option value="${response.id}" selected>${response.sn}</option>`)
                $('.search-model').html(`<option value="${response.modelId}" selected>${response.modelName}</option>`)
                let newTypeDevice = new Option(response.typeName, response.typeId, true, true)
                $('.search-typedevice').append(newTypeDevice).trigger('change')
                let newManufacturer = new Option(response.manufacturerName, response.manufacturerId, true, true)
                $('.search-manufacturer').append(newManufacturer).trigger('change')
            }
        }
    })
}

$('#search-bar').on('input', (event) => {
    const search = $(event.target).val()
    const type   = $(event.target).attr('data-type')
    $.ajax({
        url: '/search/topsearch',
        type: 'POST',
        dataType: 'json',
        data: { search: search, type: type },
        success: response => {
            if (type == 'order' || type == 'main') {
                updateOrersTable(response)
            } else if (type == 'customers') {
                updateCustomersTable(response)
            } else if (type == 'users') {
                updateUserTable(response)
            } else if (type == 'devicemodels') {
                updateDevicemodelsTable(response)
            } else {
                updateTableByName(response, type)
            }
            $('#search-empty').remove()
            if (response.length == 0) {
                $('table').after(`
                    <div id="search-empty" class="row justify-content-center">
                        <div><span>Поиск не дал результатов</span></div>
                    </div>
                `)
            }
        },
        errors: e => {
            console.log(e)
        }
    })    
})

function updateTableByName(response, type) {
    let tbody = ''
    response.forEach(item => {
        let main
        if (item.main == 1) {
            main = '<i class="fas fa-check" aria-hidden="true"></i>'
        } else {
            main = '<i class="fas fa-times" aria-hidden="true"></i>'
        }
        let info
        if (type == 'repairparts' || type == 'services') {
            info = parseFloat(item.info).toFixed(2) + ' ' + item.currency
        } else {
            info = item.info
        }
        tbody +=
            `<tr onclick="window.location.href='${item.routeId}'">
                <td scope="row" class="align-middle text-center">
                    ${item.name}
                </td>
                <td scope="row" class="align-middle text-center">
                    ${info}
                </td>
                <td scope="row" class="align-middle text-center">
                    ${main}
                </td>
                <td scope="row" class="align-middle text-center">
                    ${item.priority}
                </td>
            </tr>`
    })
    $('tbody').html(tbody)
}

function updateDevicemodelsTable(response) {
    let tbody = ''
    response.forEach(item => {
        tbody +=
            `<tr onclick="window.location.href='${item.routeId}'">
                <td scope="row" class="align-middle text-center">
                    ${item.name}
                </td>
                <td scope="row" class="align-middle text-center">
                    ${item.typeDevice}
                </td>
                <td scope="row" class="align-middle text-center">
                    ${item.manufacturer}
                </td>
            </tr>`
    })
    $('tbody').html(tbody)
}

function updateOrersTable(response) {
    let tbody = ''
    response.forEach(item => {
        tbody += 
            `<tr class=" ${item.urgency} pointer" onclick="window.location.href='${item.orderId}'">
                <td scope="row" class="align-middle text-center">
                    <span class="d-block border-bottom border-dark">${item.number}</span>
                    <span class="d-block"><a class="link" href="${item.customerId}">${item.customerName}</a></span>
                </td>
                <td class="align-middle text-center">
                    <span class="d-block border-bottom border-dark">${item.type}</span>
                    <span class="d-block">${item.sn?item.sn:'-'}</span>
                </td>
                <td class="align-middle text-center">
                    <span class="d-block border-bottom border-dark">${item.manufacturer}</span>
                    <span class="d-block">${item.model}</span>
                </td>
                <td class="align-middle text-center">
                    <span>${item.date}</span>
                    <span class="status px-1 bg-${item.color}">${item.status}</span>
                </td>
                <td class="align-middle text-center">
                    <span class="d-block border-bottom border-dark">${parseFloat(item.price).toFixed(2)} ${item.currency}</span>
                    <span class="d-block">${parseFloat(item.prepayment).toFixed(2)} ${item.currency}</span>
                </td>
            </tr>`
    })
    $('tbody').html(tbody)
}

function updateCustomersTable(response) {
    let tbody = ''
    response.forEach(item => {
        let phones = ''
        item.phone.forEach(phone => {
            phones += `<div class="text-left">
                        <span class="align-middle">${phone.phone}</span>
                        ${phone.telegram?'<img src="/css/img/telegram-icon.png" class="messenger-icon">':''}
                        ${phone.viber?'<img src="/css/img/viber-icon.png" class="messenger-icon">':''}
                        ${phone.whatsapp?'<img src="/css/img/whatsapp-icon.png" class="messenger-icon">':''}
                    </div>`

        })
        tbody +=
            `<tr onclick="window.location.href='${item.routeId}';">
                <th scope="row" class="align-middle text-center">${item.id}</th>
                <td class="align-middle">
                    <span class="">${item.name}</span>
                </td>
                <td class="align-middle">
                ${phones}
                </td>
                <td class="align-middle text-center">
                    <span class="align-middle"> ${item.orders_in_process}/${item.all_orders}</span>
                    <button class="btn btn-sm btn-success col-12 col-md-4" onclick="addCustomerOrder(event, '${item.orderId}');">
                        <i class="fas fa-plus align-middle" aria-hidden="true"></i>
                    </button>
                </td>
            </tr>`
        phones = ''
    })
    $('tbody').html(tbody)
}

function updateUserTable(response) {
    let tbody = ''
    response.forEach(item => {
        let phones = ''
        item.phones.forEach(phone => {
            phones += `<div class="text-left">
                        <span class="align-middle">${phone[0]}</span>
                        ${phone[1]?'<img src="/css/img/telegram-icon.png" class="messenger-icon">':''}
                        ${phone[2]?'<img src="/css/img/viber-icon.png" class="messenger-icon">':''}
                        ${phone[3]?'<img src="/css/img/whatsapp-icon.png" class="messenger-icon">':''}
                    </div>`

        })
        tbody += `<tr class="pointer ${item.deleted?'bg-danger':''}" onclick="window.location.href='${item.routeId}'">
                    <td scope="row" class="align-middle text-center">
                        ${item.name}
                    </td>
                    <td scope="row" class="align-middle text-center">
                        ${item.email}
                    </td>
                    <td scope="row" class="align-middle text-center">
                        ${phones}
                    </td>
                    <td scope="row" class="align-middle text-center">
                        ${item.role}
                    </td>
                </tr>`
    })
    $('tbody').html(tbody)
}
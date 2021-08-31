toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": false,
    "progressBar": false,
    "positionClass": "toast-top-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "1000",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
}

function populateModal(data, modal) {
    //console.log(data);return false;

    Object.keys(data).forEach(function (field, index) {
        let fieldName = field + '-plch';

        let $fields = modal.find('.' + fieldName);
        if ($fields && $fields.length) {
            Object.keys($fields).forEach(function (fieldIndex) {

                if (!Number.isInteger(Number.parseInt(fieldIndex))) return;

                let singleField = $fields[fieldIndex];
                let tag = singleField.localName;
                //console.log(singleField, tag, singleField.type, data[field]);return false;
                if (tag == 'select') {
                    if (typeof data[field] === "object") {
                        (data[field]).forEach(function (option) {
                            //console.log(singleField, newOption); return false;
                            $(singleField).find('option[value=' + option.id + ']').prop('selected', true).trigger('change');
                        })
                    } else {
                        $(singleField).find('option[value=' + data[field] + ']').prop('selected', true).trigger('change');
                    }
                } else if (tag == 'input') {
                    if (singleField.type == "checkbox") {
                        $(singleField).prop('checked', data[field]);
                    } else {
                        $(singleField).val(data[field]);
                    }
                } else if (tag == 'textarea') {
                    $(singleField).val(data[field]);
                } else if (tag == 'span' || tag == 'div') {
                    $(singleField).html(data[field]);
                }

                //console.log(fieldIndex, singleField, singleField.localName);
            })

        }
    })
}

function isEmpty(arg){
    return (
        arg == null || // Check for null or undefined
        arg.length === 0 || // Check for empty String (Bonus check for empty Array)
        (typeof arg === 'object' && Object.keys(arg).length === 0) // Check for empty Object or Array
    );
}

function ToggleBoolean(booleanType, entityId) {
    let form = "#" + booleanType + "_form" + entityId;
    let model = $(form + " .model").val();
    let status = $(form + " .status").attr('data-status');
    //console.log(status);
    $.ajax({
        type: 'GET',
        url: '/toggle-boolean',
        data: {entityId: entityId, model: model, booleanType: booleanType, status: status},
        success: function (res) {
            if (status == 1) {
                $(form + " .status").removeClass('bg-red').addClass('bg-green').attr('data-status', 0).html('Да');
            } else {
                $(form + " .status").removeClass('bg-green').addClass('bg-red').attr('data-status', 1).html('Не');
            }
        },
        error: function () {
            // $periodUl.find('li').remove();
        }
    });
}

function TogglePermission(permission, entityId) {
    let form = "#" + permission + "_form_" + entityId;
    let model = $(form + " .model").val();
    let status = $(form + " .status").attr('data-status');
    //console.log(status);
    $.ajax({
        type: 'GET',
        url: '/toggle-permissions',
        data: {entityId: entityId, model: model, permission: permission, status: status},
        success: function (res) {
            if (status == 1) {
                $(form + " .status").removeClass('bg-red').addClass('bg-green').attr('data-status', 0).html('Да');
            } else {
                $(form + " .status").removeClass('bg-green').addClass('bg-red').attr('data-status', 1).html('Не');
            }
        },
        error: function () {
            // $periodUl.find('li').remove();
        }
    });
}

$(document).ready(function (e) {

    if($('#summernote').length) {
        $('#summernote').summernote({
            height: 300,
            fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New'],
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']]
            ]
        });
    }
    if ($('.js-toggle-delete-resource-modal').length) {
        $('.js-toggle-delete-resource-modal').on('click', function(e) {
            e.preventDefault();

            // If delete url specify in del.btn use that url
            if($(this).data('resource-delete-url')) {
                $( $(this).data('target')).find('form').attr('action', $(this).data('resource-delete-url'));
            }

            $($(this).data('target')).find('span.resource-name').html($(this).data('resource-name'));
            $($(this).data('target')).find('#resource_id').attr('value', $(this).data('resource-id'));

            $($(this).data('target')).modal('toggle');
        })
    }
    $('.sidebar-menu').tree();

    $('.select2').select2({
        allowClear: true,
        placeholder: true
    });
    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true
    });

    $('.simple-datatable').DataTable({
        paging: false,
        // searching: false
    });

    // allow only latin letters, disable paste so no possible cyrillic letters
    $(".latin_letters").on("keypress", function (event) {
        var englishAlphabetAndWhiteSpace = /^[-@./#&+\w\s\\]*$/;
        var key = String.fromCharCode(event.which);
        if (event.keyCode == 8 || event.keyCode == 37 || event.keyCode == 39 || englishAlphabetAndWhiteSpace.test(key)) {
            return true;
        }
        return false;
    });
    $('.latin_letters').on("paste", function (e) {
        e.preventDefault();
    });

    $('[data-toggle="tooltip"]').tooltip();

})



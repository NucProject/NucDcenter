{literal}
<script>
    function postNewDeviceTypeInfo()
    {
        var fields = [];
        $('#field-table tr.field').each(function () {
            var s = $(this);
            fields.push({
                fieldName: s.find('input.fieldName').val(),
                fieldTitle: s.find('input.fieldTitle').val(),
                fieldDesc: s.find('input.fieldDesc').val(),
                fieldValueType: s.find('select.fieldValueType').val(),
                fieldDisplayFlag: s.find('select.fieldDisplayFlag').val(),
                fieldAlertFlag: s.find('select.fieldAlertFlag').val(),
                fieldUnit: s.find('input.fieldUnit').val(),
            })
        });

        var info = {
            csrfToken: $('#csrfToken').val(),
            typeKey: $('#typeKey').val().trim(),
            typeName: $('#typeName').val().trim(),
            typeDesc: $('#typeDesc').val().trim(),
            typePic: $('#typePic').val(),
            isMovable: $('#deviceMovableType').val(),
            fields: fields
        };

        $.post('index.php?r=device-type/do-add', info, function (data) {
            console.log(data);
        });
    }

    function showConfirmDialog()
    {
        var typeName = $('#typeName').val();
        bootbox.confirm({
            buttons: {
                confirm: {
                    label: '确认',
                    className: 'btn-myStyle'

                },
                cancel: {
                    label: '取消',
                    className: 'btn-default'
                }
            },
            title: "新建设备类型",
            message: '是否要新建设备类型"<b>{typeName}</b>"？'.format({typeName: typeName}),

            callback: function(result) {
                if (result) {
                    postNewDeviceTypeInfo();
                }
            }
        });
    }

    $(function () {
        var table = $('#addDeviceTypeForm table');

        $('#add-new-field').click(function () {
            var tr = table.find('tr.field-template').clone()
                    .removeClass('field-template')
                    .addClass('field')
                    .css('display', '');
            tr.appendTo(table.find('tbody'));
        });

        $('#add-new-field').click();

        table.delegate('tr a.remove', 'click', function () {
            $(this).closest('tr').remove();
        })


    });
</script>
{/literal}
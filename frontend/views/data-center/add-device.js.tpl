{literal}
<script>

    function showDeviceTypeInfo(deviceTypeInfo)
    {
        var deviceType = deviceTypeInfo.deviceType;
        if (deviceType)
        {
            var tab = $('#typeInfoTable');
            if (deviceType.type_pic) {
                tab.find('img').attr('src', deviceType.type_pic);
            }

            tab.find('td span.type-name').text(deviceType.type_name);
        }
    }

    function showConfirmDialog()
    {
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
            title: "添加设备",
            message: '是否要添加移动便携设备？',// .format({'stationName': stationName}),

            callback: function(result) {
                if (result) {
                    $('#addDeviceForm').submit();
                }
            }
        });
    }

    var launchDate = {
        elem: '#launch_date',
        istime: false,
        format: 'YYYY-MM-DD',
    };

    var rescaleDate = {
        elem: '#rescale_date',
        istime: false,
        format: 'YYYY-MM-DD',
    };

    $(function () {

        $('select[name=deviceType]').change(function () {
            var val = $(this).val();
            if (!val) {
                return false;
            }
            $(this).find('option[none-option]').remove();

            // 注意这里, 之前我在tpl的开头又调用了一次getCsrfToken(true), 导致Ajax或者submit失败
            var csrfToken = $('#addDeviceForm input[name=csrfToken]').val();

            $.post('index.php?r=device-type/info&typeKey=' + val,
                {
                    'typeKey': val, 'csrfToken': csrfToken
                },
                function(data) {
                    var ret = data.toJson();
                    if (ret.error == 0) {
                        showDeviceTypeInfo(ret.data);
                    }
                }
            );

        });

        // I would Like use Laydate as My datetime picker!
        // 可能由于字体的原因，我被迫改了一点need/laydate.css
        laydate.skin('dahong');
        laydate(launchDate);
        laydate(rescaleDate);
    })
</script>
{/literal}
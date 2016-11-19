{literal}
<script>
    function showConfirmDialog(deviceKey)
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
            title: "修改设备信息",
            message: '是否要修改设备信息？',

            callback: function(result) {
                if (result) {
                    $('#addDeviceForm').submit();
                }
            }
        });
    }

    function showDeleteConfirmDialog(deviceKey)
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
            title: "删除设备",
            message: '是否要删除该设备？',

            callback: function(result) {
                if (result) {
                    window.location.href = 'index.php?r=device/delete&deviceKey=' + deviceKey
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

        // I would Like use Laydate as My datetime picker!
        // 可能由于字体的原因，我被迫改了一点need/laydate.css
        laydate.skin('dahong');
        laydate(launchDate);
        laydate(rescaleDate);
    })
</script>
{/literal}
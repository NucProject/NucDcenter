<script>


    function showConfirmDialog()
    {
        bootbox.confirm("Hello world!", function (result) {
            if(result) {
                $('#addDeviceForm').submit();
            } else {

            }
        });
    }

    var beginTime = {
        elem: '#launch_time',
        istime: false,
        format: 'YYYY-MM-DD',
    };

    var endTime = {
        elem: '#modified_time',
        istime: false,
        format: 'YYYY-MM-DD',
    };

    $(function () {


        // I would Like use Laydate as My datetime picker!
        {* 可能由于字体的原因，我被迫改了一点need/laydate.css *}
        laydate.skin('dahong');
        laydate(beginTime);
        laydate(endTime);


    })
</script>
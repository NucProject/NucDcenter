<script>
    var beginTime = {
        elem: '#begin_time',
        istime: true,
        format: 'YYYY-MM-DD hh:mm:ss',
    };

    var endTime = {
        elem: '#end_time',
        istime: true,
        format: 'YYYY-MM-DD hh:mm:ss',
    };

    $(function () {
        // I would Like use Laydate as My datetime picker!
        laydate.skin('dahong');
        laydate(beginTime);
        laydate(endTime);
    })
</script>
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
        // $(".datepicker").datepicker();
        laydate.skin('molv')
        laydate(beginTime);
        laydate(endTime);
    })
</script>
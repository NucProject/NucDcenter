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

        initPager();

        // I would Like use Laydate as My datetime picker!
        {* 可能由于字体的原因，我被迫改了一点need/laydate.css *}
        laydate.skin('dahong');
        laydate(beginTime);
        laydate(endTime);


    })
</script>

{if !$hideChart}
    {include 'device/charts.js.tpl'}
{/if}
{if !$hideList}
    {include 'device/list.js.tpl'}
{/if}
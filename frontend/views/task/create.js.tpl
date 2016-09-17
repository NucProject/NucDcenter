{literal}
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

    var mapCenter = null;

    function createTaskConfirm()
    {
        var taskName = $('#createTaskForm input[name=taskName]').val();
        if (!taskName.trim()) {
            bootbox.alert({
                buttons: {
                    ok: {
                        label: '确定',
                        className: 'btn-myStyle'
                    }
                },
                message: '请填写任务的名称！',
                callback: function() {

                },
                title: "错误",
            });
            return false;
        }

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
            title: "新建任务",
            message: '是否要新建任务"<b>{taskName}</b>"？'.format({'taskName': taskName}),

            callback: function(result) {
                if (result) {
                    $('#createTaskForm').submit();
                }
            }
        });
    }

    $(function () {

        // I would Like use Laydate as My datetime picker!
        // 可能由于字体的原因，我被迫改了一点need/laydate.css
        laydate.skin('dahong');
        laydate(beginTime);
        laydate(endTime);

        // Map 选择区域
        var map = new BMap.Map("map"); // 创建Map实例
        map.clearOverlays();
        var point = new BMap.Point(113.28155000, 22.33260667); // TODO: 中心点;创建点坐标
        map.centerAndZoom(point, 11); // 初始化地图,设置中心点坐标和地图级别。
        map.addControl(new BMap.NavigationControl());
        map.addControl(new BMap.ScaleControl());
        map.addControl(new BMap.OverviewMapControl());
        map.addControl(new BMap.MapTypeControl());
        map.setCurrentCity("珠海"); // 仅当设置城市信息时，MapTypeControl的切换功能才能可用
        mapCenter = map.getCenter();
        map.enableScrollWheelZoom();


        $('input[name=city]').blur(function () {
            var city = $(this).val();
            map.setCurrentCity(city.trim());
            map.centerAndZoom(city.trim(), 11);

            mapCenter = map.getCenter();

        });

    });

</script>
{/literal}
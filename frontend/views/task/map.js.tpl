<script>

</script>
{literal}
<script>

    $(function () {

        var centerLng = 113.300522;
        var centerLat = 22.326188;

        var map = new BMap.Map("map"); // 创建Map实例
        // map.clearOverlays();
        var point = new BMap.Point(centerLng, centerLat); // TODO: 中心点;创建点坐标
        map.centerAndZoom(point, 10); // 初始化地图,设置中心点坐标和地图级别。
        map.addControl(new BMap.NavigationControl());
        map.addControl(new BMap.ScaleControl());
        map.addControl(new BMap.OverviewMapControl());

        // map.setCurrentCity("珠海"); // 仅当设置城市信息时，MapTypeControl的切换功能才能可用
        map.enableScrollWheelZoom(false); //禁用滚轮事件

        map.addEventListener("click", function(data) {
            //
            var markPoint = data.point;

            console.log(markPoint);
        });


    });
</script>
{/literal}
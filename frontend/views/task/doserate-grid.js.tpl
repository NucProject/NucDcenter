<script>
    var centerLng = parseFloat('{$centerLng}') || 0;
    var centerLat = parseFloat('{$centerLat}') || 0;

    var points = {};
    {foreach from=$deviceKeys item=deviceKey}
    points['{$deviceKey}'] = '{$deviceDataMap[$deviceKey]}'.toJson();
    {/foreach}

    var allPoints = [];
    var deviceStatus = {};
    for (var i in points)
    {
        deviceStatus[i] = { index: 0 };
        allPoints = allPoints.concat(points[i])
    }
    console.log("4444", allPoints);

</script>
{literal}
<script>

    function onStartButtonClick(button, mapgridOverlay)
    {
        setInterval(function() {
            for (var deviceKey in deviceStatus)
            {
                var index = deviceStatus[deviceKey].index;

                var devicePoints = points[deviceKey];
                if (index < devicePoints.length)
                {
                    // console.log(index)
                    var p = devicePoints[index];

                    mapgridOverlay.addDataPoint(p['lng'], p['lat'], p['count']);

                    deviceStatus[deviceKey]['index'] += 1;
                }
            }
        }, 100);
    }


    function addHeatmapData() {

    }

    function setGradient(heatmapOverlay){
        /*格式如下所示:
         {
         0:'rgb(102, 255, 0)',
         .5:'rgb(255, 170, 0)',
         1:'rgb(255, 0, 0)'
         }*/
        var gradient = {};
        var colors = document.querySelectorAll("input[type='color']");
        colors = [].slice.call(colors,0);
        colors.forEach(function(ele){
            gradient[ele.getAttribute("data-key")] = ele.value;
        });
        heatmapOverlay.setOptions({"gradient":gradient});
    }

    $(function () {

        var map = new BMap.Map("map"); // 创建Map实例
        // map.clearOverlays();
        var point = new BMap.Point(centerLng, centerLat); // TODO: 中心点;创建点坐标
        map.centerAndZoom(point, 12); // 初始化地图,设置中心点坐标和地图级别。
        map.addControl(new BMap.NavigationControl());
        map.addControl(new BMap.ScaleControl());
        map.addControl(new BMap.OverviewMapControl());

        // map.addControl(new BMap.MapTypeControl());
        // map.setCurrentCity("珠海"); // 仅当设置城市信息时，MapTypeControl的切换功能才能可用
        map.enableScrollWheelZoom(false); //禁用滚轮事件

        var mapgridOverlay = new BMapLib.MapgridOverlay({"radius": 20});
        map.addOverlay(mapgridOverlay);


        //

        mapgridOverlay.setDataSet({'data':allPoints, 'max':200});
        // mapgridOverlay.drawGrid();

        // 可能需要从新生成Overlay的方式来搞定拖动和缩放带来的问题
        $('a.start').click(function () {

            mapgridOverlay.redraw();
        });

    });
</script>
{/literal}
<script>
    // TODO: Move common place
    Date.prototype.format = function(fmt)
    { //author: meizz
        var o = {
            "M+" : this.getMonth()+1,                 //月份
            "d+" : this.getDate(),                    //日
            "h+" : this.getHours(),                   //小时
            "m+" : this.getMinutes(),                 //分
            "s+" : this.getSeconds(),                 //秒
            "q+" : Math.floor((this.getMonth()+3)/3), //季度
            "S"  : this.getMilliseconds()             //毫秒
        };
        if(/(y+)/.test(fmt))
            fmt=fmt.replace(RegExp.$1, (this.getFullYear()+"").substr(4 - RegExp.$1.length));
        for(var k in o)
            if(new RegExp("("+ k +")").test(fmt))
                fmt = fmt.replace(RegExp.$1, (RegExp.$1.length==1) ? (o[k]) : (("00"+ o[k]).substr((""+ o[k]).length)));
        return fmt;
    };

    var centerLng = parseFloat('{$centerLng}') || 0;
    var centerLat = parseFloat('{$centerLat}') || 0;

    var points = { };
    {foreach from=$deviceKeys item=deviceKey}
    points['{$deviceKey}'] = '{$deviceDataMap[$deviceKey]}'.toJson();
    {/foreach}

    var allPoints = [];
    var deviceStatus = { };
    for (var i in points)
    {
        deviceStatus[i] = { index: 0 };
        allPoints = allPoints.concat(points[i])
    }

    var minTime = allPoints[0]['data_time'], maxTime = minTime;
    for (var i in allPoints)
    {
        var p = allPoints[i];
        if (p['data_time'] > maxTime) {
            maxTime = p['data_time'];
            continue;
        }
        if (p['data_time'] < minTime) {
            minTime = p['data_time'];
            continue;
        }
    }

    var minTimestamp = +new Date(minTime);
    var maxTimestamp = +new Date(maxTime);
    var dt = (maxTimestamp - minTimestamp) / 100;

    function updateTimeRange(min, max)
    {
        var minTime = new Date(minTimestamp + min * dt).format('yyyy-MM-dd hh:mm:ss');
        var maxTime = new Date(minTimestamp + max * dt).format('yyyy-MM-dd hh:mm:ss');
        {literal}
        var timeRange = "从 {minTime} 到 {maxTime}".format({ minTime: minTime, maxTime: maxTime });
        {/literal}
        $('#timeRange').text(timeRange)
    }

    // 初始化Slider
    $("#slider-range").slider({
        range:true,
        min:0, max:100,
        values:[0, 60],
        slide: function( event, ui ) {
            var min = ui.values[0];
            var max = ui.values[1];

            updateTimeRange(min, max);
        }
    });

    updateTimeRange(0, 60); // 初始化

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
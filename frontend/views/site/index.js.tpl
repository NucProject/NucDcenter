{* 数据中心的首页, 显示地图和N个自动站 *}
<script>
    var stations = '({$stations})';
</script>
{literal}
<script>

    function getMarkerEventHandler(station) {
        return function() {
            var infoPane = $('#station-point-info-template').clone();
            // var i = this.zIndex;
            var stationName = station.stationName; //?
            var stationKey = station.stationKey;

            infoPane.find('h3.title').text(stationName);
            infoPane.find('td.connection').text('联通');
            infoPane.find('td.last-data-time').text('2016-09-05 23:45:00');
            infoPane.find('td.gps').text('113.1282233, 23.555450');
            infoPane.find('td.address').text('珠海市XXXXXXX');
            var link = infoPane.find('td a');

            link.attr('href', 'index.php?r=station/index&stationKey=' + stationKey);

            //创建信息窗口对象
            var infoWindow = new BMap.InfoWindow(infoPane.html());
            console.log(this);
            this.openInfoWindow(infoWindow);
        }
    }

    function showStationMarker(map, station) {
        map.clearOverlays();
        var s = station;

        var point = new BMap.Point(s.lng, s.lat);

        // TODO: relative resource
        var markerIcon = new BMap.Icon("http://127.0.0.1:1001/img/red.png", new BMap.Size(32, 32));
        console.log(point, myIcon);
        var marker = new BMap.Marker(point, {icon: markerIcon});
        marker.setZIndex(100);

        map.addOverlay(marker);

        //文字标注
        var stationName = s.stationName;
        var label = new BMap.Label('<span style="background-color: inherit;padding:3px"><i class="fa fa-home"></i>&nbsp;珠海大气监测站</span>', {offset: new BMap.Size(28, 3)});
        label.setStyle({color:"#FFFFFF", backgroundColor:"#3C3C3C", fontSize:"14px", border:"none" });
        marker.setLabel(label);

        //信息窗
        marker.addEventListener("click", getMarkerEventHandler(station) || function() {
            var infoPane = $('#station-point-info-template').clone();
            // var i = this.zIndex;

            infoPane.find('h3.title').text('珠海大气监测站');
            infoPane.find('td.connection').text('联通');
            infoPane.find('td.last-data-time').text('2016-09-05 23:45:00');
            infoPane.find('td.gps').text('113.1282233, 23.555450');
            infoPane.find('td.address').text('珠海市XXXXXXX');
            var link = infoPane.find('td a');
            var href = link.attr('href');

            link.attr('href', href + stationKey);


            //创建信息窗口对象
            var infoWindow = new BMap.InfoWindow(infoPane.html());
            this.openInfoWindow(infoWindow);
        });


    }

    function showStationMarkerDelay(map, station, delay)
    {
        setTimeout(function() {
            showStationMarker(map, station);
        }, delay);
    }

    $(function () {

        var map = new BMap.Map("map"); // 创建Map实例
        var point = new BMap.Point(113.28155000, 22.33260667); // 创建点坐标
        map.centerAndZoom(point, 11); // 初始化地图,设置中心点坐标和地图级别。
        map.addControl(new BMap.NavigationControl());
        map.addControl(new BMap.ScaleControl());
        map.addControl(new BMap.OverviewMapControl());
        map.addControl(new BMap.MapTypeControl());
        map.setCurrentCity("珠海"); // 仅当设置城市信息时，MapTypeControl的切换功能才能可用

        // map.enableScrollWheelZoom(false); //禁用滚轮事件

        var delay = 800;
        for (var i in stations)
        {
            var station = stations[i];
            showStationMarkerDelay(map, station, delay);
            delay += delay / 2; // Fast as fast
        }



    });
</script>
{/literal}
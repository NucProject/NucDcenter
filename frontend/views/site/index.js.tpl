{* 数据中心的首页, 显示地图和N个自动站, 激活设备 *}
<script>
    var stations = eval('({$stations})');
    var activeDevices = eval('({$activeDevices})');
    var city = '{$city}';
</script>
{literal}
<script>

    function getStationMarkerEventHandler(station) {
        return function() {
            var infoPane = $('#station-point-info-template').clone();

            var stationName = station.station_name;
            var stationKey = station.station_key;

            infoPane.find('h3.title').text(stationName);
            infoPane.find('td.connection').text('联通');
            infoPane.find('td.last-data-time').text('2016-09-05 23:45:00');
            infoPane.find('td.gps').text('{lng}, {lat}'.format({ 'lng': station.lng, 'lat': station.lat }));
            infoPane.find('td.address').text(station.station_addr);
            var link = infoPane.find('td a');

            link.attr('href', 'index.php?r=station/index&stationKey=' + stationKey);

            // 创建信息窗口对象
            var infoWindow = new BMap.InfoWindow(infoPane.html());
            console.log(this /* this means marker */);
            this.openInfoWindow(infoWindow);
        }
    }

    function getDeviceMarkerEventHandler(activeDevice) {
        var a = activeDevice;
        return function() {
            var deviceKey = a.device_key;
            var infoPane = $('#device-point-info-template').clone();

            var typeName = a.deviceType.type_name;


            infoPane.find('h3.title').text(typeName);
            infoPane.find('td.connection').text('已激活'); // TODO:
            var now = new Date();
            infoPane.find('td.last-data-time').text(now.toLocaleDateString('zh'));
            infoPane.find('td.gps').text('{lng}, {lat}'.format({ 'lng': a.device_lng, 'lat': a.device_lat }));
            infoPane.find('td.address').text('');
            var link = infoPane.find('td a');

            link.attr('href', 'index.php?r=device/info&deviceKey=' + deviceKey);

            // 创建信息窗口对象
            var infoWindow = new BMap.InfoWindow(infoPane.html());
            console.log(this /* this means marker */);
            this.openInfoWindow(infoWindow);
        }
    }

    function showStationMarker(map, station) {

        var s = station;

        var point = new BMap.Point(s.lng, s.lat);

        // TODO: relative resource
        var markerIcon = new BMap.Icon("/img/red.png", new BMap.Size(32, 32));
        console.log(point, markerIcon);
        var marker = new BMap.Marker(point, {icon: markerIcon});
        marker.setZIndex(100);

        map.addOverlay(marker);

        //文字标注
        var stationName = s.station_name;
        var labelHtml = '<span style="background-color: inherit;padding:3px"><i class="fa fa-home"></i>&nbsp;{stationName}</span>'.format({stationName:stationName});
        console.log(labelHtml);
        var label = new BMap.Label(labelHtml, {offset: new BMap.Size(28, 3)});
        label.setStyle({color:"#FFFFFF", backgroundColor:"#3C3C3C", fontSize:"14px", border:"none" });
        marker.setLabel(label);

        //信息窗
        marker.addEventListener( "click", getStationMarkerEventHandler(station) );
    }

    function showActiveDeviceMarker(map, activeDevice) {

        var a = activeDevice;
        console.log(a)

        var point = new BMap.Point(a.device_lng, a.device_lat);

        // TODO: relative resource
        var markerIcon = new BMap.Icon("/img/red.png", new BMap.Size(32, 32));

        var marker = new BMap.Marker(point, {icon: markerIcon});
        marker.setZIndex(100);

        map.addOverlay(marker);

        //文字标注
        var typeName = a.deviceType.type_name;
        var labelHtml = '<span style="background-color: inherit;padding:3px"><i class="fa fa-home"></i>&nbsp;{typeName}</span>'.format({typeName:typeName});
        console.log(labelHtml);
        var label = new BMap.Label(labelHtml, {offset: new BMap.Size(28, 3)});
        label.setStyle({color:"#FFFFFF", backgroundColor:"#3C3C3C", fontSize:"14px", border:"none" });
        marker.setLabel(label);

        //信息窗
        marker.addEventListener( "click", getDeviceMarkerEventHandler(activeDevice) );
    }


    function showStationMarkerDelay(map, station, delay)
    {
        setTimeout(function() {
            showStationMarker(map, station);
        }, delay);
    }

    function showActiveDeviceMarkerDelay(map, activeDevice, delay)
    {
        setTimeout(function() {
            showActiveDeviceMarker(map, activeDevice);
        }, delay);
    }



    function MovableDevicesNavigator()
    {
        this.defaultAnchor = BMAP_ANCHOR_TOP_RIGHT;
        this.defaultOffset = new BMap.Size(30, 30);
    }

    function createMovableDevicesNavigator()
    {
        MovableDevicesNavigator.prototype = new BMap.Control();

        // 右上角的移动设备列表入口!
        MovableDevicesNavigator.prototype.initialize = function(map){

            var div = $('#movable-devices-template');
            div.click(function () {
                window.location.href = 'index.php?r=data-center/movable-devices';
            });

            // 添加DOM元素到地图中
            var domNode = div.get(0);
            map.getContainer().appendChild(domNode);
            // 将DOM元素返回
            return domNode;
        };

        return new MovableDevicesNavigator();
    }

    $(function () {

        var map = new BMap.Map("map"); // 创建Map实例

        var myCtrl = createMovableDevicesNavigator();

        map.clearOverlays();
        var point = new BMap.Point(113.28155000, 22.33260667); // TODO: 中心点;创建点坐标
        map.centerAndZoom(point, 11); // 初始化地图,设置中心点坐标和地图级别。
        map.addControl(new BMap.NavigationControl());
        map.addControl(new BMap.ScaleControl());
        map.addControl(new BMap.OverviewMapControl());
        map.addControl(myCtrl)

        map.addControl(new BMap.MapTypeControl());

        // var city = "北京";
        map.setCurrentCity(city); // 仅当设置城市信息时，MapTypeControl的切换功能才能可用
        map.centerAndZoom(city, 11);

        // map.enableScrollWheelZoom(false); //禁用滚轮事件

        var delay = 800;
        var offset = 400;
        // 自动站显示marker
        for (var i in stations)
        {
            var station = stations[i];
            showStationMarkerDelay(map, station, delay + offset);
            offset /= 2; // Fast as fast
        }

        // 已经激活的设备显示为marker
        for (var i in activeDevices)
        {
            var activeDevice = activeDevices[i];
            showActiveDeviceMarkerDelay(map, activeDevice, delay + offset);
            offset /= 2; // Fast as fast
        }

    });
</script>
{/literal}
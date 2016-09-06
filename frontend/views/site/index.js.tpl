{* 数据中心的首页, 显示地图和N个自动站 *}
<script>
    var initStationPoints = '([["", "113.215763", "22.021783"]])';
</script>
{literal}
<script>

    function multiMark(map, data) {
        map.clearOverlays();
        var obj = data;
        console.log(data);

        //循环添加标注
        for ( var i = 0; i < obj.length; i++) {

            var point = new BMap.Point(obj[i][1], obj[i][2]);
            console.log(point);
            var myIcon = new BMap.Icon("http://127.0.0.1:1001/img/red.png", new BMap.Size(32, 32));
            console.log(myIcon);
            var marker = new BMap.Marker(point, {icon: myIcon});
            marker.setZIndex(0);
            map.addOverlay(marker);

            //文字标注
            var label = new BMap.Label('<span style="background-color: inherit;padding:3px"><i class="fa fa-home"></i>&nbsp;珠海大气监测站</span>', {offset: new BMap.Size(28, 3)});
            label.setStyle({color:"#FFFFFF", backgroundColor:"#3C3C3C", fontSize:"14px", border:"none" });
            marker.setLabel(label);

            //信息窗
            marker.addEventListener("click", function() {
                var infoPane = $('#station-point-info-template').clone();
                var i = this.zIndex;

                infoPane.find('h3.title').text('珠海大气监测站');
                infoPane.find('td.connection').text('联通');
                infoPane.find('td.last-data-time').text('2016-09-05 23:45:00');
                infoPane.find('td.gps').text('113.1282233, 23.555450');
                infoPane.find('td.address').text('珠海市XXXXXXX');
                var link = infoPane.find('td a');
                var href = link.attr('href');
                deviceKey = "3323131231";
                link.attr('href', href + deviceKey);


                //创建信息窗口对象
                var infoWindow = new BMap.InfoWindow(infoPane.html());
                this.openInfoWindow(infoWindow);
            });

        }
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
        setTimeout(function(){
            multiMark(map, eval(initStationPoints));
        }, 1000);


    });
</script>
{/literal}
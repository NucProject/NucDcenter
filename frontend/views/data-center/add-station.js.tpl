{literal}
<script>

    var mapCenter = null;

    function addStationMarker(map, point) {
        // Clear the last selection
        map.clearOverlays();
        var markerIcon = new BMap.Icon("/img/red.png", new BMap.Size(32, 32));
        // console.log(point, markerIcon);
        var marker = new BMap.Marker(point, {icon: markerIcon});
        marker.setZIndex(100);

        map.addOverlay(marker);

        var geo = new BMap.Geocoder();
        geo.getLocation(point, function(data) {
            if (data) {
                $('form input[name=stationAddress]').val(data.address);
            }
        });
    }

    $(function () {

        $('#is-location-fixed').change(function () {
            var v = $(this).val();
            if (v != 1) {
                $('#gps-info').removeClass('display-none');
            } else {
                $('#gps-info').addClass('display-none');
            }
        });

        $('#hasGPS').change(function () {
            var checked = $(this).prop('checked');
            if (checked) {
                $('#city').addClass('display-none');
                $('#lngAndLat').removeClass('display-none').val('');
            } else {
                $('#lngAndLat').addClass('display-none');
                $('#city').removeClass('display-none').val('');
            }
        });

        var form = $('#add-station-form');
        form.delegate('a', 'click', function () {
            form.submit();
        });

        var uploader = WebUploader.create({

            auto: true,

            // swf文件路径
            swf: 'webuploader/Uploader.swf',

            // 文件接收服务端。
            server: 'index.php?r=upload-file/station-picture',

            // 选择文件的按钮。可选。
            // 内部根据当前运行是创建，可能是input元素，也可能是flash.
            pick: '#filePicker',

            // 不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
            resize: false,

            accept: {
                title: 'Images',
                extensions: 'gif,jpg,jpeg,bmp,png',
                mimeTypes: 'image/*'
            }
        });

        uploader.on( 'fileQueued', function( file ) {

            var $list = $('#fileList');
            var $li = $list.find('div.thumbnail');
            $li.find('div.info').text(file.name);
            var $img = $li.find('img');

            var thumbnailWidth = parseInt($img.css('width'));
            var thumbnailHeight = parseInt($img.css('height'));

            // 创建缩略图
            // 如果为非图片文件，可以不用调用此方法。
            // thumbnailWidth x thumbnailHeight 为 100 x 100
            uploader.makeThumb( file, function( error, src ) {
                if ( error ) {
                    $img.replaceWith('<span>不能预览</span>');
                    return;
                }

                $img.attr( 'src', src );
            }, thumbnailWidth, thumbnailHeight );
        });

        uploader.on('uploadSuccess', function(file, data) {
            console.log(file);

            if (data)
            {
                var result = data.data.result;
                var fileName = result.file;
                $('form input[name=stationPic]').val(fileName);

            }
        });


        // Map about
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

        map.addEventListener("click", function(data) {
            //
            var markPoint = data.point;
            addStationMarker(map, markPoint);

            form.find('input[name=lng]').val(markPoint.lng);
            form.find('input[name=lat]').val(markPoint.lat);
        });


        $('input[name=city]').blur(function () {
            var city = $(this).val();
            map.setCurrentCity(city.trim());
            map.centerAndZoom(city.trim(), 11);

            mapCenter = map.getCenter();

        });
    });

</script>
{/literal}
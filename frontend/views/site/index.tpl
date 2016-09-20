{literal}
    <style type="text/css">
        html, body {
            margin: 0;
            padding: 0;
        }

        .baidu-map {
            width: 100%;
            height: 650px;
        }

        .iw_poi_title {
            color: #CC5522;
            font-size: 14px;
            font-weight: bold;
            overflow: hidden;
            padding-right: 13px;
            white-space: nowrap
        }

        .iw_poi_content {
            font: 12px arial, sans-serif;
            overflow: visible;
            padding-top: 4px;
            white-space: -moz-pre-wrap;
            word-wrap: break-word
        }

        .tip-title {
            text-align: right;
        }
    </style>
{/literal}

<!--百度地图容器-->
<div style="padding: 10px">
    <div id="map" class="baidu-map"></div>
</div>

<div class="display-none">
    <div id="station-point-info-template">
        <h3 class="title"></h3>
        <table class="table table-trip">
            <tr>
                <td class="tip-title">状态</td><td class="tip-value connection">联通</td>
            </tr>
            <tr>
                <td class="tip-title">最后测量时间</td><td class="tip-value last-data-time">2016-09-05 23:45:00</td>
            </tr>
            <tr>
                <td class="tip-title">GPS位置</td><td class="tip-value gps">113.1282233,23.555450</td>
            </tr>
            <tr>
                <td class="tip-title">地址</td><td class="tip-value address">珠海市XXXXXX</td>
            </tr>
            <tr>
                <td></td><td><a class="btn">更多信息</a></td>
            </tr>
        </table>
    </div>

    <div id="movable-devices-template">
        <div style="background-color: #3C3C3C; opacity: 0.8">
            <div style="padding: 3px">
                <span>
                    <i class="fa fa-rocket"></i>
                    <a href="javascript:void(0)">
                        <b>点击进入移动设备列表</b>
                    </a>
                </span>
            </div>
        </div>
    </div>
</div>
{extends 'common/common-box.tpl'}

{block name=title}编辑自动站{/block}
{block name=content}
    <h3 class="form-title">请填写自动站信息</h3>
    <form id="add-station-form" action="index.php?r=data-center/do-update-station&stationKey={$stationKey}" method="post">

        <input type="hidden" name="csrfToken" value="{Yii::$app->request->getCsrfToken(true)}" />

        <div class="form-group">
            <label for="exampleInputEmail1">自动站名称</label>
            <input type="text" class="form-control" name="stationName"
                   value="{$station.station_name}"
                   placeholder="请填写自动站名称">
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">自动站介绍</label>
            <textarea type="text" class="form-control" name="stationDesc"
                      placeholder="请填写自动站介绍">{$station.station_desc}</textarea>
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">自动站类型</label>
            <select class="form-control" name="stationType" id="is-location-fixed">
                <option value="0" {if $station.station_type==0}selected{/if}>固定的自动站</option>
                <option value="1" {if $station.station_type==1}selected{/if}>移动的监测车</option>
            </select>
        </div>


        <div class="form-group" id="gps-info">
            <label for="exampleInputEmail1">GPS信息</label>
            <br>
            <label><input type="checkbox" id="hasGPS" checked/>&nbsp;我知道确切的GPS位置</label>

            <div class="checkbox">
                <label>
                    <input type="text" class="form-control display-none" id='city' name="city" placeholder="试着输入城市名称">

                    <input type="text" class="form-control" id="lngAndLat" name="lngAndLat"
                           value="{$station.lng},{$station.lat}"
                           placeholder="请提供经、纬度（逗号分隔）">

                    <input type="hidden" name="lng">
                    <input type="hidden" name="lat">
                    <input type="hidden" name="stationAddress">
                </label>
            </div>

            <div id="map" style="width: 600px; height: 400px; margin-left: 50px"></div>
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">自动站图片</label>
            <!--dom结构部分-->
            <div id="fileList" class="uploader-list">
                <div class="file-item thumbnail"  style="width: 240px">
                    <img style="width: 240px; height:180px">
                    <div class="info"></div>
                </div>
            </div>
            <div id="uploader-demo">
                <!--用来存放item-->
                <input type="hidden" name="stationPic">
                <div id="filePicker">选择图片</div>
            </div>
        </div>

        <hr>
        <!-- 其他信息 -->
        <div class="form-group">
            <label for="exampleInputEmail1">业主单位</label>
            <input type="text" class="form-control" name="ownerOrg"
                   value="{$station.owner_org}"
                   placeholder="请填写业主单位">
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">负责人员</label>
            <input type="text" class="form-control" name="ownerLead"
                   value="{$station.owner_lead}"
                   placeholder="请填写负责人员姓名">
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">建成日期</label>
            <input type="text" id='built_time' class="form-control" name="completionDate"
                   value="{$station.completion_date}"
                   placeholder="请填写建成日期">
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">建设单位</label>
            <input type="text" class="form-control" name="builderOrg"
                   value="{$station.builder_org}"
                   placeholder="请填写建设单位">
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">运维单位</label>
            <input type="text" class="form-control" name="opsOrg"
                   value="{$station.ops_org}"
                   placeholder="请填写运维单位">
        </div>

        <a type='submit' class="btn btn-info add">添加</a>
    </form>
{/block}
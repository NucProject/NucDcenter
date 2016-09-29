{extends 'common/common-box.tpl'}

{block name=title}添加自动站{/block}
{block name=content}
    <h3 class="form-title">请填写自动站信息</h3>
    <form id="add-station-form" action="index.php?r=data-center/do-add-station" method="post">

        <input type="hidden" name="csrfToken" value="{Yii::$app->request->getCsrfToken(true)}" />

        <div class="form-group">
            <label for="exampleInputEmail1">自动站名称</label>
            <input type="text" class="form-control" name="stationName" placeholder="请填写自动站名称">
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">自动站介绍</label>
            <textarea type="text" class="form-control" name="stationDesc" placeholder="请填写自动站介绍"></textarea>
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">自动站类型</label>
            <select class="form-control" name="stationType" id="is-location-fixed">
                <option value="0">固定的自动站</option>
                <option value="1">移动的监测车</option>
            </select>
        </div>

        <div class="form-group" id="gps-info">
            <label for="exampleInputEmail1">GPS信息</label>
            <br>
            <label><input type="checkbox" id="hasGPS" />&nbsp;我知道确切的GPS位置</label>

            <div class="checkbox">
                <label>
                    <input type="text" class="form-control" id='city' name="city" placeholder="试着输入城市名称">

                    <input type="text" class="form-control display-none" id="lngAndLat" name="lngAndLat" placeholder="请提供经、纬度（逗号分隔）">

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
            <input type="text" class="form-control" name="ownerOrg" placeholder="请填写业主单位">
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">负责人员</label>
            <input type="text" class="form-control" name="ownerLead" placeholder="请填写负责人员姓名">
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">建成日期</label>
            <input type="text" class="form-control" name="completionDate" placeholder="请填写建成日期">
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">建设单位</label>
            <input type="text" class="form-control" name="builderOrg" placeholder="请填写建设单位">
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">运维单位</label>
            <input type="text" class="form-control" name="opsOrg" placeholder="请填写运维单位">
        </div>

        <a type='submit' class="btn btn-info add">添加</a>
    </form>
{/block}
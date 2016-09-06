{extends 'common/common-box.tpl'}

{block name=title}添加自动站{/block}
{block name=content}
    <h3 class="form-title">请填写自动站信息</h3>
    <form role="form">
        <div class="form-group">
            <label for="exampleInputEmail1">自动站名称</label>
            <input type="text" class="form-control" id="stationName" placeholder="请填写自动站名称">
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">自动站介绍</label>
            <textarea type="text" class="form-control" id="stationName" placeholder="请填写自动站介绍"></textarea>
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">是否是固定的自动站</label>
            <div class="checkbox">
                <label>
                    <input id="is-location-fixed" type="checkbox">固定的自动站
                </label>
            </div>
        </div>

        <div class="form-group display-none" id="gps-info">
            <label for="exampleInputEmail1">GPS信息</label>
            <div class="checkbox">
                <label>
                    <input type="text" class="form-control" name="lng" placeholder="请提供经度">
                    <input type="text" class="form-control" name="lat" placeholder="请提供纬度">
                </label>
            </div>
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

                <div id="filePicker">选择图片</div>
            </div>
        </div>

        <hr>
        <!-- 其他信息 -->
        <div class="form-group">
            <label for="exampleInputEmail1">业主单位</label>
            <input type="text" class="form-control" id="ownerCompany" placeholder="请填写业主单位">
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">负责人员</label>
            <input type="text" class="form-control" id="ownerName" placeholder="请填写负责人员姓名">
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">建成日期</label>
            <input type="text" class="form-control" id="ownerName" placeholder="请填写建成日期">
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">建设单位</label>
            <input type="text" class="form-control" id="ownerName" placeholder="请填写建设单位">
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">运维单位</label>
            <input type="text" class="form-control" id="ownerName" placeholder="请填写运维单位">
        </div>


        <a type='submit' class="btn btn-info">添加</a>
    </form>
{/block}
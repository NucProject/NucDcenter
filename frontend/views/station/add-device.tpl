{extends 'common/common-box.tpl'}

{block name=title}添加设备{/block}
{block name=content}
    <h3 class="form-title">请填写设备信息</h3>
    <form id="addDeviceForm" action="{$doAddDevice}" method="post">
        {* hidden keys *}
        <input type="hidden" name="centerId" value="{$centerId}">
        <input type="hidden" name="stationKey" value="{$stationKey}">
        <input type="hidden" name="deviceKey" value="{$deviceKey}">
        <input type="hidden" name="csrfToken" value="{Yii::$app->request->getCsrfToken(true)}" />

        <div class="form-group">
            <label for="exampleInputEmail1">选择设备类型</label>
            <select class="form-control" name="deviceType">
                {foreach from=$deviceTypes item=dt}
                    <option value="{$dt.type_key}">{$dt.type_name}</option>
                {/foreach}
            </select>
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">设备图片</label>
            <!--dom结构部分-->
            <div id="fileList" class="uploader-list">
                <div class="file-item thumbnail"  style="width: 240px">
                    <img style="width:240px; height:180px">
                    <div class="info"></div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">设备序列号</label>
            <input class="form-control" placeholder="请填写设备唯一序列号">
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">仪器启动时间</label>
            <input class="form-control" type="text" name="launch_time" size="10" id="launch_time">
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">仪器上一次校准时间</label>
            <input class="form-control" type="text" name="modified_time" size="10" id="modified_time">
        </div>


        <a onclick="showConfirmDialog();" class="btn btn-info">添加</a>

    </form>
{/block}
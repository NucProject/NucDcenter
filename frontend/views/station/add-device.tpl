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
        <a href="javascript:showConfirmDialog()" class="btn btn-info">添加</a>

    </form>
{/block}
{extends 'common/common-box.tpl'}

{block name=title}添加设备{/block}
{block name=content}
    <h3 class="form-title">请填写设备信息</h3>
    <form role="form">
        <input type="hidden" name="centerId" value="{$centerId}">
        <input type="hidden" name="stationKey" value="{$stationKey}">

        <div class="form-group">
            <label for="exampleInputEmail1">选择设备类型</label>
            <select class="form-control">
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
                    <img style="width: 240px; height:180px">
                    <div class="info"></div>
                </div>
            </div>
        </div>

        <a type='submit' class="btn btn-info">添加</a>
    </form>
{/block}
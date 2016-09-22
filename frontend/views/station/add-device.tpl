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
            <a href="#" style="color: #d2322d">（如未找到设备类型请点击这里通知管理员）</a>

            <select class="form-control" name="typeKey">
                <option none-option>请选择要添加的设备类型</option>
                {foreach from=$deviceTypes item=dt}
                    <option value="{$dt.type_key}">{$dt.type_name}</option>
                {/foreach}
            </select>
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">设备类型信息</label>
            <!--dom结构部分-->
            <table id="typeInfoTable">
                <tr>
                    <td>
                        <img style="width:240px; height:180px" alt="未提供图片">
                    </td>
                    <td style="vertical-align: top; padding-left: 30px">
                        <div><h3><span class="type-name"></span></h3></div>
                        <div><span></span></div>
                        <div><span></span></div>
                    </td>
                </tr>
            </table>
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">设备序列号</label>
            <input class="form-control" name="device_sn" placeholder="请填写设备唯一序列号">
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">仪器启动时间</label>
            <input class="form-control" type="text" name="launch_date" size="10" id="launch_date">
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">仪器上一次校准时间</label>
            <input class="form-control" type="text" name="rescale_date" size="10" id="rescale_date">
        </div>

        <a href="javascript:history.back()" class="btn btn-grey">返回</a>
        <a onclick="showConfirmDialog('{$stationName}');" class="btn btn-info">添加</a>

    </form>
{/block}
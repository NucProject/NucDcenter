{extends 'common/common-box.tpl'}

{block name=title}修改设备信息{/block}
{block name=content}
    <h3 class="form-title">请填写设备信息</h3>
    <form id="addDeviceForm" action="{$doModifyUrl}" method="post">
        {* hidden keys *}

        <input type="hidden" name="deviceKey" value="{$deviceKey}">
        <input type="hidden" name="csrfToken" value="{Yii::$app->request->getCsrfToken(true)}" />


        <div class="form-group">
            <label for="exampleInputEmail1">设备图片</label>
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
            <input class="form-control" value="{$deviceSn}" readonly>
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">设备类型</label>
            <input class="form-control" value="{$deviceTypeName} ({$deviceTypeKey})" readonly>
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">设备描述</label>
            <input class="form-control" name="device_desc" placeholder="请填写设备描述" value="{$device.device_desc}">
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">仪器启动时间</label>
            <input class="form-control" type="text" name="launch_date" size="10" id="launch_date"
                    value="{$device.launch_date}">
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">仪器上一次校准时间</label>
            <input class="form-control" type="text" name="rescale_date" size="10" id="rescale_date"
                   value="{$device.rescale_date}">
        </div>

        <a href="javascript:history.back()" class="btn btn-grey">返回</a>
        <a onclick="showConfirmDialog();" class="btn btn-info">修改</a>

    </form>
{/block}
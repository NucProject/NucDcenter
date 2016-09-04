{extends 'common/common-box.tpl'}

{block name=title}添加设备类型{/block}
{block name=content}
    <h3 class="form-title">请填写设备类型信息</h3>
    <form id="addDeviceForm" action="{$doAddUrl}" method="post">
        {* hidden keys *}

        <input type="hidden" name="csrfToken" value="{Yii::$app->request->getCsrfToken(true)}" />
        <div class="form-group">
            <label for="exampleInputEmail1">设备类型Key</label>
            <input type="text" class="form-control" id="typeKey" placeholder="请填写设备类型Key">
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">设备类型名称</label>
            <input type="text" class="form-control" id="TypeName" placeholder="请填写设备类型名称">
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">设备数据类型列表</label>
        </div>
        <table class="table table-striped table-bordered">
            <tbody>
            <tr class="field-template" style="display: none">
                <td>
                    <input type="text" class="form-control" id="TypeName" placeholder="请填写数据类型字段名称">
                </td>
                <td>
                    <input type="text" class="form-control" id="TypeName" placeholder="请填写数据类型名称">
                </td>
                <td>
                    <input type="text" class="form-control" id="TypeName" placeholder="请填写数据类型描述">
                </td>
                <td>
                    <select class="form-control" >
                        <option>整数</option>
                        <option>高精度浮点数</option>
                        <option>字符串</option>
                    </select>
                </td>
                <td>
                    <input type="text" class="form-control" id="TypeName" placeholder="请填写数据类型单位">
                </td>
                <td>

                </td>
                <td><a class="btn btn-danger remove">删除</a></td>
            </tr>
            </tbody>
        </table>
        <a id="add-new-field" class="btn btn-info">增加新的数据项</a>



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
        <a onclick="showConfirmDialog();" class="btn btn-info">添加</a>

    </form>
{/block}
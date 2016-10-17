{extends 'common/common-box.tpl'}
{* 此文件用于添加和修改设备类型 *}
{if $addNew}
    {block name=title}添加设备类型{/block}
{else}
    {block name=title}修改设备类型信息{/block}
{/if}

{block name=content}
    <h3 class="form-title">请填写设备类型信息</h3>
    <form id="addDeviceTypeForm" action="{$doUpdateUrl}" method="post">
        {* hidden keys *}

        <input type="hidden" id="csrfToken" value="{Yii::$app->request->getCsrfToken(true)}" />
        <div class="form-group">
            <label for="exampleInputEmail1">设备类型Key</label>
            <input {if !$addNew}readonly{/if}
                   type="text" class="form-control" name="typeKey" id="typeKey" placeholder="请填写设备类型Key">
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">设备类型名称</label>
            <input type="text" class="form-control" name="typeName" id="typeName" placeholder="请填写设备类型名称">
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">设备类型描述</label>
            <input type="text" class="form-control" name="typeDesc" id="typeDesc" placeholder="请填写设备类型描述">
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">设备便携属性</label>
            <select class="form-control" name="stationType" id="deviceMovableType">
                <option value="0">固定设备</option>
                <option value="1">移动便携设备</option>
            </select>
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">设备数据类型列表</label>
        </div>
        <table id="field-table" class="table table-striped table-bordered">
            <tbody>
            <tr class="field-template" style="display: none">
                <td>
                    <input type="text" class="form-control fieldName" name="fieldName" placeholder="请填写数据类型字段名称">
                </td>
                <td>
                    <input type="text" class="form-control fieldTitle" name="fieldTitle" placeholder="请填写数据类型名称">
                </td>
                <td>
                    <input type="text" class="form-control fieldDesc" name="fieldDesc" placeholder="请填写数据类型描述">
                </td>
                <td>
                    <select class="form-control fieldValueType" name="fieldValueType">
                        <option value="1">整数</option>
                        <option value="2">高精度浮点数</option>
                        <option value="3">字符串</option>
                    </select>
                </td>
                <td>
                    <select class="form-control fieldDisplayFlag" name="fieldDisplayFlag">
                        <option value="0">不显示</option>
                        <option value="1">重点显示</option>
                        <option value="2">显示</option>
                    </select>
                </td>
                <td>
                    <input type="text" class="form-control fieldUnit" id="fieldUnit" placeholder="请填写数据类型单位">
                </td>
                <td>

                </td>
                <td><a class="btn btn-danger remove">删除</a></td>
            </tr>

            {foreach from=$fields item=field}
                <tr class="field" style="">
                    <td>
                        <input type="text" class="form-control" name="fieldName" value="{$field.field_name}" placeholder="请填写数据类型字段名称">
                    </td>
                    <td>
                        <input type="text" class="form-control" name="fieldDisplay" value="{$field.field_display}" placeholder="请填写数据类型名称">
                    </td>
                    <td>
                        <input type="text" class="form-control" name="fieldDesc" value="{$field.field_desc}" placeholder="请填写数据类型描述">
                    </td>
                    <td>
                        <select class="form-control" name="fieldType">
                            <option value="1" {if $field.field_type==1}selected{/if}>整数</option>
                            <option value="2" {if $field.field_type==2}selected{/if}>高精度浮点数</option>
                            <option value="3" {if $field.field_type==3}selected{/if}>字符串</option>
                        </select>
                    </td>
                    <td>
                        <select class="form-control" name="fieldShow">
                            <option value="1" {if $field.display_flag==1}selected{/if}>重点显示</option>
                            <option value="2" {if $field.display_flag==2}selected{/if}>显示</option>
                            <option value="0" {if $field.display_flag==0}selected{/if}>不显示</option>
                        </select>
                    </td>
                    <td>
                        <input type="text" class="form-control" id="TypeUnit" value="{$field.field_unit}???" placeholder="请填写数据类型单位">
                    </td>
                    <td>

                    </td>
                    <td><a class="btn btn-danger remove">删除</a></td>
                </tr>
            {/foreach}
            </tbody>
        </table>
        <a id="add-new-field" class="btn btn-info">增加新的数据项</a>


        <div class="form-group">
            <label for="exampleInputEmail1">设备图片</label>
            <!--dom结构部分-->
            <div id="fileList" class="uploader-list">
                <div class="file-item thumbnail" style="width: 240px">
                    <img style="width:240px; height:180px">
                    <div class="info"></div>
                </div>
            </div>
        </div>
        {* 设备类型信息很重要, 不能轻易更改 *}
        <a onclick="showConfirmDialog();" class="btn btn-info">添加</a>

    </form>
{/block}
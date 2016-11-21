{* 一个状态阈值的 *}
{extends 'common/box.tpl'}

{block name=style}orange margin-top-50{/block}

{block name=title}{$fieldDisplayName} -- 状态值报警设置{/block}

{block name=content}
    <div class="form-group">
        <label><input type="checkbox" name="" />&nbsp;启用</label>
        <label for="exampleInputEmail1">状态值报警</label>
        <input class="form-control" name="device_desc" placeholder="请填写状态值">
    </div>
{/block}
{extends 'common/common-box.tpl'}
{block name=color}border pink{/block}
{block name=title}添加新用户{/block}
{block name=content}
    <h3 class="form-title">请填写用户信息</h3>
    <form id="addRoleForm" action="{$doAddUrl}" method="post">
        {* hidden keys *}
        <input type="hidden" name="csrfToken" value="{Yii::$app->request->getCsrfToken(true)}" />
        <div class="form-group">
            <label for="roleName">用户名</label>
            <input type="text" class="form-control" name="username" placeholder="请填写用户名">
        </div>

        <div class="form-group">
            <label for="roleDesc">选择角色</label>
            <select type="text" class="form-control" name="roleId">
                {foreach from=$roles item=role}
                    <option value="{$role.role_id}">{$role.role_name}</option>
                {/foreach}
            </select>
        </div>

        <a onclick="showConfirmDialog();" class="btn btn-info">添加</a>

    </form>
{/block}
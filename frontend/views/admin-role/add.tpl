{extends 'common/common-box.tpl'}
{block name=color}border {/block}
{block name=title}添加新角色{/block}
{block name=content}
    <h3 class="form-title">请填写角色信息</h3>
    <form id="addRoleForm" action="{$doAddUrl}" method="post">
        {* hidden keys *}
        <input type="hidden" name="csrfToken" value="{Yii::$app->request->getCsrfToken(true)}" />
        <div class="form-group">
            <label for="roleName">角色名称</label>
            <input type="text" class="form-control" name="roleName" placeholder="请填写角色名称">
        </div>

        <div class="form-group">
            <label for="roleDesc">角色描述</label>
            <input type="text" class="form-control" name="roleDesc" placeholder="请填写角色描述">
        </div>

        <a onclick="showConfirmDialog();" class="btn btn-info">添加</a>

    </form>
{/block}
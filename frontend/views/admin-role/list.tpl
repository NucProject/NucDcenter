<div>

    <table class="table table-striped table-bordered table-hover table-full-width dataTable">
        <thead>
        <tr>
            <td>角色ID</td>
            <td>角色名称</td>
            <td>角色说明</td>
            <td>状态</td>
            <td>创建时间</td>
            <td>更新时间</td>
            <td>操作</td>
        </tr>
        </thead>

        <tbody>
        {foreach item=role from=$roles}
        <tr>
            <td>{$role.role_id}</td>
            <td>{$role.role_name}</td>
            <td>{$role.role_desc}</td>
            <td>{if $role.enabled == 1}<span class="label label-info">已启用</span>{else}<span class="label label-default">已禁用</span>{/if}</td>
            <td>{$role.create_time}</td>
            <td>{$role.update_time}</td>
            <td>
                <a class="btn btn-xs btn-info" href="index.php?r=admin-role/users&roleId={$role.role_id}">用户列表</a>
                {if $role.enabled == 1}
                    <a class="btn btn-xs btn-danger enable">禁用</a>
                {else}
                    <a class="btn btn-xs btn-warning disable">启用</a>
                {/if}
            </td>
        </tr>
        {/foreach}
        </tbody>
    </table>
    <a class="btn btn-info" href="index.php?r=admin-role/add">新增角色</a>
</div>
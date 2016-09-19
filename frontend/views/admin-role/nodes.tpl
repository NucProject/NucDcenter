<div>
    <form id="roleNodesForm" method="post" action="index.php?r=admin-role/update-nodes">
        <input type="hidden" name="csrfToken" value="{Yii::$app->request->getCsrfToken(true)}" />
        <input type="hidden" name="roleId" value="{$roleId}" />

    <table class="table table-striped table-bordered table-hover table-full-width dataTable">
        <thead>
            <tr>
                <td>页面名称</td>
                <td>页面URL</td>
                <td>访问控制</td>
                <td>导航栏选项</td>
            </tr>
        </thead>
        <tbody>
        {foreach from=$nodes item=n}
            <tr>
                <td>{$n.name}</td>
                <td><a href="index.php?r={$n.pageUrl}">{$n.pageUrl}</a></td>
                <td>
                    <input type="hidden" name="f[{$n.node_id}][accessAllowed]" {if $n.accessAllowed}checked{/if}>允许访问
                    <input type="checkbox" name="f[{$n.node_id}][accessAllowed]" {if $n.accessAllowed}checked{/if}>允许访问
                </td>
                <td>
                    <select name="f[{$n.node_id}][menuId]">
                        <option value="0">不显示到左侧导航栏中</option>
                        {foreach from=$menus item=m}
                            <option value="{$m.menu_id}">{$m.menu_name}</option>
                        {/foreach}
                    </select>
                </td>
            </tr>
        {/foreach}
        </tbody>
    </table>

        <input type="submit" class="btn btn-info">
    </form>
</div>
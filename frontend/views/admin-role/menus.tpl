{literal}
<style>
    .current{
        background-color: antiquewhite !important;
    }
</style>
{/literal}
<div>
    <div id="menu_group_operator" class="clearfix box">
        <div class="control-group toolbar">
            <a class="btn btn-info icn-only blue moveUp" direct="u">
                上移 <i class="m-icon-swapup m-icon-white"></i>
            </a>
            <a class="btn btn-info icn-only blue moveDown" direct="d">
                下移 <i class="m-icon-swapdown m-icon-white"></i>
            </a>
        </div>
    </div>

    <form id="roleMenusForm" method="post" action="index.php?r=admin-role/menus-update">


        <table class="table table-bordered table-full-width dataTable" id="menu_group_table">
            <thead>
            <tr>
                <td width="80px">菜单组ID</td>
                <td>菜单组名称</td>

                <td>操作</td>
            </tr>
            <tr class="entry-template entry" style="display: none">
                <td><span class="value" type="text"></span></td>
                <td><input class="name form-control" type="text"/></td>

                <td>
                    <a class="btn del btn-xs btn-danger" data-toggle="modal">删除</a>
                </td>
            </tr>
            </thead>
            <tbody>
            {foreach from=$menus item=m}
            <tr class="entry" menu_id="{$m['menu_id']}">
                <td><span class="value" type="text">{$m['menu_id']}</span></td>
                <td><input class="name form-control" type="text" value="{$m['menu_name']}"/></td>

                <td>
                    <a class="btn del btn-xs btn-danger" data-toggle="modal">删除</a>
                </td>
            </tr>
            {/foreach}
            </tbody>
        </table>

        <a class="btn btn-info blue add" data-toggle="modal" onclick="addNewMenuGroup()">增加</a>
    </form>
    <br>

    <div style="clear: both"></div>
    <a class="btn btn-warning blue" onclick="updateMenuGroups()">更新</a>
    <div style="display: none" id="remove-confirm-dialog-content">
        <span>该菜单项可能被其他子菜单项依赖，您确定要删除它吗？</span>
        <br>
        <span style="color:darkred">如果需要删除，请删除后在'访问控制权限编辑'中重新选择菜单项</span>
    </div>
</div>
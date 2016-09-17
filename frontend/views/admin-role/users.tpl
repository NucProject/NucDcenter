<div>

    <table class="table table-striped table-bordered table-hover table-full-width dataTable">
        <thead>
        <tr>
            <td>用户ID</td>
            <td>用户名</td>

            <td>创建时间</td>
            <td>最后修改时间</td>
        </tr>
        </thead>

        <tbody>
        {foreach item=r from=$relations}
            <tr>
                <td>{$r.user.user_id}</td>
                <td>{$r.user.username}</td>

                <td>{$r.user.create_time}</td>
                <td>{$r.user.update_time}</td>

            </tr>
        {/foreach}
        </tbody>
    </table>
    <a class="btn btn-info" href="index.php?r=admin-user/add">新增用户</a>
</div>
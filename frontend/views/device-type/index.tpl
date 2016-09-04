<div>


    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <td><b>设备类型Key</b></td>
            <td><b>设备类型名称</b></td>
            <td><b>设备类型描述</b></td>

            <td>最后修改时间</td>
        </tr>
        </thead>
        <tbody>
        {foreach from=$deviceTypes item=t}
            <tr>
                <td>{$t.type_key}</td>
                <td>{$t.type_name}</td>
                <td>{$t.type_desc}</td>

                <td>{$t.update_time}</td>
            </tr>
        {/foreach}
        </tbody>
    </table>
    <a class="btn btn-info" href="index.php?r=device-type/add">新增</a>
</div>
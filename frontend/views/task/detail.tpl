<div>
    <h4>参与的设备</h4>
    <table class="table table-striped">
        <thead>
        <tr>
            <td><b>参与人</b></td>
            <td><b>设备名称</b></td>
            <td><b>设备编号</b></td>
            <td><b>参加时间</b></td>

        </tr>
        </thead>
        {foreach from=$task.attends item=attend}
            <tr>
                <td>{$attend.attend_name}</td>
                <td>{$attend.device.type_name}</td>
                <td>{$attend.device.device_key}</td>
                <td>{$attend.create_time}</td>
            </tr>
        {/foreach}
    </table>

</div>
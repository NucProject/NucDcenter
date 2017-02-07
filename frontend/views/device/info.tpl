
<div>
    <table class="table table-bordered">
        <tbody>
            <tr><td>DeviceKey</td><td>{$device.device_key}</td></tr>
            <tr><td>设备型号</td><td>{$device.type_name}</td></tr>
            <tr><td>设备描述</td><td>{$device.device_desc}</td></tr>
            <tr><td>设备序列号</td><td>{$device.device_sn}</td></tr>
        </tbody>
    </table>


        {if $device.is_movable}
        {* 该设备参与过的任务 *}
        {include 'device/attended-tasks.tpl'}
    {/if}

    <a href="index.php?r=device/active-data&deviceKey={$device.device_key}" class="btn btn-info">实时数据</a>
</div>
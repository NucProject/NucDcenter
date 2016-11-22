<div>

    {if $device.is_movable}
        {* 该设备参与过的任务 *}
        {include 'device/attended-tasks.tpl'}
    {/if}

    <a href="index.php?r=device/active-data&deviceKey={$device.device_key}" class="btn btn-info">实时数据</a>
</div>
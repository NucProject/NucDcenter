<div>

    {if $device.is_movable}
        {* 该设备参与过的任务 *}
        {include 'device/attended-tasks.tpl'}
    {/if}
</div>
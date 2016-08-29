<div>
    {if count($devices) > 0}
        {include file='station/device-list.tpl' devices=$devices}
    {else}
        {* Empty *}
        <h2>目前还没有任何设备，新增设备请点击'添加'按钮</h2>
        <a class="btn btn-info" href="index.php?r=station/add-device&stationKey={$stationKey}">添加</a>
    {/if}
</div>
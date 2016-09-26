<div>
    <div class="col-md-12 box-container">
        {include 'station/manage.tpl'}
    </div>

    {if count($devices) > 0}
    <div class="col-md-12 box-container">
        {include file='station/device-list.tpl' devices=$devices}
    </div>
    {else}
        {* Empty *}
        <h2>目前还没有任何设备，新增设备请点击'添加'按钮</h2>
        <a class="btn btn-info" href="index.php?r=station/add-device&stationKey={$stationKey}">添加</a>
    {/if}

    <div class="col-md-12 box-container">
        {include 'station/other.tpl'}
    </div>
</div>
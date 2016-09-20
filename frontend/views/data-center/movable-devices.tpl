<div>
    <div class="col-md-12 box-container">
        {include 'data-center/add-movable-device.tpl'}
    </div>

    <div class="clearfix"></div>
    {* N个自动站 *}
    {foreach from=$devices item=d}
        <div class="col-md-4 box-container">
            {include 'station/device-summary.tpl' device=$d}
        </div>
    {/foreach}


</div>
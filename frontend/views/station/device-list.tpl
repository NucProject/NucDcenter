<div>
    {* N个自动站 *}
    {foreach from=$devices item=d}
        {include 'station/device-summary.tpl' device=$d}
    {/foreach}

    {include 'station/manage.tpl'}
</div>
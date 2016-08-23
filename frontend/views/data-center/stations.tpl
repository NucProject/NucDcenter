<div>
    {* N个自动站 *}
    {foreach from=$stations item=s}
        {include 'data-center/station.tpl' station=$s}
    {/foreach}

</div>
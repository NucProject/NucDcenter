<div>
{*    <div class="col-md-12 box-container">
        {include 'data-center/none-station.tpl' has_remove=true}
    </div>*}

    {* N个自动站 *}
    {foreach from=$stations item=s}
    <div class="col-md-6 box-container">
        {include 'data-center/station.tpl' station=$s has_collapse=true}
    </div>
    {/foreach}


</div>
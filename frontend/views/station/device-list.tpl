{* *}
{extends 'common/common-box.tpl'}
{block name=color}orange{/block}
{*  *}
{block name=title}
    <span>设备概况</span>
{/block}

{block name=content}
    <div>


        <div class="clearfix"></div>
        {* N个自动站 *}
        {foreach from=$devices item=d}
            <div class="col-md-4 box-container">
                {include 'device/summary.tpl' device=$d}
            </div>
        {/foreach}


    </div>
{/block}

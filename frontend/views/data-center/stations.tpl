{* *}
{extends 'common/common-box.tpl'}
{block name=color}orange{/block}
{*  *}
{block name=title}
    <span>当前自动站</span>
{/block}

{block name=content}
<div>
    {* N个自动站 *}
    {foreach from=$stations item=s}
    <div class="col-md-6 box-container">
        {include 'data-center/station.tpl' station=$s has_collapse=true}
    </div>
    {/foreach}


</div>
{/block}
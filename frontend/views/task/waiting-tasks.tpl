{* 等待开始的任务 TAB *}
{extends 'common/box.tpl'}

{block name=style}orange{/block}

{block name=title}等待开始的任务 ({count($waitingTasks)}个){/block}

{block name=content}
    {foreach from=$waitingTasks item=t}
        {json_encode($t)}
    {/foreach}
{/block}
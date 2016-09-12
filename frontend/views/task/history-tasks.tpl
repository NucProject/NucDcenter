{* 已经完成的任务 TAB *}
{extends 'common/box.tpl'}

{block name=style}orange{/block}

{block name=title}已经完成的任务 ({count($historyTasks)}个){/block}


{block name=content}
    {foreach from=$historyTasks item=t}
        {json_encode($t)}
    {/foreach}
{/block}
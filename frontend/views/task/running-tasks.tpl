{* 正在进行的任务 Tab *}
{extends 'common/box.tpl'}

{block name=style}orange{/block}

{block name=title}正在进行的任务 ({count($runningTasks)}个){/block}

{block name=content}
    {foreach from=$runningTasks item=t}
        {json_encode($t)}
    {/foreach}
{/block}
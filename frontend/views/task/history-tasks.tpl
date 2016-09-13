{* 已经完成的任务 TAB *}
{extends 'common/box.tpl'}

{block name=style}orange margin-top-50{/block}

{block name=title}已经完成的任务 ({count($historyTasks)}个){/block}


{block name=content}
    <ul class="team-list" style="list-style: none">
    {foreach from=$historyTasks item=t}
        {include 'task/task-item.tpl' task=$t}
    {/foreach}
    </ul>
{/block}
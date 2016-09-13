{* 等待开始的任务 TAB *}
{extends 'common/box.tpl'}

{block name=style}orange margin-top-50{/block}

{block name=title}等待开始的任务 ({count($waitingTasks)}个){/block}

{block name=content}
    <ul class="team-list" style="list-style: none">
    {foreach from=$waitingTasks item=t}
        {include 'task/task-item.tpl' task=$t}
    {/foreach}
    </ul>
{/block}
{* 正在进行的任务 Tab *}
{extends 'common/box.tpl'}

{block name=style}orange margin-top-50{/block}

{block name=title}正在进行的任务 ({count($runningTasks)}个){/block}

{block name=content}
    <ul class="team-list" style="list-style: none">
    {foreach from=$runningTasks item=t}
        {include 'task/task-item.tpl' task=$t}
    {/foreach}
    </ul>
{/block}
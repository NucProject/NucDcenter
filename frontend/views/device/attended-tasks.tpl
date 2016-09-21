{extends 'common/common-box.tpl'}
{block name=color}orange{/block}
{block name=title}参与过的任务{/block}
{block name=content}
    <table class="table table-bordered">
        <thead>
        <tr>
            <td>任务名称</td>
            <td>任务描述</td>
            <td>任务状态</td>
            <td>任务开始时间</td>
            <td>任务结束时间</td>
            <td>操作</td>
        </tr>
        </thead>
        <tbody>
        {foreach from=$tasks item=i}
            <tr task_id="{$i.task.task_id}">
                <td>{$i.task.task_name}</td>
                <td>{$i.task.task_desc}</td>
                <td>{$i.task.task_status}</td>
                <td>{$i.task.begin_time}</td>
                <td>{$i.task.end_time}</td>
                <td>
                    <a class="btn btn-xs btn-info" href="index.php?r=task/detail&taskId={$i.task.task_id}">任务详情</a>
                    {if $i.task.task_status == 3}
                    <a class="btn  btn-xs btn-danger" href="index.php?r=task/replay&taskId={$i.task.task_id}">
                        <i class="fa fa-play"></i>&nbsp;任务回放</a>
                    {/if}
                </td>
            </tr>
        {/foreach}
        </tbody>
    </table>
{/block}
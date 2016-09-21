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
        </tr>
        </thead>
        <tbody>
        {foreach from=$tasks item=i}
            <tr>
                <td>{$i.task.task_name}</td>
                <td>{$i.task.task_desc}</td>
                <td>{$i.task.task_status}</td>
                <td>{$i.task.begin_time}</td>
                <td>{$i.task.end_time}</td>
            </tr>
        {/foreach}
        </tbody>
    </table>
{/block}
<div>
    <table class="table table-striped">
        <tbody>
            <tr>
                <td style="width: 200px">任务描述:</td>
                <td><b>{$task.task_desc}</b></td>
            </tr>
            {***************************************************}
            <tr>
                <td>任务状态:</td>
                <td>
                    {if $task.task_status == 1}
                        <button class="btn btn-inverse btn-xs"><i class="fa fa-clock-o"></i> 未开始</button>
                    {elseif $task.task_status == 2}
                        <button class="btn btn-success btn-xs"><i class="fa fa-random"></i> 进行中</button>
                    {elseif $task.task_status == 3}
                        <button class="btn btn-grey btn-xs"><i class="fa fa-thumbs-up"></i> 已完成</button>
                    {/if}
                </td>
            </tr>
            {***************************************************}
            <tr>
                <td>任务预计时间:</td>
                <td><b>{$task['begin_set_time']} ~ {$task['end_set_time']}</b></td>
            </tr>
            {***************************************************}
            {if $task.task_status == 1}
                {* SHOW NOTHING *}
            {elseif $task.task_status == 2}
                <tr>
                    <td>任务实际时间:</td>
                    <td><b>{$task['begin_time']} ~ 现在</b></td>
                </tr>
            {elseif $task.task_status == 3}
                <tr>
                    <td>任务实际时间:</td>
                    <td><b>{$task['begin_time']} ~ {$task['end_time']}</b></td>
                </tr>
            {/if}
        </tbody>
    </table>

    {if $task.task_status == 1}
        <a class="btn btn-info" href="index.php?r=task/start&taskId={$task['task_id']}">开始任务!</a>
    {elseif $task.task_status == 2}
        <a class="btn btn-info" href="index.php?r=task/stop&taskId={$task['task_id']}">停止任务!</a>
    {elseif $task.task_status == 3}
        <!--????
        <a class="btn btn-info" href="index.php?r=task/stop">停止</a>
        -->
    {/if}

    <h4>参与的设备</h4>
    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <td><b>参与人</b></td>
            <td><b>设备名称</b></td>
            <td><b>设备编号</b></td>
            <td><b>参加时间</b></td>

        </tr>
        </thead>
        {foreach from=$task.attends item=attend}
            <tr>
                <td>{$attend.attend_name}</td>
                <td>{$attend.device.type_name}</td>
                <td>{$attend.device.device_key}</td>
                <td>{$attend.create_time}</td>
            </tr>
        {/foreach}
    </table>

</div>
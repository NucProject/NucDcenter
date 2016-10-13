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

    {if count($task.attends)>0}
    <h4>参与的设备</h4>
    <table id="devices-table" class="table table-striped table-bordered">
        <thead>
        <tr>
            <td><b>设备名称</b></td>
            <td><b>设备编号</b></td>
            <td><b>当前测量值</b></td>
            <td><b>当前状态</b></td>
            <td><b>参与人</b></td>
            <td><b>参加时间</b></td>

        </tr>
        </thead>
        {foreach from=$task.attends item=attend}
            <tr>
                <td>{$attend.device.type_name}</td>
                <td>{$attend.device.device_sn}</td>
                <td class="value" id="{$attend.device.device_key}"></td>
                <td>
                    {if $attend.device.device_status==1}
                        <button class="btn btn-info btn-xs"> 已激活</button>
                    {else}
                        <button class="btn btn-grey btn-xs"> 未激活</button>
                    {/if}
                </td>
                <td>{$attend.attend_name}</td>
                <td>{$attend.create_time}</td>
            </tr>
        {/foreach}
    </table>
        {else}
        <h4>没有参与的设备</h4>
        <hr>
    {/if}

    <h4>当前任务区域</h4>
    <a class="btn btn-info" href="index.php?r=task/distribute&taskId={$task.task_id}">查询区域分布</a>
    <a class="btn btn-info">查询轨迹</a>

    <div style="width: 402px; height: 300px; border: solid 1px grey;margin-top: 10px">
        {if $task['task_image']}
            <img src="/taskimg/{$task['task_image']}" alt="" style="width: 400px;height: 300px">
        {else}
            {* TODO: 给个默认的图片 *}
            <img src="/taskimg/default.jpg" alt="未设置地图" style="width: 400px;height: 300px;border: none">
        {/if}
    </div>

</div>
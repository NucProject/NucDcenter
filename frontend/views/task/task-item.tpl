<li class="current pull-left" style="margin-right: 30px;margin-bottom: 20px">
    <a href="index.php?r=task/detail&taskId={$task['task_id']}">
    <div style="position:relative;">
        <div style="width: 202px;height: 200px; border: solid 1px grey">
        {if $task['task_image']}
            <img src="/taskimg/{$task['task_image']}" alt="" style="width: 200px;height: 150px">
            {else}
            {* TODO: 给个默认的图片 *}
            <img src="/taskimg/default.jpg" alt="未设置地图" style="width: 200px;height: 150px;border: none">
        {/if}
        </div>
        <div style="position:absolute; z-index:2; bottom:0; left:0; width: 100%;
                    background-color: #3c3c3c; opacity: 0.85; padding-left: 5px">

            <h4 class="title" style="color: white">
                {$task['task_name']}
            </h4>

            <span class="status">
                <div class="field">
                    <span class="badge badge-green">6</span> 设备参与
                    <span class="pull-right fa fa-check"></span>
                </div>

                <div class="field">
                    开始于 {$task['begin_time']}
                    <span class="pull-right fa fa-list-ul"></span>
                </div>
                {if $task['task_status'] == 3}
                <div class="field">
                    结束于 {$task['end_time']}
                    <span class="pull-right fa fa-list-ul"></span>
                </div>
                {/if}
            </span>

        </div>

    </div>
    </a>
</li>
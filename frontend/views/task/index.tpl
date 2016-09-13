<div>
    {if isset($hasCreateTaskPermission) && $hasCreateTaskPermission == true}
    <div class="box">
        <a class="btn btn-info" href="index.php?r=task/create">创建新任务</a>
    </div>
    {/if}


    {if count($runningTasks) > 0}
        {include 'task/running-tasks.tpl'}
    {/if}

    {if count($waitingTasks) > 0}
        {include 'task/waiting-tasks.tpl'}
    {/if}

    {include 'task/history-tasks.tpl'}

</div>
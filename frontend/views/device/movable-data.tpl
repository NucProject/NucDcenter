<div>
    {* 设置搜索条件 *}
    <form id="search-form" method="get" action="#">
        <input type="hidden" name="r" value="device/movable-data">

        {if isset($currentTaskId)}
        <div class="form-group">
            <label class="control-label pull-left" style="margin-top: 8px">
                选择任务:
            </label>
            <div class="col-md-2 pull-left">
                <select class="form-control" name="taskId">
                    {foreach from=$attends item=t}
                    <option value="{$t.task.task_id}" {if $currentTaskId==$t.task.task_id}selected{/if}>{$t.task.task_name}</option>
                    {/foreach}
                </select>
            </div>

            <input type="submit" class="btn btn-info" value="查看">
        </div>
        {/if}

        <input type="hidden" name="deviceKey" value="{$deviceKey}">
        <input type="hidden" name="__page" value="{$get.__page}">
        <input type="hidden" name="__pageSize" value="{$get.__pageSize}">
    </form>
    <div class="clearfix"></div>

    {* charts *}
    {if !$hideChart}
        {include 'device/charts.tpl'}
    {/if}

    {* list *}
    {if !$hideList}
        {include 'device/list.tpl'}
    {/if}
</div>
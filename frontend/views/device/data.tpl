<div>
    {* 设置搜索条件 *}
    <form id="search-form" method="get" action="#">
        <input type="hidden" name="r" value="device/data">

        <div class="form-group">
            <label class="control-label pull-left" style="margin-top: 8px">
                开始时间:
            </label>
            <div class="col-md-2 pull-left">
                <input class="form-control" type="text" name="begin_time" size="10" id="begin_time"
                       value="{$get.begin_time}">
            </div>
            <label class="control-label pull-left" style="margin-top: 8px">
                结束时间:
            </label>
            <div class="col-md-2  pull-left">
                <input class="form-control" type="text" name="end_time" size="10" id="end_time"
                       value="{$get.end_time}">
            </div>
        </div>

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
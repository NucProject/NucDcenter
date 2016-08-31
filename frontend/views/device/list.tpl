<div>
    {* 设置搜索条件 *}
    <form>
        <div class="form-group">
            <label class="col-md-4 control-label">选择数据时间范围:</label>
            <div class="clearfix"></div>
            <div class="col-md-2 pull-left">
                <input class="form-control" type="text" name="begin_time" size="10" id="begin_time">
            </div>
            <div class="col-md-2  pull-left">
                <input class="form-control" type="text" name="end_time" size="10" id="end_time">
            </div>
        </div>
    </form>

    <div class="form-group margin-top-50">
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                {foreach from=$data.columns item=col}
                    <td>
                        <b>{$col.field_display}</b>
                        {if isset($col.field_unit)}({$col.field_unit}){/if}
                    </td>
                {/foreach}
            </tr>
            </thead>
            <tbody>
            {foreach from=$data.items item=i}
                <tr>
                    {foreach from=$data.columns item=col}
                        <td>{$i[$col.field_name]}</td>
                    {/foreach}
                </tr>
            {/foreach}
            </tbody>
        </table>
    </div>

</div>
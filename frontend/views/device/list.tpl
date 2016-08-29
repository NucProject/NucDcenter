<div>
    {* 设置搜索条件 *}
    <form>
        <div class="form-group">
            <label class="col-md-4 control-label">选择数据时间范围:</label>
            <div class="clearfix"></div>
            <div class="col-md-2 pull-left">
                <input class="form-control datepicker" type="text" name="regular" size="10">
            </div>
            <div class="col-md-2  pull-left">
                <input class="form-control datepicker" type="text" name="regular" size="10">
            </div>
        </div>
    </form>

    <div class="">
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                {foreach from=$data.columns item=col}
                    <td>
                        {$col.field_display}
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
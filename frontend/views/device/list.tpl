<div>

    <div class="margin-top-50">
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                {foreach from=$columns item=col}
                    <td>
                        <b>{$col.field_display}</b>
                        {if isset($col.field_unit)}({$col.field_unit}){/if}
                    </td>
                {/foreach}
            </tr>
            </thead>
            <tbody>
            {foreach from=$items item=i}
                <tr>
                    {foreach from=$columns item=col}
                        <td>{$i[$col.field_name]}</td>
                    {/foreach}
                </tr>
            {/foreach}
            </tbody>
        </table>
    </div>
    {include 'common/pager.tpl' form='search-form'}

</div>
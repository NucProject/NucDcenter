<div>

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
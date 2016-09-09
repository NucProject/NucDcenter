<div>
    <form>
    <table class="table table-striped table-bordered table-hover table-full-width dataTable">
        <thead>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>²Ëµ¥Ïî</td>
            </tr>
        </thead>
        <tbody>
        {foreach from=$nodes item=n}
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>
                    <select>
                        {foreach from=$menus item=m}
                            <option value="{$m.menu_id}">{$m.menu_name}</option>
                        {/foreach}
                    </select>
                </td>
            </tr>
        {/foreach}
        </tbody>
    </table>
    </form>
</div>
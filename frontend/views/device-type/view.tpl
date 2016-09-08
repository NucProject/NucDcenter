<div>
    <h3>设备类型信息</h3>
    <table>
        <tr>
            <td>设备类型名称</td>
            <td>{$type.type_name}</td>
        </tr>
        <tr>
            <td>设备类型说明</td>
            <td>{$type.type_desc}</td>
        </tr>
        <tr>
            <td>设备类型创建时间</td>
            <td>{$type.create_time}</td>
        </tr>
        <tr>
            <td>设备类型修改时间</td>
            <td>{$type.update_time}</td>
        </tr>
    </table>

    <h3>设备类型字段信息</h3>
    <table>
        <thead>
        <tr>
            <td>字段名称</td>
            <td>字段类型</td>
            <td>字段显示名称</td>
            <td>字段说明</td>
        </tr>
        </thead>
        <!----------------------------->
        <tbody>

        {foreach from=$fields item=field}
        <tr>
            <td>{$field.field_name}</td>
            <td>{$field.field_type}</td>
            <td>{$field.field_display}</td>
            <td>{$field.field_desc}</td>
        </tr>
        {/foreach}

        </tbody>
    </table>
</div>
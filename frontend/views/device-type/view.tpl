<div>
    <h3>�豸������Ϣ</h3>
    <table>
        <tr>
            <td>�豸��������</td>
            <td>{$type.type_name}</td>
        </tr>
        <tr>
            <td>�豸����˵��</td>
            <td>{$type.type_desc}</td>
        </tr>
        <tr>
            <td>�豸���ʹ���ʱ��</td>
            <td>{$type.create_time}</td>
        </tr>
        <tr>
            <td>�豸�����޸�ʱ��</td>
            <td>{$type.update_time}</td>
        </tr>
    </table>

    <h3>�豸�����ֶ���Ϣ</h3>
    <table>
        <thead>
        <tr>
            <td>�ֶ�����</td>
            <td>�ֶ�����</td>
            <td>�ֶ���ʾ����</td>
            <td>�ֶ�˵��</td>
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
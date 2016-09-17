{literal}
<script>
    function showConfirmDialog()
    {
        var form = $('#addRoleForm');
        var username = form.find('input[name=username]').val();
        var roleName = form.find('select option:selected').text();
        bootbox.confirm({
            buttons: {
                confirm: {
                    label: '确认',
                    className: 'btn-myStyle'

                },
                cancel: {
                    label: '取消',
                    className: 'btn-default'
                }
            },
            title: "添加用户",
            message: '是否要添加用户“<b>{username}</b>”为<b>{roleName}</b>？'.format({'username': username, 'roleName': roleName}),

            callback: function(result) {
                if (result) {
                    form.submit();
                }
            }
        });
    }
</script>
{/literal}

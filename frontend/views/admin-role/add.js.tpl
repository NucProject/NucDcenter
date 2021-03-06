{literal}
<script>
    function showConfirmDialog()
    {
        var form = $('#addRoleForm');
        var roleName = form.find('input[name=roleName]').val();
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
            title: "添加角色",
            message: '是否要添加“<b>{roleName}</b>”角色？'.format({'roleName': roleName}),

            callback: function(result) {
                if (result) {
                    form.submit();
                }
            }
        });
    }
</script>
{/literal}

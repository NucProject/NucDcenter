<script>
    var token = "{Yii::$app->request->getCsrfToken(true)}";
</script>
{literal}
<script>
    function updateAdminNodes()
    {
        var posts = [];
        $('table.modules tr[node_id]').each(function() {
            var tr = $(this);
            var controller = tr.attr('controller');
            var action = tr.attr('action');
            var param0 = tr.attr('param0');
            var value0 = tr.attr('value0');
            var param1 = tr.attr('param1');
            var value1 = tr.attr('value1');
            var input = tr.find('td.name input');
            var name = input.val() || input.attr('default');

            posts.push({
                nodeId: tr.attr('node_id'),
                controller: controller, action: action, name: name,
                param0: param0, value0: value0,
                param1: param1, value1: value1,
            });

        });

        $.post('index.php?r=admin-nodes/update', { csrfToken: token, data: posts }, function(data) {
            console.log(data);
        });
    }

    function updateAdminNodesConfirm()
    {
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
            title: "更新全部页面节点确认",
            message: '要更新全部页面节点吗? ',

            callback: function(result) {
                if (result) {
                    updateAdminNodes();
                }
            }
        });


    }

    function showAddParamDialog(tr)
    {
        var div = tr.find('div.params').clone().css('display', 'block');
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
            title: "配置参数",
            message: div,

            callback: function(result) {
                if (result) {

                }
            }
        });
    }

    $(function () {
        $('table.modules').delegate('a.setParam', 'click', function () {
            var tr = $(this).closest('tr');
            showAddParamDialog(tr);
        });

        $('table.modules').delegate('a.copy', 'click', function() {

            var tr = $(this).closest('tr');
            var param0 = tr.attr('param0');
            if (param0 && param0.length > 0)
            {
                var copy = tr.clone();
                tr.after(copy);
            }
            else
            {
                alert('仅有带有参数的URL地址才能被复制');
            }
        });

        $('table.modules').delegate('a.action', 'click', function() {
            var url = $(this).text();
            url = url.trim();
            window.open('index.php?r=' + url);
        });
    })
</script>
{/literal}
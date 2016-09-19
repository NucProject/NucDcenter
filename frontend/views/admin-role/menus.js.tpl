<script>
    var token ="{Yii::$app->request->getCsrfToken(true)}";
    var roleId = parseInt('{$roleId}') || 0;
</script>
<script>
    function addNewMenuGroup() {
        var table = $('#menu_group_table');
        var t = table.find('tr.entry-template');
        var body = table.find('tbody');
        var m = t.clone();
        m.css('display', '').attr('menu_id', 0);
        m.removeClass('entry-template').find('input.name').val(name);
        m.appendTo(body);
        console.log(body, t, m);
    }


    function exchangeItems(a, b) {
        a.insertBefore(b);
    }

    function collectMenuGroupsInfo() {
        $('#group-edit-pane').find('.group').each(function(){
            var t = $(this);
            console.log(t.find('input').val());
        });
    }

    function updateMenuGroups() {
        var form = $('#roleMenusForm');
        var posts = [];
        var order = 0;
        form.find('tr[menu_id]').each(function () {
            var menuId = $(this).attr('menu_id');
            var name = $(this).find('input').val();
            posts.push({
                menuId: menuId,
                name: name, order: order
            });
            order += 1;
        });

        $.post(form.attr('action'), {
            roleId: roleId,
            csrfToken: token,
            menus: posts
        }, function(data){

        });
    }

    function removeMenuIfConfirm(tr)
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
            title: "删除菜单项",
            message: $('#remove-confirm-dialog-content').html(),

            callback: function(result) {
                if (result) {
                    tr.remove();
                }
            }
        });
    }

    $(function(){
        var table = $('#menu_group_table');

        table.delegate('tr.entry', 'click', function(){
            var self = $(this);
            self.siblings().removeClass('current');
            self.addClass('current');
        });

        table.delegate('a.del', 'click', function() {

            var tr = $(this).closest('tr');
            if (tr.attr('menu_id') > 0) {
                removeMenuIfConfirm(tr);
            } else {
                tr.remove();
            }

        });

        $('#menu_group_operator').delegate('a.moveUp, a.moveDown', 'click', function(){
            var $t = $(this);
            var direct = $t.attr('direct');
            var item = table.find('tr.current');
            if (direct == 'd') {
                exchangeItems(item.next(), item);
            } else if (direct == 'u') {
                exchangeItems(item, item.prev());
            }
        });
        // initMenuGroup(menuGroup);
    });
</script>
<script>
    var fetchValUrl = '{$fetchValUrl}';
    var taskName = '{$task.task_name}';
    var taskId = '{$task.task_id}';
    var token = "{Yii::$app->request->getCsrfToken(true)}";
</script>
{literal}
<script>

    function fetchValues(deviceKeyList) {
        console.log(deviceKeyList);
        $.post(fetchValUrl, {deviceKeyList: deviceKeyList}, function(data) {
            console.log(data);
        });
    }

    function deleteTask() {
        $.post('index.php?r=task/delete', {taskId: taskId, csrfToken:token}, function (data) {
            var result = data.toJson();
            console.log(result);
            if (result.error == 0) {
                window.location.href = 'index.php?r=task';
            } else {
                // TODO: 删除任务失败显示?
            }
        });
    }

	$(function() {
		var tds = $('#devices-table td.value');
        var deviceKeyList = [];
        tds.each(function() {
            var deviceKey = $(this).attr('device_key');
            var typeKey = $(this).attr('type_key');
            if (deviceKey && deviceKey.length > 0)
            {
                deviceKeyList.push({deviceKey:deviceKey, typeKey: typeKey});
            }
        });

        setInterval(function() {
            fetchValues(deviceKeyList);
        }, 10000);


        $('a.del-task').click(function() {

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
                title: "是否要删除该任务",
                message: '是否要删除该任务‘{taskName}’？'.format({taskName: taskName}),

                callback: function(result) {
                    if (result) {
                        deleteTask();
                    }
                }
            });
        });
	});
</script>
{/literal}
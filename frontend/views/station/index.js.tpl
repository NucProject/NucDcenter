<script>
    var deviceKeyList = [];
    {foreach from=$devices item=device}
    deviceKeyList.push({
        deviceKey: '{$device.device_key}', typeKey: '{$device.type_key}'}
    );
    {/foreach}

    console.log(deviceKeyList)
</script>
{literal}
<script>

    function updateDeviceActiveStatus(data)
    {
        var items = data['data'];
        for (var deviceKey in items)
        {
            var info = items[deviceKey];
            if (info)
            {
                var time = info['time'];
                var deviceDiv = $('div[deviceKey={deviceKey}]'.format({deviceKey: deviceKey}));
                var datatime = Date.parse(time);
                if (datatime > 0 &&  +new Date() - datatime < 120 * 1000) {
                    deviceDiv.find('span.active-status').removeClass('label-default').addClass('label-info').text('已激活');
                } else {
                    deviceDiv.find('span.active-status').removeClass('label-info').addClass('label-default').text('未激活');
                }

                deviceDiv.find('span.latest_time').text(time);
            }

        }
        console.log("~~~~");
    }

    $(function() {
        // For device summary
        $('div.tools').delegate('a.config', 'click', function () {
            var modifyLink = $(this).closest('div.box').find('div.box-body a.modify');

            window.location.href = modifyLink.attr('href');
        });


        setInterval(function() {
            $.post('index.php?r=device-data/latest', {'deviceKeyList': deviceKeyList}, function(data) {
                updateDeviceActiveStatus(data.toJson())
            });
        }, 5000);



    });
</script>
{/literal}
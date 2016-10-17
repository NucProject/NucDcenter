<script>
    var fetchValUrl = '{$fetchValUrl}';
</script>
{literal}
<script>

    function fetchValues(deviceKeyList) {
        console.log(deviceKeyList);
        $.post(fetchValUrl, {deviceKeyList: deviceKeyList}, function(data) {
            console.log(data);
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
	});
</script>
{/literal}
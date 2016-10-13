<script>
    var fetchValUrl = '{$fetchValUrl}';
</script>
{literal}
<script>

    function fetchValues(idList) {
        console.log(idList);
        $.post(fetchValUrl, {idList: idList}, function(data) {
            console.log(data);
        });
    }

	$(function() {
		var tds = $('#devices-table td.value');
        var idList = [];
        tds.each(function() {
            var id = $(this).attr('id');
            if (id && id.length > 0)
            {
                idList.push(id);
            }
        });

        setInterval(function() {
            fetchValues(idList);
        }, 10000);
	});
</script>
{/literal}
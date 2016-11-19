<script>
    $(function () {
        // 跳转到update station页面的click bind
        $('a.config').on('click', function () {
            var stationKey = $(this)
                    .closest('div.box')
                    .find('div.box-body div[stationKey]')
                    .attr('stationKey');
            var link = "index.php?r=data-center/update-station&stationKey=" + stationKey;

            window.location.href = link;
        });
    })
</script>
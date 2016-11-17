<script>
    $(function() {
        // For device summary
        $('div.tools').delegate('a.config', 'click', function () {
            var modifyLink = $(this).closest('div.box').find('div.box-body a.modify');

            window.location.href = modifyLink.attr('href');
        });
    });
</script>
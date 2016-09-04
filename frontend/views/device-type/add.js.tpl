<script>
    $(function () {
        var table = $('#addDeviceForm table');

        $('#add-new-field').click(function () {
            var tr = table.find('tr.field-template').clone().removeClass('field-template').css('display', '');
            tr.appendTo(table.find('tbody'));
        });

        $('#add-new-field').click();

        table.delegate('tr a.remove', 'click', function () {
            $(this).closest('tr').remove();
        })


    });
</script>
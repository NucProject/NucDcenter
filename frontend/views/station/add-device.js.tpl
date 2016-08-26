<script>


    function showConfirmDialog()
    {
        bootbox.confirm("Hello world!", function (result) {
            if(result) {
                $('#addDeviceForm').submit();
            } else {

            }
        });
    }
</script>
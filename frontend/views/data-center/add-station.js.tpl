<script>
    $(function () {
        var uploader = WebUploader.create({

            auto: true,

            // swf文件路径
            swf: 'webuploader/Uploader.swf',

            // 文件接收服务端。
            server: 'index.php?r=upload-file/station-picture',

            // 选择文件的按钮。可选。
            // 内部根据当前运行是创建，可能是input元素，也可能是flash.
            pick: '#filePicker',

            // 不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
            resize: false,

            accept: {
                title: 'Images',
                extensions: 'gif,jpg,jpeg,bmp,png',
                mimeTypes: 'image/*'
            }
        });



        uploader.on( 'fileQueued', function( file ) {

            var $list = $('#fileList');
            var $li = $list.find('div.thumbnail');
            $li.find('div.info').text(file.name);
            var $img = $li.find('img');

            var thumbnailWidth = parseInt($img.css('width'));
            var thumbnailHeight = parseInt($img.css('height'));

            // 创建缩略图
            // 如果为非图片文件，可以不用调用此方法。
            // thumbnailWidth x thumbnailHeight 为 100 x 100
            uploader.makeThumb( file, function( error, src ) {
                if ( error ) {
                    $img.replaceWith('<span>不能预览</span>');
                    return;
                }

                $img.attr( 'src', src );
            }, thumbnailWidth, thumbnailHeight );
        });
    });

</script>
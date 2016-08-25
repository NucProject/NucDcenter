{extends 'common/common-box.tpl'}

{block name=title}添加自动站{/block}
{block name=content}
    <h3 class="form-title">请填写自动站信息</h3>
    <form role="form">
        <div class="form-group">
            <label for="exampleInputEmail1">自动站名称</label>
            <input type="text" class="form-control" id="stationName" placeholder="请填写自动站名称">
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">自动站介绍</label>
            <textarea type="text" class="form-control" id="stationName" placeholder="请填写自动站介绍"></textarea>
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">是否是固定的自动站</label>
            <div class="checkbox">
                <label>
                    <input type="checkbox">固定的自动站
                </label>
            </div>
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">自动站图片</label>
            <!--dom结构部分-->
            <div id="uploader-demo">
                <!--用来存放item-->
                <div id="fileList" class="uploader-list"></div>
                <div id="filePicker">选择图片</div>
            </div>
        </div>

        <a type='submit' class="btn btn-info">添加</a>
    </form>
{/block}
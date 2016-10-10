{extends 'common/common-box.tpl'}

{block name=title}新建任务{/block}

{block name=content}
    <h3 class="form-title">请填写任务信息</h3>
    <form id="createTaskForm" action="index.php?r=task/do-create" method="post">

        <input type="hidden" name="csrfToken" value="{Yii::$app->request->getCsrfToken(true)}" />

        <div class="form-group">
            <label for="exampleInputEmail1">任务名称</label>
            <input type="text" class="form-control" name="taskName" placeholder="请填写任务名称">
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">任务秒数</label>
            <textarea type="text" class="form-control" name="taskDesc" placeholder="请填写任务描述"></textarea>
        </div>


        <div class="form-group clearfix">
            <label class="control-label pull-left" style="margin-top: 8px">
                预计开始时间:
            </label>
            <div class="col-md-2 pull-left">
                <input class="form-control" type="text" name="begin_time" size="10" id="begin_time">
            </div>
            <label class="control-label pull-left" style="margin-top: 8px">
                预计结束时间:
            </label>
            <div class="col-md-2  pull-left">
                <input class="form-control" type="text" name="end_time" size="10" id="end_time">
            </div>
        </div>

        <input type="hidden" name="taskImage">
        <input type="hidden" name="map_zoom">
        <input type="hidden" name="lng">
        <input type="hidden" name="lat">

        <div class="form-group" id="gps-info">
            <label for="exampleInputEmail1">选择任务区域</label>
            <div class="checkbox">
                <label>
                    <input type="text" class="form-control" name="city" placeholder="请试着输入城市名称">
                    <!--
                    暂时不支持
                    <br>
                    <input type="text" class="form-control" name="lngAndLat" placeholder="或提供经、纬度（逗号分隔）">
                    -->

                </label>
            </div>
        </div>

        <!-- 任务位置地图 -->
        <div id="map" style="width: 400px; height: 300px; margin-left: 50px;margin-bottom: 20px">
        </div>

        <a href="javascript:createTaskConfirm();" class="btn btn-info add">添加</a>
    </form>
{/block}
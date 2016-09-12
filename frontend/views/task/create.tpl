{extends 'common/common-box.tpl'}

{block name=title}新建任务{/block}

{block name=content}
    <h3 class="form-title">请填写自动站信息</h3>
    <form id="add-station-form" action="index.php?r=task/do-create" method="post">

        <input type="hidden" name="csrfToken" value="{Yii::$app->request->getCsrfToken(true)}" />

        <div class="form-group">
            <label for="exampleInputEmail1">任务名称</label>
            <input type="text" class="form-control" name="stationName" placeholder="请填写任务名称">
        </div>


        <div class="form-group clearfix">
            <label class="control-label pull-left" style="margin-top: 8px">
                开始时间:
            </label>
            <div class="col-md-2 pull-left">
                <input class="form-control" type="text" name="begin_time" size="10" id="begin_time">
            </div>
            <label class="control-label pull-left" style="margin-top: 8px">
                结束时间:
            </label>
            <div class="col-md-2  pull-left">
                <input class="form-control" type="text" name="end_time" size="10" id="end_time">
            </div>
        </div>

        <div class="form-group" id="gps-info">
            <label for="exampleInputEmail1">GPS信息</label>
            <div class="checkbox">
                <label>
                    <input type="text" class="form-control" name="lng" placeholder="请提供经度">
                    <input type="text" class="form-control" name="lat" placeholder="请提供纬度">
                </label>
            </div>
        </div>



        <hr>
        <!-- 其他信息 -->
        <div class="form-group">
            <label for="exampleInputEmail1">业主单位</label>
            <input type="text" class="form-control" name="ownerOrg" placeholder="请填写业主单位">
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">负责人员</label>
            <input type="text" class="form-control" name="ownerLead" placeholder="请填写负责人员姓名">
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">建成日期</label>
            <input type="text" class="form-control" name="completionDate" placeholder="请填写建成日期">
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">建设单位</label>
            <input type="text" class="form-control" name="builderOrg" placeholder="请填写建设单位">
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">运维单位</label>
            <input type="text" class="form-control" name="opsOrg" placeholder="请填写运维单位">
        </div>

        <a type='submit' class="btn btn-info add">添加</a>
    </form>
{/block}
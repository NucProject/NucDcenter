<div class="col-md-4 box-container">
    <!-- BOX WITH SMALL HEADER-->
    <div class="box border purple">
        <div class="box-title small">
            <h4><i class="fa fa-rocket"></i>{block name=title}{/block}</h4>
            <div class="tools">
                <a href="#box-config" data-toggle="modal" class="config">
                    <i class="fa fa-cog"></i>
                </a>
                <a href="javascript:;" class="reload">
                    <i class="fa fa-refresh"></i>
                </a>
                <a href="javascript:;" class="collapse">
                    <i class="fa fa-chevron-down"></i>
                </a>
                <a href="javascript:;" class="remove">
                    <i class="fa fa-times"></i>
                </a>
            </div>
        </div>
        <div class="box-body">
            {block name=content}{/block}
        </div>
    </div>
    <!-- /BOX WITH SMALL HEADER-->
</div>
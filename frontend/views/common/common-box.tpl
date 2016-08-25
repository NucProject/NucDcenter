<div class="box border orange">
    <div class="box-title">
        <h4><i class="fa fa-bars"></i>{block name=title}{/block}</h4>
        <div class="tools hidden-xs">
            <a href="#box-config" data-toggle="modal" class="config">
                <i class="fa fa-cog"></i>
            </a>
            <a href="javascript:;" class="reload">
                <i class="fa fa-refresh"></i>
            </a>
            <a href="javascript:;" class="collapse">
                <i class="fa fa-chevron-up"></i>
            </a>
            <a href="javascript:;" class="remove">
                <i class="fa fa-times"></i>
            </a>
        </div>
    </div>
    <div class="box-body big">
        {block name=content}{/block}
    </div>
</div>
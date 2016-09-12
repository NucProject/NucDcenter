<div class="box {block name=style}border blue{/block}">
    <div class="box-title small">
        <h4><i class="fa fa-rocket"></i>{block name=title}{/block}</h4>
        <div class="tools">
            {if isset($has_config)}
            <a href="#box-config" data-toggle="modal" class="config">
                <i class="fa fa-cog"></i>
            </a>
            {/if}

            {if isset($has_reload)}
            <a href="javascript:;" class="reload">
                <i class="fa fa-refresh"></i>
            </a>
            {/if}

            {if isset($has_collapse)}
            <a href="javascript:;" class="collapse">
                <i class="fa fa-chevron-down"></i>
            </a>
            {/if}

            {if isset($has_remove)}
            <a href="javascript:;" class="remove">
                <i class="fa fa-times"></i>
            </a>
            {/if}
        </div>
    </div>
    <div class="box-body">
        {block name=content}{/block}
    </div>
</div>

{* *}
{extends 'common/common-box.tpl'}
{block name=color}orange{/block}
{*  *}
{block name=title}
    <span>其他</span>
{/block}

{block name=content}
    <div>
        <a class="btn btn-info" href="index.php?r=station/add-device&stationKey={$stationKey}">导出报告</a>
        <a class="btn btn-info" href="index.php?r=station/add-device&stationKey={$stationKey}">添加新的设备</a>
    </div>
{/block}
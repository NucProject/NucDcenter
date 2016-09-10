{* *}
{extends 'common/common-box.tpl'}
{block name=color}orange{/block}
{*  *}
{block name=title}
    <span>自动站概况</span>
{/block}

{block name=content}
    <div>
        <span>
            珠海大气监测站
        </span>
        <br>
        <span>
            其他信息
        </span>
        <br>

        <a class="btn btn-info" href="index.php?r=station/add-device&stationKey={$stationKey}">导出报告</a>
        <a class="btn btn-info" href="index.php?r=station/add-device&stationKey={$stationKey}">添加新的设备</a>
    </div>
{/block}
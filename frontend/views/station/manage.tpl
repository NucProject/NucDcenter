{* *}
{extends 'common/box.tpl'}

{*  *}
{block name=title}
    <span>自动站管理</span>
{/block}

{block name=content}
    <div>
        <span></span>
        <br>

        <a class="btn btn-xs btn-info" href="index.php?r=station/add-device&stationKey={$stationKey}">添加</a>
    </div>
{/block}
{* 一个device的展示HTML *}
{extends 'common/box.tpl'}
{* summary的展现 *}
{block name=title}
    <span>{$device.type_name}</span>
{/block}

{block name=content}
    <div>
        <span>设备唯一Key: {$device.device_key}</span>
        <br>

        <a class="btn btn-xs btn-info" href="index.php?r=device/data&deviceKey={$device.device_key}">进入</a>
    </div>
{/block}
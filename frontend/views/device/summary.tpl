{* 一个device的展示HTML *}
{extends 'common/box.tpl'}
{* summary的展现 *}
{block name=title}
    <span>{$device.type_name}</span>
{/block}

{block name=content}
    <div>
        <span>设备型号: {$device.deviceType.type_name}</span>
        <br>
        <span>设备描述: {$device.deviceType.type_desc}</span>
        <br>
        <span>最新数据时间: {$device.last_data_time}</span>
        <br>
        {if $device.device_status==1}
            <span class="label label-info">已激活</span>
            {else}
            <span class="label label-default">未激活</span>
        {/if}
        <br>


        {if $device.is_movable}
            <a class="btn btn-primary" style="margin-bottom:5px; margin-top: 5px"
               href="index.php?r=device/info&deviceKey={$device.device_key}">设备详情</a>
        {else}
            <div class="btn-group dropdown" style="margin-bottom:5px; margin-top: 5px">

                <a class="btn btn-primary" href="index.php?r=device/data&deviceKey={$device.device_key}">查看数据</a>

                <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                </button>

                <ul class="dropdown-menu">
                    <li>
                        <a href="index.php?r=device/data&deviceKey={$device.device_key}">查看数据</a>
                    </li>
                    <li>
                        <a href="index.php?r=device/info&deviceKey={$device.device_key}">设备详情</a>
                    </li>
                </ul>
            </div>
        {/if}
    </div>
{/block}
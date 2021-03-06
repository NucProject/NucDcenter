{* 一个device的展示HTML *}
{extends 'common/box.tpl'}
{* summary的展现 *}
{$has_config=true}
{block name=title}
    <span>{$device.type_name}</span>
{/block}

{block name=content}
    <div deviceKey="{$device.device_key}">
        <span>设备型号: {$device.deviceType.type_name}</span>
        <br>
        <span>设备描述: {$device.device_desc}</span>
        <br>
        <span>设备序列号: {$device.device_sn}</span>
        <br>
        <span>最新数据时间: <span class="latest_time">{$device.last_data_time}</span></span>
        <br>
        {if $device.device_status==1}
            <span class="active-status label label-info">已激活</span>
            {else}
            <span class="active-status label label-default">未激活</span>
        {/if}
        <br>

        <a class="modify" href="index.php?r=device/modify&deviceKey={$device.device_key}" style="display: none"></a>

        {if $device.is_movable}
            {* 移动设备 *}
            <div class="btn-group dropdown" style="margin-bottom:5px; margin-top: 5px">

                <a class="btn btn-primary" href="index.php?r=device/info&deviceKey={$device.device_key}">设备详情</a>

                <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                </button>

                <ul class="dropdown-menu">
                    <li>
                        <a href="index.php?r=device/info&deviceKey={$device.device_key}">设备详情</a>
                    </li>

                    <li>
                        <a href="index.php?r=device/active-data&deviceKey={$device.device_key}">实时数据</a>
                    </li>

                    <li>
                        <a href="index.php?r=device/threshold&deviceKey={$device.device_key}">阈值设置</a>
                    </li>
                    <!--
                    这里貌似需要一个taskId, 但是先不给了(屏蔽)
                    <li>
                        <a href="index.php?r=device/data&deviceKey={$device.device_key}">查看数据</a>
                    </li>
                    -->
                </ul>
            </div>
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

                    <li>
                        <a href="index.php?r=device/threshold&deviceKey={$device.device_key}">阈值设置</a>
                    </li>
                </ul>
            </div>
        {/if}
    </div>
{/block}
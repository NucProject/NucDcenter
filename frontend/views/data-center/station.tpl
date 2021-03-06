{* 一个station的展示HTML *}
{extends 'common/box.tpl'}
{* 具体的细节 *}
{block name=style}border purple{/block}
{$has_config = true}
{block name=title}
    <span>{$station.station_name}</span>
{/block}

{block name=content}
    <div class="clearfix" stationKey="{$station.station_key}">
        <div class="pull-left">
            <span>名称: {$station.station_name}</span>
            <br>
            <span>描述: {$station.station_desc}</span>
            <br>
            <span style="display: none">唯一键: {$station.station_key}</span>
            <br>
            <span>创建时间: {$station.create_time}</span>
    
            <br>
            <span>{if true}<button class="btn btn-inverse btn-xs"><i class="fa fa-thumbs-up"></i> 已连接</button>{/if}</span>
    
            <br>
            <br>
            <a class="btn btn-info"
               href="index.php?r=station/index&stationKey={$station.station_key}">进入查看设备</a>
        </div>
        <div class="pull-right margin-left-50">
            <img src="{$station.station_pic}" style="width: 200px;height: 160px" alt="未提供图片">
        </div>
    </div>
{/block}
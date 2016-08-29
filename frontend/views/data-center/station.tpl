{* 一个station的展示HTML *}
{extends 'common/box.tpl'}
{* 具体的细节 *}
{block name=title}
    <span>{$station.station_name}</span>
{/block}

{block name=content}
    <div>
        <span>名称: {$station.station_name}</span>
        <br>
        <span>描述: {$station.station_desc}</span>
        <br>
        <span>唯一键: {$station.station_key}</span>
        <br>
        <span>创建时间: {$station.create_time}</span>
        <br>
        <a class="btn btn-xs btn-info"
           href="index.php?r=station/index&stationKey={$station.station_key}">进入</a>
    </div>
{/block}
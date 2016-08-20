{* 项目主布局文件 *}

<div>
    header
</div>

<div>
    {$content}
    {json_encode(StationService::getStations())}
    
</div>

<div>
    footer
</div>
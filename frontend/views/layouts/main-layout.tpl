{* 项目主布局文件 *}
{$this->beginPage()}
<!DOCTYPE html>
<html lang="{Yii::$app->language}">
{$this->beginBody()}
<div>
    header
</div>

<div>
    {$content}

    {*{include file=$ddd}*}
</div>

<div>
    footer
</div>
{$this->endBody()}
{include $currentPageJsFile}
</html>
{$this->endPage()}
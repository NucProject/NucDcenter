{* 项目主布局文件 *}
{$this->beginPage()}
<!DOCTYPE html>
<html lang="{Yii::$app->language}">
{$this->beginBody()}
<header>
    <title>{$pageTitle}</title>
</header>
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
{include 'layouts/common.js.tpl'}
{$this->endBody()}
{include $currentPageJsFile}
</html>
{$this->endPage()}
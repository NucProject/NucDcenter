{* 添加一个新的station的入口 *}
{extends 'common/box.tpl'}
{* 具体的细节 *}
{block name=color}{/block}

{block name=title}
    <span>添加新的自动站...</span>
{/block}

{block name=content}
    <div>
        <a class="btn btn-info"
           href="index.php?r=data-center/add-station">添加</a>
    </div>
{/block}
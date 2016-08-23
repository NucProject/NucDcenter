{* 一个station的展示HTML *}
{extends 'common/box.tpl'}
{* 具体的细节 *}
{block name=title}
    <span>{$name}</span>
{/block}

{block name=content}
    <div>{$name} %</div>
{/block}
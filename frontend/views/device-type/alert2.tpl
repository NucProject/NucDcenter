{* 一个阈值的 *}
{extends 'common/box.tpl'}

{block name=style}orange margin-top-50{/block}

{block name=title}{$fieldDisplayName} -- 一级阈值设置{/block}

{block name=content}
    <div class="form-group">
        <label><input type="checkbox" name="{$name}[threshold1_set]" {if $s1}checked{/if}/>&nbsp;启用</label>
        <label for="exampleInputEmail1">一级报警阈值 ({$fieldUnit})</label>

        <input class="form-control" name="{$name}[threshold1]" value="{$v1}"
               placeholder="请填写一级报警阈值">
    </div>
{/block}
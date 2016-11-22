{* 二个值区间的 *}
{extends 'common/box.tpl'}

{block name=style}orange margin-top-50{/block}

{block name=title}{$fieldDisplayName} -- 区间值设置{/block}

{block name=content}
    <div class="form-group">
        <label><input type="checkbox" name="{$name}[threshold1_set]" {if $s1}checked{/if}/>&nbsp;启用</label>
        <label for="exampleInputEmail1">请填写区间最小值 ({$fieldUnit})</label>

        <input class="form-control" name="{$name}[threshold1]" value="{$v1}"
               placeholder="请填写区间最小值">
    </div>

    <div class="form-group">
        <label><input type="checkbox" name="{$name}[threshold2_set]" {if $s2}checked{/if}/>&nbsp;启用</label>
        <label for="exampleInputEmail1">请填写区间最大值 ({$fieldUnit})</label>

        <input class="form-control" name="{$name}[threshold2]" value="{$v2}"
               placeholder="请填写区间最大值">
    </div>
{/block}

<script>

</script>
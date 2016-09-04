<div class="dataTables_paginate paging_bs_full">
    <ul id='pagination' class="pagination" form-id="#{$form}">
        <li class=""><a tabindex="0" class="paginate_button previous">上一页</a></li>
        {foreach from=$pagers item=p}
            {if $p.type == 'pager'}
                <li {if $p.active}class="active"{/if}><a tabindex="0">{$p.title}</a></li>
            {else}
                <li><a style="padding: 3px"><input id='randomPage' style="width: 50px"/></a></li>
            {/if}

        {/foreach}

        <li class="disabled"><a tabindex="0" class="paginate_button next">下一页</a></li>
    </ul>
</div>
<script>
    function initPager() {

        var pagination = $('#pagination');

        pagination.delegate('input', 'keyup', function(e) {
            if (e.keyCode == 13) {
                // TODO:
            }
        });

        pagination.delegate('li a', 'click', function() {
            var formId = pagination.attr('form-id');
            var page = $(this).text();
            $(formId).find('input[name=__page]').val(page);
            $(formId).submit();
        });
    }
</script>
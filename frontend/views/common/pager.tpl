<div class="dataTables_paginate paging_bs_full">
    <ul id='pagination' class="pagination" form-id="#{$form}" current="{$pager.current}">
        <li {if 1==$pager.current}class="disabled"{/if}><a tabindex="0" data="prev" class="paginate_button previous">上一页</a></li>
        {foreach from=$pager.items item=p}
            {if $p.type == 'pager'}
                <li {if $p.active}class="active"{/if}><a tabindex="0" data="{$p.title}">{$p.title}</a></li>
            {else}
                <li><a style="padding: 3px"><input id='randomPage' style="width: 50px"/></a></li>
            {/if}

        {/foreach}

        <li {if $pager.count==$pager.current}class="disabled"{/if}><a tabindex="0" data="next" class="paginate_button next">下一页</a></li>
    </ul>
</div>
<script>

    function goPage(page) {
        var pagination = $('#pagination');
        var formId = pagination.attr('form-id');
        $(formId).find('input[name=__page]').val(page);
        $(formId).submit();
    }

    function initPager() {

        var pagination = $('#pagination');

        pagination.delegate('input', 'keyup', function(e) {
            if (e.keyCode == 13) {
                var page = $(this).val();
                goPage(page);
            }
        });

        pagination.delegate('li a', 'click', function() {
            var current = parseInt(pagination.attr('current'));
            var page = $(this).attr('data');
            if (page == 'prev') {
                page = current - 1;
            } else if (page == 'next') {
                page = current + 1;
            }
            goPage(page);
        });
    }
</script>
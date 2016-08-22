<!-- SIDEBAR -->
<div id="sidebar" class="sidebar">
    <div class="sidebar-menu nav-collapse">
        <div class="divide-20"></div>
        <!-- SEARCH BAR -->
        <div id="search-bar">
            <input class="search" type="text" placeholder="Search"><i class="fa fa-search search-icon"></i>
        </div>
        <!-- /SEARCH BAR -->

        <!-- SIDEBAR QUICK-LAUNCH -->
        <!-- <div id="quicklaunch">
        <!-- /SIDEBAR QUICK-LAUNCH -->

        <!-- SIDEBAR MENU -->
        <ul>
            {foreach from=$sidebarMenus item=m}
                <li {if isset($m.subMenus)}class="has-sub"{/if}>
                    <a href="{$m.href}" class="">
                        <i class="fa fa-tachometer fa-fw"></i>
                        <span class="menu-text">{$m.title}
                            {if isset($m.badge)}
                                <span class="badge pull-right">{$m.badge}</span>
                            {/if}
                            </span>
                        <span class="
                            {if $m.selected}selected{/if}
                            {if isset($m.subMenus) && count($m.subMenus) > 0}arrow{/if}">
                        </span>
                    </a>
                    {* If has sub-menus *}
                    {if isset($m.subMenus)}
                        <ul class="sub">
                            {foreach from=$m.subMenus item=s}
                                <li>
                                    <a class="" href="{$s.href}">
                                        <span class="sub-menu-text">{$s.title}</span>
                                    </a>
                                </li>
                            {/foreach}
                        </ul>
                    {/if}
                </li>
            {/foreach}

        </ul>
        <!-- /SIDEBAR MENU -->
    </div>
</div>
<!-- /SIDEBAR -->

{* 项目主布局文件 *}
<!DOCTYPE html>
{$this->beginPage()}

<html lang="{Yii::$app->language}">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
<title>{$pageTitle}</title>
{* 字体变得漂亮了! *}
<link href="css/fonts.css" rel="stylesheet">
{*<link href="http://fonts.useso.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" type="text/css">*}

{$this->head()}
{$this->beginBody()}
{* CloudAdmin Header *}
{include 'layouts/header.tpl'}
<section id="page">
    {include 'layouts/sidebar.tpl'}

    <div id="main-content">
        <div class="container">
            <div class="row">
                <div id="content" class="col-lg-12">
                    <!-- PAGE HEADER-->
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="page-header">
                                <!-- STYLER -->

                                <!-- /STYLER -->
                                <!-- BREADCRUMBS -->
                                <ul class="breadcrumb">
                                    {foreach from=$breadcrumbs item=b}
                                        <li>
                                            {if $b.home}
                                            <i class="fa fa-home"></i>
                                            {/if}
                                            <a href="{$b.href}">{$b.title}</a>
                                        </li>
                                    {/foreach}
                                </ul>
                                <!-- /BREADCRUMBS -->

                                {if isset($pageMessage)}
                                <div class="clearfix">
                                    <h3 class="content-title pull-left">{$pageMessage}</h3>
                                </div>
                                    {if isset($pageMessage2)}
                                    <div class="description">{$pageMessage2}</div>
                                    {/if}
                                {/if}
                            </div>
                        </div>
                    </div>
                    <!-- /PAGE HEADER -->

                    {* content *}
                    {$viewContent}

                </div>
            </div>
        </div>
    </div>

</section>

{include 'layouts/common.js.tpl'}
{$this->endBody()}
{include $currentPageJsFile}
<script>
    jQuery(document).ready(function() {
        //Set current page with mini-sidebar
        App.setPage("mini_sidebar");

        App.init(); //Initialise plugins and elements
    });
</script>
</html>
{$this->endPage()}
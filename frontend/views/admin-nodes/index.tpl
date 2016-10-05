<div class="span12">
    <div>
        <table class="modules table table-striped table-bordered table-hover table-full-width dataTable">
            <thead>
            <td><b>模块</b></td>
            <td><b>网址</b></td>
            </thead>
            {foreach from=$controllers key=controller item=actions}
            <tr>
                <td>
                    {$controller}
                </td>

                <td style="padding:0px">
                    <table class="actions table table-striped table-bordered table-hover table-full-width dataTable"
                           style="margin: 0px;border: 0px">
                        {foreach from=$actions item=a}
                        <tr node_id="{$a['node_id']}"
                            controller="{$controller}"
                            action="{$a['action']}"
                            {foreach from=$a['params'] item=p key=i}
                                param{$i}='{$p.name}' value{$i}=''
                            {/foreach}
                            >

                            <td width="350px">

                                <a class="action" href="javascript:void(0)" {if $a['brand_new']}style="color:orange"{/if}>
                                    {$controller}/{$a['action']}{foreach from=$a['params'] item=p}&{$p.name}={/foreach}
                                </a>
                                {* params value setting dialog content *}
                                <div class="params display-none">
                                    <table class="table">
                                        {foreach from=$a['params'] item=p}
                                            <tr style="height: 45px">
                                                <td>{$p.name}:</td><td><input class="form-control"></td>
                                            </tr>
                                        {/foreach}
                                    </table>
                                </div>

                            </td>
                            <td class="name">
                                <input value="{$a['name']}" default="{$a['comment']}" placeholder="页面名称">
                                {if count($a['params']) > 0}
                                <a class="copy" href="javascript:void(0)">复制</a>
                                <a class="setParam" href="javascript:void(0)">配置参数</a>
                                {/if}
                            </td>
                            <td width="320px">
                                <span>{$a['comment']}</span>
                            </td>
                        </tr>
                        {/foreach}
                    </table>
                </td>
            </tr>
            {/foreach}
        </table>
    </div>

    <div class="btn-group">
        <a href="" class="btn btn-info"><i class="fa fa-refresh"></i>&nbsp;&nbsp;<span>重新加载</span></a>
        <a href="javascript:updateAdminNodesConfirm();" class="btn btn-danger">更新</a>
    </div>

</div>

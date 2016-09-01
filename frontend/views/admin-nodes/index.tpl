<div class="span12">
    <div>
        <table class="table table-striped table-bordered table-hover table-full-width dataTable">
            <thead>
            <td><b>Controller</b></td>
            <td><b>Action</b></td>
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
                        <tr node_id="{$a['node_id']}">
                            <td title="{$controller}/{$a['action']}"
                                controller="{$controller}"
                                action="{$a['action']}}"
                                width="200px">
                            <span {if $a['brand_new']}style="color:green"{/if}>
                                {$a['action']}
                            </span>

                            </td>
                            <td>
                                <input value="{$a['name']}">
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
        <a href="javascript:updateAdminNodes();" class="btn btn-danger">更新</a>
    </div>

</div>

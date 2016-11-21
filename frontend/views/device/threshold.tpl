<form action="index.php?r=device/set-threshold&deviceKey={$deviceKey}" method="post">
    {foreach from=$settings item=s}
        {if $s.alert_flag == 1}
            {include 'device-type/alert1.tpl' fieldDisplayName=$s.fieldDisplayName
                fieldUnit='' v1=$s.threshold1 name=$s.field_name }
        {elseif $s.alert_flag == 2}
            {include 'device-type/alert2.tpl' fieldDisplayName=$s.fieldDisplayName
                fieldUnit=$s.field.field_unit v1=$s.threshold1 name=$s.field_name}
        {elseif $s.alert_flag == 3}
            {include 'device-type/alert3.tpl' fieldDisplayName=$s.fieldDisplayName
                fieldUnit=$s.field.field_unit name=$s.field_name
                v1=$s.threshold1 s1=$s.threshold1_set
                v2=$s.threshold2 s2=$s.threshold2_set
            }
        {elseif $s.alert_flag == 4}
            {include 'device-type/alert4.tpl' fieldDisplayName=$s.fieldDisplayName
                fieldUnit=$s.field.field_unit name=$s.field_name
                v1=$s.threshold1
                v2=$s.threshold2}
        {/if}
    {/foreach}

    <input type="hidden" name="csrfToken" value="{Yii::$app->request->getCsrfToken(true)}" />

    <a class="btn btn-grey">放弃</a>
    &nbsp;
    <input class="btn btn-info" type="submit"/>
</form>
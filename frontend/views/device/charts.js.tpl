<script>
    var chartTitle = '{$chartTitle}';
    var chartVerticalLineTitle = '值';
    {if isset($chartVerticalLineTitle)}
    chartVerticalLineTitle = '{$chartVerticalLineTitle}';
    {/if}

    // 处理报警阈值
    var alertValues = [];
    {if isset($alertSettings)}
    var alertValues = '{$alertSettings}'.toJson();
    {/if}

    console.log(alertValues);

    var pieces = [];
    for (var i in alertValues)
    {
        var v = alertValues[i];
        if ('{$displayFieldName}' == v['field_name'])
        {
            var alertFlag = v['alert_flag'];
            if (alertFlag == 1)
            {
                // 这种情况应该是不需要曲线的才对
            }
            else if (alertFlag == 2)
            {
                // 一级报警
                pieces =  [{
                    gt: parseFloat(v['threshold1']),
                    color: '#EE0000'
                }, {
                    lte: parseFloat(v['threshold1']),
                    color: '#00EE00'
                }];
            }
            else if (alertFlag == 3)
            {
                // 二级报警
                pieces =  [{
                    gt: parseFloat(v['threshold2']),
                    color: '#EE0000'
                }, {
                    gt: parseFloat(v['threshold1']),
                    lte: parseFloat(v['threshold2']),
                    color: '#EE8000'
                }, {
                    lte: parseFloat(v['threshold1']),
                    color: '#00EE00'
                }];
            }
            else if (alertFlag == 4)
            {
                // 区间报警
            }
        }
    }

    var data = '{$itemPoints}'.toJson();

    if (data.length > 0) {
        startValue = data[0][0];

        var everyIsNull = true;
        // 如果每一个元素都是null值，则渲染阈值渐变条会出错!
        for (var i in data) {
            if (data[i][1] != null) {
                everyIsNull = false;
                break;
            }
        }

        var min = parseFloat("{$minVal}");
        var max = parseFloat("{$maxVal}");

        if (everyIsNull) {
            data[0][1] = min;
        }

    } else {
        data = [['2016-12-01', 0]];
        startValue = 0; min = 0; max = 0;
    }

    var diff = (max - min) / 3.0;
    var yMin = parseFloat((min - diff).toFixed(2));
    var yMax = parseFloat((max + diff).toFixed(2));

    // VisualMap 控制(阈值显示Bar)
    if (pieces.length == 0) {
        visualMap = null;
    } else {
        visualMap = {
            top: 10,
            right: 10,
            pieces: pieces,
            outOfRange: {
                color: '#FFFFFF'
            }
        };
    }

    console.log(startValue, min, max, yMin, yMax);
</script>
{literal}
<script>
    $(function () {
        var dataChart = echarts.init(document.getElementById('dataChartId'));

        var option = {
            title: {
                text: chartTitle
            },
            tooltip: {
                trigger: 'axis'
            },
            xAxis: {
                data: data.map(function (item) {
                    return item[0];
                })
            },
            yAxis: {
                splitLine: {
                    show: false
                },
                min: yMin, // 纵轴的最小值控制
                max: yMax
            },
            toolbox: {
                left: 'center',
                feature: {
                    dataZoom: {
                        yAxisIndex: 'none'
                    },
                    restore: {},
                    saveAsImage: {}
                }
            },
            dataZoom: [{
                startValue: startValue
            }, {
                type: 'inside'
            }],
            visualMap: visualMap,
            series: {
                name: chartVerticalLineTitle,
                type: 'line',
                data: data.map(function (item) {
                    return item[1];
                }),
                markLine: {
                    silent: true,
                    data: [{ yAxis: min / 2 }, { yAxis: max }]
/*                    || [{
                        yAxis: 50
                    }, {
                        yAxis: 100
                    }, {
                        yAxis: 150
                    }, {
                        yAxis: 200
                    }, {
                        yAxis: 300
                    }]*/
                }
            }
        };

        dataChart.setOption(option);

    });


</script>
{/literal}
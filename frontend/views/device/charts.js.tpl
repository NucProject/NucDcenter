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

    /*
    console.log(pieces)
    pieces = [{
        gt: 150,
        lte: 200,
        color: '#cc0033'
    }, {
        gt: 200,
        lte: 300,
        color: '#660099'
    }
    ];
    */
    console.log(pieces)

    var data = '{$itemPoints}'.toJson();
    if (data.length > 0) {
        var startValue = data[0][0];
        var min = parseFloat("{$minVal}");
        var max = parseFloat("{$maxVal}");
    } else {
        // data = [['1970-01-01', 1]];
        var startValue = '1970-01-01';
    }
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
                min: min - 20, // 纵轴的最小值控制
                max: max + 20
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
            visualMap: {
                top: 10,
                right: 10,
                pieces: pieces /*|| [{
                    gt: 150,
                    lte: 200,
                    color: '#cc0033'
                }, {
                    gt: 200,
                    lte: 300,
                    color: '#660099'
                }
                ]*/,
                outOfRange: {
                    color: '#999'
                }
            },
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
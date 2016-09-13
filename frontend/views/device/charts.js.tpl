<script>
    var chartTitle = '{$chartTitle}';
    var chartVerticalLineTitle = '值';
    {if isset($chartVerticalLineTitle)}
    chartVerticalLineTitle = '{$chartVerticalLineTitle}';
    {/if}

    var jsonItemPoints = '{$itemPoints}';
    if (jsonItemPoints.length > 0) {
        var data = '{$itemPoints}'.toJson();
        var startValue = data[0][0];
        var min = parseFloat("{$minVal}");
        var max = parseFloat("{$maxVal}");
    } else {
        var data = [['1999-09-01', 0]];
        var startValue = '2016-09-01';
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
                pieces: [{
                    gt: 150,
                    lte: 200,
                    color: '#cc0033'
                }, {
                    gt: 200,
                    lte: 300,
                    color: '#660099'
                }
                ],
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
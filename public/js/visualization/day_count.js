$.get('/api/day_income').done(function (data) {
    var myChart = echarts.init(document.getElementById('day_count'), 'macarons');
    myChart.setOption({
        title: {
            text: '教练当日上课统计',
            subtext: '来自数据库',
            left: 'center'
        },
        tooltip: {
            trigger: 'item',
            formatter: '{a} <br/>{b} : {c} ({d}%)'
        },
        legend: {
            orient: 'vertical',
            left: 'left',
            data: data.data2
        },
        series: [
            {
                name: data.data3,
                type: 'pie',
                radius: '55%',
                center: ['50%', '60%'],
                data: data.data,
                emphasis: {
                    itemStyle: {
                        shadowBlur: 10,
                        shadowOffsetX: 0,
                        shadowColor: 'rgba(0, 0, 0, 0.5)'
                    }
                }
            }
        ]
    });
});

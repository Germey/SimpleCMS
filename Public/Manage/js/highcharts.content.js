// 修改默认颜色
Highcharts.setOptions({
    colors: ['#2f7ed8', '#8bbc21', '#910000', '#1aadce', '#492970', '#f28f43', '#77a1e5', '#c42525', '#a6c96a', '#0d233a']
});
Highcharts.wrap(Highcharts.Chart.prototype, 'getContainer', function(proceed) {
    proceed.call(this);
});

// 线性统计
function hightchart_line(selector, keys, s_column, h_data, height, title) {
    var keys = JSON.parse(keys);
    if (!height) height = 320;
    if (!title) title = '';
    $(selector).highcharts({
        chart: {
            height: height,
        },
        title: {
            text: title,
            x: -20 //center
        },
        xAxis: {
            categories: keys,
            tickmarkPlacement: 'on',
            tickInterval: parseInt(s_column),
        },
        yAxis: {
            title: {
                text: h_data['y_title']
            },
            min: 0,
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        legend: {
            enabled: true
        },
        credits: {
            href: '',
            text: ''
        },

        tooltip: {
            valueSuffix: ''
        },
        series: h_data['series']
    });
}


function hightchart_pie(selector, data, series_name, title) {

    if (!title) title = '';

    $(selector).highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
            text: title
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    style: {
                        width: '200px'
                    },
                    enabled: true,
                    color: '#000000',
                    connectorColor: '#000000',
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                }
            }
        },
        credits: {
            href: '',
            text: ''
        },
        series: [{
            type: 'pie',
            name: series_name,
            data: data
        }]
    });
}
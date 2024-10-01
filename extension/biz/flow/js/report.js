$(document).ready(function()
{
    $('#menu .container li').removeClass('active');
    if(config.requestType == 'GET')
    {
        $('#menu .container li a[href*=' + config.moduleVar + '\\=' + window.moduleName + '\\&' + config.methodVar + '\\=report]').parent('li').addClass('active');
    }   
    else
    {
        $('#menu .container li a[href*=' + window.moduleName + '-report]').parent('li').addClass('active');
    }   

    var colorIndex = 0;
    function nextAccentColor(idx)
    {
        if(typeof idx === 'undefined') idx = colorIndex++;
        return new $.zui.Color({h: idx * 67 % 360, s: 0.5, l: 0.55});
    }

    var percentageOption = {scaleLabel: "<%=value%>%", tooltipTemplate: "<%if (label){%><%=label%>: <%}%><%= value %>%",  multiTooltipTemplate: "<%if (datasetLabel){%><%=datasetLabel%>: <%}%><%= value %>%"};

    $('.text-top').each(function()
    {
        var options   = {};
        var $canvas   = $(this).find('canvas');
        var canvasId  = $canvas.attr('id');
        var type      = $canvas.data('type');
        var legend    = $canvas.data('legend');
        var chartData = window.chartData[canvasId];

        if($canvas.data('displaytype') == 'percent') options = percentageOption;

        options["responsive"] = true;
        if(type == 'pie')
        {
            for(var data of chartData)
            {
                (function(data) {
                    data.color = nextAccentColor().toCssStr();
                })(data);
            }

            options["scaleShowLabels"] = true;
            options["animation"]       = false;

            var pieChart = $("#" + canvasId).pieChart(chartData, options);
            $(this).find('.legend').append(pieChart.generateLegend());

            var maxHeight = $(this).height();
            var css       = {'max-height': maxHeight};
            $(this).find('.legend ul').css('max-height', maxHeight - 10);
            if(maxHeight <= $(this).find('.legend ul').height() + 10) $(this).find('.legend ul').addClass('scrollbar-hover').css('overflow-y', 'scroll');
            $('.legend .pie-legend li').each(function()
            {
                $(this).attr('title', $(this).text()); 
            });
        }
        else
        {
            if(chartData.datasets === undefined) return true;

            for(var dataset of chartData.datasets)
            {
                (function(dataset) {
                    dataset.color = nextAccentColor().toCssStr();
                })(dataset);
            }

            var chart = {};
            if(type == 'line') chart = $("#" + canvasId).lineChart(chartData, options);
            if(type == 'bar')
            {
                options["barValueSpacing"] = 20;
                chart = $("#" + canvasId).barChart(chartData, options);
            }

            if(legend) $(this).find('.legend').append(chart.generateLegend());
        }
    });
});

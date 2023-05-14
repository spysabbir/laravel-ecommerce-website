$(function() {
    "use strict";
    MorrisArea();

    // progress bars
    $('.progress .progress-bar').progressbar({
            display_text: 'none'
    });

    $('.sparkbar').sparkline('html', { type: 'bar' });

    $('.sparkline-pie').sparkline('html', {
        type: 'pie',
        offset: 90,
        width: '100px',
        height: '100px',
        sliceColors: ['#29bd73', '#ffaf1d', '#0e9be2']
    })


// Customer Overview
function MorrisArea() {
    Morris.Area({
        element: 'Sales_Overview',
        data: [{
                period: '2012',
                SiteA: 0,
                SiteB: 10,

            }, {
                period: '2013',
                SiteA: 106,
                SiteB: 71,

            }, {
                period: '2014',
                SiteA: 68,
                SiteB: 41,

            }, {
                period: '2015',
                SiteA: 89,
                SiteB: 285,

            }, {
                period: '2016',
                SiteA: 185,
                SiteB: 104,

            }, {
                period: '2017',
                SiteA: 146,
                SiteB: 102  ,

            }
        ],
        xkey: 'period',
        ykeys: ['SiteA', 'SiteB'],
        labels: ['Site A', 'Site B'],
        pointSize: 2,
        fillOpacity: 0.9,
        pointStrokeColors: ['#ffaf1d', '#0e9be2'],
        behaveLikeLine: true,
        gridLineColor: '#252a31',
        lineWidth: 1,
        smooth: true,
        hideHover: 'auto',
        lineColors: ['#ffaf1d', '#0e9be2'],
        resize: true

    });
}



});


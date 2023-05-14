window.hexabit= {
    colors: {
        'blue': '#467fcf',
        'blue-darkest': '#0e1929',
        'blue-darker': '#1c3353',
        'blue-dark': '#3866a6',
        'blue-light': '#7ea5dd',
        'blue-lighter': '#c8d9f1',
        'blue-lightest': '#edf2fa',
        'azure': '#45aaf2',
        'azure-darkest': '#0e2230',
        'azure-darker': '#1c4461',
        'azure-dark': '#3788c2',
        'azure-light': '#7dc4f6',
        'azure-lighter': '#c7e6fb',
        'azure-lightest': '#ecf7fe',
        'indigo': '#6574cd',
        'indigo-darkest': '#141729',
        'indigo-darker': '#282e52',
        'indigo-dark': '#515da4',
        'indigo-light': '#939edc',
        'indigo-lighter': '#d1d5f0',
        'indigo-lightest': '#f0f1fa',
        'purple': '#a55eea',
        'purple-darkest': '#21132f',
        'purple-darker': '#42265e',
        'purple-dark': '#844bbb',
        'purple-light': '#c08ef0',
        'purple-lighter': '#e4cff9',
        'purple-lightest': '#f6effd',
        'pink': '#f66d9b',
        'pink-darkest': '#31161f',
        'pink-darker': '#622c3e',
        'pink-dark': '#c5577c',
        'pink-light': '#f999b9',
        'pink-lighter': '#fcd3e1',
        'pink-lightest': '#fef0f5',
        'red': '#e74c3c',
        'red-darkest': '#2e0f0c',
        'red-darker': '#5c1e18',
        'red-dark': '#b93d30',
        'red-light': '#ee8277',
        'red-lighter': '#f8c9c5',
        'red-lightest': '#fdedec',
        'orange': '#fd9644',
        'orange-darkest': '#331e0e',
        'orange-darker': '#653c1b',
        'orange-dark': '#ca7836',
        'orange-light': '#feb67c',
        'orange-lighter': '#fee0c7',
        'orange-lightest': '#fff5ec',
        'yellow': '#f1c40f',
        'yellow-darkest': '#302703',
        'yellow-darker': '#604e06',
        'yellow-dark': '#c19d0c',
        'yellow-light': '#f5d657',
        'yellow-lighter': '#fbedb7',
        'yellow-lightest': '#fef9e7',
        'lime': '#7bd235',
        'lime-darkest': '#192a0b',
        'lime-darker': '#315415',
        'lime-dark': '#62a82a',
        'lime-light': '#a3e072',
        'lime-lighter': '#d7f2c2',
        'lime-lightest': '#f2fbeb',
        'green': '#5eba00',
        'green-darkest': '#132500',
        'green-darker': '#264a00',
        'green-dark': '#4b9500',
        'green-light': '#8ecf4d',
        'green-lighter': '#cfeab3',
        'green-lightest': '#eff8e6',
        'teal': '#2bcbba',
        'teal-darkest': '#092925',
        'teal-darker': '#11514a',
        'teal-dark': '#22a295',
        'teal-light': '#6bdbcf',
        'teal-lighter': '#bfefea',
        'teal-lightest': '#eafaf8',
        'cyan': '#17a2b8',
        'cyan-darkest': '#052025',
        'cyan-darker': '#09414a',
        'cyan-dark': '#128293',
        'cyan-light': '#5dbecd',
        'cyan-lighter': '#b9e3ea',
        'cyan-lightest': '#e8f6f8',
        'gray': '#868e96',
        'gray-darkest': '#1b1c1e',
        'gray-darker': '#36393c',
        'gray-dark': '#6b7278',
        'gray-light': '#aab0b6',
        'gray-lighter': '#dbdde0',
        'gray-lightest': '#f3f4f5',
        'gray-dark': '#343a40',
        'gray-dark-darkest': '#0a0c0d',
        'gray-dark-darker': '#15171a',
        'gray-dark-dark': '#2a2e33',
        'gray-dark-light': '#717579',
        'gray-dark-lighter': '#c2c4c6',
        'gray-dark-lightest': '#ebebec'
    }
};

$(function() {
    "use strict";
    $(document).ready(function(){
        var chart = c3.generate({
            bindto: '#chart-employment', // id of chart wrapper
            data: {
                columns: [
                    // each columns data
                    ['data1', 2, 8, 6, 7, 14, 11],
                    ['data2', 5, 15, 11, 15, 21, 25],
                    ['data3', 17, 18, 21, 20, 30, 29]
                ],
                type: 'line', // default type of chart
                colors: {
                    'data1': hexabit.colors["orange"],
                    'data2': hexabit.colors["blue"],
                    'data3': hexabit.colors["green"]
                },
                names: {
                    // name of each serie
                    'data1': 'Development',
                    'data2': 'Marketing',
                    'data3': 'Sales'
                }
            },
            axis: {
                x: {
                    type: 'category',
                    // name of each category
                    categories: ['2013', '2014', '2015', '2016', '2017', '2018']
                },
            },
            legend: {
                show: true, //hide legend
            },
            padding: {
                bottom: 0,
                top: 0
            },
        });
    });
    $(document).ready(function(){
        var chart = c3.generate({
            bindto: '#chart-temperature', // id of chart wrapper
            data: {
                columns: [
                    // each columns data
                    ['data1', 7.0, 6.9, 9.5, 14.5, 18.4, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6],
                    ['data2', 3.9, 4.2, 5.7, 8.5, 11.9, 15.2, 17.0, 16.6, 14.2, 10.3, 6.6, 4.8]
                ],
                labels: true,
                type: 'line', // default type of chart
                colors: {
                    'data1': hexabit.colors["blue"],
                    'data2': hexabit.colors["green"]
                },
                names: {
                    // name of each serie
                    'data1': 'Tokyo',
                    'data2': 'London'
                }
            },
            axis: {
                x: {
                    type: 'category',
                    // name of each category
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun']
                },
            },
            legend: {
                show: true, //hide legend
            },
            padding: {
                bottom: 0,
                top: 0
            },
        });
    });
    $(document).ready(function(){
        var chart = c3.generate({
            bindto: '#chart-area', // id of chart wrapper
            data: {
                columns: [
                    // each columns data
                    ['data1', 11, 8, 15, 18, 19, 17],
                    ['data2', 7, 7, 5, 7, 9, 12]
                ],
                type: 'area', // default type of chart
                colors: {
                    'data1': hexabit.colors["blue"],
                    'data2': hexabit.colors["pink"]
                },
                names: {
                    // name of each serie
                    'data1': 'Maximum',
                    'data2': 'Minimum'
                }
            },
            axis: {
                x: {
                    type: 'category',
                    // name of each category
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun']
                },
            },
            legend: {
                show: true, //hide legend
            },
            padding: {
                bottom: 0,
                top: 0
            },
        });
    });
    $(document).ready(function(){
        var chart = c3.generate({
            bindto: '#chart-area-spline', // id of chart wrapper
            data: {
                columns: [
                    // each columns data
                    ['data1', 11, 8, 15, 18, 19, 17],
                    ['data2', 7, 7, 5, 7, 9, 12]
                ],
                type: 'area-spline', // default type of chart
                colors: {
                    'data1': hexabit.colors["blue"],
                    'data2': hexabit.colors["pink"]
                },
                names: {
                    // name of each serie
                    'data1': 'Maximum',
                    'data2': 'Minimum'
                }
            },
            axis: {
                x: {
                    type: 'category',
                    // name of each category
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun']
                },
            },
            legend: {
                show: true, //hide legend
            },
            padding: {
                bottom: 0,
                top: 0
            },
        });
    });
    $(document).ready(function(){
        var chart = c3.generate({
            bindto: '#chart-area-spline-sracked', // id of chart wrapper
            data: {
                columns: [
                    // each columns data
                    ['data1', 11, 8, 15, 18, 19, 17],
                    ['data2', 7, 7, 5, 7, 9, 12]
                ],
                type: 'area-spline', // default type of chart
                groups: [
                    [ 'data1', 'data2']
                ],
                colors: {
                    'data1': hexabit.colors["blue"],
                    'data2': hexabit.colors["pink"]
                },
                names: {
                    // name of each serie
                    'data1': 'Maximum',
                    'data2': 'Minimum'
                }
            },
            axis: {
                x: {
                    type: 'category',
                    // name of each category
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun']
                },
            },
            legend: {
                show: true, //hide legend
            },
            padding: {
                bottom: 0,
                top: 0
            },
        });
    });
    $(document).ready(function(){
        var chart = c3.generate({
            bindto: '#chart-spline', // id of chart wrapper
            data: {
                columns: [
                    // each columns data
                    ['data1', 0.2, 0.8, 0.8, 0.8, 1, 1.3, 1.5, 2.9, 1.9, 2.6, 1.6, 3, 4, 3.6, 4.5, 4.2, 4.5, 4.5, 4, 3.1, 2.7, 4, 2.7, 2.3, 2.3, 4.1, 7.7, 7.1, 5.6, 6.1, 5.8, 8.6, 7.2, 9, 10.9, 11.5, 11.6, 11.1, 12, 12.3, 10.7, 9.4, 9.8, 9.6, 9.8, 9.5, 8.5, 7.4, 7.6],
                    ['data2', 0, 0, 0.6, 0.9, 0.8, 0.2, 0, 0, 0, 0.1, 0.6, 0.7, 0.8, 0.6, 0.2, 0, 0.1, 0.3, 0.3, 0, 0.1, 0, 0, 0, 0.2, 0.1, 0, 0.3, 0, 0.1, 0.2, 0.1, 0.3, 0.3, 0, 3.1, 3.1, 2.5, 1.5, 1.9, 2.1, 1, 2.3, 1.9, 1.2, 0.7, 1.3, 0.4, 0.3]
                ],
                labels: true,
                type: 'spline', // default type of chart
                colors: {
                    'data1': hexabit.colors["blue"],
                    'data2': hexabit.colors["green"]
                },
                names: {
                    // name of each serie
                    'data1': 'Hestavollane',
                    'data2': 'Vik'
                }
            },
            axis: {
                x: {
                    type: 'category',
                    // name of each category
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun']
                },
            },
            legend: {
                show: true, //hide legend
            },
            padding: {
                bottom: 0,
                top: 0
            },
        });
    });
    $(document).ready(function(){
        var chart = c3.generate({
            bindto: '#chart-spline-rotated', // id of chart wrapper
            data: {
                columns: [
                    // each columns data
                    ['data1', 11, 8, 15, 18, 19, 17],
                    ['data2', 7, 7, 5, 7, 9, 12]
                ],
                type: 'spline', // default type of chart
                colors: {
                    'data1': hexabit.colors["blue"],
                    'data2': hexabit.colors["pink"]
                },
                names: {
                    // name of each serie
                    'data1': 'Maximum',
                    'data2': 'Minimum'
                }
            },
            axis: {
                x: {
                    type: 'category',
                    // name of each category
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun']
                },
                rotated: true,
            },
            legend: {
                show: true, //hide legend
            },
            padding: {
                bottom: 0,
                top: 0
            },
        });
    });
    $(document).ready(function(){
        var chart = c3.generate({
            bindto: '#chart-step', // id of chart wrapper
            data: {
                columns: [
                    // each columns data
                    ['data1', 11, 8, 15, 18, 19, 17],
                    ['data2', 7, 7, 5, 7, 9, 12]
                ],
                type: 'step', // default type of chart
                colors: {
                    'data1': hexabit.colors["blue"],
                    'data2': hexabit.colors["pink"]
                },
                names: {
                    // name of each serie
                    'data1': 'Maximum',
                    'data2': 'Minimum'
                }
            },
            axis: {
                x: {
                    type: 'category',
                    // name of each category
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun']
                },
            },
            legend: {
                show: true, //hide legend
            },
            padding: {
                bottom: 0,
                top: 0
            },
        });
    });
    $(document).ready(function(){
        var chart = c3.generate({
            bindto: '#chart-area-step', // id of chart wrapper
            data: {
                columns: [
                    // each columns data
                    ['data1', 11, 8, 15, 18, 19, 17],
                    ['data2', 7, 7, 5, 7, 9, 12]
                ],
                type: 'area-step', // default type of chart
                colors: {
                    'data1': hexabit.colors["blue"],
                    'data2': hexabit.colors["pink"]
                },
                names: {
                    // name of each serie
                    'data1': 'Maximum',
                    'data2': 'Minimum'
                }
            },
            axis: {
                x: {
                    type: 'category',
                    // name of each category
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun']
                },
            },
            legend: {
                show: true, //hide legend
            },
            padding: {
                bottom: 0,
                top: 0
            },
        });
    });
    $(document).ready(function(){
        var chart = c3.generate({
            bindto: '#chart-bar', // id of chart wrapper
            data: {
                columns: [
                    // each columns data
                    ['data1', 11, 8, 15, 18, 19, 17],
                    ['data2', 7, 7, 5, 7, 9, 12]
                ],
                type: 'bar', // default type of chart
                colors: {
                    'data1': hexabit.colors["blue"],
                    'data2': hexabit.colors["pink"]
                },
                names: {
                    // name of each serie
                    'data1': 'Maximum',
                    'data2': 'Minimum'
                }
            },
            axis: {
                x: {
                    type: 'category',
                    // name of each category
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun']
                },
            },
            bar: {
                width: 16
            },
            legend: {
                show: true, //hide legend
            },
            padding: {
                bottom: 0,
                top: 0
            },
        });
    });
    $(document).ready(function(){
        var chart = c3.generate({
            bindto: '#chart-bar-rotated', // id of chart wrapper
            data: {
                columns: [
                    // each columns data
                    ['data1', 11, 8, 15, 18, 19, 17],
                    ['data2', 7, 7, 5, 7, 9, 12]
                ],
                type: 'bar', // default type of chart
                colors: {
                    'data1': hexabit.colors["blue"],
                    'data2': hexabit.colors["pink"]
                },
                names: {
                    // name of each serie
                    'data1': 'Maximum',
                    'data2': 'Minimum'
                }
            },
            axis: {
                x: {
                    type: 'category',
                    // name of each category
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun']
                },
                rotated: true,
            },
            bar: {
                width: 16
            },
            legend: {
                show: true, //hide legend
            },
            padding: {
                bottom: 0,
                top: 0
            },
        });
    });
    $(document).ready(function(){
        var chart = c3.generate({
            bindto: '#chart-bar-stacked', // id of chart wrapper
            data: {
                columns: [
                    // each columns data
                    ['data1', 11, 8, 15, 18, 19, 17],
                    ['data2', 7, 7, 5, 7, 9, 12]
                ],
                type: 'bar', // default type of chart
                groups: [
                    [ 'data1', 'data2']
                ],
                colors: {
                    'data1': hexabit.colors["blue"],
                    'data2': hexabit.colors["pink"]
                },
                names: {
                    // name of each serie
                    'data1': 'Maximum',
                    'data2': 'Minimum'
                }
            },
            axis: {
                x: {
                    type: 'category',
                    // name of each category
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun']
                },
            },
            bar: {
                width: 16
            },
            legend: {
                show: true, //hide legend
            },
            padding: {
                bottom: 0,
                top: 0
            },
        });
    });
    $(document).ready(function(){
        var chart = c3.generate({
            bindto: '#chart-pie', // id of chart wrapper
            data: {
                columns: [
                    // each columns data
                    ['data1', 63],
                    ['data2', 44],
                    ['data3', 12],
                    ['data4', 14]
                ],
                type: 'pie', // default type of chart
                colors: {
                    'data1': hexabit.colors["blue-darker"],
                    'data2': hexabit.colors["blue"],
                    'data3': hexabit.colors["blue-light"],
                    'data4': hexabit.colors["blue-lighter"]
                },
                names: {
                    // name of each serie
                    'data1': 'A',
                    'data2': 'B',
                    'data3': 'C',
                    'data4': 'D'
                }
            },
            axis: {
            },
            legend: {
                show: true, //hide legend
            },
            padding: {
                bottom: 0,
                top: 0
            },
        });
    });
    $(document).ready(function(){
        var chart = c3.generate({
            bindto: '#chart-donut', // id of chart wrapper
            data: {
                columns: [
                    // each columns data
                    ['data1', 63],
                    ['data2', 37]
                ],
                type: 'donut', // default type of chart
                colors: {
                    'data1': hexabit.colors["green"],
                    'data2': hexabit.colors["green-light"]
                },
                names: {
                    // name of each serie
                    'data1': 'Maximum',
                    'data2': 'Minimum'
                }
            },
            axis: {
            },
            legend: {
                show: true, //hide legend
            },
            padding: {
                bottom: 0,
                top: 0
            },
        });
    });
    $(document).ready(function(){
        var chart = c3.generate({
            bindto: '#chart-scatter', // id of chart wrapper
            data: {
                columns: [
                    // each columns data
                    ['data1', 11, 8, 15, 18, 19, 17],
                    ['data2', 7, 7, 5, 7, 9, 12]
                ],
                type: 'scatter', // default type of chart
                colors: {
                    'data1': hexabit.colors["blue"],
                    'data2': hexabit.colors["pink"]
                },
                names: {
                    // name of each serie
                    'data1': 'Maximum',
                    'data2': 'Minimum'
                }
            },
            axis: {
                x: {
                    type: 'category',
                    // name of each category
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun']
                },
            },
            legend: {
                show: true, //hide legend
            },
            padding: {
                bottom: 0,
                top: 0
            },
        });
    });
    $(document).ready(function(){
        var chart = c3.generate({
            bindto: '#chart-combination', // id of chart wrapper
            data: {
                columns: [
                    // each columns data
                    ['data1', 30, 20, 50, 40, 60, 50],
                    ['data2', 200, 130, 90, 240, 130, 220],
                    ['data3', 300, 200, 160, 400, 250, 250],
                    ['data4', 200, 130, 90, 240, 130, 220]
                ],
                type: 'bar', // default type of chart
                types: {
                    'data2': "line",
                    'data3': "spline",
                },
                groups: [
                    [ 'data1', 'data4']
                ],
                colors: {
                    'data1': hexabit.colors["green"],
                    'data2': hexabit.colors["pink"],
                    'data3': hexabit.colors["green"],
                    'data4': hexabit.colors["blue"]
                },
                names: {
                    // name of each serie
                    'data1': 'Development',
                    'data2': 'Marketing',
                    'data3': 'Sales',
                    'data4': 'Sales'
                }
            },
            axis: {
                x: {
                    type: 'category',
                    // name of each category
                    categories: ['2013', '2014', '2015', '2016', '2017', '2018']
                },
            },
            bar: {
                width: 16
            },
            legend: {
                show: true, //hide legend
            },
            padding: {
                bottom: 0,
                top: 0
            },
        });
    });
});

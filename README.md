Yii Echarts Widget
# yii-echarts
Yii1.1 Echarts百度图表小工具
======================================================

Requirements
------------

* Yii 1.1 or above
* PHP 5.4 or above


Installation
-------------

* Extract the release file under `protected/extensions/`


Usage
-----

To use this widget, you may insert the following code into a view file:
-----

### Array key support
```php
$options = [
    'title' => [
        'text' => '统计图标题',
        'textStyle' => ['color' => '#000000', 'fontSize' => '13'],
        'top' => '0'
    ],
    'tooltip' => ['show' => true, 'trigger' => 'axis'],
    'legend' => [
        'data' => ['统计A','统计B','统计C','统计D','统计E','统计F'],
        'bottom' => '0'
    ],
    'toolbox' => [
        'show' => true,
        'feature' => [
            'dataView' => ['readOnly' => false],
            'magicType' => ['type' => ['line', 'bar']],
            'restore' => [],
            'saveAsImage' => [],
        ]
    ],
    'xAxis' => [
        array(
            'name' => 'x坐标轴',
            'type' => 'category',
            'data' => ["产品A","产品B","产品C","产品D","产品E","产品F"]
        )
    ],
    'yAxis' => [
        [
            'name' => 'y坐标轴',
            'type' => 'value',
            'axisLabel' => ['formatter' => '{value}（件）']
        ]
    ],
    'series' => [
        [
            'name' => '统计A',
            'type' => 'bar',
            'data' => [10, 20, 30, 40, 50, 60]
        ],
        [
            'name' => '统计B',
            'type' => 'bar',
            'data' => [55, 12, 33, 60, 20, 75]
        ],
        [
            'name' => '统计C',
            'type' => 'bar',
            'data' => [5, 65, 25, 12, 12, 55]
        ],
        [
            'name' => '统计D',
            'type' => 'bar',
            'data' => [65, 25, 95, 5, 15, 25]
        ],
        [
            'name' => '统计E',
            'type' => 'bar',
            'data' => [15, 26, 44, 65, 65, 15]
        ],
        [
            'name' => '统计F',
            'type' => 'bar',
            'data' => [8, 95, 105, 115, 125, 135]
        ],
    ],
    'color' => ['#EEAAEE','#7CB5EC','#F7A35C', '#90EE7E', '#7798BF', '#FF0066', '#AAEEEE', '#bda29a','#6e7074', '#546570', '#c4ccd3']
];
$this->widget('ext.yii-echarts.EchartsWidget',[
    'htmlOptions' => ['style' => 'height:400px'],
    'options' => $options
]);
```

说明：具体的参数使用参照 http://echarts.baidu.com/option.html#title 配置项手册

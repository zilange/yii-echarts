<?php
/**
 * Created by PhpStorm.
 * User: kevin.ye
 * Date: 2016/10/19
 * Time: 15:53
 */
class EchartsWidget extends CWidget implements ArrayAccess
{
    protected $_baseScript = 'echarts.min';  //默认使用baidu Echarts完整的js库
    public $options = [];   //图表配置
    public $htmlOptions = [];   //div标签配置，必须配置高度如：['height' => '400px'],否则无法显示图表
    public $scripts = [];   //配置可加载的js
    public $scriptPosition = null;  //js显示位置,默认为null，可选 0:头部,1:body开始处,2:body结束处，3:添加到load函数，4：添加到ready函数

    /**
     * 渲染小部件
     */
    public function run()
    {
        if (isset($this->htmlOptions['id'])) {
            $this->id = $this->htmlOptions['id'];
        } else {
            $this->htmlOptions['id'] = $this->getId().'Echarts';
        }

        //创建div标签
        echo CHtml::openTag('div', $this->htmlOptions);
        echo CHtml::closeTag('div')."\n";

        //检测options参数是否为json数据
        if (is_string($this->options)) {
            if (!$this->options = CJSON::decode($this->options)) {
                throw new CException('The options parameter is not valid JSON.');
            }
        }

        //注册资源
        $this->registerAssets();
    }

    /**
     * 发布和注册必要的脚本文件
     */
    protected function registerAssets()
    {
        //创建echarts目录
        $basePath = Yii::app()->getAssetManager()->getBasePath(). '/echarts';
        if (!is_dir($basePath)) {
            $re = CFileHelper::createDirectory($basePath, 0777, true);
            if (!$re) {
                throw new Exception("$basePath directory creation failed");
            }
        }
        $baseUrl = Yii::app()->getAssetManager()->getBaseUrl(). '/echarts';
        Yii::app()->getAssetManager()->setBasePath($basePath);
        Yii::app()->getAssetManager()->setBaseUrl($baseUrl);
        $assetsBasePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR; //资源所在目录
        $publishUrl = Yii::app()->getAssetManager()->publish($assetsBasePath, false, 1, YII_DEBUG);

        //注册JavaScript脚本
        $assets = Yii::app()->clientScript;
        foreach ($this->scripts as $script) {
            $assets->registerScriptFile("{$publishUrl}/{$script}.js", $this->scriptPosition);
        }
        if ($this->_baseScript === 'echarts.min') {
            $assets->registerScriptFile("{$publishUrl}/{$this->_baseScript}.js", $this->scriptPosition);
        }

        //准备和注册JavaScript代码块
        $id = $this->getId();
        $options = CJavaScript::encode($this->options);
        $js = "var {$id}Dom = document.getElementById('{$id}Echarts');var {$id}MyChart = echarts.init({$id}Dom, 'null');{$id}MyChart.setOption({$options});";
        $key = __CLASS__ . '#' . $this->id;
        $assets->registerScript($key, $js, CClientScript::POS_LOAD);
    }

    /**
     * 检查一个偏移位置是否存在
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists ($offset)
    {
        return isset($this->options[$offset]);
    }

    /**
     * 设置一个偏移位置的值
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet ($offset)
    {
        if(!$this->offsetExists($offset))
            $this->options[$offset] = new self;

        return $this->options[$offset];
    }

    /**
     * 获取一个偏移位置的值
     * @param mixed $offset
     * @param mixed $value
     * @return mixed
     */
    public function offsetSet ($offset, $value)
    {
        if(is_null($offset))
            return $this->options[] = $value;
        else
            return $this->options[$offset] = $value;
    }

    /**
     * 复位一个偏移位置的值
     * @param mixed $offset
     */
    public function offsetUnset ($offset)
    {
        unset($this->options[$offset]);
    }
}
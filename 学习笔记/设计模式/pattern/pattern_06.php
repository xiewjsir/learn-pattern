<?php
/**
 * 抽象工厂模式
 * @author http://blog.samoay.me/post/view/27
 */

interface ExportFactory{
    //这里的config我们用于传入导出的一些需要的特殊配置，与默认配置进行合并
    //如果是自己的项目框架内使用，除了通过方法传入参数，还可以通过配置文件的方式
    public function create($config=array());
}


//Txt格式具体工厂
class TxtExportFactory implements ExportFactory{
    public function create($config=array()){
        return new TxtExportHelper($config);
    }
}


//Pdf格式具体工厂
class PdfExportFactory implements ExportFactory{
    public function create($config=array()){
        return new PdfExportHelper($config);
    }
}


//抽象产品
interface ExportHelper{
    /**
     * @param $source 导出数据源
     */
    public function export($source);
}


//具体Txt导出类
class TxtExportHelper implements ExportHelper{
    private $config;

    public function __construct($config = array()){
        $defaultConfig = array(
            'maxsize' => 1024*1024*5,
            'rootdir' => './export/',
            'prefix' => 'ex_',
            'coding' => 'UTF-8',
            'linechars' => 100,
        );
        $this->config = array_merge($defaultConfig, $config);
    }

    public function export($source){
        //具体导出逻辑，这里省略
    }
}

//具体Pdf导出类
class PdfExportHelper implements ExportHelper{
    private $config;

    public function __construct($config=array()){
        $defaultConfig = array(
            'maxsize' => 1024*1024*5,
            'rootdir' => './export/',
            'prefix' => 'ex_',
            'width' => 1800,
            'height' => 3200,
            'margin' => 200,
        );
        $this->config = array_merge($defaultConfig, $config);
    }

    public function export($source){
        //具体导出逻辑，这里省略
    }
}

//Client调用，假定我们有一个博客文章阅读的Controller（MVC）如下：
class NovelController{
    public function actionView($id){
        //html页面显示$id内容
    }

    public function actionVote($id){
        //给$id内容投票
    }

    public function actionExportTxt($id){
        //导出$id的内容
        $source = $this->modle->getDataByPk($id);//假定调用Model提取数据
        $factory = new TxtExportFactory();
        $this->export($factory);//txt方式完全使用默认配置
    }

    public function actionExportPdf($id){
        //导出$id的内容
        $source = $this->modle->getDataByPk($id);//假定调用Model提取数据
        $config = array(
            'width' => 1200,
            'height' => 1800,
        );
        $factory = new PdfExportFactory();
        $this->export($factory, $source, $config);
    }

    //将具体的导出处理独立
    private function export(ExportFactory $factory, $source, $config=array()){
        $exportHelper = $factory->create($config);
        $exportHelper->export($source); 
    }

    //省略更多方法
}

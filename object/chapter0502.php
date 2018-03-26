<?php
/**
 * 反射API
 */
function classData(ReflectionClass $class){
    $detail = '';
    $name = $class->getName();
    if($class->isUserDefined()){
        $detail .= "{$name} is user defined\n";
    }
    
    if($class->isInternal()){//内置类
        $detail .= "{$name} is built-int\n";
    }
    
    if($class->isInterface()){
        $detail .= "{$name} is an interface\n";
    }
    
    if($class->isAbstract()){
        $detail .= "{$name} is an abstract class\n";
    }
    
    if($class->isFinal()){
        $detail .= "{$name} is a final class\n";
    }
    
    if($class->isInstantiable()){//检测是否可得到类的实例
        $detail .= "{$name} can be instantiated\n";
    }else{
        $detail .= "{$name} can be instantiated\n";
    }
    
    return $detail;
}

function methodData(ReflectionMethod $method){
    $details = "";
    $name = $method->getName();
    if($method->isUserDefined()){
        $details .= "{$name} is user defined\n";
    }
    if($method->isInternal()){
        $details .= "{$name} is user built-in\n";
    }
    if($method->isAbstract()){
        $details .= "{$name} is abstract\n";
    }
    if($method->isPublic()){
        $details .= "{$name} is public\n";
    }
    if($method->isProtected()){
        $details .= "{$name} is protected\n";
    }
    if($method->isPrivate()){
        $details .= "{$name} is private\n";
    }
    if($method->isStatic()){
        $details .= "{$name} is static\n";
    }
    if($method->isFinal()){
        $details .= "{$name} is final\n";
    }
    if($method->isConstructor()){
        $details .= "{$name} is the constructor\n";
    }
    if($method->returnsReference()){
        $details .= "{$name} return a reference (as opposed to a value)\n";
    }
    
    return $details;
}

function argData(ReflectionParameter $arg){
    $details = "";
    $declaringclass = $arg->getDeclaringClass();
    $name = $arg->getName();
    $class = $arg->getClass();
    $position = $arg->getPosition();
    $details .= "\${$name} has position {$position}\n";
    if(!empty($class)){
        $classname = $class->getName();
        $details .= "\${$name} must be a {$classname} object \n";
    }
    
    if($arg->isPassedByReference()){
        $details .= "\${$name} is passed by reference\n";
    }
    
    if($arg->isDefaultValueAvailable()){
        $def = $arg->getDefaultValue();
        $details .= "\${$name} has default:$def \n";
    }
    
    return $details;
}

interface Product{
    public function setStock($num);
}

abstract class MediaProduct implements Product{
    public $name;
    public $price;
    public $stock_num;
    
    function __construct($name,$price = 10) {
        $this->name = $name;
        $this->price = $price;
    }
    
    public function getName(){
        echo "this product name is media product \n";
    }
    
    abstract public function getPrice($price); 
    
    public function setStock($num) {
        $this->stock_num = $num;
    }
}

class CdProduct extends MediaProduct{
    public function getName(){
        echo "this product name is {$this->name} \n";
    }
    
    public function getPrice($price){
        echo "this product name is {$this->price} \n";
    }
    
    static function desc(){
        echo "this is a test\n";
    }
}

$cdProduct = new CdProduct('bubugao',200);
$cdProduct->getName();



class ReflectionUtil{
    static function getClassSource(ReflectionClass $class){
        $path = $class->getFileName();       
        $lines = @file($path);
        $from = $class->getStartLine();
        $to = $class->getEndLine();
        $len = $to - $from+1;
        return implode(array_slice($lines,$from-1,$len));
    }
}

print ReflectionUtil::getClassSource(new ReflectionClass('CdProduct'));

echo "+++++++++++++++++++++++++++++类+++++++++++++++++++++++++++++++\n";
$prodClass = new ReflectionClass('CdProduct');
print classData($prodClass);

echo "+++++++++++++++++++++++++++++方法+++++++++++++++++++++++++++++\n";
$methods = $prodClass->getMethods();
foreach($methods as $method){
    print methodData($method);
}

echo "++++++++++++++++++++++++++++属性+++++++++++++++++++++++++++++\n";
$prodClass = new ReflectionClass('MediaProduct');
$method = $prodClass->getMethod("__construct");
$params = $method->getParameters();
foreach($params as $param){
    print argData($param);
}


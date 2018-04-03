<?php
/**
 * 工厂模式
 * @author http://blog.samoay.me/post/view/27
 * 
工厂方法（FactoryMethod）模式是类的创建模式，其用意是定义一个创建产品对象的工厂接口，将实际创建工作推迟到子类中。
工厂方法模式是简单工厂模式的进一步抽象和推广。由于使用了多态性，工厂方法模式保持了简单工厂模式的优点，而且克服了它的缺点。
在工厂方法模式中，核心的工厂类不再负责所有产品的创建，而是将具体创建工作交给子类去做。这个核心类仅仅负责给出具体工厂必须实现的接口，
而不接触哪一个产品类被实例化这种细节。这使得工厂方法模式可以允许系统在不修改工厂角色的情况下引进新产品

工厂方法模式与简单工厂模式再结构上的不同不是很明显。工厂方法类的核心是一个抽象工厂类，而简单工厂模式把核心放在一个具体类上。
工厂方法模式之所以有一个别名叫多态性工厂模式是因为具体工厂类都有共同的接口，或者有共同的抽象父类。
当系统扩展需要添加新的产品对象时，仅仅需要添加一个具体对象以及一个具体工厂对象，原有工厂对象不需要进行任何修改，也不需要修改客户端，
很好的符合了"开放－封闭"原则。而简单工厂模式在添加新产品对象后不得不修改工厂方法，扩展性不好。

工厂方法模式退化后可以演变成简单工厂模式。
 
在Factory Method模式中，工厂类与产品类往往具有平行的等级结构，它们之间一一对应。
 */

//统一的操作接口，保证对于外部调用是透明统一的
interface DbInterface{
    public function connect(Array $params=array());
    public function query($sql);
    public function insert($table, $record);
    public function update($table, $record, $where);
    public function delete($table, $where);
}

class Mysql implements DbInterface{
    //...省略具体实现
}

class SqlServer implements DbInterface{
    //...省略具体实现
}

class Sqlite implements DbInterface{
    //...省略具体实现
}

//我们具体的应用中，一般只会使用一种数据引擎，一般会根据一个全局的配置
class GlobalConfig{
    const DBENGINE = "mysql";
}

//原始的方法每次需要使用数据库的时候都使用if或者switch方法判断配置并实例化需要的数据库操作类。
//这样代码中会出现大量重复的代码，那么我们应该将相应的代码迁移到一个统一的类当中，这就是简单工厂了
class DbFactory{
    //一般为了调用便利，不需要初始化这个工具类，将方法定义为静态方法
    public static function factory(){
        if (GlobalConfig::DBENGINE=='mysql'){
            return new Mysql();
        }elseif (GlobalConfig::DBENGINE=='sqlserver'){
            return new SqlServer();
        }elseif (GlobalConfig::DBENGINE=='sqlite'){
            return new Sqlite();
        }
    }
}

//需要使用时
$db = DbFactory::factory();
$db->connect();//当然，我们可以把connect操作在类的构造方法中去实现了


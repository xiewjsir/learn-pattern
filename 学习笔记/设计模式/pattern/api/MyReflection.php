<?php
/**
 * Description of Reflection
 *
 * @author Administrator
 */
class tmp {

    public function index() {
        
    }

}

$tmp = new ReflectionClass('tmp');
Reflection::export($tmp);


/*
Reflection:为类的摘要信息提供静态函数export()
 
getModifierNames//导出一个类或方法的详细信息
export//


ReflectionFunction:函数信息和工具
 
__construct
__toString
export//导出该函数的详细信息
isDisabled
invoke//调用该函数，通过参数列表传参数
invokeArgs//调用该函数，通过数组传参数
inNamespace
isClosure
isDeprecated
isInternal//测试是否为系统内部函数
isUserDefined//测试是否为用户自定义函数
getDocComment//取得函数的注释
getEndLine//取得定义函数的结束行
getExtension
getExtensionName
getFileName//取得文件名，包括路径名
getName//取得函数名
getNamespaceName
getNumberOfParameters//取得该方法所需的参数个数
getNumberOfRequiredParameters//取得该方法所需的参数个数
getParameters//取得该方法所需的参数，返回值为对象数组
getShortName
getStartLine//取得定义函数的起始行
getStaticVariables//取得静态变量
returnsReference//测试该函数是否返回引用
 
  
  
ReflectionParameter: 方法参数信息
 
export//导出该参数的详细信息
__construct
__toString
getName//取得参数名
isPassedByReference//测试该参数是否通过引用传递参数
getDeclaringFunction
getDeclaringClass
getClass//若该参数为对象，返回该对象的类名
isArray//若该参数为对象，返回该对象的类名
allowsNull//测试该参数是否允许为空
getPosition
isOptional//测试该参数是否为可选的，当有默认参数时可选
isDefaultValueAvailable//测试该参数是否为默认参数
getDefaultValue//测试该参数是否为默认参数
 
 
 ReflectionClass：类信息和工具
 
 export//导出该类的详细信息
__construct
__toString
getName//取得类名或接口名
isInternal//测试该类是否为系统内部类
isUserDefined//测试该类是否为用户自定义类
isInstantiable//测试该类是否被实例化过
getFileName//取得定义该类的文件名，包括路径名
getStartLine//取得定义该类的开始行
getEndLine//取得定义该类的开始行
getDocComment//取得该类的注释
getConstructor//取得该类的构造函数信息
hasMethod//测试该类是否有特定的方法
getMethod//取得该类的某个特定的方法信息
getMethods//取得该类的所有的方法信息
hasProperty//测试该类是否有特定的属性
getProperty//取得某个特定的属性信息
getProperties//取得某个特定的属性信息
hasConstant//测试该类是否有特定的常量
getConstants//取得某个特定的属性信息
getConstant//取得该类特定常量信息
getInterfaces//取得该类特定常量信息
getInterfaceNames
isInterface//测试该类是否为接口
isAbstract//测试该类是否为抽象类
isFinal//测试该类是否为抽象类
getModifiers//取得该类的修饰符，返回值类型可能是个资源类型
isInstance//测试传入的对象是否为该类的一个实例
newInstance//测试传入的对象是否为该类的一个实例
newInstanceArgs
getParentClass//取得父类
isSubclassOf//测试传入的类是否为该类的父类
getStaticProperties//取得该类的所有静态属性
getStaticPropertyValue//取得该类的所有静态属性
setStaticPropertyValue//设置该类的静态属性值，若private，则不可访问，有悖封装原则
getDefaultProperties//取得该类的属性信息，不含静态属性
isIterateable
implementsInterface//测试是否实现了某个特定接口
getExtension
getExtensionName
inNamespace
getNamespaceName
getShortName
 
 
 ReflectionMethod：类方法信息和工具
 
 export//导出该方法的信息
__construct
__toString
isPublic//测试该方法是否为public
isPrivate//测试该方法是否为private
isProtected//测试该方法是否为protected
isAbstract//测试该方法是否为abstract
isFinal//测试该方法是否为final
isStatic//测试该方法是否为protected
isConstructor//测试该方法是否为构造函数
isDestructor//测试该方法是否为析构函数
getModifiers//取得该方法的修饰符
invoke//调用该方法
invokeArgs//调用该方法，传多参数
getDeclaringClass//取得该方法所属的类
getPrototype
setAccessible
inNamespace
isClosure
isDeprecated
isInternal
isUserDefined
getDocComment
getEndLine
getExtension
getExtensionName
getFileName
getName
getNamespaceName
getNumberOfParameters
getNumberOfRequiredParameters
getParameters
getShortName
getStartLine
getStaticVariables
returnsReference
 
 
 ReflectionProperty：类属性信息
 
 export//导出该属性的详细信息
__construct
__toString
getName//取得该属性名
getValue//取得该属性值
setValue//设置该属性值
isPublic//取得该属性名
isPrivate//测试该属性名是否为private
isProtected//测试该属性名是否为private
isStatic//测试该属性名是否为static
isDefault
getModifiers//取得修饰符
getDeclaringClass//取得定义该属性的类
getDocComment//取得该属性的注释
setAccessible
 
 
 ReflectionExtension:PHP扩展信息
 
 export//导出该扩展的所有信息
__construct
__toString
getName//取得该扩展的名字
getVersion//取得该扩展的名字
getFunctions//取得该扩展的所有函数
getConstants//取得该扩展的所有常量
getINIEntries//取得该扩展的所有常量
getClasses
getClassNames
getDependencies
info
 */

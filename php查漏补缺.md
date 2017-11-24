## php获取当前时间错误

   1. 修改php.ini文件，date.timezone=RPC
   2. 在程序中添加时间的初始化语句，date_default_timezone_set("Asia/Shanghai"); 

## php public、private、protected修饰词

### php的public、protected、private三种访问控制模式的区别 
* public: 公有类型

      1. 在子类中可以通过self::var调用public方法或属性,parent::method调用父类方法
　　　 2. 在实例中可以能过$obj->var 来调用public类型的方法或属性
* protected: 受保护类型

        1. 在子类中可以通过self::var调用protected方法或属性,parent::method调用父类方法
        2. 在实例中不能通过$obj->var 来调用  protected类型的方法或属性
* private: 私有类型

       该类型的属性或方法只能在该类中使用，在该类的实例、子类中、子类的实例中都不能调用私有类型的属性和方法

## self和parent的区别

  1. 在子类中常用到这两个对像。他们的主要区别在于self可以调用父类中的公有或受保护的属性，但parent不可以调用
  2. .self:: 它表示当前类的静态成员(方法和属性)　与 $this　不同,$this是指当前对像

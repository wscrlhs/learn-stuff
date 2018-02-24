# web安全
## mysql注入与防御  
SQL注入的本质是恶意攻击者将SQL代码插入或添加到程序的参数中，而程序并没有对传入的参数进行正确处理，导致参数中的数据会被当做代码来执行，并最终将执行结果返回给攻击者

### 注入方式  
>攻击者通过把恶意SQL命令插入到**Web表单的输入域**或**页面请求的查询字符串**中，来达到欺骗服务器执行恶意的SQL命令的一种攻击方式。

### 防御  
- 在表单中通过js绑定数据类型、或者过滤一些非法字符  

- 连接数据库时，使用预编译语句，绑定变量【PHP中使用mysqli、PDO进行连接使用数据库】  

- 在数据进入后台逻辑时，先对传入的参数进行验证，确保符合应用中定义的标准。主要有白名单和黑名单两种方法来实现。  

## XSS跨站脚本攻击  

跨站脚本（cross site script）为了避免与样式css混淆，所以简称为XSS。

XSS是指恶意攻击者利用网站没有对用户提交数据进行转义处理或者过滤不足的缺点，进而添加一些代码，嵌入到web页面中去。使别的用户访问都会执行相应的**嵌入代码**。

从而盗取用户资料、利用用户身份进行某种动作或者对访问者进行病毒侵害的一种攻击方式。

### xss漏洞修复-安全过滤    
- php中相应函数  
```php
strip_tags($str, [允许标签])  #从字符串中去除 HTML 和 PHP 标记

htmlentities($str)函数    #转义html实体

html_entity_decode($str)函数    #反转义html实体

addcslashes($str, '字符')函数     #给某些字符加上反斜杠

stripcslashes($str)函数          #去掉反斜杠

addslashes ($str )函数          #单引号、双引号、反斜线与 NULL加反斜杠

stripslashes($str)函数           #去掉反斜杠

htmlspecialchars()              #特殊字符转换为HTML实体

htmlspecialchars_decode()       #将特殊的 HTML 实体转换回普通字符
```
- 数据过滤  
```php
 /**
     * @desc 过滤数据
     *
     * @param $data string|array 输入数据
     * @param $low  bool      是否采用更为严格的过滤
     *
    * @return 返回过滤的数据
    */
    public function clean_xss($data, $low = False)
    {
        #字符串过滤
       if (! is_array ( $data ))
       {
           $data = trim ( $data );              #字符两边的处理
           $data = strip_tags ( $data );        #从字符串中去除 HTML 和 PHP 标记
           $data = htmlspecialchars ( $data );  #特殊字符转换为HTML实体
           if ($low)
           {
               return $data;
           }
           #匹配换空格
           $data = str_replace ( array ('"', "\\", "'", "/", "..", "../", "./", "//" ), '', $data );
           $no = '/%0[0-8bcef]/'; 
           $data = preg_replace ( $no, '', $data );
           $no = '/%1[0-9a-f]/';
           $data = preg_replace ( $no, '', $data );
           $no = '/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]+/S';
           $data = preg_replace ( $no, '', $data );
           return $data;
       }
       #数组过滤
       $arr=array();
       foreach ($data as $k => $v) 
       {
           $temp=$this->clean_xss($v);
           $arr[$k]=$temp;
       }
       return $arr;
    }
```

## csrf跨站请求伪造
　CSRF(Cross-site request forgery)是一种夹持用户在已经登陆的web应用程序上执行非本意的操作的攻击方式。相比于XSS，CSRF是利用了系统对页面浏览器的信任，XSS则利用了系统对用户的信任。

### csrf防御方法
1. 重要数据交互采用POST进行接收，当然是用POST也不是万能的，伪造一个form表单即可破解

2. 使用验证码，只要是涉及到数据交互就先进行验证码验证，这个方法可以完全解决CSRF。但是出于用户体验考虑，网站不能给所有的操作都加上验证码。因此验证码只能作为一种辅助手段，不能作为主要解决方案。

3. 验证HTTP Referer字段，该字段记录了此次HTTP请求的来源地址，最常见的应用是图片防盗链。PHP中可以采用APache URL重写规则进行防御，可参考：[http://www.cnblogs.com/phpstudy2015-6/p/6715892.html](http://www.cnblogs.com/phpstudy2015-6/p/6715892.html)

4. 为每个表单添加令牌token并验证

（可以使用cookie或者session进行构造。当然这个token仅仅只是针对CSRF攻击，在这前提需要解决好XSS攻击，否则这里也将会是白忙一场【XSS可以偷取客户端的cookie】）

　　CSRF攻击之所以能够成功，是因为攻击者可以伪造用户的请求，该请求中所有的用户验证信息都存在于Cookie中，因此攻击者可以在不知道这些验证信息的情况下直接利用用户自己的Cookie来通过安全验证。由此可知，抵御CSRF攻击的关键在于：在请求中放入攻击者所不能伪造的信息，并且该信息不存在于Cookie之中。

　　鉴于此，我们将为每一个表单生成一个随机数秘钥，并在服务器端建立一个拦截器来验证这个token，如果请求中没有token或者token内容不正确，则认为可能是CSRF攻击而拒绝该请求。

　　由于这个token是随机不可预测的并且是隐藏看不见的，因此恶意攻击者就不能够伪造这个表单进行CSRF攻击了。

　　要求：

　　1、要确保同一页面中每个表单都含有自己唯一的令牌

　　2、验证后需要删除相应的随机数

## 参考：  
[sql注入与防御](http://www.cnblogs.com/phpstudy2015-6/p/6790490.html)  
[XSS跨站脚本攻击](http://www.cnblogs.com/phpstudy2015-6/p/6767032.html)  
[csrf跨站请求伪造](http://www.cnblogs.com/phpstudy2015-6/p/6771239.html)  

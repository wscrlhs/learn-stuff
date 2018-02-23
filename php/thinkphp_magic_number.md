Thinkphp单字母函数使用指南
## A方法

A方法用于在内部实例化控制器，调用格式：A(‘[项目://][分组/]模块','控制器层名称')

最简单的用法：
 $User = A('User');
复制代码
表示实例化当前项目的UserAction控制器（这个控制器对应的文件位于Lib/Action/UserAction.class.），如果采用了分组模式，并且要实例化另外一个Admin分组的控制器可以用：
$User = A('Admin/User');
复制代码
也支持跨项目实例化（项目的目录要保持同级）
$User = A('Admin://User');
复制代码
表示实例化Admin项目下面的UserAction控制器

.1版本增加了分层控制器的支持，所以还可以用A方法实例化其他的控制器，例如：
 $User = A('User','Event);
复制代码
实例化UserEvent控制器（对应的文件位于Lib/Event/UserEvent.class.）。

实例化控制器后，就可以调用该控制器中的方法，不过需要注意的情况是，在跨项目调用的情况下，如果你的操作方法 有针对当前控制器的特殊变量操作，会有一些未知的问题，所以，一般来说，官方建议需要公共调用的控制器层单独开发，不要有太多的依赖关系。

## B方法

这是随着行为应运而生的新生函数，可以执行某个行为，例如
B('app_begin');
复制代码
就是在项目开始之前，执行这个行为定义的所有函数。支持2个参数，第二个参数支持需要接受一个数组，例如
B('app_begin',array("name"=& gt;"tdweb","time"=>time()));
复制代码
## C方法

C方法是Think用于设置、获取，以及保存配置参数的方法，使用频率较高。

了解C方法需要首先了解下Think的配置，因为C方法的所有操作都是围绕配置相关的。Think的配置文件采用数组格式定义。

由于采用了函数重载设计，所以用法较多，我们来一一说明下。

设置参数
C('DB_NAME','think');
复制代码
表示设置DB_NAME配置参数的值为think，由于配置参数不区分大小写，所以下面的写法也是一样：
C('db_name','think');
复制代码
但是建议保持统一大写的配置定义规范。

项目的所有参数在未生效之前都可以通过该方法动态改变配置，最后设置的值会覆盖前面设置或者惯例配置里面的定义，也可以使用参数配置方法添加新的配置。

支持二级配置参数的设置，例如：
C('USER.USER_ID',8);
复制代码
配置参数不建议超过二级。

如果要设置多个参数，可以使用批量设置，例如：
$config['user_id'] = 1;
$config['user_type'] = 1;
C($config);
复制代码
如果C方法的第一个参数传入数组，就表示批量赋值，上面的赋值相当于：
C('USER_ID',1);
C('USER_TYPE',1);
复制代码
获取参数

要获取设置的参数，可以用：
$userId = C('USER_ID');
$userType = C('USER_TYPE');
复制代码
如果USER_ID参数尚未定义过，则返回NULL。

也可以支持获取二级配置参数，例如：
$userId = C('USER.USER_ID');
复制代码
如果传入的配置参数为空，表示获取全部的参数：
$config = C();
复制代码
保存设置

.1版本增加了一个永久保存设置参数的功能，仅针对批量赋值的情况，例如：
$config['user_id'] = 1;
$config['user_type'] = 1;
C($config,'name');
复制代码
在批量设置了config参数后，会连同当前所有的配置参数保存到缓存文件（或者其他配置的缓存方式）。

保存之后，如果要取回保存的参数，可以用
$config = C('','name');
复制代码
其中name就是前面保存参数时用的缓存的标识，必须一致才能正确取回保存的参数。取回的参数会和当前的配置参数合并，无需手动合并。

## D方法

D方法应该是用的比较多的方法了，用于实例化自定义模型类，是Think框架对Model类实例化的一种封装，并实现了单例模式，支持跨项目和分组调用，调用格式如下：

D(‘[项目://][分组/]模型','模型层名称')

方法的返回值是实例化的模型对象。

D方法可以自动检测模型类，如果存在自定义的模型类，则实例化自定义模型类，如果不存在，则会实例化Model基类，同时对于已实例化过的模型，不会重复去实例化。

D方法最常用的用法就是实例化当前项目的某个自定义模型，例如：
// 实例化User模型
$User = D('User');
复制代码
会导入当前项目下面的Lib/Model/UserModel.class.文件，然后实例化UserModel类，所以，实际上的代码可能和下面的等效：
import('@.Model.UserModel');
$User = new UserModel();
复制代码
但是如果使用D方法的话，如果这个UserModel类不存在，则会自动调用
new Model('User');
复制代码
并且第二次调用的时候无需再次实例化，可以减少一定的对象实例化开销。

D方法可以支持跨分组和项目实例化模型，例如：
//实例化Admin项目的User模型
D('Admin://User')
//实例化Admin分组的User模型
D('Admin/User')
复制代码
注意：要实现跨项目调用模型的话，必须确保两个项目的目录结构是并列的。

.1版本开始，由于增加了分层模型的支持，所以D方法也可以实例化其他的模型，例如：
// 实例化UserService类
$User = D('User','Service');
// 实例化UserLogic类
$User = D('User','Logic');
复制代码
D('User','Service');
复制代码
会导入Lib/Service/UserService.class.，并实例化，等效于下面的代码：
import('@.Service.UserService');
$User = new UserSerivce();
复制代码
## F方法

F方法其实是S方法的一个子集功能，仅用于简单数据缓存，并且只能支持文件形式，不支持缓存有效期，因为采用的是返回方式，所以其效率较S方法较高，因此我们也称之为快速缓存方法。

F方法的特点是：

简单数据缓存；

文件形式保存；

采用返回数据方式加载缓存；

支持子目录缓存以及自动创建；

支持删除缓存和批量删除；

写入和读取缓存
F('data','test data');
复制代码
默认的保存起始路径是DATA_PATH（该常量在默认配置位于RUNTIME_PATH.'Data/'下面），也就是说会生成文件名为DATA_PATH.'data.'的缓存文件。

注意：确保你的缓存标识的唯一，避免数据覆盖和冲突。

下次读取缓存数据的时候，使用：
$Data = F('data');
复制代码
我们可以采用子目录方式保存，例如：
F('user/data',$data); // 缓存写入
F('user/data'); // 读取缓存
复制代码
就会生成DATA_PATH.'user/data.' 缓存文件，如果user子目录不存在的话，则会自动创建，也可以支持多级子目录，例如：
F('level1/level2/data',$data);
复制代码
如果需要指定缓存的起始目录，可以用下面的方式：
F('data',$data,TEMP_PATH);
复制代码
获取的时候则需要使用：
F('data','',TEMP_PATH);
复制代码
删除缓存

删除缓存也很简单，使用：
F('data',NULL); 
复制代码
第二个参数传入NULL，则表示删除标识为data的数据缓存。

支持批量删除功能，尤其是针对子目录缓存的情况，假设我们要删除user子目录下面的所有缓存数据，可以使用：
F('user/*',NULL);
复制代码
又或者使用过滤条件删除，例如：
F('user/[^a]*',NULL);
复制代码
## G方法

Thinkphp长期以来需要通过debug_start、debug_end方法甚至Debug类才能完成的功能，3.1版本中被一个简单的G方法取代了，不可不谓是一次华丽升级。

G方法的作用包括标记位置和区间统计两个功能，下面来看下具体用法：

标记位置

G方法的第一个用法就是标记位置，例如：
G('begin');
复制代码
表示把当前位置标记为begin标签，并且记录当前位置的执行时间，如果环境支持的话，还能记录内存占用情况。可以在任何位置调用G方法标记。

运行时间统计

标记位置后，我们就可以再次调用G方法进行区间统计了，例如：
G('begin');
// ...其他代码段
G('end');
// ...也许这里还有其他代码
// 进行统计区间
echo G('begin','end').'s';
复制代码
G(‘begin','end') 表示统计begin位置到end位置的执行时间（单位是秒），begin必须是一个已经标记过的位置，如果这个时候end位置还没被标记过，则会自动把当前位置标记为end标签，输出的结果类似于：
0.0056s
复制代码
默认的统计精度是小数点后4位，如果觉得这个统计精度不够，还可以设置例如：
G('begin','end',6).'s';
复制代码
可能的输出会变成：
0.005587s
复制代码
内存开销统计

如果你的环境支持内存占用统计的话，还可以使用G方法进行区间内存开销统计（单位为kb），例如：
echo G('begin','end','m').'kb';
复制代码
第三个参数使用m表示进行内存开销统计，输出的结果可能是：
625kb
复制代码
同样，如果end标签没有被标记的话，会自动把当前位置先标记位end标签。

如果环境不支持内存统计，则该参数无效，仍然会进行区间运行时间统计。

忘掉debug_start、debug_end吧，大道至简，你懂的~

## I方法

Thinkphp的I方法是3.1.3版本新增的，如果你是之前的3.*版本的话，可以直接参考使用3.1快速入门教程系列的变量部分。

概述

正如你所见到的一样，I方法是Thinkphp众多单字母函数中的新成员，其命名来自于英文Input（输入），主要用于更加方便和安全的获取系统输入变量，可以用于任何地方，用法格式如下：

I(‘变量类型.变量名',[‘默认值'],[‘过滤方法'])

变量类型是指请求方式或者输入类型，包括：

get 获取GET参数

post 获取POST参数

param 自动判断请求类型获取GET、POST或者PUT参数

request 获取REQUEST 参数

put 获取PUT 参数

session 获取 $_SESSION 参数

cookie 获取 $_COOKIE 参数

server 获取 $_SERVER 参数

globals 获取 $GLOBALS参数

注意：变量类型不区分大小写。

变量名则严格区分大小写。

默认值和过滤方法均属于可选参数。

用法

我们以GET变量类型为例，说明下I方法的使用：
echo I('get.id'); // 相当于 $_GET['id']
echo I('get.name'); // 相当于 $_GET['name']
复制代码
支持默认值：
echo I('get.id',0); // 如果不存在$_GET['id'] 则返回0
echo I('get.name',''); // 如果不存在$_GET['name'] 则返回空字符串
复制代码
采用方法过滤：
echo I('get.name','','htmlspecialchars'); // 采用htmlspecialchars方法对$_GET['name'] 进行过滤，如果不存在则返回空字符串
复制代码
支持直接获取整个变量类型，例如：
I('get.'); // 获取整个$_GET 数组
复制代码
用同样的方式，我们可以获取post或者其他输入类型的变量，例如：
1.I('post.name','','htmlspecialchars'); // 采用htmlspecialchars方法对$_POST['name'] 进行过滤，如果不存在则返回空字符串
I('session.user_id',0); // 获取$_SESSION['user_id'] 如果不存在则默认为0
I('cookie.'); // 获取整个 $_COOKIE 数组
I('server.REQUEST_METHOD'); // 获取 $_SERVER['REQUEST_METHOD'] 
复制代码
param变量类型是框架特有的支持自动判断当前请求类型的变量获取方式，例如：
echo I('param.id');
复制代码
如果当前请求类型是GET，那么等效于 GET[′id′]，如果当前请求类型是POST或者PUT，那么相当于获取_POST[‘id'] 或者 PUT参数id。

并且param类型变量还可以用数字索引的方式获取URL参数（必须是PATHINFO模式参数有效，无论是GET还是POST方式都有效），例如：

当前访问URL地址是
http://serverName/index./New/2013/06/01 
复制代码
那么我们可以通过
echo I('param.1'); // 输出2013
echo I('param.2'); // 输出06
echo I('param.3'); // 输出01
复制代码
事实上，param变量类型的写法可以简化为：
I('id'); // 等同于 I('param.id')
I('name'); // 等同于 I('param.name')
复制代码
变量过滤

使用I方法的时候 变量其实经过了两道过滤，首先是全局的过滤，全局过滤是通过配置VAR_FILTERS参数，这里一定要注意，3.1版本之后，VAR_FILTERS参数的过滤机制已经更改为采用array_walk_recursive方法递归过滤了，主要对过滤方法的要求是必须引用返回，所以这里设置htmlspecialchars是无效的，你可以自定义一个方法，例如：
function filter_default(&$value){
$value = htmlspecialchars($value);
}
复制代码
然后配置：
'VAR_FILTERS'=>'filter_default'
复制代码
如果需要进行多次过滤，可以用：
'VAR_FILTERS'=>'filter_default,filter_exp'
复制代码
filter_exp方法是框架内置的安全过滤方法，用于防止利用模型的EXP功能进行注入攻击。

因为VAR_FILTERS参数设置的是全局过滤机制，而且采用的是递归过滤，对效率有所影响，所以，我们更建议直接对获取变量过滤的方式，除了在I方法的第三个参数设置过滤方法外，还可以采用配置DEFAULT_FILTER参数的方式设置过滤，事实上，该参数的默认设置是：
'DEFAULT_FILTER'        => 'htmlspecialchars'
复制代码
也就说，I方法的所有获取变量都会进行htmlspecialchars过滤，那么：
I('get.name'); // 等同于 htmlspecialchars($_GET['name'])
复制代码
同样，该参数也可以支持多个过滤，例如：
'DEFAULT_FILTER'        => 'strip_tags,htmlspecialchars'
复制代码
I('get.name'); // 等同于 htmlspecialchars(strip_tags($_GET['name']))
复制代码
如果我们在使用I方法的时候 指定了过滤方法，那么就会忽略DEFAULT_FILTER的设置，例如：
echo I('get.name','','strip_tags'); // 等同于 strip_tags($_GET['name'])
复制代码
I方法的第三个参数如果传入函数名，则表示调用该函数对变量进行过滤并返回（在变量是数组的情况下自动使用array_map进行过滤处理），否则会调用内置的filter_var方法进行过滤处理，例如：
I('post.email','',FILTER_VALIDATE_EMAIL);
复制代码
表示 会对$_POST[‘email'] 进行 格式验证，如果不符合要求的话，返回空字符串。

（关于更多的验证格式，可以参考 官方手册的filter_var用法。）

或者可以用下面的字符标识方式：
I('post.email','','email');
复制代码
可以支持的过滤名称必须是filter_list方法中的有效值（不同的服务器环境可能有所不同），可能支持的包括：
int
boolean
float
validate_regexp
validate_url
validate_email
validate_ip
string
stripped
encoded
special_chars
unsafe_raw
email
url
number_int
number_float
magic_quotes
callback
复制代码
在有些特殊的情况下，我们不希望进行任何过滤，即使DEFAULT_FILTER已经有所设置，可以使用：
I('get.name','',NULL);
复制代码
一旦过滤参数设置为NULL，即表示不再进行任何的过滤。

## L方法



L方法用于启用多语言的情况下，设置和获取当前的语言定义。

调用格式：L(‘语言变量',[‘语言值'])

设置语言变量

除了使用语言包定义语言变量之外，我们可以用L方法动态设置语言变量，例如：
L('LANG_VAR','语言定义');
复制代码
语言定义不区分大小写，所以下面也是等效的：
L('lang_var','语言定义');
复制代码
不过规范起见，我们建议统一采用大写定义语言变量。

L方法支持批量设置语言变量，例如：
$lang['lang_var1'] = '语言定义1';
$lang['lang_var2'] = '语言定义2';
$lang['lang_var3'] = '语言定义3';
L($lang);
复制代码
表示同时设置3个语言变量lang_var1 lang_var2和lang_var3。

[-more-]

获取语言变量
$langVar = L('LANG_VAR');
复制代码
或者：
$langVar = L('lang_var');
复制代码
如果参数为空，表示获取当前定义的全部语言变量（包括语言定义文件中的）：
$lang = L();
复制代码
或者我们也可以在模板中使用
{$Think.lang.lang_var}
复制代码
来输出语言定义。

## M方法

M方法用于实例化一个基础模型类，和D方法的区别在于：

、不需要自定义模型类，减少IO加载，性能较好；

、实例化后只能调用基础模型类（默认是Model类）中的方法；

、可以在实例化的时候指定表前缀、数据库和数据库的连接信息；

D方法的强大则体现在你封装的自定义模型类有多强，不过随着新版Think框架的基础模型类的功能越来越强大，M方法也比D方法越来越实用了。

M方法的调用格式：

M(‘[基础模型名:]模型名','数据表前缀','数据库连接信息')

我们来看下M方法具体有哪些用法：

、实例化基础模型（Model） 类

在没有定义任何模型的时候，我们可以使用下面的方法实例化一个模型类来进行操作：
//实例化User模型
$User = M('User');
//执行其他的数据操作
$User->select();
复制代码
这种方法最简单高效，因为不需要定义任何的模型类，所以支持跨项目调用。缺点也是因为没有自定义的模型类，因此无法写入相关的业务逻辑，只能完成基本的CURD操作。
$User = M('User');
复制代码
其实等效于：
$User = new Model('User');
复制代码
表示操作think_user表。M方法和D方法一样也有单例功能，多次调用并不会重复实例化。M方法的模型名参数在转换成数据表的时候会自动转换成小写，也就是说Think的数据表命名规范是全小写的格式。

、实例化其他公共模型类

第一种方式实例化因为没有模型类的定义，因此很难封装一些额外的逻辑方法，不过大多数情况下，也许只是需要扩展一些通用的逻辑，那么就可以尝试下面一种方法。
$User = M('CommonModel:User');
复制代码
改用法其实等效于：
$User = new CommonModel('User');
复制代码
因为系统的模型类都能够自动加载，因此我们不需要在实例化之前手动进行类库导入操作。模型类CommonModel必须继承Model。我们可以在CommonModel类里面定义一些通用的逻辑方法，就可以省去为每个数据表定义具体的模型类，如果你的项目已经有超过100个数据表了，而大多数情况都是一些基本的CURD操作的话，只是个别模型有一些复杂的业务逻辑需要封装，那么第一种方式和第二种方式的结合是一个不错的选择。

、传入表前缀、数据库和其他信息

M方法有三个参数，第一个参数是模型名称（可以包括基础模型类和数据库），第二个参数用于设置数据表的前缀（留空则取当前项目配置的表前缀），第三个参数用于设置当前使用的数据库连接信息（留空则取当前项目配置的数据库连接信息），例如：
$User = M('db2.User','think_');
复制代码
表示实例化Model模型类，并操作db2数据库中的think_user表。

如果第二个参数留空或者不传，表示使用当前项目配置中的数据表前缀，如果操作的数据表没有表前缀，那么可以使用：
$User = M('db1.User',null);
复制代码
表示实例化Model模型类，并操作db1数据库中的user表。

如果你操作的数据库需要不同的用户账号，可以传入数据库的连接信息，例如：
$User = M('User','think_','mysql://user_a:1234@localhost:3306/think');
复制代码
表示基础模型类用Model，然后对think_user表进行操作，用user_a账号进行数据库连接，操作数据库是think。

第三个连接信息参数可以使用DSN配置或者数组配置，甚至可以支持配置参数。

例如，在项目配置文件中配置了：
'DB_CONFIG'=>'mysql://user_a:1234@localhost:3306/think';
复制代码
则可以使用：
$User = M('User','think_','DB_CONFIG');
复制代码
基础模型类和数据库可以一起使用，例如：
$User = M('CommonModel:db2.User','think_');
复制代码
如果要实例化分层模型的话，利用公共模型类的方式，我们可以使用：
M('UserLogic:User');
复制代码
来实例化UserLogic，虽然这样做的意义不大，因为可以用
D('User','Logic');
复制代码
实现同样的功能。

## R方法

R方法用于调用某个控制器的操作方法，是A方法的进一步增强和补充。关于A方法的用法见这里。

R方法的调用格式：

R(‘[项目://][分组/]模块/操作','参数','控制器层名称')

例如，我们定义了一个操作方法为：
class UserAction extends Action {
 public function detail($id){
     return M('User')->find($id);
 }
}
复制代码
那么就可以通过R方法在其他控制器里面调用这个操作方法（一般R方法用于跨模块调用）
$data = R('User/detail',array('5'));
复制代码
表示调用User控制器的detail方法（detail方法必须是public类型），返回值就是查询id为5的一个用户数据。如果你要调用的操作方法是没有任何参数的话，第二个参数则可以留空，直接使用：
$data = R('User/detail');
复制代码
也可以支持跨分组和项目调用，例如：
R('Admin/User/detail',array('5'));
复制代码
表示调用Admin分组下面的User控制器的detail方法。
R('Admin://User/detail',array('5'));
复制代码
表示调用Admin项目下面的User控制器的detail方法。

官方的建议是不要在同一层多太多调用，会引起逻辑的混乱，被公共调用的部分应该封装成单独的接口，可以借助3.1的新特性多层控制器，单独添加一个控制器层用于接口调用，例如，我们增加一个Api控制器层，
class UserApi extends Action {
 public function detail($id){
     return M('User')->find($id);
 }
}
复制代码
然后，使用R方法调用
$data = R('User/detail',array('5'),'Api');
复制代码
也就是说，R方法的第三个参数支持指定调用的控制器层。

同时，R方法调用操作方法的时候可以支持操作后缀设置C(‘ACTION_SUFFIX')，如果你设置了操作方法后缀，仍然不需要更改R方法的调用方式。

## S方法

S方法还支持对当前的缓存方式传入缓存参数，例如：
S('data',$Data,3600,'File',array('length'=>10,'temp'=>RUNTIME_PATH.'temp/'));
复制代码
经测试，这样使用 只有前三个参数有效，后面的均无效
{ 'File',array('length'=>10,'temp'=>RUNTIME_PATH.'temp/')}
复制代码
最终这么用：
S('data1',$list,array('prefix'=>aaa','expire'=>'3600','temp'=>RUNTIME_PATH.'temp/1236'));
复制代码
获取的时候：
$sdata = S('data1','',array('prefix'=>'aaa','temp'=>RUNTIME_PATH.'temp/1236'));
复制代码
## T方法

为了更方便的输出模板文件，新版封装了一个T函数用于生成模板文件名。

用法：

T([资源://][模块@][主题/][控制器/]操作,[视图分层])

T函数的返回值是一个完整的模板文件名，可以直接用于display和fetch方法进行渲染输出。

例如：
T('Public/menu');
// 返回 当前模块/View/Public/menu.html
T('blue/Public/menu');
// 返回 当前模块/View/blue/Public/menu.html
T('Public/menu','Tpl');
// 返回 当前模块/Tpl/Public/menu.html
T('Public/menu');
// 如果TMPL_FILE_DEPR 为 _ 返回 当前模块/Tpl/Public_menu.html
T('Public/menu');
// 如果TMPL_TEMPLATE_SUFFIX 为.tpl 返回 当前模块/Tpl/Public/menu.tpl
T('Admin@Public/menu');
// 返回 Admin/View/Public/menu.html
T('Extend://Admin@Public/menu');
// 返回 Extend/Admin/View/Public/menu.html (Extend目录取决于AUTOLOAD_NAMESPACE中的配置）
复制代码
在display方法中直接使用T函数：
// 使用T函数输出模板
$this->display(T('Admin@Public/menu'));
复制代码
T函数可以输出不同的视图分层模板。

## U方法

U方法用于完成对URL地址的组装，特点在于可以自动根据当前的URL模式和设置生成对应的URL地址，格式为：

U(‘地址','参数','伪静态','是否跳转','显示域名');

在模板中使用U方法而不是固定写死URL地址的好处在于，一旦你的环境变化或者参数设置改变，你不需要更改模板中的任何代码。

在模板中的调用格式需要采用 {:U('地址', '参数'…)} 的方式

U方法的用法示例：
U('User/add') // 生成User模块的add操作地址
复制代码
也可以支持分组调用：
U('Home/User/add') // 生成Home分组的User模块的add操作地址
复制代码
当然，也可以只是写操作名，表示调用当前模块的
U('add') // 生成当前访问模块的add操作地址
复制代码
除了分组、模块和操作名之外，我们也可以传入一些参数：
U('Blog/readid=1') // 生成Blog模块的read操作 并且id为1的URL地址
复制代码
U方法的第二个参数支持传入参数，支持数组和字符串两种定义方式，如果只是字符串方式的参数可以在第一个参数中定义，下面几种方式都是等效的：
U('Blog/cate',array('cate_id'=>1,'status'=>1))
U('Blog/cate','cate_id=1&status=1')
U('Blog/catecate_id=1&status=1')
复制代码
但是不允许使用下面的定义方式来传参数：
U('Blog/cate/cate_id/1/status/1')
复制代码
根据项目的不同URL设置，同样的U方法调用可以智能地对应产生不同的URL地址效果，例如针对：
U('Blog/readid=1')
复制代码
这个定义为例。

如果当前URL设置为普通模式的话，最后生成的URL地址是：
http://serverName/index.m=Blog&a=read&id=1
复制代码
如果当前URL设置为PATHINFO模式的话，同样的方法最后生成的URL地址是： http://serverName/index./Blog/read/id/1

如果当前URL设置为REWRITE模式的话，同样的方法最后生成的URL地址是： http://serverName/Blog/read/id/1

如果你同时还设置了PATHINFO分隔符的话：
'URL_PATHINFO_DEPR'=>'_'
复制代码
就会生成
http://serverName/Blog_read_id_1
复制代码
如果当前URL设置为REWRITE模式，并且设置了伪静态后缀为html的话，同样的方法最后生成的URL地址是：
http://serverName/Blog/read/id/1.html
复制代码
如果设置了多个伪静态支持，那么会自动取第一个伪静态后缀添加到URL地址后面，当然你也可以手动在U方法里面指定要生成的伪静态后缀，例如：
U('Blog/read','id=1','xml')
复制代码
就会生成
http://serverName/Blog/read/id/1.xml
复制代码
U方法还可以支持路由，如果我们定义了一个路由规则为：
'news/:id\d'=>'News/read'
复制代码
那么可以使用
U('/news/1')
复制代码
最终生成的URL地址是：
http://serverName/index./news/1
复制代码
如果你的应用涉及到多个子域名的操作地址，那么也可以在U方法里面指定需要生成地址的域名，例如：
U('Blog/read@blog.think.cn','id=1');
复制代码
@后面传入需要指定的域名即可。

此外，U方法的第5个参数如果设置为true，表示自动识别当前的域名，并且会自动根据子域名部署设置APP_SUB_DOMAIN_DEPLOY和APP_SUB_DOMAIN_RULES自动匹配生成当前地址的子域名。

如果开启了URL_CASE_INSENSITIVE，则会统一生成小写的URL地址。

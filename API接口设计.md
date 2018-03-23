```php

<?php

/*************************************************
 *       设计API的基本流程
 *       1. 接收数据
 *       2. 解密数据
 *       3. 签名验证
 *       4. 方法匹配
 *       5. 参数验证
 *       6. 执行程序
 *       7. 封装数据
 *       8. 加密数据
 *       9. 返回数据
 ************************************************/


/**
 * 接收数据
 * @return mixed
 */
function reveiveJsonData()
{
    $json = file_get_contents('php://input');
    $urldecodeData = urldecode($json);
    $decipherData = decipher($urldecodeData);
    $jsonData = json_decode($decipherData);
    return $jsonData;
}

/**
 * 解密
 * @param $data
 * @return null
 */
function decipher($data)
{
    return null;
}

/**
 * 签名验证
 * @param $data
 * @return bool
 */
function verify($data)
{
    return true;
}

/**
 * 方法匹配
 * @param $data
 */
function action($data)
{
    $action = $data->action;
    switch ($action) {
        case 'action1':
            function1();
            break;
        default:
            echo returnData(dataPackage(400, 'Not Found'));
    }
}

/**
 * 参数验证
 * @param $data
 * @return bool
 */
function checkParams($data)
{
    return true;
}

/**
 *执行方法
 * @return null
 */
function function1()
{
    return null;
}

/**
 * 封装数据
 * @param string $code
 * @param string $message
 * @param array $data
 * @return null
 */
function dataPackage($code = "", $message = "", $data = array())
{
    return null;
}

/**
 * 签名
 * @param $data
 * @return null
 */
function sign($data)
{
    return null;
}

/**
 * 加密
 * @param $data
 * @return null
 */
function cipher($data)
{
    return null;
}

/**
 * 返回数据
 * @param $data
 * @return string
 */
function returnData($data)
{
    $result = array();
    $result['sign'] = sign($data);
    $cipherData = cipher($data);
    $urlencodeData = urlencode($cipherData);
    return $urlencodeData;
}
```

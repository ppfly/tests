<?php


function data_auth_sign($data) {
    //数据类型检测
    if (!is_array($data)) {
        $data = (array) $data;
    }
    ksort($data); //排序
    $code = http_build_query($data); //url编码并生成query字符串
    $sign = sha1($code); //生成签名
    return $sign;
}

function is_login() {
    $user = session('user_auth');
    if (empty($user)) {
        return 0;
    } else {
        return session('user_auth_sign') == data_auth_sign($user) ? $user['id'] : 0;
    }
}

function is_administrator($uid = null) {
    $uid = is_null($uid) ? is_login() : $uid;
    return $uid && (intval($uid) === config('user_administrator'));
}

//解决跨域问题
function output_data($datas, $extend_data = array(), $error = false) {


    $data = $datas;

    $jsonFlag = 0 && config('app_debug') && version_compare(PHP_VERSION, '5.4.0') >= 0
        ? JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
        : 0;

    if ($jsonFlag) {
        header('Content-type: text/plain; charset=utf-8');
    }

    if (!empty($_GET['callback'])) {
        echo $_GET['callback'].'('.json_encode($data, $jsonFlag).')';die;
    } else {
        header("Access-Control-Allow-Origin:*");
        echo json_encode($data, $jsonFlag);die;
    }
}
?>
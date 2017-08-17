<?php
 ini_set('date.timezone','Asia/Shanghai');

$jsonData = $_POST['images'];
$imagesdata = json_decode($jsonData);

//路径
$upload_path = './uploads/'.date('Y-m-d',time());
if (!file_exists($upload_path)) {
    mkdir($upload_path,0777,true);
}

foreach ($imagesdata as $key => $value) {

    if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $value, $result)){  //匹配图片格式
        $type = $result[2];
        $data = str_replace($result[1], '', $value);
        $new_file = $upload_path.'/'.md5($value).".{$type}";
        file_put_contents($new_file, base64_decode(str_replace(' ', '+',$data)));
    }
}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<style type="text/css">
    .imageDIV {
        position:relative; 
        max-width: 100px;
    }
    .imageDIV img {
        max-width: 100px;
    }
    .redx{
        position:absolute;
        float: right;
        right: 4px;
        color: red;
        display: none;
        cursor: pointer;
    }
    .showx{
        display: block;
    }
</style>
<body id="body">
<div class="container">
    <label>请选择一个图像文件：</label>
    <input type="file" id="image" multiple/>    <!--multiple多选图片-->
</div>
<div><button id="uploadAction" onclick="uploadAction();">上传</button></div>
</body>
<script type="text/javascript">
    var input = document.getElementById('image');
    var result,div;

    if(typeof FileReader==='undefined'){
            result.innerHTML = "浏览器不支持FileReader";
            input.setAttribute('disabled','disabled');
        }else{
            input.addEventListener('change',loadImage,false);
        }

        function loadImage(){

            for(var i=0;i<this.files.length;i++){
                if (!input['value'].match(/.jpg|.gif|.png|.bmp/i)){     //i忽略大小写
                    return alert("上传的图片格式不正确")　　　　　　　　　
                }
                var reader = new FileReader();

                reader.readAsDataURL(this.files[i]);
                reader.onload = function(e){
                    result = '<div class="imageDIV"  onmouseover="showx(this);" onmouseout="hidex(this);"><img src="'+this.result+'" alt=""/><span class="redx" onclick="deleteImage(this)">x</span></div>';
                    div = document.createElement('div');
                    /*div.addEventListener('onmouseover',showx,false);*/
                    div.innerHTML = result;
                    document.getElementById('body').appendChild(div);
                }
            }  
        }

        function uploadAction()
        {
            var imageDiv = document.getElementsByClassName('imageDIV');
            var imageSrc = new Array();
            for(var i=0; i<imageDiv.length; i++)
            {
                imageSrc[i] = imageDiv[i].childNodes[0].src;
            }
            var jsonData = "images=" + JSON.stringify(imageSrc);
            var url = document.location.href + 'uploadAction';
            post(url,jsonData);
        }

        function deleteImage(obj)
        {
            var div = obj.parentElement.parentElement;
            div.remove();
        }

        function showx(obj)
        {
            obj.childNodes[1].style.display="inline";
        }

        function hidex(obj)
        {
            obj.childNodes[1].style.display="none";
        }

        function post(url, data) {         // datat应为'a=a1&b=b1'这种字符串格式，在jq里如果data为对象会自动将对象转成这种字符串格式
        var obj = new XMLHttpRequest();
        obj.open("POST", url, true);
        obj.setRequestHeader("Content-type", "application/x-www-form-urlencoded");  // 添加http头，发送信息至服务器时内容编码类型

        obj.send(data);
        obj.onreadystatechange= function() {  
                       if(obj.readyState == 4 && obj.status == 200) {
                                console.log(obj);
                                console.log(obj.responseText);  
                       }  
              };  
        }

</script>
</html>
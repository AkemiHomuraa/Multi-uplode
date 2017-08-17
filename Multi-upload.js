
var Multi_upload = {
    createNewUpload: function(path,name){
        var uploadDiv = document.getElementById('Multi_upload_div');
        uploadElement = '<div class="container" id="container"><button id="selectImage" onclick="checkFileInput();">请选择</button><input style="display:none" onchange="loadImage(this);" type="file" id="Multi_image" multiple /><div><button id="uploadAction" onclick="'+name+'.uploadAction();">上传</button></div></div>';
        uploadDiv.innerHTML = uploadElement;

        var newUpload = {};
        newUpload.setUploadPath = path;

        newUpload.uploadAction = function(){
            var imageDiv = document.getElementsByClassName('imageDIV');
            var imageSrc = new Array();

            for(var i=0; i<imageDiv.length; i++)
            {
                imageSrc[i] = imageDiv[i].childNodes[0].src;
            }

            var jsonData = "images=" + JSON.stringify(imageSrc);

            var myupload_ = Multi_upload.createNewUpload();

            var url = myupload_.upload_path;
            console.log(path);
            post(path,jsonData);
        }

        return newUpload;
    }
}

    function checkFileInput() 
    {
        var input = document.getElementById('Multi_image');
        input.click();
    }

    function loadImage(obj){
        var input = document.getElementById('Multi_image');
        var result,div;

        for(var i=0;i<obj.files.length;i++){
            if (!input['value'].match(/.jpg|.gif|.png|.bmp/i)){     //i忽略大小写
                return alert("上传的图片格式不正确")　　　　　　　　　
            }
            var reader = new FileReader();

            reader.readAsDataURL(obj.files[i]);
            reader.onload = function(e){
                result = '<div class="imageDIV"  onmouseover="showx(this);" onmouseout="hidex(this);"><img src="'+this.result+'" alt=""/><span class="redx" onclick="deleteImage(this)">x</span></div>';
                div = document.createElement('div');
                
                div.innerHTML = result;
                document.getElementById('container').appendChild(div);
            }
        }  
    }

    //删除图片
    function deleteImage(obj)
    {
        var div = obj.parentElement.parentElement;
        div.remove();
    }

    //叉叉显示与隐藏
    function showx(obj)
    {
        obj.childNodes[1].style.display="inline";
    }
    function hidex(obj)
    {
        obj.childNodes[1].style.display="none";
    }

    function post(url, data) {         // datat应为'a=a1&b=b1'这种字符串格式
        var obj = new XMLHttpRequest();
        obj.open("POST", url, true);
        obj.setRequestHeader("Content-type", "application/x-www-form-urlencoded");  // 添加http头，发送信息至服务器时内容编码类型

        obj.send(data);
        obj.onreadystatechange= function() {
            if(obj.readyState == 4 && obj.status == 200) {  //这里面写回调
                console.log(obj);
                console.log(obj.responseText);  
            }  
        };  
    }
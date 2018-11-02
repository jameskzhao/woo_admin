<?php
require_once 'auth-header.php';
require_once 'woo-header.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php header_libs('Admin - Settings'); ?>
    <link href="css/pages/settings.css" rel="stylesheet">
    
</head>

<body>
    <?php navbar_top('settings'); ?>
    <div class="main">
        <div class="main-inner">
            <div class="container">
                <div class="row">
                    <div class="tabbable">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a href="#general" data-toggle="tab">General</a>
                            </li>
                            <li>
                                <a href="#hours" data-toggle="tab">Hours</a>
                            </li>
                        </ul>
                        <br>
                        <div class="tab-content">
                            <div class="tab-pane active" id="general">
                                <div class="row">
                                    <div class="span6">
                                        <div class="widget">
                                            <div class="widget-header"> <i class="far fa-image icon-2x"></i> <h3>Logo</h3></div>
                                            <div class="widget-content">
                                                <div class="alert alert-success" role="alert" hidden="hidden">Upload complete!</div>
                                                <div class="alert alert-warning" role="alert" hidden="hidden">File too large. Upload failed.</div>
                                                
                                                <form id="form1" enctype="multipart/form-data" method="post" action="Upload.aspx" class="form-horizontal ">
                                                    <div class="control-group">
                                                        <div>
                                                            <input type="file" name="fileToUpload" id="fileToUpload" onchange="fileSelected();" capture="camera" title="Select Logo" />
                                                        </div>
                                                    </div>
                                                    <div id="details"></div>
                                                    <div>
                                                        <img id="uploadPreview" />
                                                    </div>

                                                    <div class=" text-center">
                                                        <input id="submit" type="button" class="btn btn-lg btn-primary " onclick="uploadFile()" value="Upload" disabled="true" />
                                                    </div>

                                                    <div id="progress" class="progress-bar progress-bar-striped active top_5" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="height: 20px;"></div>
                                                </form>
                                                <img id="image_preview" />
                                                <img id="result_image" style="max-width:80%;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane " id="hours">
                                <?php require_once('html/setting-hours.php'); ?>
                            </div>
                        </div>
                    </div>
                    <!-- /tabbable -->
                </div>
                <!-- /row -->
            </div>
            <!-- /container -->
        </div>
        <!-- /main-inner -->
    </div>
    <!-- /main -->
    <?php extra_bottom(); ?>
    <?php admin_page_footer(); ?>
    <!-- Le javascript
================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery-1.7.2.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/setting-hours.js"></script>
    <script type="text/javascript">
        var files_to_upload = [];

        function doUpload() {
            var file = document.getElementById('fileToUpload').files[0];
            var dataUrl = "";
            // Create an image
            var img = document.createElement("img");
            // Create a file reader
            var reader = new FileReader();
            // Set the image once loaded into file reader
            reader.onload = function(e) {
                    img.src = e.target.result;

                    var canvas = document.createElement("canvas");
                    //var canvas = $("<canvas>", {"id":"testing"})[0];
                    var ctx = canvas.getContext("2d");
                    ctx.drawImage(img, 0, 0);

                    // Set Width and Height
                    var MAX_WIDTH = 400;
                    var MAX_HEIGHT = 300;
                    var width = img.width;
                    var height = img.height;

                    if (width > height) {
                        if (width > MAX_WIDTH) {
                            height *= MAX_WIDTH / width;
                            width = MAX_WIDTH;
                        }
                    } else {
                        if (height > MAX_HEIGHT) {
                            width *= MAX_HEIGHT / height;
                            height = MAX_HEIGHT;
                        }
                    }
                    canvas.width = width;
                    canvas.height = height;
                    var ctx = canvas.getContext("2d");
                    ctx.drawImage(img, 0, 0, width, height);

                    dataUrl = canvas.toDataURL("image/png");
                    document.getElementById('image_preview').src = dataUrl;

                    // Post the data
                    var fd = new FormData();
                    fd.append("image", dataUrl);

                    var xhr = new XMLHttpRequest();
                    xhr.upload.addEventListener("progress", uploadProgress, false);
                    xhr.addEventListener("load", uploadComplete, false);
                    xhr.addEventListener("error", uploadFailed, false);
                    xhr.addEventListener("abort", uploadCanceled, false);
                    xhr.open("POST", "server/upload_image.php");
                    xhr.send(fd);
                }
                // Load files into file reader
            reader.readAsDataURL(file);
        }

        function fileSelected() {
            var count = document.getElementById('fileToUpload').files.length;
            //document.getElementById('details').innerHTML = "";
            for (var index = 0; index < count; index++) {
                var file = document.getElementById('fileToUpload').files[index];
                var dataUrl = "";

                //create an image
                var img = document.createElement("img");
                //create a file reader
                var reader = new FileReader();
                //Set the image once loaded into file raeder
                reader.onload = function(e) {
                    img.src = e.target.reasult;
                    console.log("file reader onload fired");
                    var canvas = document.createElement("canvas");
                    var ctx = canvas.getContext("2d");
                    ctx.drawImage(img, 0, 0);

                    //Set max width and height
                    var MAX_WIDTH = 800;
                    var MAX_HEIGHT = 600;
                    var width = img.width;
                    var height = img.height;
                    if (width > height) {
                        if (width > MAX_WIDTH) {
                            height *= MAX_WIDTH / width;
                            width = MAX_WIDTH;
                        }
                    } else {
                        if (height > MAX_HEIGHT) {
                            width *= MAX_HEIGHT / height;
                            height = MAX_HEIGHT;
                        }
                    }
                    canvas.width = width;
                    canvas.height = height;
                    var ctx = canvas.getContext("2d");
                    ctx.drawImage(img, 0, 0, width, height);
                    dataUrl = canvas.toDataURL("image/png");

                    document.getElementById('image_preview').src = dataUrl;
                }

                var fileSize = 0;
                if (file.size > 1024 * 1024) {
                    fileSize = (Math.round(file.size * 100 / (1024 * 1024)) / 100).toString() + 'MB';
                    $('.alert-warning').show();
                } else {
                    $('.alert-warning').hide();
                    fileSize = (Math.round(file.size * 100 / 1024) / 100).toString() + 'KB';
                }
                //document.getElementById('details').innerHTML += '文件名: ' + file.name + '<br>文件大小: ' + fileSize + '<br>文件类型: ' + file.type;
                //document.getElementById('details').innerHTML += '<p>';
                $('#details').empty();
                $('#details').append('Filename: ' + file.name + '<br>Size: ' + fileSize + '<br>Type: ' + file.type);
                $('.alert-success').hide();
                $('.alert-info').show();
                $('#submit').prop('disabled', false);
                $('#submit').show();

            }
        }

        function uploadFile() {
            var fd = new FormData();
            var count = document.getElementById('fileToUpload').files.length;
            for (var index = 0; index < count; index++) {
                var file = document.getElementById('fileToUpload').files[index];
                fd.append('myFile', file);
            }
            var xhr = new XMLHttpRequest();
            xhr.upload.addEventListener("progress", uploadProgress, false);
            xhr.addEventListener("load", uploadComplete, false);
            xhr.addEventListener("error", uploadFailed, false);
            xhr.addEventListener("abort", uploadCanceled, false);
            xhr.open("POST", "server/upload_image.php");
            xhr.send(fd);
        }

        function uploadProgress(evt) {
            if (evt.lengthComputable) {
                var percentComplete = Math.round(evt.loaded * 100 / evt.total);
                document.getElementById('progress').innerHTML = percentComplete.toString() + '%';
                $('#progress').css({
                    "width": percentComplete + "%"
                });
            } else {
                document.getElementById('progress').innerHTML = '无法计算进度';
            }
        }

        function uploadComplete(evt) {
            /* This event is raised when the server send back a response */
            var return_data = JSON.parse(evt.target.response);
            console.log(return_data);
            if (return_data.code > 0) {
                alert(return_data.url);
                $('#progress').css({
                    "width": "0%"
                });
            } else {
                $('#submit').hide();
                $('#progress').hide();
                $('#result_image').prop("src", return_data.file.url);
                $('.alert-info').hide();
                $('.alert-success').show();
            }
        }

        function uploadFailed(evt) {
            alert("Upload failed.");
        }

        function uploadCanceled(evt) {
            alert("Upload canceled.");
        }
    </script>
    
</body>

</html>
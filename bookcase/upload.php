<!DOCTYPE html>
<html>
<head>
<meta charset=UTF-8>
<title>上传信息 - 网信书柜</title>
</head>
<body>
<?php
if ($_FILES["file"]["error"] > 0) {
    echo "文件错误! 错误码: " . $_FILES["file"]["error"] . "<br />";
} elseif ($_FILES["file"]["type"] !== "application/epub+zip") {
    echo "不是标准的 EPUB 格式文件！<br />";
} else {
    $fname = $_FILES["file"]["name"];

    if (file_exists($fname)) {
        while (file_exists($fname)) {
            $fname = '_' . $fname;
        }
        $fname = $_POST['filepath'] . "/" . $fname;
    }

    move_uploaded_file($_FILES["file"]["tmp_name"],$fname);

    echo "图书" . $fname . "上传成功<br />";
}
?>
<a href="./">返回目录</a>
</body>
</html>
        
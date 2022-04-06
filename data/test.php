<?php
    if(isset($_POST['upload'])){
        $file = $_FILES['myFile']['tmp_name'];
        $path = "../Excel/".$_FILES['myFile']['name'];
        if(copy($file, $path)){
            echo "Tải tập tin thành công";
        }else{
            echo "Tải tập tin thất bại";
        }

        echo '<pre>';
        echo 'Here is some more debugging info:';
        print_r($_FILES);
        print "</pre>";
    }

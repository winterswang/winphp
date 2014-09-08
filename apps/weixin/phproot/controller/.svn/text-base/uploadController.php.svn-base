<?php
class uploadController extends AppController {
    public function actionImage() {
        $this->setMeta('title','上传图片');
        $this->render("upload_image");
    }

    public function actionApi() {
        error_reporting(E_ERROR | E_WARNING | E_PARSE);
        header('Content-Type:text/html;charset=UTF-8');
        $req = WinBase::app()->getRequest();
        // save img
        $img = $req -> getParam("base64", "");

        if (isset($img)) { # dataURI
            $filename = date('YmdHis').rand(1000,9999). '.jpg';
            $target = "./tmp/".$filename;
            // $img = str_replace('data:image/png;base64,', '', $img);
            if (preg_match('/data:([^;]*);base64,(.*)/', $img, $matches)) {
                // $type = $matches[1];
                // $matches[2] = str_replace(' ', '+', $matches[2]);
                $img = base64_decode($matches[2]);
                file_put_contents($target, $img);
            } else {
                echo 'error'; 
            }
        } else { # 普通上传
            $uploadFile = $_FILES['upfile'];
            // var_dump($uploadFile);
            $target = 'tmp1.jpg';
            if (isset($uploadFile) && is_uploaded_file($uploadFile['tmp_name']) && $uploadFile['error'] == 0) {
                echo 'filename: ' . $uploadFile['name'] . ', ';
                echo 'type: ' . $uploadFile['type'] . ', ';
                echo 'size: ' . ($uploadFile['size'] / 1024) . ' Kb';
                move_uploaded_file($uploadFile['tmp_name'], $target);
            } else {
                echo 'error: ' . $uploadFile['error'];
            }
        }
    }
}
?>
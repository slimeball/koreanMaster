<?php
    
    //接收行为
    $action = $_REQUEST['action'];    //上传 or 入库

    require_once("./UploadController.php");
    $obj_upload = new UploadController();

    //根据action分配任务
    if( $action == 'upload' ){
        //上传
        $file = $_FILES['img'];            //接收图片信息
        $p_type = $_POST['p_type']; //接收图片类型
        $dir_path = '../uploads';   //定义上传根
        $res = $obj_upload->uploadImg(  $file , $dir_path , $p_type );
        returnVal( $res );  //返回图片url

    }elseif( $action == 'add' ){
        //入库
        $data = $_POST; //接收入库数据
        var_dump($_POST);
        $res = $obj_upload->addImg( $data );
        returnVal( $res );  //返回
    }else{
        //违法行为
        returnVal(false);
    }




    /**
     * 返回处理
     */
    function returnVal( $res ){
      $arr['result'] = $res;
      $arr['status'] = is_array($res)  ? 'succ' : 'fail';
      echo json_encode($arr);
    }


<?php
include_once('./UploadModel.php');
class UploadController {

  private $M_upload;  //model

  private $allow = array('image/gif','image/jpg','image/jpeg','image/png','image/pjpeg');   //ok format

  private $error =0;
  private $error_msg = array(
    '1'=>'文件超过服务器允许的大小',
    '2'=>'文件超过浏览器允许的大小',
    '3'=>'文件因为网络问题上传不完整',
    '4'=>'没有选择文件上传',
    '5'=>'文件类型错误',
    '6'=>'找不到临时文件夹。',
    '7'=>'System busing!'       //system error , should write into log
    );

    private $type = array(
      '1'=>'shouye',
      '2'=>'xinwen',
      '3'=>'zuopin',
      '4'=>'kepian',
      '5'=>'lifu'
      );

  public function test (){
    echo 123;
    var_dump($this->M_upload);
  }

public function __construct(){
  $this->M_upload = new UploadModel();
}








/**
 * 上传图片
 */
public function uploadImg(  $file_data , $dir_path = '../uploads'  , $p_type ) {
    //检验
    if( !$file_data || !is_array( $file_data )  || !isset( $file_data['error'] ) ) return false;
    if( $this->_check( $file_data ) )   return  $this->error_msg[ $this->error ];

    //创建文件夹
    $dir_path = $dir_path."/".$this->type["$p_type"].'/'.date('Ymd');
    if( !is_dir($dir_path) ) mkdir($dir_path);  

    //图片路径(含文件名)
    $file_path = $dir_path.'/'.$this->_rename( $file_data['name'] );  

    //保存图片
    if ( move_uploaded_file($file_data['tmp_name'], $file_path) ){  

        $data['p_type'] = $p_type;
        $data['img_url'] = trim(stristr($file_path,'/'),'/');
        return $data;

    }else{
        return false;
    }
    // if( in_array( 'sub', array_keys($file_data) ) ){

    //   var_dump($file_data);die;
    //     return $this->uploadImgSub(  $file_data , $dir_path = '../uploads'  , $p_type );
    // }else{
    //    return $this->uploadImgMain(  $file_data['main'] , $dir_path = '../uploads'  , $p_type );
    // }
  }

  /**
   * 图片入库
   */
  public function addImg( $data ){

    if( in_array('sub', array_keys($data)) ){
      //有子图片
      $data['main']['add_time'] = time();
      $main_id = $this->M_upload->add_main( $data['main'] ); //入主图,返回id

      foreach($data['sub'] as $k=>$v){  //根据主图id,入子图
        $v['add_time'] = time();
        $v['main_img_id'] = $main_id;
        $res = $this->M_upload->add_sub( $v );
      }

      return $res ? $res : false;

    }else{
      //没有子图片
      $data['main']['add_time'] = time();
      $res = $this->M_upload->add_main( $data['main'] );
      return $res ? $res : false;
    }

  }


  /**
   * 上传主图
   * @return 返回图片路径&&类型
   */
  // public function uploadImgMain(  $file_data , $dir_path = '../uploads'  , $p_type ) {


  // }
  

  // /**
  //  * 上传子图
  //  */
  // public function uploadImgSub( $file_data , $dir_path = '../uploads'  , $p_type , $main_id ){
  //     if( !$main_id ) return false;
      
  // }

  // array(
  //   'main'=>array{'p_type'=>'1','img_url'=>'/1/1/1.jpg'},
  //   'sub'=>array(
  //     array('p_type'=>'1','img_url'=>'/2/2/2.jpg'),
  //     array('p_type'=>'1','img_url'=>'/3/3/3.jpg'),
  //     array('p_type'=>'1','img_url'=>'/4/4/4.jpg'),
  //     array('p_type'=>'1','img_url'=>'/5/5/5.jpg')
  //     )
  //   )

  // {
  //   'main':{'p_type':1,'img_url':'/1/1/1.jpg'},
  //   'sub':[
  //     {'p_type':1,'img_url':'/2/2/2.jpg'},
  //     {'p_type':1,'img_url':'/3/3/3.jpg'},
  //     {'p_type':1,'img_url':'/4/4/4.jpg'}
  //   ]
  // }









  /**
   * 检验数据
   */
  private function _check ( $file_data ) {

    if( $file_data['error'] !== 0)  $this->error = $file_data['error'];   //check error

    if( !in_array($file_data['type'],$this->allow) ) $this->error = 5;      //check format

    return $this->error;

  }









  /**
   * 图片重命名
   */
  private function _rename ( $filename ) {
      //获取文件后缀名
      $ext = strrchr($filename,'.');

      //生成文件名字
      $name = '';
      $name .= date('YmdHis');

      //随机字符串
      // $str = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ123456789';

      // //随机6次
      // for($i = 0;$i < 6;$i++){
      //   //使用字符串数组形式获取单个字符
      //   $name .= $str[mt_rand(0,strlen($str) - 1)];
      // }

      //返回一个全名
      return $name . $ext;
  }


}

<?php
class UploadModel {

  private $main_tbl = 'main_img_tbl', //主图表
          $sub_tbl   = 'sub_img_tbl'; //子图表

  public function __construct(){

    //$this->conn = mysql_connect('127.0.0.1','root','root');
    //mysql_set_charset('utf8', $this->conn);
    //mysql_select_db( 'upload' , $this->conn );

    $this->pdo = new PDO('mysql:host=localhost;port=3306;dbname=upload','root','');
    $this->db_exec("set names utf8");

  }




  /**
   * 新增主图片
   */
  public function add_main( $data ){

      $fields = implode(",",array_keys($data)); //字段
      $val = "'".implode("','",array_values($data))."'";  //对应值

      $sql = "insert into {$this->main_tbl} ({$fields}) values ({$val})";
      $res = $this->db_exec( $sql );  //入库
      return  $res ? $res : false;
  }


  /**
   * 新增子图片
   */
  public function add_sub( $data ){

      $fields = implode(",",array_keys($data)); //字段
      $val = "'".implode("','",array_values($data))."'";  //对应值

      $sql = "insert into {$this->sub_tbl} ({$fields}) values ({$val})";
      $res = $this->db_exec( $sql );  //入库
      return  $res ? $res : false;
  }


    /**
     * exec写操作
     * @param1 string $sql
     * @return 返回受影响的行数
     */
    private function db_exec($sql){
      $res = $this->pdo->exec($sql);

      //判断结果
      // if($res === false){
      //   //语法错误
      //   echo 'SQL语句执行出错<br/>';
      //   echo '错误代码是：' . $this->pdo->errorCode() . '<br/>';
      //   echo '错误信息是：' . $this->pdo->errorInfo()[2] . '<br/>';
      //   exit;
      // }

      //没有错
      return $res;
    }

}

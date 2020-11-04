<?php
/*
 * ファイルパス：/Applications/MAMP/htdocs/DT/shopping/lib/Login.class.php
 * ファイル名：Login.class.php (セッション関係のクラスファイル、Model)
 * セッション：サーバー側に一時的にデータを保存する仕組みのこと
 * 基本的に、keyで判断をして、IDを取るというのが流れ
 */
namespace shopping\lib;

// セッションをスタートする
session_start();

class Login
{

    public $session_key = '';
    public $db = NULL;

    public function __construct($db)
    {
        // DBの登録
        $this->db = $db;
    }

    public function get_userdata($data)
    {
        $table = ' member ';
        $col = ' mem_id,family_name,first_name,email, CONCAT( zip1,"-",zip2 ) ,address ';
        $where = ' email = ? AND password= ? ';
        $arrVal = [$data['email'],$data['password']];
        $res = $this->db->select($table, $col, $where, $arrVal);
        return $res;        
    }

}

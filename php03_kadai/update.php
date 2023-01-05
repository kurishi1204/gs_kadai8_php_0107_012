<?php

//PHP:コード記述/修正の流れ
//1. insert.phpの処理をマルっとコピー。
//2. $id = $_POST["id"]を追加
//3. SQL修正
//   "UPDATE テーブル名 SET 変更したいカラムを並べる WHERE 条件"
//   bindValueにも「id」の項目を追加
//4. header関数"Location"を「select.php」に変更


//1. POSTデータ取得
$id = $_POST['id'];
$bookname = $_POST['bookname'];
$bookurl = $_POST['bookurl'];
$content = $_POST['content'];

//2. DB接続します
//*** function化する！  *****************
require_once('funcs.php'); //1回呼び出し
$pdo = db_conn();

//３．データ登録SQL作成
$stmt = $pdo->prepare(
    'UPDATE gs_bm_table 
        SET
            bookname = :bookname, 
            bookurl = :bookurl, 
            content = :content, 
            indate = sysdate()
        WHERE 
            id = :id;
    '
);

// 数値の場合 PDO::PARAM_INT
// 文字の場合 PDO::PARAM_STR
$stmt->bindValue(':bookname', $bookname, PDO::PARAM_STR);
$stmt->bindValue(':bookurl', $bookurl, PDO::PARAM_STR);
$stmt->bindValue(':content', $content, PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_INT); //PARAM_INTなので注意
$status = $stmt->execute(); //実行

//４．データ登録処理後
if ($status === false) {
    //*** function化する！******\
    $error = $stmt->errorInfo();
    exit('SQLError:' . print_r($error, true));
} else {
    //*** function化する！*****************
    header('Location: select.php');
    exit();
}

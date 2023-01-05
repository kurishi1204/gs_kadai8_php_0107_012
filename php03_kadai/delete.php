<?php

$id   = $_GET['id'];

//2. DB接続します
//*** function化する！  *****************

require_once('funcs.php'); //1回呼び出し
$pdo = db_conn();

//３．データ登録SQL作成
$stmt = $pdo->prepare(
    'DELETE FROM gs_bm_table
        WHERE
        id = :id
    '
);
$stmt->bindValue(':id', $id, PDO::PARAM_INT); //PARAM_INTなので注意
$status = $stmt->execute(); //実行

//４．データ登録処理後、ここはdselectに飛ぶ形なので関数を複数作る必要ありなので注意。
require_once('funcs.php'); //1回呼び出し
$status = db_stat();

// if ($status === false) {
//     //*** function化する！******\
//     $error = $stmt->errorInfo();
//     exit('SQLError:' . print_r($error, true));
// } else {
//     //*** function化する！*****************
//     header('Location: select.php');
//     exit();
// }

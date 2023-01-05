<?php

/**
 * 1. index.phpのフォームの部分がおかしいので、ここを書き換えて、
 * insert.phpにPOSTでデータが飛ぶようにしてください。
 * 2. insert.phpで値を受け取ってください。
 * 3. 受け取ったデータをバインド変数に与えてください。
 * 4. index.phpフォームに書き込み、送信を行ってみて、実際にPhpMyAdminを確認してみてください！
 */

//1. POSTデータ取得
$bookname = $_POST['bookname'];
$bookurl = $_POST['bookurl'];
$content = $_POST['content'];


//2. DB接続します、try catchは挑戦してみてダメだったら例外的にこれやってねというもの。
// try {
//   //ID:'root', Password: xamppは 空白 '' xamppのデフォルト設定がrootでパスは空白とのこと。
//   $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','');
// } catch (PDOException $e) {
//   exit('DBConnectError:'.$e->getMessage());
// }


require_once('funcs.php'); //1回呼び出し
$pdo = db_conn();

//３．データ登録SQL作成

// 1. SQL文を用意　insert文を作る
$stmt = $pdo->prepare("INSERT INTO 
                      gs_bm_table(id, bookname, bookurl, content, indate)
                      VALUES(NULL, :bookname, :bookurl, :content, sysdate())");

//  2. バインド変数を用意。フォーム入力内容をそのまま入れると、 DB削除文言などを入れて悪さされる可能性あるので必要なもの。
// Integer 数値の場合 PDO::PARAM_INT
// String文字列の場合 PDO::PARAM_STR
// SQLインジェクション攻撃を避けるための処理。

$stmt->bindValue(':bookname', $bookname, PDO::PARAM_STR);
$stmt->bindValue(':bookurl', $bookurl, PDO::PARAM_STR);
$stmt->bindValue(':content', $content, PDO::PARAM_STR);

//  3. 実行
$status = $stmt->execute();

//４．データ登録処理後
if($status === false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit('ErrorMessage:'.$error[2]);
}else{
  //５．index.phpへリダイレクト
  header('Location: select.php');

}
?>

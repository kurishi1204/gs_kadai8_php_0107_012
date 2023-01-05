<?php
//1.  DB接続します
require_once('funcs.php'); //1回呼び出し
$pdo = db_conn();

//２．データ取得SQL作成
$stmt = $pdo->prepare("SELECT * FROM gs_bm_table;");
$status = $stmt->execute();

//３．データ表示
$view="";
if ($status==false) {
    //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);

}else{
  //Selectデータの数だけ自動でループしてくれる
  //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
  //データから一行取ってくる処理：$stmt->fetch(PDO::FETCH_ASSOC。これを繰り返す。
  //resultの中に DB取得情報が格納されている。
  //.=の.がないとReslutに何度も上書きするだけになる。よって＝だけだとデータの最後が表示される。.があることで追加で処理になる。
  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
    // $view .= '<p>' .  $result['id'] . ' / ' . h($result['書籍名']) . ' / ' . h($result['書籍URL']) . ' / ' . h($result['書籍コメント']) . ' / ' . h($result['登録日時']) . '</p>';
    $view .= '<p>';
    $view .= '<a href="detail.php?id=' . $result['id'] . '">';
    $view .= $result['indate'] . '：' . $result['bookname'];
    $view .= '</a>';

    $view .= '<a href="delete.php?id=' . $result['id'] . '">';
    $view .= '[ 削除 ]';
    $view .= '</a>';

    $view .= '</p>';

  }
}
?>



<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>ブックマーク表示</title>
<link rel="stylesheet" href="css/range.css">
<link href="css/bootstrap.min.css" rel="stylesheet">
<style>div{padding: 10px;font-size:16px;}</style>
</head>
<body id="main">
<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
      <a class="navbar-brand" href="index.php">データ登録</a>
      </div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<div>
    <div class="container jumbotron"><?= $view ?></div>
</div>
<!-- Main[End] -->

</body>
</html>

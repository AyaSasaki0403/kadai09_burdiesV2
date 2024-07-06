<?php

require_once('funcs.php');

$pdo = db_conn();

$id = $_GET['id'];

$stmt = $pdo->prepare('DELETE FROM favorites WHERE id = :id');
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

// エラーチェック
if ($status === false) {
    sql_error($stmt);
    // $error = $stmt->errorInfo();
    // exit('SQLError:' . print_r($error, true));
} else {
    redirect('favorite.php');
    // header('Location: favorite.php');
    // exit();
}

?>
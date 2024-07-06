<?php
require_once('funcs.php');
$pdo = db_conn();

// エラーレポートの設定
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo '<pre>';
    print_r($_POST);
    echo '</pre>';
} 


$visit_date = isset($_POST['visit_date']) ? $_POST['visit_date'] : '';
$place_type = isset($_POST['place_type']) ? $_POST['place_type'] : '';
$facility_name = isset($_POST['facility_name']) ? $_POST['facility_name'] : '';
$location = isset($_POST['location']) ? $_POST['location'] : '';
$slider1 = isset($_POST['slider1']) ? $_POST['slider1'] : '';
$slider2 = isset($_POST['slider2']) ? $_POST['slider2'] : '';
$slider3 = isset($_POST['slider3']) ? $_POST['slider3'] : '';
$slider4 = isset($_POST['slider4']) ? $_POST['slider4'] : '';
$slider5 = isset($_POST['slider5']) ? $_POST['slider5'] : '';
$slider6 = isset($_POST['slider6']) ? $_POST['slider6'] : '';
$slider7 = isset($_POST['slider7']) ? $_POST['slider7'] : '';
$slider8 = isset($_POST['slider8']) ? $_POST['slider8'] : '';
$slider9 = isset($_POST['slider9']) ? $_POST['slider9'] : '';
$slider10 = isset($_POST['slider10']) ? $_POST['slider10'] : '';
$free_text = isset($_POST['free_text']) ? $_POST['free_text'] : '';
$id = isset($_POST['id']) ? $_POST['id'] : '';

// ファイルのアップロード処理
$image_path = null;
if (isset($_FILES['imageUpload']) && $_FILES['imageUpload']['error'] == 0) {
    $upload_dir = 'uploads/';
    $image_path = $upload_dir . basename($_FILES['imageUpload']['name']);
    if (!move_uploaded_file($_FILES['imageUpload']['tmp_name'], $image_path)) {
        exit('File upload failed');
    }
} else {
    // 既存の画像パスを保持
    $image_path = isset($_POST['image_path']) ? $_POST['image_path'] : '';
}

try {
 
    // 全ての投稿を取得
    $stmt = $pdo->prepare('UPDATE favorites
    SET visit_date = :visit_date,
        place_type = :place_type,
        facility_name = :facility_name,
        location = :location,
        slider1 = :slider1,
        slider2 = :slider2,
        slider3 = :slider3,
        slider4 = :slider4,
        slider5 = :slider5,
        slider6 = :slider6,
        slider7 = :slider7,
        slider8 = :slider8,
        slider9 = :slider9,
        slider10 = :slider10,
        free_text = :free_text,
        image_path = :image_path
    WHERE id = :id;');

$stmt->bindValue(':visit_date', $visit_date, PDO::PARAM_STR);
$stmt->bindValue(':place_type', $place_type, PDO::PARAM_STR);
$stmt->bindValue(':facility_name', $facility_name, PDO::PARAM_STR);
$stmt->bindValue(':location', $location, PDO::PARAM_STR);
$stmt->bindValue(':slider1', $slider1, PDO::PARAM_INT);
$stmt->bindValue(':slider2', $slider2, PDO::PARAM_INT);
$stmt->bindValue(':slider3', $slider3, PDO::PARAM_INT);
$stmt->bindValue(':slider4', $slider4, PDO::PARAM_INT);
$stmt->bindValue(':slider5', $slider5, PDO::PARAM_INT);
$stmt->bindValue(':slider6', $slider6, PDO::PARAM_INT);
$stmt->bindValue(':slider7', $slider7, PDO::PARAM_INT);
$stmt->bindValue(':slider8', $slider8, PDO::PARAM_INT);
$stmt->bindValue(':slider9', $slider9, PDO::PARAM_INT);
$stmt->bindValue(':slider10', $slider10, PDO::PARAM_INT);
$stmt->bindValue(':free_text', $free_text, PDO::PARAM_STR);
$stmt->bindValue(':image_path', $image_path, PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);

$status = $stmt->execute();

// エラーチェック
if ($status === false) {
    sql_error($stmt);
    // $error = $stmt->errorInfo();
    // exit('SQLError:' . print_r($error, true));
} else {
    header('Location: favorite.php');
    exit();
}
} catch (PDOException $e) {
    echo 'Database Error:' . $e->getMessage();
    exit;
}

?>
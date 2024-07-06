<?php
require_once('funcs.php');
$pdo = db_conn();

// エラーレポートの設定
error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
ini_set('display_errors', 1);

// Post data取得
$visit_date = !empty($_POST['visit_date']) ? $_POST['visit_date'] : date('Y-m-d'); // デフォルト値を設定
$place_type = !empty($_POST['place_type']) ? $_POST['place_type'] : null;
$facility_name = !empty($_POST['facility_name']) ? $_POST['facility_name'] : null;
$location = !empty($_POST['location']) ? $_POST['location'] : null;
$slider1 = (int)($_POST['slider1'] ?? 0);
$slider2 = (int)($_POST['slider2'] ?? 0);
$slider3 = (int)($_POST['slider3'] ?? 0);
$slider4 = (int)($_POST['slider4'] ?? 0);
$slider5 = (int)($_POST['slider5'] ?? 0);
$slider6 = (int)($_POST['slider6'] ?? 0);
$slider7 = (int)($_POST['slider7'] ?? 0);
$slider8 = (int)($_POST['slider8'] ?? 0);
$slider9 = (int)($_POST['slider9'] ?? 0);
$slider10 = (int)($_POST['slider10'] ?? 0);
$free_text = !empty($_POST['free_text']) ? $_POST['free_text'] : null;

// 画像アップロードの処理
$image_path = null;
if (isset($_FILES['imageUpload']) && $_FILES['imageUpload']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = __DIR__ . '/uploads/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    $uploadFile = $uploadDir . basename($_FILES['imageUpload']['name']);
    if (move_uploaded_file($_FILES['imageUpload']['tmp_name'], $uploadFile)) {
        $image_path = 'uploads/' . basename($_FILES['imageUpload']['name']);
    } else {
        exit('ファイルの移動に失敗しました。');
    }
}

// SQL文を用事
try{
   $stmt = $pdo->prepare('INSERT INTO favorites (
visit_date, place_type, facility_name, location, slider1, slider2, slider3, slider4, slider5, slider6, slider7, slider8, slider9, slider10, free_text, image_path
) VALUES (
 :visit_date, :place_type, :facility_name, :location, :slider1, :slider2, :slider3, :slider4, :slider5, :slider6, :slider7, :slider8, :slider9, :slider10, :free_text, :image_path
)');
   $stmt->execute([
    ':visit_date' => $visit_date,
    ':place_type' => $place_type,
    ':facility_name' => $facility_name,
    ':location' => $location,
    ':slider1' => $slider1,
    ':slider2' => $slider2,
    ':slider3' => $slider3,
    ':slider4' => $slider4,
    ':slider5' => $slider5,
    ':slider6' => $slider6,
    ':slider7'=> $slider7,
    ':slider8' => $slider8,
    ':slider9' => $slider9,
    ':slider10' => $slider10,
    ':free_text' => $free_text,
    ':image_path' => $image_path,
   ]);
} catch (PDOException $e) {
    exit('データベースへの保存に失敗しました: ' . $e->getMessage());
}

// favorite.php にリダイレクト
header('Location: favorite.php');
exit;

?>
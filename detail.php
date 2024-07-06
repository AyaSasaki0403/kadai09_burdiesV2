<?php
require_once('funcs.php');
$pdo = db_conn();

// エラーレポートの設定
error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
ini_set('display_errors', 1);

// favorite.phpのphpパートを全てコピペする
// getを使ってデータを取得する

$id = $_GET['id'];
 
// :idは受け皿のようなもの。ダイレクトに$idを入れるのは危険
$stmt = $pdo->prepare('SELECT * FROM favorites WHERE id = :id');
// :idに$idを入れるという意味
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
// ↑で、データベースからidに基づいてデータ取得ができる
$status = $stmt->execute();

$view='';
if ($status === false) {
    sql_error($stmt);
    // $error = $stmt->errorInfo();
    // exit('SQLError:' . print_r($error, true));
} else {
    $favorite = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Burdies Questions</title>
    <link rel="stylesheet" href="css/style.css">

    <style>
        .custom-file-input {
            position: relative;
            display: inline-block;
            width: 300px;
            height: 40px;
            margin: 10px 0;
            cursor: pointer;
        }

        .custom-file-input input[type="file"] {
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        .custom-file-input::before {
            content: '画像を変更する';
            display: inline-block;
            /* width: 200px;
            height: 40px; */
            width: 100%;
            height: 100%;
            background: #007bff;
            color: white;
            text-align: center;
            line-height: 40px;
            border-radius: 5px;
            cursor: pointer;
        }

        .custom-file-input input[type="file"]:hover + .custom-file-input::before {
            background-color: #0056b3;
        }

        .custom-file-input input[type="file"]:active + .custom-file-input::before {
            background-color: #004080;
        }
    </style>

</head>


<body>
<div id="favPost">修正ページ</div>

<div class = "favorite-container">

    <form id="favorite" action="update.php" method="post" enctype="multipart/form-data">
        <!-- 追加した箇所 -->
    <input type="hidden" name="id" value="<?= htmlspecialchars($favorite['id']) ?>">


               <div class="form-group inline">
                <label for="visit_date">訪問日</label>
                <input type="date" name="visit_date" value="<?= htmlspecialchars($favorite['visit_date']) ?>" id="visit_date">
            </div>

            <div class="form-group inline">
                <label for="place_type">行った場所</label>
                <select name="place_type" id="place_type">
                    <option value="restaurant" <?= $favorite['place_type'] == 'restaurant' ? 'selected' : '' ?>>飲食店</option>
                    <option value="shop" <?= $favorite['place_type'] == 'shop' ? 'selected' : '' ?>>ショップ</option>
                    <option value="sightseeing" <?= $favorite['place_type'] == 'sightseeing' ? 'selected' : '' ?>>観光地</option>
                </select>
            </div>

            <div class="form-group inline">
                <label for="facility_name">場所の名前</label>
                <input type="text" name="facility_name" id="facility_name" value="<?= htmlspecialchars($favorite['facility_name']) ?>">
            </div>

            <div class="form-group inline">
                <label for="location">所在地</label>
                <input type="text" name="location" id="location" alue="<?= htmlspecialchars($favorite['location']) ?>">
            </div>

            <div id="measure_box">項目別満足度</div>
            <div class="form-group inline">
                <label for="slider1">1. 価格</label>
                <input type="range" name="slider1" value="<?= htmlspecialchars($favorite['slider1']) ?>" id="slider1" min="0" max="100" step="10">
            </div>
            <div class="form-group inline">
                <label for="slider2">2. 料理の味付け</label>
                <input type="range" name="slider2" value="<?= htmlspecialchars($favorite['slider2']) ?>" id="slider2" min="0" max="100" step="10">
            </div>
            <div class="form-group inline">
                <label for="slider3">3. 料理の見栄え</label>
                <input type="range" name="slider3" value="<?= htmlspecialchars($favorite['slider3']) ?>" id="slider3" min="0" max="100" step="10">
            </div>
            <div class="form-group inline">
                <label for="slider4">4. 料理のオリジナリティ</label>
                <input type="range" name="slider4" value="<?= htmlspecialchars($favorite['slider4']) ?>" id="slider4" min="0" max="100" step="10">
            </div>
            <div class="form-group inline">
                <label for="slider5">5. ドリンクの味</label>
                <input type="range" name="slider5" value="<?= htmlspecialchars($favorite['slider5']) ?>" id="slider5" min="0" max="100" step="10">
            </div>
            <div class="form-group inline">
                <label for="slider6">6. ドリンクの見栄え</label>
                <input type="range" name="slider6" value="<?= htmlspecialchars($favorite['slider6']) ?>" id="slider6" min="0" max="100" step="10">
            </div>
            <div class="form-group inline">
                <label for="slider7">7. ドリンクのオリジナリティ</label>
                <input type="range" name="slider7" value="<?= htmlspecialchars($favorite['slider7']) ?>" id="slider7" min="0" max="100" step="10">
            </div>
            <div class="form-group inline">
                <label for="slider8">8. 店舗の外観</label>
                <input type="range" name="slider8" value="<?= htmlspecialchars($favorite['slider8']) ?>" id="slider8" min="0" max="100" step="10">
            </div>
            <div class="form-group inline">
                <label for="slider9">9. 店内の雰囲気</label>
                <input type="range" name="slider9" value="<?= htmlspecialchars($favorite['slider9']) ?>" id="slider9" min="0" max="100" step="10">
            </div>
            <div class="form-group inline">
                <label for="slider10">10. スタッフの対応</label>
                <input type="range" name="slider10" value="<?= htmlspecialchars($favorite['slider10']) ?>" id="slider10" min="0" max="100" step="10">
            </div>

            <div class="form-group inline">
                <label for="free_text">最も「好き」だった点は？</label>
                <input type="text" name="free_text" id="free_text" value="<?= htmlspecialchars($favorite['free_text']) ?>">
            </div>

            <div class="upload-container">
                <label for="imageUpload">画像を変更する</label>
                <div class="custom-file-input">
                    <input type="file" id="imageUpload" name="imageUpload">
            </div>
                <?php if (!empty($favorite['image_path'])): ?>
                    <img src="<?= htmlspecialchars($favorite['image_path']) ?>" alt="アップロードされた画像" class="favorite-image">

                    <input type="hidden" name="image_path" value="<?= htmlspecialchars($favorite['image_path']) ?>">

                <?php endif; ?>
            </div>

            <div id="imagePreview" style="display: none;"></div>
            </div>
        
            <!-- update.phpへ送る&idは編集できないようにする -->
            <input type="hidden" name="id" value="<?= $favorite['id'] ?>">


            <div class="button-container">
            <button type="submit" id="register">内容を修正する</button>
        </div>
    </form>
</div>    

<script src="script.js"></script>
</body>

</html>
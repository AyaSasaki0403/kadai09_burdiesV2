<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>お気に入りの投稿結果</title>
    <link rel="stylesheet" href="css/favorite.css">
</head>


<body>
    <h1>お気に入りの投稿結果</h1>

    <div class="result-container">
        <?php
        require_once('funcs.php');

        error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
        ini_set('display_errors', 1);

        $pdo = db_conn();

        // 全ての投稿を取得
        $stmt = $pdo->query('SELECT * FROM favorites ORDER BY id DESC');
        $status = $stmt->execute();

        $view='';
        if ($status === false) {
            sql_error($stmt);
            // $error = $stmt->errorInfo();
            // exit('SQLError:' . print_r($error, true));
        } else {
            while ($favorite = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $view .= '<a href="detail.php?id='. $favorite['id'] .'" class="favorite-item">';
                $view .= '<p><strong>訪問日:</strong> ' . htmlspecialchars($favorite['visit_date']) . '</p>';
                $view .= '<p><strong>行った場所:</strong> ' . htmlspecialchars($favorite['place_type']) . '</p>';
                $view .= '<p><strong>場所の名前:</strong> ' . htmlspecialchars($favorite['facility_name']) . '</p>';
                $view .= '<p><strong>所在地:</strong> ' . htmlspecialchars($favorite['location']) . '</p>';
                $view .= '<p><strong>価格:</strong> ' . htmlspecialchars($favorite['slider1']) . '</p>';
                $view .= '<p><strong>料理の味付け:</strong> ' . htmlspecialchars($favorite['slider2']) . '</p>';
                $view .= '<p><strong>料理の見栄え:</strong> ' . htmlspecialchars($favorite['slider3']) . '</p>';
                $view .= '<p><strong>料理のオリジナリティ:</strong> ' . htmlspecialchars($favorite['slider4']) . '</p>';
                $view .= '<p><strong>ドリンクの味:</strong> ' . htmlspecialchars($favorite['slider5']) . '</p>';
                $view .= '<p><strong>ドリンクの見栄え:</strong> ' . htmlspecialchars($favorite['slider6']) . '</p>';
                $view .= '<p><strong>ドリンクのオリジナリティ:</strong> ' . htmlspecialchars($favorite['slider7']) . '</p>';
                $view .= '<p><strong>店舗の外観:</strong> ' . htmlspecialchars($favorite['slider8']) . '</p>';
                $view .= '<p><strong>店内の雰囲気:</strong> ' . htmlspecialchars($favorite['slider9']) . '</p>';
                $view .= '<p><strong>スタッフの対応:</strong> ' . htmlspecialchars($favorite['slider10']) . '</p>';
                $view .= '<p><strong>最も「好き」だった点:</strong> ' . htmlspecialchars($favorite['free_text']) . '</p>';

                // 画像アップロードが成功した場合、画像を表示
                if ($favorite['image_path']) {
                    $view .= "<p>投稿画像:</p>";
                    $view .= "<img src='" . htmlspecialchars($favorite['image_path']) . "' alt='アップロードされた画像' class='favorite-image'>";
                }
                $view .= '</a>';

                $view .= '<a href="delete.php?id=' . $favorite['id'] . '">';
                $view .= '[削除]';
                $view .= '</a>';

            }
            echo $view;
        }
        ?>
    </div>
</body>
</html>
<?PHP

session_start();
header('X-FRAME-OPTIONS:DENY');
date_default_timezone_set('Asia/Tokyo');


// ページの切り替え
$pageFlag = 0;

if (!empty($_POST['btn_confirm'])){
    $pageFlag = 1;
}

if (!empty($_POST['btn_send'])){
    $pageFlag = 2;
}

// if(!empty($_POST)){
//     echo '<pre>';
//     // var_dump($_POST);
//     json_encode($_POST);
//     echo '</pre>';
// }


// HTMLSPECIALCHARS
function h($str)
{
	return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>お問い合わせ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
</head>
<body>

    <!-- お問い合わせ画面 -->
    <?PHP if ($pageFlag === 0): ?>
    <?php
    if(!isset($_SESSION['csrfToken'])){
    $csrfToken = bin2hex(random_bytes(32));
    $_SESSION['csrfToken'] = $csrfToken;
    }
    $token = $_SESSION['csrfToken'];
    ?>
    <h3><a href="index.html" class="text-decoration-none text-body" >FlowToStock</a></h3>
    <a href="admin.php" class="text-center  text-decoration-none text-body float-end me-5">管理者画面</a>               
    <div class="container">
        <div class="row">
            <h3 class="p-10 mt-5 text-center" >お問い合わせフォーム</h3> 
            <form action="support.php" method="POST" class="form-group">
                <label class="fw-bold mb-3" for="username">お名前</label>
                <input type="text" name="username"class="mb-3 form-control" value="<?PHP if(!empty($_POST['username'])){echo h($_POST['username']);} ?>">
                <label class="fw-bold mb-3" for="email">Email</label>
                <input type="email" name="email" class="mb-3 form-control" value="<?PHP if(!empty($_POST['email'])){echo h($_POST['email']);} ?>">   
                <label class="fw-bold mb-3" for="question">内容</label> 
                <textarea name="question" class="mb-3 form-control" rows="10"><?PHP if(!empty($_POST['question'])){echo h($_POST['question']);} ?></textarea>
                <input type="submit" name="btn_confirm" class="btn btn-primary mb-3" value="Confirm">
                <input type="hidden" name="csrf" value="<?PHP echo $token; ?>">
            </form>
        </div>
    </div>
    <?PHP endif; ?>

    <!-- お問い合わせ内容確認画面 -->
    <?PHP if ($pageFlag === 1): ?>
    <?php if($_POST['csrf'] === $_SESSION['csrfToken']) :?>    
        <div class="container">
        <h3 class="p-10 text-center" >お問い合わせ 確認画面</h3>    
        <form action="support.php" method="POST" class="form-group">
            <p class="fw-bold mb-3">お名前</p>
            <?PHP echo '<p>'.h($_POST['username']).'</p>'; ?>
            <p class="fw-bold mb-3">Email</p>
            <?PHP echo '<p>'.h($_POST['email']).'</p>'; ?>
            <p class="fw-bold mb-3">内容</p> 
            <textarea name="question" class="mb-3 bg-light form-control" rows="10" readonly><?PHP echo h($_POST['question']); ?></textarea>
            <input type="submit" name="btn_back" class="btn btn-secondary mb-3" value="Back">
            <input type="submit" name="btn_send" class="btn btn-primary mb-3 ms-3" value="Send">
            <input type="hidden" name="username" value="<?PHP echo $_POST['username']; ?>">
            <input type="hidden" name="email" value="<?PHP echo $_POST['email']; ?>">   
            <input type="hidden" name="csrf" value="<?PHP echo $_POST['csrf']; ?>">   
            <input type="hidden" name="sendtime" value="<?PHP echo date("Y-m-d H:i");?>">
       
        </form>
    </div>

    <?PHP endif; ?>
    <?PHP endif; ?>

    <!-- お問い合わせ完了画面 -->
    <?PHP if ($pageFlag === 2): ?>
    <?php if($_POST['csrf'] === $_SESSION['csrfToken']) :?>
    <?PHP 
    // 問い合わせ内容の書き込み JSONは諦めた
    // $str = json_encode($_POST).PHP_EOL;
    // // $file = fopen('./data/data.txt','a');
    // $file = fopen('./data/data.txt','a');
    // fwrite($file, $str);
    // fclose($file);
    // 問い合わせ内容の書き込み カンマ区切り
    $sendtime = $_POST['sendtime'];
    $username = $_POST['username'];
    $email = h($_POST['email']);    
    $question = nl2br($_POST['question']);

    $str = $sendtime.','.$username.','.$email.','.$question.PHP_EOL;
    $file = fopen('./data/data.txt','a');
    fwrite($file, $str);
    fclose($file);
    
    ?>
    <div class="container">
        <div class="row">
            <h6 class="p-5">お問い合わせが完了しました。
            弊社サポートからのご連絡をお待ちください。
            </h6>
            <a href="index.html" class="text-center text-body">メイン画面に戻る</a>
        </div>
    </div>

    <?php 
    unset($_SESSION['csrfToken']);
    ?>        
    <?PHP endif; ?>
    <?PHP endif; ?>

    <!-- <footer>
        <div class="container bg-secondary  text-white py-5 ">
            <div class="row">
                <a href="admin.php" class="text-center  text-decoration-none text-body">管理者画面</a>
            </div>
        </div>
    </footer> -->

</body>
</html>
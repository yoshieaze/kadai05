<?php

$openFile = fopen('data/data.txt','r');
// var_dump($openFile);
$count = count(file('data/data.txt'));
// echo ($count);

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FileToStock サポート管理画面</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
</head>
<body>
    <header>
        <h3><a href="index.html" class="text-decoration-none text-body" >FlowToStock</a></h3>
    </header>
    <div class="container">
        <div class="row">
            <h4 class="mb-3 mt-3">お問い合わせ一覧</h4>
            <table class="table table-striped">
              <tr>
                <th scope="col" class="table-primary">SendDate</th>
                <th scope="col" class="table-primary">UserName</th>
                <th scope="col" class="table-primary">Email</th>
                <th scope="col" class="table-primary">Question</th>
             </tr>
    <?PHP 
     for ($i = 0; $i < $count ; $i++){
         $csv = fgets($openFile);
         $str = explode(",",$csv);
    
        //  echo ($str[0]);
     ?>
     <tr>
        <td><?PHP echo $str[0]; ?></td>
        <td><?PHP echo $str[1]; ?></td>
        <td><?PHP echo $str[2]; ?></td>
        <td><?PHP echo $str[3]; ?></td>
     </tr>
     <?PHP
     }
     fclose($openFile);
     ?>
    </table>

</body>
</html>

<?PHP

// ファイル内容を1行ずつ読み込んで出力

// while ($str = fgets($openFile)){
//     echo nl2br($str);
// } -->

// exit;
    

// foreach($contents_array as $contents_array1){
//     $contents_array1 = json_decode($contents_array1,true);
//     var_dump($contents_array1);
//     foreach ($contents_array1 as $key -> $value){
//         echo $key; 
//         // var_dump($support_array); 
//         //  echo '<li>'.$content.'<li>';    // $contents_array[$key] = rtrim($value,"\r");
//     }
// }



// echo $contents_array[0]['question'];

// $support_array = array(
//     'username' => $contents_array['username'],
//     'question' => $contents_array['question']
// );

// echo ($support_array["username"]);


// $jsoncontents = json_encode($contents_array,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
// $jsoncontents = mb_convert_encoding($jsoncontents,'UTF8','ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
// var_dump ($jsoncontents);


// ファイル内容を1行ずつ読み込んで出力
// while (
//     $str = fgets($openFile)){
//     // $jsoncontents = json_decode($str,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);    
//     // var_dump($jsoncontents);
//     echo nl2br($str);
// 




// $contents = fopen("data/data.txt");
// while($jsoncontents = fgets($contents)){
//         var_dump($jsoncontents);
//     }
// exit;
// $jsoncontents = mb_convert_encoding($jsoncontents,'UTF8','ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
// $array = json_decode($jsoncontents,true);
// var_dump($array);

// $contents = file('data/data.txt');
// var_dump($contents[0]);
// $jsoncontents = json_decode($contents[0], true);
// // echo '<br>';
// var_dump ($jsoncontents);
?>
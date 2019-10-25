<?php

/*
  var_dump($_POST);
  exit(); */

function sql($servername,$username,$password,$dbname,$sql) {



    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }


    $result = $conn->query($sql);

    $arr = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }
    }
    $conn->close();


    if (count($arr) > 0) {
        return $arr;
    }
    return false;
}





$to = 'info@art-blamo.ru';


$HTTP_HOST = $_SERVER['HTTP_HOST'];


if (is_file('../../../config.php')) {
    require_once('../../../config.php');
    $emails=sql(DB_HOSTNAME,DB_USERNAME,DB_PASSWORD,DB_DATABASE,"SELECT `email` FROM `oc_user` WHERE `user_id`=1 AND `user_group_id`=1");
    if ($emails!=false){
        $to = $emails[0]["email"];
        

    }
    
}





$subject = current($_POST['data']);


$message = 'url:' . $_POST['data']['url'] . '<br>' . '<br>';
foreach ($_POST['data'] as $value) {
    if (isset($value['title']) && isset($value['val']))
        $message .= $value['title'] . ':' . $value['val'] . '<br>';
}



$headers = "From: info@$HTTP_HOST" . "\r\n" .
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= "X-Mailer: PHP/" . phpversion();



$file = "";


$separator = "---"; // разделитель в письме
if ($file != '') {
    $bodyMail = "--$separator\n"; // начало тела письма, выводим разделитель
    $bodyMail .= "Content-Type:text/html; charset=\"utf-8\"\n"; // кодировка письма
    $bodyMail .= "Content-Transfer-Encoding: 7bit\n\n"; // задаем конвертацию письма
    $bodyMail .= $message . "\n"; // добавляем текст письма
    $bodyMail .= "--$separator\n";
    $fileRead = fopen($file, "r"); // открываем файл
    $contentFile = fread($fileRead, filesize($file)); // считываем его до конца
    fclose($fileRead); // закрываем файл
    $bodyMail .= "Content-Type: application/octet-stream; name==?utf-8?B?" . base64_encode(basename($file)) . "?=\n";
    $bodyMail .= "Content-Transfer-Encoding: base64\n"; // кодировка файла
    $bodyMail .= "Content-Disposition: attachment; filename==?utf-8?B?" . base64_encode(basename($file)) . "?=\n\n";
    $bodyMail .= chunk_split(base64_encode($contentFile)) . "\n"; // кодируем и прикрепляем файл
    $bodyMail .= "--" . $separator . "--\n";
    // письмо без вложения
} else {
    $bodyMail = $message;
}









if (mail($to, $subject, $bodyMail, $headers)) {

    echo json_encode(array(
        'result' => true
    ));
    exit();
}
?>
        



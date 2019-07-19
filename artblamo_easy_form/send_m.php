<?php
/*
var_dump($_POST);
exit();*/

$HTTP_HOST = $_SERVER['HTTP_HOST'];

$to = 'info@art-blamo.ru';
$to2 = 'project@art-blamo.ru';
$to3 = 'ssrezhepa@yandex.ru';

$subject = current($_POST['data']);


$message = 'url:' . $_POST['data']['url'] . '<br>' . '<br>';
foreach ($_POST['data'] as $value) {
    if (isset($value['title']) && isset($value['val']))
        $message .= $value['title'] . ':' . $value['val'] . '<br>';
}



$headers = "From: info@$HTTP_HOST" . "\r\n" .
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= "X-Mailer: PHP/" . phpversion();



$file="";


$separator = "---"; // разделитель в письме
if ($file!='') {
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
    mail($to2, $subject, $bodyMail, $headers);
    mail($to3, $subject, $bodyMail, $headers);
    echo json_encode(array(
        'result' => true
    ));
    exit();
}
?>
        



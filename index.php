<?php
// Функция для определения местоположения пользователя по IP-адресу
function getCountryByIP($ip) {
    $response = file_get_contents("https://ipwhois.app/json/$ip");
    $data = json_decode($response, true);
    return isset($data['country_code']) ? $data['country_code'] : null;
}

// Получаем IP-адрес пользователя
$ip = $_SERVER['REMOTE_ADDR'];

// Получаем код страны пользователя
$countryCode = getCountryByIP($ip);

// Читаем ссылки из файла links.txt
$links = file("links.txt", FILE_IGNORE_NEW_LINES);

// Если пользователь из России, редиректим на одну из первых трех ссылок случайным образом
if ($countryCode === "RU") {
    $randomIndex = array_rand($links, 3);
    $redirectUrl = $links[$randomIndex[array_rand($randomIndex)]];
} else {
    // Иначе редиректим на четвертую ссылку
    $redirectUrl = $links[3];
}

// Выполняем редирект на полученную ссылку
header("Location: $redirectUrl");
exit;
?>

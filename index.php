<?php
// Функция для отправки запроса к API сервиса ip.me и извлечения кода страны
function getCountryByIP($ip) {
    $url = "https://ip.me";
    $response = file_get_contents($url);
    preg_match('/Country Code: ([A-Z]+)/', $response, $matches);
    if (isset($matches[1])) {
        return $matches[1];
    } else {
        return null;
    }
}

// Получение IP-адреса пользователя
$ip = $_SERVER['REMOTE_ADDR'];

// Определение страны пользователя по IP-адресу
$country = getCountryByIP($ip);

// Если удалось получить код страны
if ($country) {
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
} else {
    // Если не удалось получить код страны, выводим сообщение об ошибке
    echo "Не удалось определить местоположение пользователя.";
}
?>

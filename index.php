<?php
// Получение ответа от сайта http://ipwho.is/
$response = file_get_contents('http://ipwho.is/');

// Поиск кода страны в ответе с помощью регулярного выражения
if (preg_match('/region_code: "(\w+)"/', $response, $matches)) {
    $countryCode = $matches[1]; // Полученный код страны
    echo $countryCode; // Вывод кода страны
} else {
    echo "Не удалось определить местоположение пользователя.";
}
?>

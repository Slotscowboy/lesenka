<?php
// Получение IP-адреса пользователя
$ip = $_SERVER['REMOTE_ADDR'];

// Отправка запроса к сервису ipinfo.io для получения информации о местоположении пользователя
$response = file_get_contents("https://ipinfo.io/$ip/json");
$data = json_decode($response, true);

// Получение кода страны
$countryCode = isset($data['country']) ? $data['country'] : null;

// Вывод кода страны
if ($countryCode) {
    echo $countryCode; // Вывод кода страны
} else {
    echo "Не удалось определить местоположение пользователя.";
}
?>

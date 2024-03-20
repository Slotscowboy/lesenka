<?php
// Функция для получения IP-адреса пользователя
function getUserIP() {
    // Проверяем, определен ли IP-адрес через прокси-сервер
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

// Получаем IP-адрес пользователя
$ip = getUserIP();

// Инициализация cURL-сессии
$ch = curl_init('http://ipwho.is/'.$ip);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, false);

// Выполнение запроса и получение ответа
$response = curl_exec($ch);

// Закрытие cURL-сессии
curl_close($ch);

// Преобразование ответа в формат JSON
$ipwhois = json_decode($response, true);

// Вывод кода страны
if (isset($ipwhois['country_code'])) {
    echo $ipwhois['country_code']; // Вывод кода страны
} else {
    echo "Не удалось определить местоположение пользователя.";
}
?>

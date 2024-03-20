<?php
// Читаем ссылки из файла links.txt
$links = file("links.txt", FILE_IGNORE_NEW_LINES);

// Получаем текущий индекс строки, на которую должен будет редиректиться пользователь
if (isset($_COOKIE['redirect_index'])) {
    $redirectIndex = $_COOKIE['redirect_index'];
    $redirectIndex = ($redirectIndex + 1) % count($links); // Следующая строка в кольцевом порядке
} else {
    $redirectIndex = 0; // Первая строка
}

// Устанавливаем cookie с индексом строки для следующего запроса
setcookie('redirect_index', $redirectIndex, time() + 3600); // Cookie сохраняется на 1 час

// Выполняем редирект на полученную ссылку
$redirectUrl = $links[$redirectIndex];
header("Location: $redirectUrl");
exit;
?>

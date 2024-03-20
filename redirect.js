window.onload = function() {
    // Читаем ссылки из файла links.txt
    fetch('links.txt')
        .then(response => response.text())
        .then(text => {
            const links = text.split('\n').filter(link => link.trim() !== '');
            // Получаем текущий индекс строки, на которую должен будет редиректиться пользователь
            let redirectIndex = localStorage.getItem('redirectIndex');
            redirectIndex = redirectIndex ? parseInt(redirectIndex) : 0;
            // Следующая строка в кольцевом порядке
            redirectIndex = (redirectIndex + 1) % links.length;
            // Сохраняем индекс для следующего раза
            localStorage.setItem('redirectIndex', redirectIndex);
            // Выполняем редирект на полученную ссылку
            window.location.href = links[redirectIndex];
        })
        .catch(error => console.error('Error fetching links:', error));
};

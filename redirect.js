window.onload = function() {
    // Функция для определения местоположения пользователя по IP-адресу
    function getCountryByIP() {
        return fetch('https://ipwhois.app/json/')
            .then(response => response.json())
            .then(data => data.country_code)
            .catch(error => {
                console.error('Error fetching country:', error);
                return null;
            });
    }

    // Читаем ссылки из файла links.txt
    fetch('links.txt')
        .then(response => response.text())
        .then(text => {
            const links = text.split('\n').filter(link => link.trim() !== '');
            // Получаем текущий индекс строки, на которую должен будет редиректиться пользователь
            let redirectIndex = localStorage.getItem('redirectIndex');
            redirectIndex = redirectIndex ? parseInt(redirectIndex) : -1; // Начинаем с -1, чтобы сразу увеличить на 1
            // Получаем код страны пользователя и решаем, должен ли произойти редирект
            getCountryByIP().then(countryCode => {
                if (countryCode === 'RU') {
                    // Если пользователь из России, то редиректим его на одну из четырех ссылок
                    redirectIndex = (redirectIndex + 1) % 4; // Следующая строка в кольцевом порядке для четырех ссылок
                } else {
                    // Если пользователь не из России, редиректим его на пятую ссылку
                    redirectIndex = 4;
                }
                // Сохраняем индекс для следующего раза
                localStorage.setItem('redirectIndex', redirectIndex);
                // Выполняем редирект на полученную ссылку
                window.location.href = links[redirectIndex];
            });
        })
        .catch(error => console.error('Error fetching links:', error));
};

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
            redirectIndex = redirectIndex ? parseInt(redirectIndex) : 0;
            // Получаем код страны пользователя и решаем, должен ли произойти редирект
            getCountryByIP().then(countryCode => {
                if (countryCode === 'RU') {
                    // Если пользователь из России, то редиректим его на одну из первых трех ссылок
                    redirectIndex = redirectIndex < 3 ? redirectIndex : 0; // Циклический переход
                } else {
                    // Если пользователь не из России, редиректим его всегда на четвертую ссылку
                    redirectIndex = 3;
                }
                // Сохраняем индекс для следующего раза
                localStorage.setItem('redirectIndex', redirectIndex);
                // Выполняем редирект на полученную ссылку
                window.location.href = links[redirectIndex];
            });
        })
        .catch(error => console.error('Error fetching links:', error));
};

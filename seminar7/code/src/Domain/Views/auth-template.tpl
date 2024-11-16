{% if not user_authorized %}
    <p><a href="/user/auth/">Вход в систему</a></p>
{% else %}
    <p>Добро пожаловать на сайт!</p>
<p><a href="/user/logout/">Выйти из системы</a></p>
{% endif %}
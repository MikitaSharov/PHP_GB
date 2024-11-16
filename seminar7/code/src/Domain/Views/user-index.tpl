<p>Список пользователей в хранилище</p>
<a href="/user/edit"></a>
<ul id="navigation">
    {% for user in users %}
        <li>{{ user.getUserName() }} {{ user.getUserLastName() }}. День рождения: {{ user.getUserBirthday() | date('d.m.Y') }}</li>
    {% endfor %}
</ul>
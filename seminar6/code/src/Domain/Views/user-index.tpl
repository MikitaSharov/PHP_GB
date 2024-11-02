<div class="content">
        <form action="/user/save/" method="get">
                Имя<input type="text" name="name" required>
                Фамилия<input type="text" name="lastname" required>
                День рождения<input type="date" name="birthday" required>
                <button type="submit">Добавить</button>
        </form>
        <hr>
        <p>Список пользователей в хранилище</p>

        {% if message %}
        <div class="info-success">
                <p>{{ message }}</p>
                <p class="close-info">close</p>
        </div>
        {% endif %}

        <ul id="navigation">
                {% for user in users %}
                        <li>
                                {{user.getUserId}}. {{ user.getUserName() }} {{user.getUserLastName}}.
                                День рождения: {{ user.getUserBirthday() | date('d.m.Y') }}
                                <a href="/user/delete/?id={{ user.getUserId() }}" class="delete-user"
                                   onclick="return confirm('Вы уверены, что хотите удалить этого пользователя?');">❌</a>
                                <a href="/user/update/?id={{ user.getUserId() }}" class="update-user">изменить</a>

                        </li>
                {% endfor %}
        </ul>
</div>
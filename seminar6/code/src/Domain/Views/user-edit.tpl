<div class="content">
    <h2>Редактирование пользователя</h2>
    <form action="/user/update/?id={{ user.getUserId }}" method="post">
        <label for="name">Имя:</label>
        <input type="text" id="name" name="name" value="{{ user.getUserName }}" required>

        <label for="lastname">Фамилия:</label>
        <input type="text" id="lastname" name="lastname" value="{{ user.getUserLastName }}" required>

        <label for="birthday">День рождения:</label>
        <input type="date" id="birthday" name="birthday" value="{{ user.getUserBirthday | date('Y-m-d') }}" required>

        <button type="submit">Сохранить изменения</button>
    </form>
    <a href="/user">Назад к списку пользователей</a>
</div>
<main class="content">
    <form action="/user/save/" method="get">
        Имя<input type="text" name="name" required>
        Фамилия<input type="text" name="lastname" required>
        День рождения<input type="date" name="birthday" required>
        <button type="submit">Добавить</button>
    </form>
    <hr>
    {{ message }}
</main>
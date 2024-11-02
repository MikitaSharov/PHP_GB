<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="/src/Domain/Views/style/style.css">

        <title>{{ title }}</title>
    </head>
    <body>
        {% include header %}
        <main class="main">
            {% include leftSidebar %}
            {% include content_template_name %}
        </main>
        {% include footer %}
    </body>
</html>
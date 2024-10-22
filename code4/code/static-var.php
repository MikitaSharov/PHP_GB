<?php

function my_function() {
    static $static_variable = 0;
    echo ++$static_variable; // значение увеличивается каждый раз, когда функция вызывается
}

for($i = 0; $i < 5; $i++){
    my_function();
}

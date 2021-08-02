<?php
/*
    Template Name: ByNextPr - User Actions AJAX
*/
?>
<?php
// обработка асинхронных запросов
if (isset($_POST)) {
    echo 'Ваш запрос: ';
    print_r($_POST);
} else {
    echo 'Пустой запрос';
}
?>
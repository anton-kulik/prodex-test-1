<?php
session_name('prodex-1');
session_start();

require_once 'settings.php';


/*********
 * LOGIN *
 ********/

if (isset($_POST['login']) && isset($_POST['password']) && $_POST['action'] == 'enter') {

    $connect = mysqli_connect(HOST, USER, PASS, DB_NAME) or die('Error database');
    $query = "SELECT `login`, `password` FROM `users` WHERE login = '{$_POST['login']}'";
    $result = mysqli_query($connect, $query);
    $data = mysqli_fetch_assoc($result);
    mysqli_close($connect);

    if (empty($data)) {
        echo '<p id="error">Неправильный логин и/или пароль</p>';
        die;
    }

    if ($data['password'] == $_POST['password']) {
        echo '<p id="success">Успешная авторизация</p>';
        $_SESSION['isLogged'] = true;
    }
}


/*************************
 * CHECK LOGIN AVAILABLE *
 ************************/

if (isset($_POST['login']) && !isset($_POST['action'])) {
    $connect = mysqli_connect(HOST, USER, PASS, DB_NAME) or die('Error database');
    $query = "SELECT `login` FROM `users` WHERE login = '{$_POST['login']}'";
    $result = mysqli_query($connect, $query);
    mysqli_close($connect);

    $login_true = null;

    while ($all_login = mysqli_fetch_assoc($result))
        if ($all_login['login'] == $_POST['login'])
            $login_true = 1;

    if ($login_true == 1) {
        echo '<p id="error">Логин занят</p>';
    } else {
        echo '<p id="success">Логин доступен</p>';
    }
}



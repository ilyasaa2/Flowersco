<?php
//Menggunakan session yang sama dengan config.php
session_name('FLOWERSCO_SESSION');
session_start();

//Menghancurkan semua session data
$_SESSION = array();

//Menghapus cookie session
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params;
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

session_destroy();

header("Location: Login.php");
exit();
?>
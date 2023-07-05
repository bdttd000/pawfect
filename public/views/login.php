<?php
$SessionController = new SessionController();
if ($SessionController::isLogged()) {
    $SessionController->redirectToHome();
}
?>

<html lang="en">

<head>
    <?php include('public/views/components/headImports.php'); ?>
    <title>Logowanie</title>
</head>

<body>
    <main class="login container">
        <div class="login-logo">
            <img class="login-logo-img" src="public/img/logo.png" alt="logo">
            <div class="flex flex-center">
                <h1 class="login-logo-text">PAW</h1>
                <h1 class="login-logo-text logo-login-text-grey">FECT</h1>
            </div>
        </div>
        <form class="login-form" action="checkLogin" method="POST">
            <div class="login-error-message">
                <?php echo $messages['error']; ?>
            </div>
            <div class="login-success-message">
                <?php echo $messages['success']; ?>
            </div>
            <input class="input input-text-primary" type="text" name="email" placeholder="PODAJ EMAIL" value="<?php if (isset($messages['email']))
                echo $messages['email']; ?>" required>
            <input class="input input-text-primary" type="password" name="password" placeholder="PODAJ HASŁO">
            <button class='button button-primary drop-shadow-animate' type='submit'>Zaloguj</button>
            <a class="button button-primary drop-shadow-animate" href="register">Zarejestruj</a>
        </form>
    </main>
</body>

</html>
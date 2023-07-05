<?php
$SessionController = new SessionController();
$userIsAuthenticated = $SessionController::isLogged();

if ($SessionController::isLogged() === false) {
    $SessionController->redirectToLogin();
}

$Repository = new Repository;
$cities = $Repository->getAllCities();
?>

<html lang="en">

<head>
    <?php include('public/views/components/headImports.php'); ?>
    <title>home</title>
</head>

<body>
    <?php include('public/views/components/navbar.php'); ?>
    <main>
        <div class="container">
            <section class="addPet">
                <form class="login-form" action="addPetForm" method="POST" enctype="multipart/form-data">
                    <div class="login-error-message">
                        <?php echo $messages['error']; ?>
                    </div>
                    <input class="input input-text-primary" type="text" name="title" placeholder="Podaj imię pupila"
                        value="<?php if (isset($messages['email']))
                            echo $messages['email']; ?>" required>
                    <textarea class="textarea" name="description" id="" cols="30" rows="10"
                        placeholder="Dodaj opis"></textarea>
                    <div class="custom-select">
                        <select name="city" required>
                            <option value="">Wybierz miasto</option>
                            <?php
                            foreach ($cities as $city) {
                                echo '<option value="' . $city[0] . '">' . $city[1] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <input type="file" name="avatar">
                    <input type="file" name="photos[]" multiple>
                    <button class='button button-primary drop-shadow-animate' type='submit'>Dodaj zwierzaka</button>
                </form>
            </section>
        </div>
    </main>
    <?php include('public/views/components/footer.php'); ?>
</body>

</html>
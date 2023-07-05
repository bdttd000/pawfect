<?php
$SessionController = new SessionController();
if ($SessionController::isLogged() === false) {
    $SessionController->redirectToLogin();
}
?>

<html lang="en">

<head>
    <?php include('public/views/components/headImports.php'); ?>
    <script src="public/js/search-bar.js" defer></script>
    <title>home</title>
</head>

<body>
    <?php include('public/views/components/navbar.php'); ?>
    <main>
        <div class="container">
            <div class="home-search-bar">
                <h3 class="input input-text-primary" id="search-title">Zwierzęta dla miasta
                    <?= $defaultCityName ?>
                </h3>
                <div class="custom-select">
                    <select name="city" id="select">
                        <option value="">Wybierz miasto</option>
                        <?php
                        foreach ($cities as $city) {
                            echo '<option value="' . $city[0] . '">' . $city[1] . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
            <section class="card-container" id="card-container">
                <?php if ($pets)
                    foreach ($pets as $pet): ?>
                        <a href="pet?id=<?= $pet->getPetId(); ?>" class="card">
                            <img class="card-img"
                                src="public/uploads/<?= $pet->getPetInfo()->getDirectoryUrl(); ?>/<?= $pet->getPetInfo()->getAvatarUrl(); ?>"
                                alt="Zdjecie auta">
                            <div class="card-info">
                                <h3>Imię:
                                    <?= $pet->getPetInfo()->getName(); ?>
                                </h3>
                                <h4>Opis:
                                    <?= strlen($pet->getPetInfo()->getDescription()) > 50 ? substr($pet->getPetInfo()->getDescription(), 0, 50) . '...' : $pet->getPetInfo()->getDescription(); ?>
                                </h4>
                            </div>
                        </a>
                    <?php endforeach; ?>
            </section>
        </div>
    </main>
    <?php include('public/views/components/footer.php'); ?>
</body>

<template id="card-template">
    <a href="" class="card">
        <img class="card-img" src="" alt="Zdjecie auta">
        <div class="card-info">
            <h3>Imię:

            </h3>
            <h4>Opis:

            </h4>
        </div>
    </a>
</template>

</html>
<?php
$SessionController = new SessionController();
if ($SessionController::isLogged() === false) {
    $SessionController->redirectToLogin();
}
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
            <section class="pet-container">
                <div class="pet-main">
                    <img class="pet-avatar"
                        src="public/uploads/<?= $pet->getPetInfo()->getDirectoryUrl(); ?>/<?= $pet->getPetInfo()->getAvatarUrl(); ?>"
                        alt="Zdjecie zwierzaka">
                    <div class="pet-info">
                        <h2 class="pet-text">
                            <?= $pet->getPetInfo()->getName(); ?>
                        </h2>
                        <div class="pet-info-container">
                            <div class="pet-text">
                                <h3>Dane kontaktowe:</h3>
                                <p>
                                    <?= $owner->getUserInfo()->getAddress(); ?>
                                </p>
                                <p>
                                    <?= $owner->getUserInfo()->getPhone(); ?>
                                </p>
                                <p>
                                    <?= $owner->getEmail(); ?>
                                </p>
                            </div>
                            <div class="pet-text">
                                <h3>Opis:</h3>
                                <p>
                                    <?= $pet->getPetInfo()->getDescription(); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pet-photo-container">
                    <?php
                    $photos = $pet->getPetInfo()->getPhotos();
                    if ($photos[0]) {
                        foreach ($photos as $photoInfo) {
                            echo '<img 
                            src="public/uploads/' . $pet->getPetInfo()->getDirectoryUrl() . '/' . $photoInfo['photo_url'] . '"
                            alt="Zdjecie zwierzaka">';
                        }
                    }
                    ?>
                </div>
            </section>
        </div>
    </main>

    <?php include('public/views/components/footer.php'); ?>
</body>

</html>
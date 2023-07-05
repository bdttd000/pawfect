<?php
$SessionController = new SessionController();
if ($SessionController::isLogged() === false) {
    $SessionController->redirectToLogin();
}
?>

<html lang="en">

<head>
    <?php include('public/views/components/headImports.php'); ?>
    <title>Kontakt</title>
</head>

<body>
    <?php include('public/views/components/navbar.php'); ?>
    <main>
        <div class="container white-text">
            <h3>
                Jeśli masz jakiekolwiek pytania, wątpliwości lub sugestie dotyczące naszej strony "PawFect" lub
                chciałbyś
                skontaktować się z nami w sprawach związanych z prywatnością lub danymi osobowymi, prosimy skorzystać z
                poniższych informacji kontaktowych:
            </h3>

            <ul>
                <li>Adres: PawFect Inc., ul. Przykładowa 123, 00-000 Miasto, Kraj</li>
                <li>Adres e-mail: info@pawfect.com</li>
                <li>Telefon: +XX-XXX-XXX-XXX</li>
            </ul>

            <h3>
                Nasi przedstawiciele są dostępni od poniedziałku do piątku w godzinach 9:00-17:00. Postaramy się
                odpowiedzieć na Twoje zapytanie w najkrótszym możliwym czasie.
            </h3>

            <h3>
                Jeśli preferujesz kontakt pisemny, prosimy o przesłanie wiadomości na wskazany adres e-mail lub
                korzystanie z formularza kontaktowego dostępnego na naszej stronie.
            </h3>

            <h3>
                Zalecamy również zapoznanie się z naszą Polityką Prywatności, aby dowiedzieć się, w jaki sposób
                przetwarzamy
                i chronimy Twoje dane osobowe.
            </h3>

            <h3>
                Dziękujemy za zainteresowanie stroną "PawFect" i czekamy na Twoją wiadomość. Postaramy się jak
                najlepiej
                odpowiedzieć na Twoje pytania i zapewnić Ci satysfakcję z naszych usług.
            </h3>
        </div>
    </main>
    <?php include('public/views/components/footer.php'); ?>
</body>

</html>
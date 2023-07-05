<?php
$SessionController = new SessionController();
if ($SessionController::isLogged() === false) {
    $SessionController->redirectToLogin();
}
?>

<html lang="en">

<head>
    <?php include('public/views/components/headImports.php'); ?>
    <title>Polityka prywatności</title>
</head>

<body>
    <?php include('public/views/components/navbar.php'); ?>
    <main>
        <div class="container white-text">
            <h2>
                Niniejsza Polityka Prywatności określa sposób gromadzenia, używania i ochrony danych osobowych
                użytkowników
                na
                stronie "PawFect". Dbamy o prywatność naszych użytkowników i zobowiązujemy się do zapewnienia
                bezpieczeństwa
                ich
                danych osobowych zgodnie z obowiązującymi przepisami dotyczącymi ochrony prywatności.
            </h2>

            <h3>Gromadzenie danych osobowych</h3>

            <ul>
                <li>
                    1.1. Podczas rejestracji konta i korzystania z naszej strony "PawFect", możemy zbierać pewne dane
                    osobowe,
                    takie
                    jak imię, nazwisko, adres e-mail, numer telefonu, dane kierowcy i inne informacje niezbędne do
                    świadczenia
                    usług.
                </li>
                <li>
                    1.2. Dodatkowo, podczas korzystania z naszej strony, automatycznie gromadzimy pewne informacje
                    techniczne,
                    takie
                    jak adres IP, dane o przeglądarce, systemie operacyjnym i aktywności na stronie. Te informacje są
                    wykorzystywane
                    w celach analitycznych i doskonalenia naszej strony.
                </li>
            </ul>

            <h3>Wykorzystywanie danych osobowych</h3>

            <ul>
                <li>
                    2.1. Dane osobowe zbierane przez nas są wykorzystywane w celu umożliwienia użytkownikom korzystania
                    z
                    funkcji
                    strony "PawFect" oraz do prowadzenia działań marketingowych i promocyjnych.
                </li>
                <li>
                    2.2. Możemy wykorzystywać dane osobowe w celu kontaktowania się z użytkownikami w celu dostarczania
                    informacji o
                    usługach, aktualizacji, promocjach i ofertach specjalnych.
                </li>
                <li>
                    2.3. Nie ujawniamy danych osobowych użytkowników osobom trzecim bez ich zgody, chyba że jest to
                    wymagane
                    przez
                    prawo lub w przypadku, gdy jest to niezbędne do świadczenia usług i realizacji transakcji.
                </li>
            </ul>

            <h3>Ochrona danych osobowych</h3>

            <ul>
                <li>
                    3.1. Stosujemy odpowiednie środki techniczne i organizacyjne w celu ochrony danych osobowych przed
                    utratą,
                    nieuprawnionym dostępem, zmianami lub ujawnieniem.
                </li>
                <li>
                    3.2. Użytkownik może mieć dostęp do swoich danych osobowych, ich edytowanie lub usunięcie,
                    kontaktując się z
                    nami za pośrednictwem wskazanych danych kontaktowych.
                </li>
            </ul>
        </div>
    </main>
    <?php include('public/views/components/footer.php'); ?>
</body>

</html>
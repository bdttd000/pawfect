<?php

require_once 'AppController.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../repository/UserRepository.php';

class SecurityController extends AppController
{
    private $userRepository;

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
    }

    public function checkLogin()
    {
        if (!$this->isPost()) {
            return $this->render('login');
        }

        $email = $_POST['email'];
        $password = $_POST['password'];

        $user = $this->userRepository->getUserByEmail($email);

        if (!$user) {
            return $this->render('login', ['messages' => ['error' => 'Nie ma takiego użytkownika', 'email' => $email]]);
        }

        if ($user->getPassword() !== hash('sha256', $password)) {
            return $this->render('login', ['messages' => ['error' => 'Nieprawidłowe hasło', 'email' => $email]]);
        }

        $_SESSION["user_info"] = serialize($user);

        $this->redirectToHome();
    }

    public function checkRegister()
    {
        if (!$this->isPost()) {
            return $this->render('register');
        }

        $email = $_POST['email'];
        $password = $_POST['password'];
        $password2 = $_POST['password2'];
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $city_id = $_POST['city'];

        $user = $this->userRepository->checkUser($email);

        if ($user) {
            return $this->render(
                'register',
                [
                    'messages' => [
                        'error' => 'Istnieje już taki użytkownik',
                        'email' => $email,
                        'name' => $name,
                        'surname' => $surname,
                        'phone' => $phone,
                        'address' => $address
                    ]
                ]
            );
        }

        if ($password !== $password2) {
            return $this->render(
                'register',
                [
                    'messages' => [
                        'error' => 'Hasła nie są takie same',
                        'email' => $email,
                        'name' => $name,
                        'surname' => $surname,
                        'phone' => $phone,
                        'address' => $address
                    ]
                ]
            );
        }

        $this->userRepository->addUser($email, $password, $name, $surname, $phone, $address, $city_id);

        return $this->render('login', ['messages' => ['success' => 'Dodano użytkownika']]);
    }

}
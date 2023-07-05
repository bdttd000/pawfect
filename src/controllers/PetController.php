<?php

require_once 'AppController.php';
require_once 'SessionController.php';
require_once __DIR__ . '/../models/Pet.php';
require_once __DIR__ . '/../models/PetInfo.php';
require_once __DIR__ . '/../repository/PetRepository.php';
require_once __DIR__ . '/../repository/UserRepository.php';

class PetController extends AppController
{
    const MAX_FILE_SIZE = 1024 * 1024;
    const SUPPORTED_TYPES = ['image/png', 'image/jpeg'];
    const UPLOAD_DIRECTORY = '/../public/uploads/';
    private static $messages = [];
    private $petRepository;
    private $userRepository;
    private $sessionController;

    public function __construct()
    {
        parent::__construct();
        $this->petRepository = new PetRepository();
        $this->userRepository = new UserRepository();
        $this->sessionController = new SessionController();
    }

    public function home($query = '')
    {
        $user = $this->sessionController->unserializeUser();

        if (!$user) {
            $this->redirectToLogin();
        }

        $defaultCityId = $user->getUserInfo()->getCityId();
        $defaultCityName = $user->getUserInfo()->getCityName();

        $cities = $this->petRepository->getAllCities();
        $pets = $this->getPets($defaultCityId);

        $this->render('home', ['pets' => $pets, 'cities' => $cities, 'defaultCityId' => $defaultCityId, 'defaultCityName' => $defaultCityName]);
    }

    public function pet($query = '')
    {
        $user = $this->sessionController->unserializeUser();

        if (!$user) {
            $this->redirectToLogin();
        }

        $defaultCityId = $user->getUserInfo()->getCityId();
        $defaultCityName = $user->getUserInfo()->getCityName();

        parse_str($query, $query);
        $petId = intval($query['id']);

        $pet = $this->petRepository->getPetById($petId);
        $owner = $this->userRepository->getUserById($pet->getUserId());

        $this->render('pet', ['pet' => $pet, 'owner' => $owner, 'defaultCityId' => $defaultCityId, 'defaultCityName' => $defaultCityName]);
    }

    public function getPetById($petId)
    {
        return $this->petRepository->getPetById($petId);
    }

    public function getPets($cityId)
    {
        return $this->petRepository->getPetsByCity($cityId);
    }

    public function addPetForm()
    {
        if (
            !(
                $this->isPost()
                && is_uploaded_file($_FILES['avatar']['tmp_name'])
                && $this->validateFile($_FILES['avatar'])
                && $this->validateTitle($_POST['title'])
            )
        ) {
            return $this->redirectToHome();
        }

        $folderName = $this->petRepository->generateID();
        $newPath = dirname(__DIR__) . self::UPLOAD_DIRECTORY . $folderName;
        mkdir($newPath);

        $avatarUrl = $this->petRepository->generateID() . '.' . pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);

        move_uploaded_file(
            $_FILES['avatar']['tmp_name'],
            $newPath . '/' . $avatarUrl
        );

        $photos = [];
        if ($_FILES['photos']['name'][0] != '') {
            for ($i = 0; $i < count($_FILES['photos']['name']); $i++) {
                $tmp_name = $_FILES['photos']['tmp_name'][$i];
                $ext = pathinfo($_FILES['photos']['name'][$i], PATHINFO_EXTENSION);
                $newName = $this->petRepository->generateID() . '.' . $ext;

                move_uploaded_file(
                    $tmp_name,
                    $newPath . '/' . $newName
                );

                array_push($photos, $newName);
            }
        }

        $this->petRepository->addPet(
            $_POST['title'],
            $_POST['description'],
            intval($_POST['city']),
            $folderName,
            $avatarUrl,
            $photos
        );

        return $this->redirectToHome();
    }

    private function validateFile(array $file): bool
    {
        if ($file['size'] > self::MAX_FILE_SIZE) {
            array_push(self::$messages, 'Plik jest za duży');
            return false;
        }

        if (!isset($file['type']) && !in_array($file['type'], self::SUPPORTED_TYPES)) {
            array_push(self::$messages, 'Rozszerzenie pliku jest niedozwolone');
            return false;
        }

        return true;
    }

    private function validateTitle(string $title): bool
    {
        if (strlen($title) < 3) {
            array_push(self::$messages, 'Nazwa jest za krótka');
            return false;
        }

        if (strlen($title) > 50) {
            array_push(self::$messages, 'Nazwa jest za długa');
            return false;
        }

        return true;
    }

    public function changeCity()
    {
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

        if ($contentType !== "application/json") {
            return;
        }

        $content = trim(file_get_contents("php://input"));

        header('Content-type: application/json');
        http_response_code(200);

        echo json_encode($this->petRepository->getPetsByCityAssoc(intval($content)));
    }
}
<?php

require_once 'Repository.php';
require_once __DIR__ . '/../models/Pet.php';
require_once __DIR__ . '/../models/PetInfo.php';
require_once __DIR__ . '/../controllers/SessionController.php';

class PetRepository extends Repository
{
    private $sessionController;

    public function __construct()
    {
        parent::__construct();
        $this->sessionController = new SessionController();
    }
    public function getPetsByCity(string $cityId): ?array
    {
        $stmt = $this->database->connect()->prepare('
            SELECT c.*, ci.name, ci.description, ci.directory_url, ci.avatar_url, city.city_id, city.name city_name
            FROM pet c
            JOIN pet_info ci ON c.pet_info_id = ci.pet_info_id
            JOIN pet_city cc ON c.pet_id = cc.pet_id
            JOIN city ON cc.city_id = city.city_id
            WHERE city.city_id= :cityId
            ORDER BY c.pet_id DESC
        ');
        $stmt->bindParam(':cityId', $cityId, PDO::PARAM_INT);
        $stmt->execute();

        $pets = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!$pets) {
            return null;
        }

        $output = [];

        foreach ($pets as $pet) {
            $photos = $this->getPhotosByPetInfoId(intval($pet['pet_info_id']));

            $petInfo = new PetInfo(
                $pet['pet_info_id'],
                $pet['name'],
                $pet['description'],
                $pet['directory_url'],
                $pet['avatar_url'],
                $photos
            );

            $newPet = new Pet(
                $pet['pet_id'],
                $pet['user_id'],
                $pet['pet_info_id'],
                $pet['active'],
                $pet['creation_date'],
                $petInfo,
                $pet['city_id'],
                $pet['city_name']
            );

            array_push($output, $newPet);
        }

        return $output;
    }

    public function getPetsByCityAssoc(string $cityId): ?array
    {
        $stmt = $this->database->connect()->prepare('
            SELECT c.*, ci.name, ci.description, ci.directory_url, ci.avatar_url, city.city_id, city.name city_name
            FROM pet c
            JOIN pet_info ci ON c.pet_info_id = ci.pet_info_id
            JOIN pet_city cc ON c.pet_id = cc.pet_id
            JOIN city ON cc.city_id = city.city_id
            WHERE city.city_id= :cityId
            ORDER BY c.pet_id DESC
        ');
        $stmt->bindParam(':cityId', $cityId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPetById(string $petId): ?Pet
    {
        $stmt = $this->database->connect()->prepare('
            SELECT c.*, ci.name, ci.description, ci.directory_url, ci.avatar_url, city.city_id, city.name city_name
            FROM pet c
            JOIN pet_info ci ON c.pet_info_id = ci.pet_info_id
            JOIN pet_city cc ON c.pet_id = cc.pet_id
            JOIN city ON cc.city_id = city.city_id
            WHERE c.pet_id = :petId
        ');
        $stmt->bindParam(':petId', $petId, PDO::PARAM_INT);
        $stmt->execute();

        $pet = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$pet) {
            return null;
        }

        $photos = $this->getPhotosByPetInfoId(intval($pet['pet_info_id']));

        $petInfo = new PetInfo(
            $pet['pet_info_id'],
            $pet['name'],
            $pet['description'],
            $pet['directory_url'],
            $pet['avatar_url'],
            $photos
        );

        return new Pet(
            $pet['pet_id'],
            $pet['user_id'],
            $pet['pet_info_id'],
            $pet['active'],
            $pet['creation_date'],
            $petInfo,
            $pet['city_id'],
            $pet['city_name']
        );
    }

    public function getPhotosByPetInfoId(int $petInfoId): array
    {
        $output = [];

        $stmt = $this->database->connect()->prepare('
            SELECT photo_id, photo_url 
            FROM photos 
            WHERE pet_info_id = :petInfoId
        ');
        $stmt->bindParam(':petInfoId', $petInfoId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addPet(string $name, string $description, int $cityId, string $directoryUrl, string $avatarUrl, array $photos): void
    {
        $petId = $this->getNextId('pet', 'pet_id');
        $petInfoId = $this->getNextId('pet_info', 'pet_info_id');
        $userId = $this->sessionController->unserializeUser()->getUserID();
        $creationDate = new DateTime();

        $stmt = $this->database->connect()->prepare('
            INSERT INTO pet (pet_id, user_id, pet_info_id, active, creation_date) VALUES (?, ?, ?, ?, ?)
        ');

        $stmt->execute([
            $petId,
            $userId,
            $petInfoId,
            true,
            $creationDate->format('Y-m-d')
        ]);

        $stmt = $this->database->connect()->prepare('
            INSERT INTO pet_info (pet_info_id, name, description, directory_url, avatar_url) VALUES (?, ?, ?, ?, ?)
        ');

        $stmt->execute([
            $petInfoId,
            $name,
            $description,
            $directoryUrl,
            $avatarUrl
        ]);

        $stmt = $this->database->connect()->prepare('
            INSERT INTO pet_city (pet_id, city_id) VALUES (?, ?)
        ');

        $stmt->execute([
            $petId,
            $cityId
        ]);

        foreach ($photos as $photo) {
            $photoId = $this->getNextId('photos', 'photo_id');
            $stmt = $this->database->connect()->prepare('
                INSERT INTO photos (photo_id, pet_info_id, photo_url) VALUES (?, ?, ?)
            ');

            $stmt->execute([
                $photoId,
                $petInfoId,
                $photo
            ]);
        }
    }
}
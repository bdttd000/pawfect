<?php

require_once 'Repository.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/UserInfo.php';
require_once __DIR__ . '/../models/Privilege.php';

class UserRepository extends Repository
{
    public function getUserByEmail(string $email): ?User
    {
        $stmt = $this->database->connect()->prepare('
            SELECT u.*, p.name privilege_name, ui.name user_info_name, ui.surname, ui.phone, ui.address, c.city_id city_id, c.name city_name
            FROM users u 
            JOIN privilege p ON u.privilege_id = p.privilege_id 
            JOIN user_info ui ON u.user_info_id = ui.user_info_id
            JOIN user_info_city uic ON ui.user_info_id = uic.user_info_id
            JOIN city c ON c.city_id = uic.city_id
            WHERE email = :email
        ');
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return null;
        }

        $privilege = new Privilege(
            $user['privilege_id'],
            $user['privilege_name']
        );

        $userInfo = new UserInfo(
            $user['user_info_id'],
            $user['user_info_name'],
            $user['surname'],
            $user['phone'],
            $user['address'],
            $user['city_id'],
            $user['city_name']
        );

        return new User(
            $user['user_id'],
            $privilege,
            $userInfo,
            $user['email'],
            $user['password'],
            $user['enabled'],
            $user['creation_date']
        );
    }

    public function getUserById($userId): ?User
    {
        $stmt = $this->database->connect()->prepare('
            SELECT u.*, p.name privilege_name, ui.name user_info_name, ui.surname, ui.phone, ui.address, c.city_id city_id, c.name city_name
            FROM users u 
            JOIN privilege p ON u.privilege_id = p.privilege_id 
            JOIN user_info ui ON u.user_info_id = ui.user_info_id
            JOIN user_info_city uic ON ui.user_info_id = uic.user_info_id
            JOIN city c ON c.city_id = uic.city_id
            WHERE user_id = :userId
        ');
        $stmt->bindParam(':userId', $userId, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return null;
        }

        $privilege = new Privilege(
            $user['privilege_id'],
            $user['privilege_name']
        );

        $userInfo = new UserInfo(
            $user['user_info_id'],
            $user['user_info_name'],
            $user['surname'],
            $user['phone'],
            $user['address'],
            $user['city_id'],
            $user['city_name']
        );

        return new User(
            $user['user_id'],
            $privilege,
            $userInfo,
            $user['email'],
            $user['password'],
            $user['enabled'],
            $user['creation_date']
        );
    }

    public function checkUser(string $email): bool
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM users WHERE LOWER(email) = :email
        ');

        $stmt->bindParam(':email', strtolower($email), PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return (bool) $user;
    }

    public function addUser(string $email, string $password, string $name, string $surname, string $phone, string $address, int $city_id): void
    {
        $user_id = $this->getNextId('users', 'user_id');
        $user_info_id = $this->getNextId('user_info', 'user_info_id');
        $enabled = true;
        $privilege_id = 2;
        $creationDate = new DateTime();

        $stmt = $this->database->connect()->prepare('
            INSERT INTO users (user_id, privilege_id, user_info_id, email, password, enabled, creation_date) VALUES (?, ?, ?, ?, ?, ?, ?)
        ');

        $stmt->execute([
            $user_id,
            $privilege_id,
            $user_info_id,
            $email,
            hash('sha256', $password),
            $enabled,
            $creationDate->format('Y-m-d')
        ]);

        $stmt = $this->database->connect()->prepare('
            INSERT INTO user_info (user_info_id, name, surname, phone, address) VALUES (?, ?, ?, ?, ?)
        ');

        $stmt->execute([
            $user_info_id,
            $name,
            $surname,
            $phone,
            $address
        ]);

        $stmt = $this->database->connect()->prepare('
            INSERT INTO user_info_city (user_info_id, city_id) VALUES (?, ?)
        ');

        $stmt->execute([
            $user_info_id,
            $city_id
        ]);
    }
}
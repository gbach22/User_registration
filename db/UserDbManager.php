<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'Database.php';

class UserDbManager {

    private $pdo;
    const DEFAULT_PHOTO = 'https://www.shutterstock.com/image-vector/blank-avatar-photo-place-holder-600nw-1095249842.jpg';
    public function __construct(){
        $db = new Database();
        $this->pdo = $db->getConnection();
    }

    public function getUserByEmailOrUsername(string $emailOrUsername){
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE (email = :emailOrUsername OR username = :emailOrUsername) LIMIT 1");
        $stmt->execute(['emailOrUsername' => $emailOrUsername]);
        return $stmt->fetch();
    }

    public function getAdminByEmailOrUsername(string $emailOrUsername){
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE (email = :emailOrUsername OR username = :emailOrUsername) AND is_admin = 1 LIMIT 1");
        $stmt->execute(['emailOrUsername' => $emailOrUsername]);
        return $stmt->fetch();
    }

    public function emailExists(string $email): bool {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetchColumn() > 0;
    }

    public function usernameExists(string $username): bool {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        return $stmt->fetchColumn() > 0;
    }

    public function registerUser(string $firstName, string $lastName, string $email, string $photoUrl, string $dateOfBirth, string $gender, string $phone, string $password, string $username, bool $isAdmin = false): string {
        if ($this->emailExists($email)) {
            return "Email is already in use.";
        }

        if ($this->usernameExists($username)) {
            return "Username is already in use.";
        }

        $stmt = $this->pdo->prepare("INSERT INTO users (first_name, last_name, email, photoUrl, dob, gender, phone, password, is_admin, username) 
                                    VALUES (:first_name, :last_name, :email, :photoUrl, :dob, :gender, :phone, :password, :is_admin, :username)");

        if ($photoUrl == '')
            $photoUrl = self::DEFAULT_PHOTO;
//        $hashedPassword = hash('sha256', $password);

        $isUserRegistered =  $stmt->execute([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'photoUrl' => $photoUrl,
            'dob' => $dateOfBirth,
            'gender' => $gender,
            'phone' => $phone,
            'password' => $password,
            'is_admin' => $isAdmin ? 1 : 0,
            'username' => $username
        ]);

        return $isUserRegistered ? 'success' : 'failure';
    }

    public function getUsers(): array {
        $stmt = $this->pdo->prepare("SELECT id, photoUrl, first_name, last_name, email, dob, gender, phone, username FROM users WHERE is_admin = 0");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserByUsername(string $username) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
        $stmt->execute(['username' => $username]);
        return $stmt->fetch();
    }

    public function makeUserAdmin(int $id): bool {
        $stmt = $this->pdo->prepare("UPDATE users SET is_admin = 1 WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function removeUser(int $userId): bool {
        $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = :id");

        return $stmt->execute(['id' => $userId]);
    }


}

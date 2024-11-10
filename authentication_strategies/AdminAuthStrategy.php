<?php

require_once 'AuthenticationStrategy.php';
require_once __DIR__ . '/../db/UserDbManager.php';


class AdminAuthStrategy implements AuthenticationStrategy {
    private $userRepository;

    public function __construct($userRepository) {
        $this->userRepository = $userRepository;
    }

    public function authenticate(string $emailOrUsername, string $password): string {
        $user = $this->userRepository->getAdminByEmailOrUsername($emailOrUsername);

        $input_hashed_password = hash('sha256', $password);

        if($user)
            $real_hashed_password = hash('sha256', $user["password"]);

        if ($user && (strcmp($input_hashed_password, $real_hashed_password) === 0)) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['is_admin'] = $user['is_admin'];
            return 'admin_home';
        }

        return 'Invalid email/username or You are not admin.';
    }

}
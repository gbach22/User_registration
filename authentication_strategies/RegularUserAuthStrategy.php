<?php

require_once __DIR__ . '/../db/UserDbManager.php';
require_once 'AuthenticationStrategy.php';

class RegularUserAuthStrategy implements AuthenticationStrategy {
    private $user_db_manager;

    public function __construct(UserDbManager $user_db_manager) {
        $this->user_db_manager = $user_db_manager;
    }

    public function authenticate(string $emailOrUsername, string $password): string {
        $user = $this->user_db_manager->getUserByEmailOrUsername($emailOrUsername);

        $input_hashed_password = hash('sha256', $password);
        if($user){
            $real_hashed_password = hash('sha256', $user["password"]);
        }
        if ($user && (strcmp($input_hashed_password, $real_hashed_password) === 0)) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['is_admin'] = $user['is_admin'];
            return 'user_home';
        }

        return 'Invalid email/username or password.';
    }
}

<?php

namespace Src\Authentication;

use App\Models\User;
use App\Services\UserService;
use Src\Session\Session;

class SessionAuthentication
{
    private User $user;

    public function __construct(
        private UserService $userService,
        private Session $session
    )
    {
    }

    public function authenticate(string $input, string $password): bool
    {
        if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
            $user = $this->userService->findByField('email', $input);
        } else {
            $user = $this->userService->findByField('phone', $input);
        }

        if (!$user) {
            return false;
        }

        if (password_verify($password, $user->getPasswordHash())) {

            $this->login($user);

            return true;
        }

        return false;
    }

    public function login(User $user): void
    {
        $this->session->set(Session::AUTH_KEY, $user->getId());

        $this->user = $user;
    }

    public function logout()
    {
        $this->session->remove(Session::AUTH_KEY);
    }


    public function check(): bool
    {
        return $this->session->has(Session::AUTH_KEY);
    }

    public function setUserService(UserService $userService): void
    {
        $this->userService = $userService;
    }
}
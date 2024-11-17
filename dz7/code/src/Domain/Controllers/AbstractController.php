<?php

namespace Geekbrains\Application1\Domain\Controllers;

use Geekbrains\Application1\Application\Application;
use Geekbrains\Application1\Domain\Models\User;

class AbstractController {

    protected array $actionsPermissions = [];

    public function getUserRoles(): array {
        if (isset($_SESSION['id_user'])) {
            return User::getUserRolesById($_SESSION['id_user']);
        }

        return ['user'];
    }

    public function getActionsPermissions(string $methodName): array {
        return $this->actionsPermissions[$methodName] ?? [];
    }
}
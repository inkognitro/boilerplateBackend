<?php declare(strict_types=1);

namespace App\Packages\UserManagement\Domain\User\Policies;

use App\Utilities\AuthUser as AuthUser;
use App\Packages\UserManagement\Domain\User\Attributes\Values\User;

final class ChangeUserPolicy extends UserPolicy
{
    public function isAuthorized(AuthUser $authUser, User $user): bool
    {
        if ($authUser->hasEveryRight()) {
            return true;
        }
        return $this->isAuthUserOwnerOfUser($authUser, $user);
    }
}
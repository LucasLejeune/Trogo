<?php

namespace App\Security;

use App\Entity\User;
use App\Entity\Workout;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class WorkoutVoter extends Voter
{
    const EDIT = 'workout_edit';
    const CREATE = 'workout_create';

    protected function supports(string $attribute, mixed $subject): bool
    {
        if (!in_array($attribute, [self::EDIT, self::CREATE])) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }

        return match ($attribute) {
            self::EDIT => $this->canEdit($user),
            self::CREATE => $this->canCreate($user),
            default => throw new \LogicException('This code should not be reached!')
        };
    }

    public function canEdit(User $user): bool
    {
        if (in_array('ROLE_ADMIN', $user->getRoles(), true)) {
            return true;
        }
        return false;
    }

    public function canCreate(User $user): bool
    {
        if (in_array('ROLE_ADMIN', $user->getRoles(), true)) {
            return true;
        }
        return false;
    }
}

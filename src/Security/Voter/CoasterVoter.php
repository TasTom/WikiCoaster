<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\Coaster;
use App\Entity\CoasterType;
use App\Entity\User;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;

final class CoasterVoter extends Voter
{
    public const EDIT = 'COASTER_EDIT';
    public const VIEW = 'COASTER_VIEW';

    public function __construct(
        private readonly AccessDecisionManagerInterface $accessDecisionManager
    ) {}

    protected function supports(string $attribute, mixed $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::EDIT, self::VIEW])
            && $subject instanceof \App\Entity\Coaster;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        // Si l'utilisateur n'est pas authentifié, refuser l'accès
        if (!$user instanceof UserInterface) {
            return false;
        }

        /** @var Coaster $coaster */
        $coaster = $subject;

        switch ($attribute) {
            case self::EDIT:
                // Seul l'auteur du coaster peut le modifier
                return $this->canEdit($coaster, $user);

            case self::VIEW:
                // Tout le monde peut voir un coaster (même non authentifié avant, mais ici on exige l'auth)
                return $coaster->isPublished() || $coaster->getAuthor() === $user;
        }

        return false;
    }

    private function canEdit(Coaster $coaster, User $user): bool
    {
        // Vérifie que l'utilisateur connecté est l'auteur du coaster
        return $coaster->getAuthor() === $user;
    }
}

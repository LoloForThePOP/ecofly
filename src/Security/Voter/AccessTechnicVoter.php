<?php

namespace App\Security\Voter;

use App\Entity\Technic;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class AccessTechnicVoter extends Voter
{

    private $requestStack;

    public function __construct(RequestStack $requestStack) {

        $this->requestStack = $requestStack;

    }



    protected function supports(string $attribute, $subject): bool
    {
        return in_array($attribute, ['view', 'edit'])
            && $subject instanceof Technic;
    }

    protected function voteOnAttribute(string $attribute, $technic, TokenInterface $token): bool
    {

        $user = $token->getUser();


        switch ($attribute) {

            case 'view':

                return $this->canView($technic, $token);

                break;

            case 'edit':

                return $this->canEdit($technic, $token);

                break;
        }

        return false;
    }


    private function canEdit(Technic $technic, TokenInterface $token)
    {

        // !! $token->getUser() represents an user ONLY if user is logged in. Otherwise, it is not an instance of class User. To check if user is not logged in (i.e. anonymous), test !$token->getUser() instanceof UserInterface

        $user = $token->getUser();

        // if user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // otherwise we check if user is technic's creator
        if ($user == $technic->getCreator()) {
            return true;
        }

        // otherwise we check if user is an admin
        if(in_array('ROLE_ADMIN', $user->getRoles())){
            return true;
        }

        return false;
    }

    private function canView(Technic $technic, TokenInterface $token)
    {

        $user = $token->getUser();

        return true;
    }

}

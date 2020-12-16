<?php

declare(strict_types=1);

namespace Controller;

use Framework\Render;
use Service\User\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserProfileController
{
    use Render;

    /**
     * Личный кабинет
     *
     * @param Request $request
     * @return Response
     */
     public function profileAction(Request $request): Response
     {
         $isAllowed = (new Security($request->getSession()))->isAdmin();
         if ($isAllowed) {
             $user = (new Security($request->getSession()))->getUser();
             return $this->render('user/profile.html.php', ['user' => $user]);
         }else{
             return $this->render('error401.html.php', []);
         }
     }
}

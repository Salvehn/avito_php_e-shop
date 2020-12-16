<?php

declare(strict_types=1);

namespace Controller;

use Framework\Render;
use Service\User\User;
use Service\User\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserListController
{
    use Render;

    /**
     * Список всех пользователей
     *
     * @param Request $request
     * @return Response
     */
     public function listAction(Request $request): Response
     {
         $isAllowed = (new Security($request->getSession()))->isAdmin();
         if ($isAllowed) {
             $userList = (new User())->getAll();
             return $this->render('user/user.list.php', ['userList' => $userList]);
         }else{
             return $this->render('error401.html.php', []);
         }
     }
}

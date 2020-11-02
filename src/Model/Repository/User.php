<?php

declare(strict_types = 1);

namespace Model\Repository;

use Model\Entity;

class User
{
    /**
     * Получаем пользователя по идентификатору
     *
     * @param int $id
     * @return Entity\User|null
     */
    public function getById(int $id): ?Entity\User
    {
        foreach ($this->getDataFromSource(['id' => $id]) as $user) {
            return $this->createUser($user);
        }

        return null;
    }

    /**
     * Получаем пользователя по логину
     *
     * @param string $login
     * @return Entity\User
     */
    public function getByLogin(string $login): ?Entity\User
    {
        foreach ($this->getDataFromSource(['login' => $login]) as $user) {
            if ($user['login'] === $login) {
                return $this->createUser($user);
            }
        }

        return null;
    }

    /**
     * Получаем cписок
     *
     *  @return array
     */

    //Вариант с array_map почему-то не работает

    // public function fetchAll(): array
    // {
    //
    //     $userList = array_map(array('User','createUser'),$this->getDataFromSource())
    //     return $userList
    // }



    public function fetchAll(): array
    {
        $userList = [];
        foreach ($this->getDataFromSource() as $item) {
            $output = $this->createUser($item, true);

            $userList[] = $output;
        }

        return $userList;
    }
    /**

     * Фабрика по созданию сущности пользователя
     *
     * @param array $user
     * @return Entity\User
     */
    private function createUser(array $user): Entity\User
    {
        $role = $user['role'];

        $birthday = strtotime($user['birthday']);
        $testtime = strtotime('31.12.1969 04:00:00pm');
        if ($birthday === false || date("Y-m-d h:i:sa", $birthday) === date("Y-m-d h:i:sa", $testtime)) {
            $birthday = strtotime('01.01.1970');
        }

        return new Entity\User(
            $user['id'],
            $user['name'],
            $user['login'],
            $user['password'],
            new Entity\Role($role['id'], $role['title'], $role['role']),
            $birthday
        );
    }

    /**
     * Получаем пользователей из источника данных
     *
     * @param array $search
     *
     * @return array
     */
    private function getDataFromSource(array $search = [])
    {
        $admin = ['id' => 1, 'title' => 'Super Admin', 'role' => 'admin'];
        $user = ['id' => 1, 'title' => 'Main user', 'role' => 'user'];
        $test = ['id' => 1, 'title' => 'For test needed', 'role' => 'test'];

        $dataSource = [
            [
                'id' => 1,
                'name' => 'Super Admin',
                'login' => 'root',
                'password' => '$2y$10$GnZbayyccTIDIT5nceez7u7z1u6K.znlEf9Jb19CLGK0NGbaorw8W', // 1234
                'role' => $admin,
                'birthday' => '10.09.1976'
            ],
            [
                'id' => 2,
                'name' => 'Doe John',
                'login' => 'doejohn',
                'password' => '$2y$10$j4DX.lEvkVLVt6PoAXr6VuomG3YfnssrW0GA8808Dy5ydwND/n8DW', // qwerty
                'role' => $user,
                'birthday' => '01.01.1970'
            ],
            [
                'id' => 3,
                'name' => 'Ivanov Ivan Ivanovich',
                'login' => 'i**3',
                'password' => '$2y$10$TcQdU.qWG0s7XGeIqnhquOH/v3r2KKbes8bLIL6NFWpqfFn.cwWha', // PaSsWoRd
                'role' => $user,
                'birthday' => '21.11.1989'
            ],
            [
                'id' => 4,
                'name' => 'Test Testov Testovich',
                'login' => 'testok',
                'password' => '$2y$10$vQvuFc6vQQyon0IawbmUN.3cPBXmuaZYsVww5csFRLvLCLPTiYwMa', // testss
                'role' => $test,
                'birthday' => '04.02.1992'
            ],
            [
                'id' => 5,
                'name' => 'student',
                'login' => 'student',
                'password' => '$2y$10$./5CWjqoeVl0t/dBytA3GuJA0iY1YT0zmf5sqkZ8PHWjvG3M4.k/C', // student (password_hash()  bcrypt gen)
                'role' => $user,
                'birthday' => '25.09.1982'
            ]
        ];

        if (!count($search)) {
            return $dataSource;
        }

        $productFilter = function (array $dataSource) use ($search): bool {
            return (bool) array_intersect_assoc($dataSource, $search);
        };

        return array_filter($dataSource, $productFilter);
    }
}

<?php
namespace Framework;

class Invoker {
    public function action(ICommand $command) {
// вызывает другие команды и действия
        return $command->execute();
    }
//Знает как отправить Каждый метод выполняет запрос команде некоторое действие
}

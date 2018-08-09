<?php

namespace src\Integration;
class DataProvider //todo сменить неинформативное имя класса

{
    //todo добавить phpDoc и тип данных
    private $host;
    private $user;
    private $password;
    /**
     * todo добавить тип данных
     * @param $host
     * @param $user
     * @param $password
     */
    public function __construct($host, $user, $password) //todo добавить тип данных
    {
        $this->host = $host;
        $this->user = $user;
        $this->password = $password;
    }
    /**
     * todo указать, что должно быть в массивах, параметре и возвращаемое значение
     * @param array $request
     *
     * @return array
     */
    public function get(array $request) //todo добавить тип данных, поменять неинформативное наименование метода
    {
        // returns a response from external service
    }
}

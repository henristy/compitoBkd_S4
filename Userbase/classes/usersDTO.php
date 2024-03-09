<?php

namespace usersDTO {
    use PDO;
    class usersDTO
    {
        private PDO $conn;

        public function __construct(PDO $conn)
        {
            $this->conn = $conn;
        }

        public function createTable() {
            $sql = "CREATE TABLE IF NOT EXISTS `db_user.users`  (
                `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                `username` VARCHAR(255) NOT NULL COLLATE 'utf8mb4_0900_ai_ci',
                `password` VARCHAR(15) NOT NULL COLLATE 'utf8mb4_0900_ai_ci',
                `name` VARCHAR(255) NOT NULL COLLATE 'utf8mb4_0900_ai_ci',
                `city` VARCHAR(255) NOT NULL COLLATE 'utf8mb4_0900_ai_ci',
                `state` VARCHAR(255) NOT NULL COLLATE 'utf8mb4_0900_ai_ci',
                `role` VARCHAR(255) NOT NULL COLLATE 'utf8mb4_0900_ai_ci',
                `image` VARCHAR(255) NOT NULL COLLATE 'utf8mb4_0900_ai_ci',
                PRIMARY KEY (`id`) USING BTREE,
                UNIQUE INDEX `username` (`username`) USING BTREE
            )";
            $this->conn->exec($sql);
        }
        public function getAllUsers()
        {
            $sql = 'SELECT * FROM db_user.users';
            $res = $this->conn->query($sql, PDO::FETCH_ASSOC);
            $res = $res->fetchAll();
            return $res ? $res: null;
        }
        public function getUserByID(int $id)
        {
            $sql = 'SELECT * FROM db_user.users WHERE id = :id';
            $stm = $this->conn->prepare($sql);
            $stm->execute(['id' => $id]);
            return $stm->fetchAll()['0'];
        }

        public function login(string $username, string $password) {
            $sql = 'SELECT * FROM db_user.users WHERE username = :username AND password = :password';
            $stm = $this->conn->prepare($sql);
            $stm->execute(['username' => $username, 'password' => $password]);
            return $stm->fetchAll()['0'];
        }
        public function addUser($user)
        {
            $sql = "INSERT INTO db_user.users (username, password, name, city, state, role, image) VALUES (:username, :password, :name, :city, :state, :role, :image)";
            $stm = $this->conn->prepare($sql);
            $stm->execute(['username' => $user['username'], 'password' => $user['password'], 'name' => $user['name'], 'city' => $user['city'], 'state' => $user['state'], 'role' => $user['role'], 'image' => $user['image']]);
            return $stm->rowCount();
        }

        public function modifyUser($user)
        {
            $sql = "UPDATE db_user.users SET username = :username, password = :password, name = :name, city = :city, state = :state, role = :role, image = :image WHERE id = :id";
            $stm = $this->conn->prepare($sql);
            $stm->execute(['username' => $user['username'], 'password' => $user['password'], 'name' => $user['name'], 'city' => $user['city'], 'state' => $user['state'], 'role' => $user['role'], 'image' => $user['image'], 'id' => $user['id']]);
            return $stm->rowCount();
        }
        public function deleteUser(int $id)
        {
            $sql = "DELETE FROM db_user.users WHERE id = :id";
            $stm = $this->conn->prepare($sql);
            $stm->execute(['id' => $id]);
            return $stm->rowCount();
        }
    }

}
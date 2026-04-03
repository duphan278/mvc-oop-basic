<?php
class User
{
    private $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    private function usersHasStatusColumn(): bool
    {
        $sql = "SELECT COUNT(*) AS cnt
                FROM INFORMATION_SCHEMA.COLUMNS
                WHERE TABLE_SCHEMA = DATABASE()
                  AND TABLE_NAME = 'users'
                  AND COLUMN_NAME = 'status'";
        $stmt = $this->conn->query($sql);
        $row = $stmt ? $stmt->fetch(PDO::FETCH_ASSOC) : null;
        return ((int)($row['cnt'] ?? 0)) > 0;
    }

    public function findByEmail(string $email)
    {
        $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findById(int $id)
    {
        $sql = "SELECT * FROM users WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create(array $data)
    {
        $sql = "INSERT INTO users (fullname, email, password, role) VALUES (:fullname, :email, :password, :role)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'fullname' => $data['fullname'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role' => $data['role'] ?? 'user'
        ]);
    }

    public function getAll(): array
    {
        // Một số môi trường DB cũ chưa có cột `status`, nên cần query an toàn.
        if ($this->usersHasStatusColumn()) {
            $sql = "SELECT id, fullname, email, role, status
                    FROM users
                    ORDER BY id DESC";
        } else {
            $sql = "SELECT id, fullname, email, role, 1 AS status
                    FROM users
                    ORDER BY id DESC";
        }
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    public function update(int $id, array $data): bool
    {
        $sql = "UPDATE users 
                SET fullname = :fullname, email = :email, role = :role
                WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'id' => $id,
            'fullname' => $data['fullname'] ?? '',
            'email' => $data['email'] ?? '',
            'role' => $data['role'] ?? 'user'
        ]);
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    public function updateStatus(int $id, int $status): bool
    {
        if (!$this->usersHasStatusColumn()) {
            return false;
        }
        $sql = "UPDATE users SET status = :status WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute(['id' => $id, 'status' => $status]);
    }
}
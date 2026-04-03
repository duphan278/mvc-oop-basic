<?php
class User
{
    private $conn;

    public function __construct()
    {
        $this->conn = connectDB();
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
        $sql = "SELECT id, fullname, email, role, status FROM users ORDER BY id DESC";
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
        $sql = "UPDATE users SET status = :status WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute(['id' => $id, 'status' => $status]);
    }
}
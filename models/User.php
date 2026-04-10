<?php
class User
{
    private $conn;
    private const PROFILE_COLUMNS = ['phone', 'birth_date', 'address', 'hometown'];

    public function __construct()
    {
        $this->conn = connectDB();
    }

    private function usersHasColumn(string $column): bool
    {
        $sql = "SELECT COUNT(*) AS cnt
                FROM INFORMATION_SCHEMA.COLUMNS
                WHERE TABLE_SCHEMA = DATABASE()
                  AND TABLE_NAME = 'users'
                  AND COLUMN_NAME = :column";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['column' => $column]);
        $row = $stmt ? $stmt->fetch(PDO::FETCH_ASSOC) : null;
        return ((int)($row['cnt'] ?? 0)) > 0;
    }

    private function usersHasStatusColumn(): bool
    {
        return $this->usersHasColumn('status');
    }

    private function getExistingProfileColumns(): array
    {
        $existing = [];
        foreach (self::PROFILE_COLUMNS as $column) {
            if ($this->usersHasColumn($column)) {
                $existing[] = $column;
            }
        }
        return $existing;
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
        $columns = ['fullname', 'email', 'password', 'role'];
        $values = [':fullname', ':email', ':password', ':role'];
        $params = [
            'fullname' => $data['fullname'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role' => $data['role'] ?? 'user',
        ];

        foreach ($this->getExistingProfileColumns() as $column) {
            $columns[] = $column;
            $values[] = ':' . $column;
            $params[$column] = $data[$column] ?? null;
        }

        $sql = "INSERT INTO users (" . implode(', ', $columns) . ")
                VALUES (" . implode(', ', $values) . ")";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($params);
    }

    public function getAll(): array
    {
        // Một số môi trường DB cũ chưa có cột `status`, nên cần query an toàn.
        $profileCols = $this->getExistingProfileColumns();
        $profileSql = '';
        foreach ($profileCols as $col) {
            $profileSql .= ", {$col}";
        }
        $statusSql = $this->usersHasStatusColumn() ? 'status' : '1 AS status';
        $sql = "SELECT id, fullname, email, role, {$statusSql}{$profileSql}
                FROM users
                ORDER BY id DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    public function update(int $id, array $data): bool
    {
        $setParts = ['fullname = :fullname', 'email = :email', 'role = :role'];
        $params = [
            'id' => $id,
            'fullname' => $data['fullname'] ?? '',
            'email' => $data['email'] ?? '',
            'role' => $data['role'] ?? 'user',
        ];

        foreach ($this->getExistingProfileColumns() as $column) {
            $setParts[] = "{$column} = :{$column}";
            $params[$column] = $data[$column] ?? null;
        }

        $sql = "UPDATE users
                SET " . implode(', ', $setParts) . "
                WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($params);
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
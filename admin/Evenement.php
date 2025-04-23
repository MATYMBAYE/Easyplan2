
<?php
// Evenement.php

require_once __DIR__ . '/config.php';

class Evenement
{
    public $id;
    public $titre;
    public $description;
    public $date_evenement;
    public $image;
    public $user_id;

    public function __construct(array $data = [])
    {
        $this->id             = $data['id'] ?? null;
        $this->titre          = $data['titre'] ?? '';
        $this->description    = $data['description'] ?? '';
        $this->date_evenement = $data['date_evenement'] ?? '';
        $this->image          = $data['image'] ?? null;
        $this->user_id = $data['user_id'] ?? null;
    }

    public static function getAllByUser(mysqli $conn, int $userId): array
    {
        $sql  = "SELECT * FROM evenements WHERE user_id=? ORDER BY date_evenement";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $res = $stmt->get_result();

        $list = [];
        while ($row = $res->fetch_assoc()) {
            $list[] = new Evenement($row);
        }
        return $list;
    }

    public static function getById(mysqli $conn, int $id, int $userId): ?Evenement
    {
        $sql  = "SELECT * FROM evenements WHERE id=? AND user_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $id, $userId);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        return $row ? new Evenement($row) : null;
    }

    public function save(mysqli $conn): bool
    {
        if ($this->id === null) {
            // INSERT
            $sql  = "INSERT INTO evenements (titre,description,date_evenement,image,user_id)
                     VALUES (?,?,?,?,?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param(
                "ssssi",
                $this->titre,
                $this->description,
                $this->date_evenement,
                $this->image,
                $this->user_id
            );
            $ok = $stmt->execute();
            if ($ok) $this->id = $conn->insert_id;
            return $ok;
        } else {
            // UPDATE
            $sql  = "UPDATE evenements
                     SET titre=?, description=?, date_evenement=?, image=?
                     WHERE id=? AND user_id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param(
                "sssiii",
                $this->titre,
                $this->description,
                $this->date_evenement,
                $this->image,
                $this->id,
                $this->user_id
            );
            return $stmt->execute();
        }
    }

    public function delete(mysqli $conn): bool
    {
        if ($this->id === null) return false;
        $sql  = "DELETE FROM evenements WHERE id=? AND user_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $this->id, $this->user_id);
        return $stmt->execute();
    }
}
?>
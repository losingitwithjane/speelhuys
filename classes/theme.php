<?php
class Theme
{
    public $id;
    public $name;

    public static function findAll()
    {
        $conn = Database::start();

        $sql = "SELECT * FROM themes";
        $result = $conn->query($sql);

        $themes = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $theme = new Theme();

                $theme->id = $row["theme_id"];
                $theme->name = $row["theme_name"];

                $themes[] = $theme;
            }
        }
        $conn->close();
        return $themes;
    }

    public static function findById($id)
    {
        $conn = Database::start();

        $id = mysqli_real_escape_string($conn, $id);

        $sql = "SELECT * FROM themes WHERE theme_id = " . $id;
        $result = $conn->query($sql);

        $theme = null;

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $theme = new Theme();

                $theme->id = $row["theme_id"];
                $theme->name = $row["theme_name"];
            }
        }
        $conn->close();
        return $theme;
    }

    public function insert()
    {
        $conn = Database::start();

        $id = mysqli_real_escape_string($conn, $this->id);
        $name = mysqli_real_escape_string($conn, $this->name);

        $sql = "INSERT INTO themes
        (theme_id,
        theme_name)
        VALUES
        ('$id',
        '$name')";

        $result = $conn->query($sql);
        if (!$result) {
            die("error" . $conn->error);
        }
        $conn->close();
    }
    public function update()
    {
        $conn = Database::start();

        $id = mysqli_real_escape_string($conn, $this->id);
        $name = mysqli_real_escape_string($conn, $this->name);

        $sql = "
            UPDATE
                themes
            SET
                theme_name = '$name'
            WHERE
                theme_id = $id
        ";

        $result = $conn->query($sql);
        if (!$result) {
            die("error" . $conn->error);
        }
        $conn->close();
    }

    public function delete()
    {
        $conn = Database::start();

        $id = mysqli_real_escape_string($conn, $this->id);

        $sql = "
            DELETE FROM
                themes
            WHERE
                theme_id = $id
        ";

        $result = $conn->query($sql);
        if (!$result) {
            die("error" . $conn->error);
        }
        $conn->close();
    }

    public static function getThemeName($id)
    {
        $conn = Database::start();

        $id = mysqli_real_escape_string($conn, $id);
        $sql = "SELECT theme_name FROM themes WHERE theme_id = $id";
        $result = $conn->query($sql);

        $name = null;

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $name = $row["theme_name"];
        }

        $conn->close();
        return $name;
    }
}
?>
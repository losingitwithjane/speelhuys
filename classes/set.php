<?php
class Set
{
    public $id;
    public $name;
    public $description;
    public $brandId;
    public $themeId;
    public $image;
    public $price;
    public $age;
    public $pieces;
    public $stock;

    private static function fromRow($row)
    {
        $set = new Set();

        $set->id = $row["set_id"];
        $set->name = $row["set_name"];
        $set->description = $row["set_description"];
        $set->brandId = $row["set_brand_id"];
        $set->themeId = $row["set_theme_id"];
        $set->image = $row["set_image"];
        $set->price = $row["set_price"];
        $set->age = $row["set_age"];
        $set->pieces = $row["set_pieces"];
        $set->stock = $row["set_stock"];

        return $set;
    }

    // Geeft een willekeurige set terug die een afbeelding heeft, of null als die er niet is.
    public static function findRandom()
    {
        $conn = Database::start();

        $sql = "
            SELECT
                *
            FROM
                sets
            WHERE
                set_image IS NOT NULL AND set_image != ''
            ORDER BY
                RAND()
            LIMIT 1
        ";
        $result = $conn->query($sql);

        $set = null;

        if ($result && $result->num_rows > 0) {
            $set = Set::fromRow($result->fetch_assoc());
        }
        $conn->close();
        return $set;
    }

    public static function findAll()
    {
        $conn = Database::start();

        $sql = "SELECT * FROM sets";
        $result = $conn->query($sql);

        $sets = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $set = new Set();

                $set->id = $row["set_id"];
                $set->name = $row["set_name"];
                $set->description = $row["set_description"];
                $set->brandId = $row["set_brand_id"];
                $set->themeId = $row["set_theme_id"];
                $set->image = $row["set_image"];
                $set->price = $row["set_price"];
                $set->age = $row["set_age"];
                $set->pieces = $row["set_pieces"];
                $set->stock = $row["set_stock"];

                $sets[] = $set;
            }
        }
        $conn->close();
        return $sets;
    }

    public static function findById($id)
    {
        $conn = Database::start();

        $id = mysqli_real_escape_string($conn, $id);

        $sql = "SELECT * FROM sets WHERE set_id = " . $id;
        $result = $conn->query($sql);

        $set = null;

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $set = new Set();

                $set->id = $row["set_id"];
                $set->name = $row["set_name"];
                $set->description = $row["set_description"];
                $set->brandId = $row["set_brand_id"];
                $set->themeId = $row["set_theme_id"];
                $set->image = $row["set_image"];
                $set->price = $row["set_price"];
                $set->age = $row["set_age"];
                $set->pieces = $row["set_pieces"];
                $set->stock = $row["set_stock"];
            }
        }
        $conn->close();
        return $set;
    }

    public function update()
    {
        $conn = Database::start();

        $id = mysqli_real_escape_string($conn, $this->id);
        $name = mysqli_real_escape_string($conn, $this->name);
        $description = mysqli_real_escape_string($conn, $this->description);
        $brandId = mysqli_real_escape_string($conn, $this->brandId);
        $themeId = mysqli_real_escape_string($conn, $this->themeId);
        $image = mysqli_real_escape_string($conn, $this->image);
        $price = mysqli_real_escape_string($conn, $this->price);
        $age = mysqli_real_escape_string($conn, $this->age);
        $pieces = mysqli_real_escape_string($conn, $this->pieces);
        $stock = mysqli_real_escape_string($conn, $this->stock);

        $sql = "
            UPDATE
                sets
            SET
                set_name = '$name',
                set_description = '$description',
                set_brand_id = '$brandId',
                set_theme_id = '$themeId',
                set_image = '$image',
                set_price = '$price',
                set_age = '$age',
                set_pieces = '$pieces',
                set_stock = '$stock'
            WHERE
                set_id = $id
        ";
        $result = $conn->query($sql);
        if (!$result) {
            die("error" . $conn->error);
        }
        $conn->close();
    }

    public function insert()
{
    $conn = Database::start();

    $name = mysqli_real_escape_string($conn, $this->name);
    $description = mysqli_real_escape_string($conn, $this->description);
    $brandId = mysqli_real_escape_string($conn, $this->brandId);
    $themeId = mysqli_real_escape_string($conn, $this->themeId);
    $image = mysqli_real_escape_string($conn, $this->image);
    $price = mysqli_real_escape_string($conn, $this->price);
    $age = mysqli_real_escape_string($conn, $this->age);
    $pieces = mysqli_real_escape_string($conn, $this->pieces);
    $stock = mysqli_real_escape_string($conn, $this->stock);

    $sql = "INSERT INTO sets
    (set_name,
    set_image,
    set_description,
    set_brand_id,
    set_theme_id,
    set_price,
    set_age,
    set_pieces,
    set_stock)
    VALUES
    ('$name',
    '$image',
    '$description',
    '$brandId',
    '$themeId',
    '$price',
    '$age',
    '$pieces',
    '$stock')";

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
                sets
            WHERE
                set_id = $id
        ";
        $result = $conn->query($sql);
        if (!$result) {
            die("error" . $conn->error);
        }
        $conn->close();
    }
}
?>
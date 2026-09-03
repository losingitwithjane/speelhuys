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

    public static function findAll() //vindt alle blogs via deze statische functie net zoals gebruiker.php
    {
        $conn = Database::start();

        $sql = "SELECT * FROM sets"; //pakt alle sets
        $result = $conn->query($sql);

        $sets = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) { //stopt de sets in een array
                $set = new Set();

                $set->id = $row["set_id"];
                $set->name = $row["set_name"];
                $set->description = $row["set_description"];
                $set->brandId = $row["brand_id"];
                $set->themeId = $row["theme_id"];
                $set->image = $row["set_image"];
                $set->price = $row["set_price"];
                $set->age = $row["set_age"];
                $set->pieces = $row["set_pieces"];
                $set->stock = $row["set_stock"];

                $sets[] = $set;
            }
        }
        $conn->close();
        return $sets; //returnt de array
    }

    public static function findById($id) //vindt een specifieke set via de id
    {
        $conn = Database::start();

        $sql = "SELECT * FROM sets WHERE set_id = " . $id; //pakt de set met de id
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
        return $set; //returnt de set met alle informatie
    }

    public function update() //update de set
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
                set_name = '" . $name . "',
                set_description = '" . $description . "',
                set_brand_id = '" . $brandId . "',
                set_theme_id = '" . $themeId . "',
                set_image = '" . $image . "',
                set_price = '" . $price . "',
                set_age = '" . $age . "',
                set_pieces = '" . $pieces . "',
                set_stock = '" . $stock . "'
            WHERE
                set_id = " . $id . "
        "; //verplaatst de oude informatie met de nieuwe
        $result = $conn->query($sql);
        if (!$result) { //als er geen resultaat is dan error
            die("error" . $conn->error);
        }
        $conn->close();
    }

    public function insert() //maak nieuwe set
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

        $sql = "INSERT INTO sets
        (set_id,
        set_name,
        set_image,
        set_description,
        set_brand_id,
        set_theme_id,
        set_price,
        set_age,
        set_pieces,
        set_stock)
        VALUES
        ('$id',
        '$name',
        '$image',
        '$description',
        '$brandId',
        '$themeId',
        '$price',
        '$age',
        '$pieces',
        '$stock')"; //maakt de nieuwe set aan voor in de database

        $result = $conn->query($sql);
        if (!$result) {
            die("error" . $conn->error);
        }
        $conn->close();
    }

    public function delete() //verwijder de set
    {
        $conn = Database::start();

        $id = mysqli_real_escape_string($conn, $this->id); //veilig

        $sql = "
            DELETE FROM
                sets
            WHERE
                set_id = " . $id . "
        "; //vindt de set via de id en verwijdert het van de database
        $result = $conn->query($sql);
        if (!$result) {
            die("error" . $conn->error);
        }
        $conn->close();
    }
}
?>
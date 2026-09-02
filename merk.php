<?php
class Brand
{
    public $id;
    public $name;
    public $logo;

    // Get all brands
    public static function allBrands()
    {
        include 'database.php'; // basic connection

        $sql = "SELECT * FROM brands";
        $result = $conn->query($sql);

        $brands = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $brand = new Brand();
                $brand->id = $row["brand_id"];
                $brand->name = $row["brand_name"];
                $brand->logo = $row["brand_logo"];
                $brands[] = $brand;
            }
        }

        $conn->close();
        return $brands;
    }

    // Find a single brand by ID
    public static function find(int $id)
    {
        include 'database.php';

        $id = mysqli_real_escape_string($conn, $id);
        $sql = "SELECT * FROM brands WHERE brand_id = '$id'";
        $result = $conn->query($sql);

        $brand = null;

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $brand = new Brand();
            $brand->id = $row["brand_id"];
            $brand->name = $row["brand_name"];
            $brand->logo = $row["brand_logo"];
        }

        $conn->close();
        return $brand;
    }

    // Update this brand
    public function update()
    {
        include 'database.php';

        $id = mysqli_real_escape_string($conn, $this->id);
        $name = mysqli_real_escape_string($conn, $this->name);
        $logo = mysqli_real_escape_string($conn, $this->logo);

        $sql = "
            UPDATE brands
            SET
                brand_name = '$name',
                brand_logo = '$logo'
            WHERE
                brand_id = '$id'
        ";

        $conn->query($sql);
        $conn->close();
    }

    // Delete this brand
    public function delete()
    {
        include 'database.php';

        $id = mysqli_real_escape_string($conn, $this->id);
        $sql = "DELETE FROM brands WHERE brand_id = '$id'";

        $conn->query($sql);
        $conn->close();
    }
}
?>
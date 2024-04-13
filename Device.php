<?php

require_once 'DBConnection.php';

class Device
{

    var $dev_id;
    var $dev_name;
    var $dev_category;
    var $dev_brand;
    var $dev_image;
    var $dev_price;

    protected $conn;

    public function __construct()
    {
        $this->dev_id = "";
        $this->dev_name = "";
        $this->dev_category = "";
        $this->dev_brand = "";
        $this->dev_image = "";
        $this->dev_price = "";
        $connectObj = new DBConnection();
        $this->conn = $connectObj->conn;
    }

    public function get_brand($brand_id)
    {
        try {
            $sql = "SELECT BRAND_NAME FROM T_BRAND WHERE BRAND_ID = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $brand_id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                return $row['BRAND_NAME'];
            } else {
                return null; // No brand found
            }
        } catch (Exception $e) {
            die("Query failed: " . $e->getMessage());
        }
    }
    private function get_category($cate_id)
    {
        try {
            $sql = "SELECT CATE_NAME FROM T_CATEGORY WHERE CATE_ID = $cate_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $cate_id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                return $row['CATE_NAME'];
            } else {
                return null; // No category found
            }
        } catch (Exception $e) {
            die("Query failed: " . $e->getMessage());
        }
    }

    public function get_cate_list()
    {
        try {
            $sql = "SELECT * FROM T_CATEGORY ";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            $result_array = array();
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {
                $result_array[] = $row;
            }

            return $result_array;
        } catch (Exception $e) {
            die("Query failed: " . $e->getMessage());
        }
    }

    public function get_brand_list()
    {
        try {
            $sql = "SELECT * FROM T_BRAND ";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            $result_array = array();
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {
                $result_array[] = $row;
            }

            return $result_array;
        } catch (Exception $e) {
            die("Query failed: " . $e->getMessage());
        }
    }

    private function id_fusion($brand_id, $name)
    {
        $brand = $this->get_brand($brand_id);
        return "$brand" . "_" . "$name";
    }

    private function name_fusion($name, $cate_id)
    {
        $cate_name = $this->get_category($cate_id);
        return "$cate_name" . " " . "$name";
    }

    private function check_device_existence($id)
    {
        try {
            $sql = "SELECT * FROM T_DEVICE WHERE DEV_ID = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param('s', $id);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->num_rows > 0;
        } catch (Exception $e) {
            die("Query failed: " . $e->getMessage());
        }
    }

    function get_device ($id)
    {
        try {
            $sql = "SELECT * FROM T_DEVICE WHERE DEV_ID = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param('s', $id);
            $stmt->execute();
            return $stmt->get_result()->fetch_assoc();

        } catch (Exception $e) {
            die("Query failed: " . $e->getMessage());
        }
    }

    function add_device($name, $brand_id, $cate_id, $dev_image, $dev_price)
    {
        $dev_id = $this->id_fusion($brand_id, $name);
        $dev_name = $this->name_fusion($name, $cate_id);
        if ($this->check_device_existence($dev_id)) {
            echo "Device already exists in the database! Please try again!";
        } else {
            try {
                $sql = "INSERT INTO T_DEVICE (`DEV_ID`, `DEV_NAME`, `CATE_ID`, `BRAND_ID`, `DEV_IMAGEURL`, `DEV_PRICE`) 
                VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("ssiisi", $dev_id, $dev_name, $cate_id, $brand_id, $dev_image, $dev_price);
                $stmt->execute();
            } catch (Exception $e) {
                die("Query failed: " . $e->getMessage());
            }
        }
    }

    function remove_device($dev_id)
    {
        if (!$this->check_device_existence($dev_id)) {
            echo "Device does not exist in the database! Please try again!";
        } else {
            try {
                $sql = "DELETE FROM T_DEVICE WHERE DEV_ID = ?";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("s", $dev_id);
                $stmt->execute();

                if ($stmt->affected_rows > 0) {
                    echo "Device with ID $dev_id has been successfully removed from the database.";
                } else {
                    echo "Failed to remove device with ID $dev_id from the database.";
                }
            } catch (Exception $e) {
                die("Query failed: " . $e->getMessage());
            }
        }
    }

    function update_device($dev_id, $dev_image, $dev_price)
    {
        if (!$this->check_device_existence($dev_id)) {
            echo "Device does not exist in the database! Please try again!";
        } else {
            try {
                $sql = "UPDATE T_DEVICE SET DEV_IMAGEURL = ?, DEV_PRICE = ?
                    WHERE DEV_ID = ?";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("sis", $dev_image, $dev_price, $dev_id);
                $stmt->execute();

                if ($stmt->affected_rows > 0) {
                    echo "Information of device with ID $dev_id has been successfully updated.";
                } else {
                    echo "Failed to update device information with ID $dev_id.";
                }
            } catch (Exception $e) {
                die("Query failed: " . $e->getMessage());
            }
        }
    }
}

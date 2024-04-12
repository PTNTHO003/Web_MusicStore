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

    private function get_brand($brand_id)
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

    function confirm_order($temp_order_id)
    {
        try {
            // extract the temporary order
            $ord_sql = "SELECT * FROM T_TEMPORARY_ORDER WHERE TEMP_ORDER_ID = ?";
            $stmt_ord = $this->conn->prepare($ord_sql);
            $stmt_ord->bind_param("s", $temp_order_id);
            $stmt_ord->execute();
            $order_result = $stmt_ord->get_result()->fetch_assoc();

            // extract all the devices of the temp order
            $dev_sql = "SELECT * FROM T_TEMPORARY_ORDER_DEVICES WHERE TEMP_ORDER_ID = ?";
            $stmt_dev = $this->conn->prepare($dev_sql);
            $stmt_dev->bind_param("s", $temp_order_id);
            $stmt_dev->execute();
            $dev_result = $stmt_dev->get_result()->fetch_all(MYSQLI_ASSOC);

            // insert the order to the main order table
            $insert_order_sql = "INSERT INTO T_ORDER (ORDER_ID, CUSTOMER_PHONE, ORDER_DATETIME, ORDER_TOTAL_AMOUNT, 
                                ORDER_NOTES) VALUES (?,?,?,?,?)";
            $stmt_insert_order = $this->conn->prepare($insert_order_sql);
            $stmt_insert_order->bind_param(
                "sssis",
                $order_result['TEMP_ORDER_ID'],
                $order_result['CUSTOMER_PHONE'],
                $order_result['ORDER_DATETIME'],
                $order_result['TOTAL_AMOUNT'],
                $order_result['ORDER_NOTES']
            );
            $stmt_insert_order->execute();

            // Insert the devices of the order to the order-devices table
            $order_id = $order_result['TEMP_ORDER_ID'];

            $insert_dev_sql = "INSERT INTO T_ORDER_DEVICES (ORDER_ID, DEV_ID) VALUES ";
            $values = array();

            foreach ($dev_result as $device) {
                $insert_dev_sql .= "(?, ?),";
                $values[] = $order_id;
                $values[] = $device['DEV_ID'];
            }

            // Remove the trailing comma and adding the semicolon to the end
            $insert_dev_sql = rtrim($insert_dev_sql, ',') . ';';

            $stmt_insert_dev = $this->conn->prepare($insert_dev_sql);
            if (!$stmt_insert_dev) {
                die("Prepare failed: " . $this->conn->error);
            }

            // Bind parameters
            $types = str_repeat('ss', count($dev_result));
            $stmt_insert_dev->bind_param($types, ...$values);

            // Execute the statement
            $execute_result = $stmt_insert_dev->execute();
            if (!$execute_result) {
                die("Execution failed: " . $stmt_insert_dev->error);
            }


            // delete temporary order
            $delete_order_sql = "DELETE FROM T_TEMPORARY_ORDER WHERE Order_ID = ?";
            $stmt_delete_order = $this->conn->prepare($delete_order_sql);
            $stmt_delete_order->bind_param("s", $temp_order_id);
            $stmt_delete_order->execute();

            //delete temporary devices
            $delete_dev_sql = "DELETE FROM T_TEMPORARY_ORDER_DEVICES WHERE Order_ID = ?";
            $stmt_delete_dev = $this->conn->prepare($delete_dev_sql);
            $stmt_delete_dev->bind_param("s", $temp_order_id);
            $stmt_delete_dev->execute();

        } catch (Exception $e) {
            die("Query failed: " . $e->getMessage());
        }
    }
}

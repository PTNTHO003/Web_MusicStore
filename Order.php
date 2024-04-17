<?php

class Order{
    var $order_id;
    var $customer_phone;
    var $order_datetime;
    var $order_total_amount;
    var $order_notes;

    protected $conn;

    public function __construct() {
        $this->order_id = "";
        $this->customer_phone = "";
        $this->order_datetime = "";
        $this->order_total_amount = 0;
        $this->order_notes = "";
        $connectObj = new DBConnection();
        $this->conn = $connectObj->conn;
    }

    function get_order ($order_id){
        try {
            $sql = "SELECT * FROM T_ORDER WHERE ORDER_ID = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param('s', $order_id);
            $stmt->execute();
            return $stmt->get_result()->fetch_assoc();
        } catch (Exception $e) {
            die("Query failed: " . $e->getMessage());
        }
    }

    function get_ord_devices ($order_id)
    {
        try {
            $sql = "SELECT * FROM T_ORDER-DEVICES WHERE ORDER_ID = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param('s', $order_id);
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

    function get_pending_order ()
    {
        try {
            $sql = "SELECT * FROM T_TEMPORARY_ORDER";
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

    function get_pending_devices($order_id)
    {
        try{
            $sql = "SELECT * FROM T_TEMPORARY_ORDER_DEVICES WHERE TEMP_ORDER_ID = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("s", $order_id);
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
?>
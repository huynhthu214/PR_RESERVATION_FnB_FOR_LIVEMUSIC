<?php
class NotificationModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function addNotification($data) {
        $id = 'N' . time() . rand(100,999); // tạo ID đơn giản
        $stmt = $this->conn->prepare("INSERT INTO NOTIFICATIONS
            (NOTIFICATION_ID, CUSTOMER_ID, ADMIN_ID, SENDER_ID, RECEIVER_ID, RECEIVER_TYPE, TITLE, MESSAGE, TYPE, LINK, SENT_AT, IS_READ)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssssssi",
            $id,
            $data['CUSTOMER_ID'],
            $data['ADMIN_ID'],
            $data['SENDER_ID'],
            $data['RECEIVER_ID'],
            $data['RECEIVER_TYPE'],
            $data['TITLE'],
            $data['MESSAGE'],
            $data['TYPE'],
            $data['LINK'],
            $data['SENT_AT'],
            $data['IS_READ']
        );
        $stmt->execute();
        $stmt->close();
        return $id;
    }

    public function markAsRead($notificationId) {
        $stmt = $this->conn->prepare("UPDATE NOTIFICATIONS SET IS_READ = 1 WHERE NOTIFICATION_ID = ?");
        $stmt->bind_param("s", $notificationId);
        $stmt->execute();
        $stmt->close();
    }
}
?>

<?php
class EmailLogModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function addLog($data) {
        $id = 'E' . time() . rand(100,999);
        $stmt = $this->conn->prepare("INSERT INTO EMAIL_LOG
            (EMAILLOG_ID, ADMIN_ID, CUSTOMER_ID, RECIPIENT_EMAIL, SUBJECT, SENT_TIME, STATUS, ERRORMESSAGE)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssss",
            $id,
            $data['ADMIN_ID'],
            $data['CUSTOMER_ID'],
            $data['RECIPIENT_EMAIL'],
            $data['SUBJECT'],
            $data['SENT_TIME'],
            $data['STATUS'],
            $data['ERRORMESSAGE']
        );
        $stmt->execute();
        $stmt->close();
        return $id;
    }
}
?>

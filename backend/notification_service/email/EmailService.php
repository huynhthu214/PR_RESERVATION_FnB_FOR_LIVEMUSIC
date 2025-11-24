<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/EmailLogModel.php';

// PHPMailer — đường dẫn chuẩn theo bạn cung cấp
require_once __DIR__ . '/../../../vendor/PHPMailer-master/src/PHPMailer.php';
require_once __DIR__ . '/../../../vendor/PHPMailer-master/src/SMTP.php';
require_once __DIR__ . '/../../../vendor/PHPMailer-master/src/Exception.php';

class EmailService {
    private $conn;  
    private $emailLogModel;

    private $smtpHost = 'smtp.gmail.com';
    private $smtpPort = 465;
    private $smtpUser = 'minhthuhuynh23@gmail.com';
    private $smtpPass = 'kapendjgusnxwczc';
    private $fromEmail = 'minhthuhuynh23@gmail.com';
    private $fromName  = 'Live Music App';

    public function __construct($conn) {
        $this->conn = $conn;
        $this->emailLogModel = new EmailLogModel($conn);
    }

    public function sendEmail($to, $subject, $body, $customerId = null, $adminId = null) {
        $status = 'FAILED';
        $errorMessage = '';
        $sentAt = date("Y-m-d H:i:s");

        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = $this->smtpHost;
            $mail->SMTPAuth = true;
            $mail->Username = $this->smtpUser;
            $mail->Password = $this->smtpPass;
            $mail->SMTPSecure = 'ssl';
            $mail->Port = $this->smtpPort;
            $mail->CharSet = 'UTF-8';

            $mail->setFrom($this->fromEmail, $this->fromName);
            $mail->addAddress($to);
            $mail->isHTML(true);

            $mail->Subject = $subject;
            $mail->Body = $body;

            $mail->send();
            $status = 'SENT';
        } catch (Exception $e) {
            $errorMessage = $mail->ErrorInfo;
        }

        // save log
        $this->emailLogModel->addLog([
            'CUSTOMER_ID' => $customerId,
            'ADMIN_ID' => $adminId,
            'RECIPIENT_EMAIL' => $to,
            'SUBJECT' => $subject,
            'SENT_TIME' => $sentAt,
            'STATUS' => $status,
            'ERRORMESSAGE' => $errorMessage
        ]);

        return $status === 'SENT';
    }
}

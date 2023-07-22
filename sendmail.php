<?php
require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';
 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mail{
    public function kichhoat($email,$pass,$subject,$body){
        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        $mail -> CharSet = 'UTF-8';
        try {
        //Server settings
        $mail->SMTPDebug = 0;                                 // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        // $mail->Host = 'smtp.example.com';  // Specify main and backup SMTP servers
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'anb2007220@student.ctu.edu.vn';                 // SMTP username
        $mail->Password = 'jcsuuayswweszaqi';                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to

        //Recipients
        $mail->setFrom('anb2007220@student.ctu.edu.vn', 'Trần Phước An');

        $mail->addAddress($email);     // Add a recipient
        // $mail->addAddress('ellen@example.com', 'Joe User');               // Name is optional
        // $mail->addReplyTo('info@example.com', 'Information');
        // $mail->addCC('cc@example.com');
        // $mail->addBCC('bcc@example.com');

        //Attachments
        // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $subject; // Set email subject
        $mail->Body    =  $body; // Chỗ này, Thay vì e trỏ tới 1 strng Testing, em tạo 1 file layout_mail . Xong e thiết kế nội dung trong đó, rồi qua đây gôi vào
        // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        echo"<script>Swal.fire({
            icon: 'success',
            title: 'Thông báo',
            text: 'Mật khẩu đã được gửi vào email nhập vào',
            confirmButtonText: 'Xác nhận',
            }).then((result) => {
                if (result.isConfirmed) {
                  window.location.href = 'confirm.php';
                }
              })
            </script>";
        } 
        catch (Exception $e) {
            echo"<script>Swal.fire({
                icon: 'error',
                title: 'Lỗi',
                text: 'Lỗi hệ thống',
              })</script>";
        }
    }   
}
?>
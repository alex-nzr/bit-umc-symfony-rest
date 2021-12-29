<?php
namespace App\Service;

class MailerService{

    public function __construct(){ }

    /**
     * @param array $params
     * @return array
     */
    public function sendEmail(array $params): array
    {
        if (is_array($params)){
            $name = htmlspecialchars($params["name"] ." ". $params["middleName"] ." ". $params["surname"]);
            $emailTo = htmlspecialchars($params["email"]);
            $phone = htmlspecialchars($params["phone"]);
            $clinic = htmlspecialchars($params["clinicName"]);
            $specialty = htmlspecialchars($params["specialty"]);
            $service = htmlspecialchars($params["serviceName"]);
            $doctor = htmlspecialchars($params["doctorName"]);
            $dateTime = date("d.m.Y H:i", strtotime($params["timeBegin"]));
            $comment = htmlspecialchars($params["comment"]);

            if (!empty($emailTo))
            {
                $from = 'no-reply@'.$_SERVER['HTTP_HOST'];
                $subject = 'Запись на приём';
                $html = "<h3>Вы успешно записались на приём</h3>".
                        "<p>Клиника:         $clinic</p>".
                        "<p>Специализация:   $specialty</p>".
                        "<p>Услуга:          $service</p>".
                        "<p>Врач:            $doctor</p>".
                        "<p>Дата/время:      $dateTime</p>".
                        "<p>ФИО:             $name</p>".
                        "<p>Номер телефона:  $phone</p>".
                        "<p>Комментарий:     $comment</p>";

                return ['success' => mail($emailTo,$subject,$html,"from: $from")];
            }
            else {
                return ['error' => "EmailTo is empty"];
            }
        }
        else {
            return ['error' => "Invalid type of params. Array expected, but ". gettype($params). " given"];
        }
    }
}
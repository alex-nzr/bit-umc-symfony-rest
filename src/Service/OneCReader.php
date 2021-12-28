<?php
namespace App\Service;

use App\Config\Variables;
use App\Utils\Utils;

class OneCReader extends BaseOneCService
{
    /** get list of clinics in json
     * @return string
     */
    public function getClinicsList(): string
    {
        $this->endpoint .= "GetListClinics";
        $data = json_decode($this->post(), true);
        if (empty($data["error"]) && is_array($data["clinics"]))
        {
            $data = $data["clinics"];
        }
        return json_encode($data);
    }

    /** get list of clients in json
     * @param array $params
     * @return string
     */
    public function getEmployeesList(array $params =[]): string
    {
        $this->endpoint .= "GetListEmployees";
        $data = json_decode($this->post($params), true);
        if (empty($data["error"]) && is_array($data["employees"]))
        {
            $data = $data["employees"];
        }
        return json_encode($data);
    }

    /** get list of nomenclature in json
     * @param array $params
     * @return string
     */
    public function getNomenclatureList(array $params =[]): string
    {
        $this->endpoint .= "GetListNomenclature";
        $data = json_decode($this->post($params), true);
        if (empty($data["error"]) && is_array($data["nomenclature"]))
        {
            $data = $data["nomenclature"];
        }
        return json_encode($data);
    }

    /** get doctors schedule in json
     * @return string
     */
    public function getSchedule(): string
    {
        $this->endpoint .= "GetSchedule";

        $period = Utils::getDateInterval(Variables::SCHEDULE_PERIOD_IN_DAYS);

        $data = json_decode($this->post($period), true);
        $schedule = $data["ГрафикиДляСайта"]["ГрафикДляСайта"];
        if (!empty($schedule) && empty($schedule["error"]))
        {
            if (is_array($schedule)){
                if (Utils::is_assoc($schedule))
                {
                    $schedule = array($schedule);
                }

                $formattedSchedule = [];
                foreach ($schedule as $key => $item)
                {
                    if (isset($item["СотрудникID"])){
                        $formattedSchedule[$key]["refUid"] = $item["СотрудникID"];
                    }
                    if (isset($item["Специализация"])){
                        $formattedSchedule[$key]["specialty"] = $item["Специализация"];
                    }
                    if (isset($item["СотрудникФИО"])){
                        $formattedSchedule[$key]["name"] = $item["СотрудникФИО"];
                    }
                    if (isset($item["Клиника"])){
                        $formattedSchedule[$key]["clinicUid"] = $item["Клиника"];
                    }

                    $duration = 0;
                    if (isset($item["ДлительностьПриема"])){
                        $formattedSchedule[$key]["duration"] = $item["ДлительностьПриема"];
                        $duration = intval(date("H", strtotime($item["ДлительностьПриема"]))) * 3600
                            + intval(date("i", strtotime($item["ДлительностьПриема"]))) * 60;
                        $formattedSchedule[$key]["durationInSeconds"] = $duration;
                    }

                    $freeTime = is_array($item["ПериодыГрафика"]["СвободноеВремя"])
                        ? $item["ПериодыГрафика"]["СвободноеВремя"]["ПериодГрафика"] : [];
                    $busyTime = is_array($item["ПериодыГрафика"]["ЗанятоеВремя"])
                        ? $item["ПериодыГрафика"]["ЗанятоеВремя"]["ПериодГрафика"] : [];
                    if (Utils::is_assoc($freeTime)) {
                        $freeTime = array($freeTime);
                    }
                    if (Utils::is_assoc($busyTime)) {
                        $busyTime = array($busyTime);
                    }

                    $formattedSchedule[$key]["timetable"]["free"] = Utils::formatTimetable($freeTime, $duration);
                    $formattedSchedule[$key]["timetable"]["busy"] = Utils::formatTimetable($busyTime, 0, true);
                    $formattedSchedule[$key]["timetable"]["freeNotFormatted"] = Utils::formatTimetable($freeTime, 0, true);
                }
                $data = [
                    "schedule" => $formattedSchedule,
                ];
            }
        }
        return json_encode($data);
    }

    /** get list of clients in json
     * @param array $params
     * @return string
     */
    public function getClientsList(array $params = []): string
    {
        $this->endpoint .= "GetListClients";
        $data = json_decode($this->post($params), true);
        $clients = $data["clients"];
        if (empty($data["error"]) && is_array($clients))
        {
            foreach ($clients as $key => $client)
            {
                if (!empty($client["birthday"]))
                {
                    $clients[$key]["displayBirthday"] = date("d-m-Y", strtotime($client["birthday"]));
                }

                if (is_array($client["contacts"]))
                {
                    foreach($client['contacts'] as $contactType => $contactValue){
                        if ($contactType === "phone")
                        {
                            $clients[$key]["contacts"]["phone"] = Utils::formatPhone($contactValue);
                        }
                        else
                        {
                            $clients[$key]["contacts"][$contactType] = trim($contactValue);
                        }
                    }
                }

                foreach ($clients[$key] as $param => $value){
                    if (is_string($value)){
                        $clients[$key][$param] = trim($value);
                    }
                }
            }
            $data = $clients;
        }

        return json_encode($data);
    }

    /** get list of orders in json
     * @param array $params
     * @return string
     */
    public function getOrdersList(array $params): string
    {
        if (!empty($params["clientUid"])){
            $this->endpoint .= "GetListOrders";
            $data = json_decode($this->post($params), true);
            $orders = $data["orders"];
            if (empty($data["error"]) && is_array($orders))
            {
                foreach ($orders as $key => $order)
                {
                    if (!empty($order["orderDate"])){
                        $orders[$key]["displayOrderDate"] = date("d-m-Y", strtotime($order["orderDate"]));
                    }
                    if (!empty($order["timeBegin"])){
                        $orders[$key]["displayTimeBegin"] = date("H:i", strtotime($order["timeBegin"]));
                    }
                    if (!empty($order["timeEnd"])){
                        $orders[$key]["displayTimeEnd"] = date("H:i", strtotime($order["timeEnd"]));
                    }
                    if (!empty($order["clientBirthday"])){
                        $orders[$key]["displayClientBirthday"] = date("d-m-Y", strtotime($order["clientBirthday"]));
                    }

                    $data = $orders;
                }
            }

            return json_encode($data);
        }
        return Utils::addError('ClientUid is empty');
    }
}
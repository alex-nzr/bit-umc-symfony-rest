<?php
namespace App\Service;

use App\Utils\Utils;

class OneCWriter extends BaseOneCService
{
    /** make request to creating order
     * @param array $params
     * @param bool $unauthorized
     * @return string
     */
    public function addOrder(array $params): string
    {
        if (Utils::validateOrderParams($params))
        {
            $params['orderDate'] = Utils::formatDateToOrder($params['orderDate']);
            $params['timeBegin'] = Utils::formatDateToOrder($params['timeBegin'], true);
            $params['timeEnd']   = Utils::formatDateToOrder($params['timeEnd'], true);

            if (empty($params["clientUid"]))
            {
                $params["comment"] =    $params['name'] . " "
                    . $params['middleName'] . " "
                    . $params['surname'] . "\n"
                    . $params['phone'] ."\n". $params["comment"];

                $params['unauthorized'] = "Y";
            }

            $this->endpoint .= "CreateOrder";
            return $this->post($params);
        }
        return Utils::addError('Not enough params to make appointment');
    }

    /** cancelling order in 1C
     * @param array $params
     * @return string
     */
    public function deleteOrder(array $params): string
    {
        if (!empty($params["orderUid"])){
            $this->endpoint .= "CancelOrder";
            return $this->post($params);
        }
        return Utils::addError('orderUid is empty');
    }

    /** make request to update client's data
     * @param array $params
     * @return string
     */
    public function updateClient(array $params): string
    {
        if (!empty($params["clientUid"]))
        {
            foreach ($params as $key => $value) {
                switch ($key){
                    case "name":
                    case "surname":
                    case "middlename":
                    case "emailHome":
                    case "emailWork":
                        $params[$key] = trim($value);
                        break;
                    case "phone":
                        $params["phone"] = Utils::formatPhone($value);
                        break;
                }
            }
            $this->endpoint .= "UpdateClient";
            return $this->post($params);
        }
        return Utils::addError('"clientUid" is necessary to update client data');
    }
}
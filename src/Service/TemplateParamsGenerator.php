<?php
namespace App\Service;

use App\Utils\Utils;

class TemplateParamsGenerator{
    /** generate params for widget template
     * @return array
     */
    public function generateWidgetParams(): array
    {
        $settings = file_get_contents($_SERVER["DOCUMENT_ROOT"].'/umc-api/public/build/settings/settings.json');
        $result = json_decode($settings, true);
        if (is_array($result))
        {
            if ($result["selectDoctorBeforeService"] === "Y"){
                $altSelectionBlocks = [
                    "clinicsBlock"      => $result["selectionBlocks"]["clinicsBlock"],
                    "specialtiesBlock"  => $result["selectionBlocks"]["specialtiesBlock"],
                    "employeesBlock"    => $result["selectionBlocks"]["employeesBlock"],
                    "servicesBlock"     => $result["selectionBlocks"]["servicesBlock"],
                    "scheduleBlock"     => $result["selectionBlocks"]["scheduleBlock"],
                ];
                $result["selectionBlocks"] = $altSelectionBlocks;
            }
        }
        else
        {
            $result = [];
        }
        return $result;
    }
}
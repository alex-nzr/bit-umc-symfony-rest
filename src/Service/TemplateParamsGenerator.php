<?php
namespace App\Service;

class TemplateParamsGenerator{
    /** generate params for widget template
     * @return array
     */
    public function generateWidgetParams(): array
    {
        $result = [
            $useServices                    = "Y",
            $selectDoctorBeforeService      = "Y",
            $useTimeSteps                   = "N",  //use timeSteps only for services with duration>=30 minutes
            $timeStepDurationMinutes        = 15,   //minutes
            $strictCheckingOfRelations      = "Y",  //strict verification of the binding of employees to the clinic and specializations to the clinic
            $showDoctorsWithoutDepartment   = "Y",  //show doctors and specialties with empty department
            $privacyPageLink                = "javascript: void(0)"
        ];
        return $result;
    }
}
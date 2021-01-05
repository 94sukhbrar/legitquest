<?php

$items = [
    "HIDO" => "Supreme Court ",
    "allahabad_high_court" => "Allahabad High Court ",
    "andhra_pradesh_high_court" => "Andhra Pradesh High Court ",
    "bombay_high_court" => "Bombay High Court ",
    "calcutta_high_court" => "Calcutta High Court ",
    "chhattisgarh_high_court" => "Chhattisgarh High Court ",
    "delhi_high_court" => "Delhi High Court ",
    "Guwahati_high_court" => "Guwahati High Court ",
    "Goa_high_court" => "Goa High Court ",
    "Gujarat_high_court" => "Gujarat High Court ",
    "Himachal_pradesh_high_court" => "Himachal Pradesh High Court ",
    "Jaipur_high_court" => "Jaipur High Court ",
    "Jammu_high_court" => "Jammu High Court ",
    "Jharkhand_high_court" => "Jharkhand High Court ",
    "Karnataka_high_court" => "Karnataka High Court ",
    "Kerala_high_court" => "Kerala High Court ",
    "Madhya_pradesh_high_court" => "Madhya Pradesh High Court ",
    "Madras_high_court" => "Madras High Court ",
    "Manipur_high_court" => "Manipur High Court ",
    "Meghalaya_high_court" => "Meghalaya High Court ",
    "Orissa_high_court" => "Orissa High Court ",
    "Patna_high_court" => "Patna High Court ",
    "Sikkim_high_court" => "Sikkim High Court ",
    "Punjab_and_Haryana_high_ourt" => "Punjab and Haryana High Court",
    "Rajasthan_high_court" => "Rajasthan High Court",
    "Tripura_high_court" => "Tripura High Court ",
    "Telangana_high_court" => "Telangana High Court ",
    "Uttarakhand_high_court" => "Uttarakhand High Court ",
];
if (isset($form) && isset($model)) {
    echo $form->field($model, 'court')
        ->dropDownList(
            $items,           // Flat array ('id'=>'label')
            ['prompt' => 'Select Court']    // options
        )->label(false);
}
?>
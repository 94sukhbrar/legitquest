<?php

$items = [
    "HIDO" => "Supreme Court ",
    "AP211" => "Allahabad High Court ",
    "CG1811" => "Andhra Pradesh High Court ",
    //"bombay_high_court" => "Bombay High Court ",
    //"calcutta_high_court" => "Calcutta High Court ",
    "GJ1711" => "Chhattisgarh High Court ",
    //"delhi_high_court" => "Delhi High Court ",
    //"Guwahati_high_court" => "Guwahati High Court ",
    //"Goa_high_court" => "Goa High Court ",
    "GJ1711" => "Gujarat High Court ",
    "HP511" => "Himachal Pradesh High Court ",
    "RJ911(jaipur)" => "Jaipur High Court ",
    "JK1211" => "Jammu High Court ",
    //"Jharkhand_high_court" => "Jharkhand High Court ",
    //"Karnataka_high_court" => "Karnataka High Court ",
    "KL411" => "Kerala High Court ",
    //"Madhya_pradesh_high_court" => "Madhya Pradesh High Court ",
    "TN1011" => "Madras High Court ",
    "MN2511" => "Manipur High Court ",
    "ML2111" => "Meghalaya High Court ",
    "OR1111" => "Orissa High Court ",
    //"Patna_high_court" => "Patna High Court ",
    "SK2411" => "Sikkim High Court ",
    //"Punjab_and_Haryana_high_ourt" => "Punjab and Haryana High Court",
    "RJ912 (jodhpur)" => "Rajasthan High Court",
    "TR2011" => "Tripura High Court ",
    "TE2911" => "Telangana High Court ",
    "UK1511" => "Uttarakhand High Court ",
];
if (isset($form) && isset($model)) {
    echo $form->field($model, 'court')
        ->dropDownList(
            $items,           // Flat array ('id'=>'label')
            ['prompt' => 'Select Court']    // options
        )->label(false);
}
?>
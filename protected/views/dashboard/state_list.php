<!-- <select class="form-control" name="ScrapperForm[court]">
    <option>Select Court </option>
    <option value="supreme_court">Supreme Court </option>
    <option value="allahabad_high_court">Allahabad High Court </option>
    <option value="andhra_pradesh_high_court">Andhra Pradesh High Court </option>
    <option value="bombay_high_court">Bombay High Court </option>
    <option value="calcutta_high_court">Calcutta High Court </option>
    <option value="chhattisgarh_high_court">Chhattisgarh High Court </option>
    <option value="delhi_high_court">Delhi High Court </option>
    <option value="Guwahati_high_court">Guwahati High Court </option>
    <option value="Goa_high_court">Goa High Court </option>
    <option value="Gujarat_high_court">Gujarat High Court </option>
    <option value="Himachal_pradesh_high_court">Himachal Pradesh High Court </option>
    <option value="Jaipur_high_court">Jaipur High Court </option>
    <option value="Jammu_high_court">Jammu High Court </option>
    <option value="Jharkhand_high_court">Jharkhand High Court </option>
    <option value="Karnataka_high_court">Karnataka High Court </option>
    <option value="Kerala_high_court">Kerala High Court </option>
    <option value="Madhya_pradesh_high_court">Madhya Pradesh High Court </option>
    <option value="Madras_high_court">Madras High Court </option>
    <option value="Manipur_high_court">Manipur High Court </option>
    <option value="Meghalaya_high_court">Meghalaya High Court </option>
    <option value="Orissa_high_court">Orissa High Court </option>
    <option value="Patna_high_court">Patna High Court </option>
    <option value="Sikkim_high_court">Sikkim High Court </option>
    <option value="Punjab_and_Haryana_high_ourt">Punjab and Haryana High Court</option>
    <option value="Rajasthan_high_court">Rajasthan High Court</option>
    <option value="Tripura_high_court">Tripura High Court </option>
    <option value="Telangana_high_court">Telangana High Court </option>
    <option value="Uttarakhand_high_court">Uttarakhand High Court </option>
</select> -->

<?php

$items = [
    "supreme_court"=>"Supreme Court ",
    "allahabad_high_court"=>"Allahabad High Court ",
    "andhra_pradesh_high_court"=>"Andhra Pradesh High Court ",
    "bombay_high_court"=>"Bombay High Court ",
    "calcutta_high_court"=>"Calcutta High Court ",
    "chhattisgarh_high_court"=>"Chhattisgarh High Court ",
    "delhi_high_court"=>"Delhi High Court ",
    "Guwahati_high_court"=>"Guwahati High Court ",
    "Goa_high_court"=>"Goa High Court ",
    "Gujarat_high_court"=>"Gujarat High Court ",
    "Himachal_pradesh_high_court"=>"Himachal Pradesh High Court ",
    "Jaipur_high_court"=>"Jaipur High Court ",
    "Jammu_high_court"=>"Jammu High Court ",
    "Jharkhand_high_court"=>"Jharkhand High Court ",
    "Karnataka_high_court"=>"Karnataka High Court ",
    "Kerala_high_court"=>"Kerala High Court ",
    "Madhya_pradesh_high_court"=>"Madhya Pradesh High Court ",
    "Madras_high_court"=>"Madras High Court ",
    "Manipur_high_court"=>"Manipur High Court ",
    "Meghalaya_high_court"=>"Meghalaya High Court ",
    "Orissa_high_court"=>"Orissa High Court ",
    "Patna_high_court"=>"Patna High Court ",
    "Sikkim_high_court"=>"Sikkim High Court ",
    "Punjab_and_Haryana_high_ourt"=>"Punjab and Haryana High Court",
    "Rajasthan_high_court"=>"Rajasthan High Court",
    "Tripura_high_court"=>"Tripura High Court ",
    "Telangana_high_court"=>"Telangana High Court ",
    "Uttarakhand_high_court"=>"Uttarakhand High Court ",

];
if(isset($form) && isset($model)){
echo $form->field($model, 'court')
->dropDownList(
    $items,           // Flat array ('id'=>'label')
    ['prompt'=>'Select Court']    // options
)->label(false);

}
?>
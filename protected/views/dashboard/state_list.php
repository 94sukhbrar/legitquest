

<?php

$items =   Yii::$app->params['stateList'];
if(isset($addationalParams)){
     unset( $items["HIDO"] );
     unset( $items["DL1112"]);
     unset( $items["DL1111"]);      
    $items = array_merge($addationalParams,$items);
}
if (isset($form) && isset($model)) {
    echo $form->field($model, 'court')
        ->dropDownList(
            $items,           // Flat array ('id'=>'label')

            ['prompt' => 'Select Court','options'=> ['data-id' =>'asdsa'] ]    // options
        )->label(false);
}
?>
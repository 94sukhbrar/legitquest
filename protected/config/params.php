<?php
$constants = require (__DIR__ . '/constants.php');
/**
*@copyright :Amusoftech Pvt. Ltd. < www.amusoftech.com >
*@author     : Ram mohamad Singh< er.amudeep@gmail.com >
*/
return [
    'adminEmail' => 'amusoftech@gmail.com',
    'company' => 'Amusoftech Pvt Ltd',
    'companyUrl' => 'https://www.toxsl.com',
    'user.passwordResetTokenExpire' => 60 * 1024,
    'bsVersion' => '4.3.1',
    'useCrudModals' => true,
    'apiUrl'=>"https://ffdnw92kh1.execute-api.ap-south-1.amazonaws.com/default/lambda_query?",
    'highCourtScraper' =>'https://ffdnw92kh1.execute-api.ap-south-1.amazonaws.com/default/high_court_scraper?',
    'getPDFdocURL'=>"https://ffdnw92kh1.execute-api.ap-south-1.amazonaws.com/default/fetch-links?",
    'stateList' =>[
        "HIDO" => "Supreme Court ",
        "allahabad_high_court" => "Allahabad High Court ",
        "AP211" => "Andhra Pradesh High Court ",
        "bombay_high_court" => "Bombay High Court ",
        "calcutta_high_court" => "Calcutta High Court ",
        "CG1811" => "Chhattisgarh High Court ",
        "delhi_high_court" => "Delhi High Court ",
        "Guwahati_high_court" => "Guwahati High Court ",
        "Goa_high_court" => "Goa High Court ",
        "GJ1711" => "Gujarat High Court ",
        "HP511" => "Himachal Pradesh High Court ",
        "RJ911(jaipur)" => "Jaipur High Court ",
        "JK1211" => "Jammu High Court ",
        "Jharkhand_high_court" => "Jharkhand High Court ",
        "Karnataka_high_court" => "Karnataka High Court ",
        "KL411" => "Kerala High Court ",
        "Madhya_pradesh_high_court" => "Madhya Pradesh High Court ",
        "TN1011" => "Madras High Court ",
        "MN2511" => "Manipur High Court ",
        "ML2111" => "Meghalaya High Court ",
        "Orissa_high_court" => "Orissa High Court ",
        "Patna_high_court" => "Patna High Court ",
        "SK2411" => "Sikkim High Court ",
        "Punjab_and_Haryana_high_ourt" => "Punjab and Haryana High Court",
        "Rajasthan_high_court" => "Rajasthan High Court",
        "TR2011" => "Tripura High Court ",
        "TE2911" => "Telangana High Court ",
        "UK1511" => "Uttarakhand High Court ",
    ],
    'maxScrapDays' =>30,
    'getPDFdocURL'=>"https://ffdnw92kh1.execute-api.ap-south-1.amazonaws.com/default/fetch-links?",
    'checlApiUrl'=>'https://ffdnw92kh1.execute-api.ap-south-1.amazonaws.com/default/Lambda_random_initial_query?',
    'constants' => $constants,
];
//  Judgements => JU
//Daily Orders => DO

// HIDO for highe court => fixed  
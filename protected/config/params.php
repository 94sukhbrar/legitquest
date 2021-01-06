<?php
$constants = require(__DIR__ . '/constants.php');
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
    'apiUrl' => "https://ffdnw92kh1.execute-api.ap-south-1.amazonaws.com/default/lambda_query?",
    'highCourtScraper' => 'https://ffdnw92kh1.execute-api.ap-south-1.amazonaws.com/default/high_court_scraper?',
    'getPDFdocURL' => "https://ffdnw92kh1.execute-api.ap-south-1.amazonaws.com/default/fetch-links?",
    'stateCodes' => [
        "AndhraPradesh" =>  [
            "state_cd" => 2,
            "dist_cd" => 1,
            "court_code" => 1
        ],
        "Chhattisgarh" => [
            "state_cd" => 18,
            'dist_cd' => 1,
            "court_code" => 1
        ],
        "Gujarat" => ["state_cd" => 17, "dist_cd" => 1,  "court_code" => 1],
        "HimachalPradesh" => ["state_cd" => 5, "dist_cd" => 1, "court_code" => 1,],
        "Rajasthan" => ["state_cd" => 9, "dist_cd" => 1, "court_code" => 1,],
        "JammuandKashmir" => ["state_cd"=>12,"dist_cd"=>1 ,"court_code"=>1] ,
        "Kerala"=> ["state_cd"=>4,"dist_cd"=>1, "court_code" =>1 ],
        "Madras" => ["state_cd"=>10,"dist_cd"=>1,"court_code"=>1],
        "Manipur"=>  ["state_cd"=>25,"dist_cd"=>1,"court_code"=>1],
        "Meghalaya" => ["state_cd"=>21,"dist_cd"=>1,"court_code"=>1],
        "Odisha"=> [ "state_cd"=>11,"dist_cd"=>1,"court_code"=>1],
        "Sikkim"=> [ "state_cd"=>11,"dist_cd"=>1, "court_code"=>1],
        "Tripura" => ["state_cd"=>20,"dist_cd"=>1,"court_code"=>1],
        "Telangana"=> ["state_cd"=>29,"dist_cd"=>1,"court_code"=>1],
        "Uttarakhand" => [ "state_cd"=>15,"dist_cd"=>1,"court_code"=>1],
        "JammuandKashmir"=>[ "state_cd"=>12,"dist_cd"=>1,"court_code"=>2],
        "Madras" => ["state_cd"=>10,"dist_cd"=>1,"court_code"=>2],


    ],
    'stateList' => [
        "HIDO" => "Supreme Court ",
        "AP211" => "Andhra Pradesh High Court ",
        "CG1811" => "Chhattisgarh High Court ",
        "GJ1711" => "Gujarat High Court ",
        "HP511" => "Himachal Pradesh High Court ",
        "RJ911(jaipur)" => "Jaipur High Court ",
        "JK1211" => "Jammu High Court ",
        "TN1011" => "Madras High Court (Madurai) ",
        "MN2511" => "Manipur High Court ",
        "ML2111" => "Meghalaya High Court ",
        "SK2411" => "Orissa High Court ",
        "KL411" => "Kerala High Court ",
        "RJ912 (jodhpur)" => "Rajasthan High Court",
        "TR2011" => "Tripura High Court ",
        "TE2911" => "Telangana High Court ",
        "UK1511" => "Uttarakhand High Court ",
        "SK2411" => "Sikkim High Court ",
        //"allahabad_high_court" => "Allahabad High Court ",
        //"bombay_high_court" => "Bombay High Court ",
        // "calcutta_high_court" => "Calcutta High Court ",
        //"delhi_high_court" => "Delhi High Court ",
        //"Guwahati_high_court" => "Guwahati High Court ",
        //"Goa_high_court" => "Goa High Court ",
        // "Jharkhand_high_court" => "Jharkhand High Court ",
        //"Karnataka_high_court" => "Karnataka High Court ",
        //"Madhya_pradesh_high_court" => "Madhya Pradesh High Court ",
        //"Patna_high_court" => "Patna High Court ",
        //"Punjab_and_Haryana_high_ourt" => "Punjab and Haryana High Court",

    ],
    'maxScrapDays' => 30,
    'getPDFdocURL' => "https://ffdnw92kh1.execute-api.ap-south-1.amazonaws.com/default/fetch-links?",
    'checlApiUrl' => 'https://ffdnw92kh1.execute-api.ap-south-1.amazonaws.com/default/Lambda_random_initial_query?',
    'checkApiUrl' => "https://ffdnw92kh1.execute-api.ap-south-1.amazonaws.com/default/check_button?",
    'supremeCourtJudgementsApiUrl' =>  "https://ffdnw92kh1.execute-api.ap-south-1.amazonaws.com/default/supreme_court_scraper?scraping_type=Judgements&",
    'supremeCourtOrdersApiUrl' => "https://ffdnw92kh1.execute-api.ap-south-1.amazonaws.com/default/supreme_court_scraper?scraping_type=Orders&",
    "logsApi" =>   "https://ffdnw92kh1.execute-api.ap-south-1.amazonaws.com/default/fetch_court_logs",
    'constants' => $constants,
];
//  Judgements => JU
//Daily Orders => DO

// HIDO for highe court => fixed  
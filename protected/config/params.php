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

        "AP211" =>  [
            "state_name" => "AndhraPradesh",
            "state_cd" => 2,
            "dist_cd" => 1,
            "court_code" => 1
        ],
        "CG1811" => [
            "state_name" => "Chhattisgarh",
            "state_cd" => 18,
            'dist_cd' => 1,
            "court_code" => 1
        ],
        "GJ1711" => ["state_name" => "Gujarat", "state_cd" => 17, "dist_cd" => 1,  "court_code" => 1],
        "HP511" => ["state_name" => "HimachalPradesh", "state_cd" => 5, "dist_cd" => 1, "court_code" => 1,],
        "RJ911" => ["state_name" => "Rajasthan", "state_cd" => 9, "dist_cd" => 1, "court_code" => 1,],
        "JK1211" => ["state_name" => "JammuandKashmir", "state_cd" => 12, "dist_cd" => 1, "court_code" => 1],
        "TN1011" => ["state_name" => "Madras", "state_cd" => 10, "dist_cd" => 1, "court_code" => 1],
        "MN2511" =>  ["state_name" => "Manipur", "state_cd" => 25, "dist_cd" => 1, "court_code" => 1],
        "ML2111" => ["state_name" => "Meghalaya", "state_cd" => 21, "dist_cd" => 1, "court_code" => 1],
        "JK1212" => ["state_name" => "JammuandKashmir", "state_cd" => 12, "dist_cd" => 1, "court_code" => 2],
        "TN1012" => ["state_name" => "Madras", "state_cd" => 10, "dist_cd" => 1, "court_code" => 2],
        "SK2411" => ["state_name" => "Sikkim", "state_cd" => 24, "dist_cd" => 1, "court_code" => 1],
        "OR1111" =>   ["state_name" => "Odisha", "state_cd" => 11, "dist_cd" => 1, "court_code" => 1],
        "KL411" =>  ["state_name" => "Kerala", "state_cd" => 4, "dist_cd" => 1, "court_code" => 1],
        "RJ912"  =>  ["state_name" => "Rajasthan", "state_cd" => 9, "dist_cd" => 1, "court_code" => 2],
        "TR2011" =>  ["state_name" => "Tripura", "state_cd" => 20, "dist_cd" => 1, "court_code" => 1],
        "TE2911" => ["state_name" => "Telangana", "state_cd" => 29, "dist_cd" => 1, "court_code" => 1],
        "UK1511" => ["state_name" => "Uttarakhand",  "state_cd" => 15, "dist_cd" => 1, "ourt_code" => 1],

        "KA312" =>  ["state_name" => "Karnataka", "state_cd" => 3, "dist_cd" => 1, "court_code" => 2],
        "KA313" => ["state_name" => "Karnataka", "state_cd" => 3, "dist_cd" => 1, "court_code" => 3],
        "KA311" => ["state_name" => "Karnataka", "state_cd" => 3, "dist_cd" => 1, "court_code" => 1],
        "JH711" => ["state_name" => "Jharkhand", "state_cd" => "7", "dist_cd" => 1, "court_code" => 1],
        "MH115" => ["state_name" => "Bombay", "state_cd" => 1, "dist_cd" => 1, "court_code" => 5],
        "AS611" => ["state_name" => "Assam", "state_cd" => 6, "dist_cd" => 1, "court_code" => 1],
        "DL1112" => ["state_name" => "DelhiDO", "state_cd" => 91, "dist_cd" => 1, "court_code" => 1],
        "DL1111" =>  ["state_name" => "DelhiJU", "state_cd" => 90, "dist_cd" => 1, "court_code" => 1],
        "WB1611" => ["state_name" => "Calcutta", "state_cd" => 16, "dist_cd" => 1, "court_code" => 1],
        "BB1117" => ["state_name" => "aurangabadcriminal", "state_cd" => 2, "dist_cd" => 1, "court_code" => 1],
        "BB1116" => ["state_name" => "aurangabadcivil", "state_cd" => 2, "dist_cd" => 1, "court_code" => 1],
        "BB1115" => ["state_name" => "nagpurcriminal", "state_cd" => 2, "dist_cd" => 1, "court_code" => 1],
        "BB1114" => ["state_name" => "nagpurcivil", "state_cd" => 2, "dist_cd" => 1, "court_code" => 1],
        "BB1113" => ["state_name" => "bombayoriginal", "state_cd" => 2, "dist_cd" => 1, "court_code" => 1],
        "BB1112" => ["state_name" => "bombaycriminal", "state_cd" => 2, "dist_cd" => 1, "court_code" => 1],
        "BB1111" => ["state_name" => "bombaycivil", "state_cd" => 2, "dist_cd" => 1, "court_code" => 1],
        "PU1111"=>  [ "state_name"=>"Punjab", "state_cd"=>24, "dist_cd"=>1,"court_code"=>1],
        "UP1111" =>[ "state_name"=> "Allahabad","state_cd"=>1, "dist_cd"=>1, "court_code" =>1],
        "BH1111" => ["state_name"=>"BH1111",  "state_cd"=>1, "dist_cd"=>1,"court_code"=>1	],
        "MP1111" => ["state_name"=>"MadhyaPradesh", "state_cd"=>1, "dist_cd"=>1, "court_code"=>1]
    ],
    'stateList' => [
        "HIDO" => "Supreme Court ",
        "AP211" => "Andhra Pradesh High Court ",
        "CG1811" => "Chhattisgarh High Court ",
        "GJ1711" => "Gujarat High Court ",
        "HP511" => "Himachal Pradesh High Court ",
        "RJ911" => "Rajasthan High Court [Bench at Jaipur]",
        "RJ912" => "Rajasthan High Court [Principal Seat, Jodhpur] ",
        "JK1211" => "High Court of Jammu & Kashmir [Jammu Wing] ",
        "JK1212" => "High Court of Jammu & Kashmir [Srinagar Wing] ",
        "TN1011" => "Madras High Court ",
        //"TN1012" => "Madras High Court (Madurai) ",
        "MN2511" => "Manipur High Court ",
        "ML2111" => "Meghalaya High Court ",
        "OR1111" => "Orissa High Court ",
        "KL411" => "Kerala High Court ",
        "TR2011" => "Tripura High Court ",
        "TE2911" => "Telangana High Court ",
        "UK1511" => "Uttarakhand High Court ",
        "SK2411" => "Sikkim High Court ",
        "KA312" => "Karnataka High Court [Dharwad Bench At Karnataka]",
        "KA313" => "Karnataka High Court [Kalburagi Bench At Karnataka]",
        "KA311" => "Karnataka High Court [Principal Bench at Bengaluru]",
        "JH711" => "Jharkhand High Court",
        "MH115" => "Goa High Court",
        "AS611" => "Guwahati High Court",
        "DL1112" => "Delhi High Court [order]",
        "DL1111" => "Delhi High Court [Judgements]",
        "WB1611" => "Calcutta High Court",
        "BB1117" => "Bombay High Court [Aurangabad-Criminal]",
        "BB1116" => 'Bombay High Court [Aurangabad-Civil]',
        "BB1115" => "Bombay High Court [Nagpur-Criminal]",
        "BB1114" => "Bombay High Court [Nagpur-Civil]",
        "BB1113" => "Bombay High Court [Bombay-Original]",
        "BB1112" => "Bombay High Court [Bombay - Appellate (Criminal)]",
        "BB1111" => "Bombay High Court [Bombay - Appellate (Civil)]",
        "PU1111" =>  "Punjab and Haryana High Court",
        "UP1111" => "Allahabad High Court",
        "BH1111" => "Patna High Court",
        "MP1111" => "Madhya Pradesh High Court "
        
    ],
    "expeptionalCases" => [ #for highe courts only 
        "DL1111" => "DLJU",
        "DL1112" => "DLDO",

    ],
    'maxScrapDays' => 30,
    'getPDFdocURL' => "https://ffdnw92kh1.execute-api.ap-south-1.amazonaws.com/default/fetch-links?",
    'recordByCourtApiUrl' => 'https://ffdnw92kh1.execute-api.ap-south-1.amazonaws.com/default/Lambda_random_initial_query?',
    'checkApiUrl' => "https://ffdnw92kh1.execute-api.ap-south-1.amazonaws.com/default/check_button?",
    'supremeCourtJudgementsApiUrl' =>  "https://ffdnw92kh1.execute-api.ap-south-1.amazonaws.com/default/supreme_court_scraper?scraping_type=Judgements&",
    'supremeCourtOrdersApiUrl' => "https://ffdnw92kh1.execute-api.ap-south-1.amazonaws.com/default/supreme_court_scraper?scraping_type=Orders&",
    "logsApi" =>   "https://ffdnw92kh1.execute-api.ap-south-1.amazonaws.com/default/fetch_court_logs",
    "countApiUrl" => "https://ffdnw92kh1.execute-api.ap-south-1.amazonaws.com/default/count_dashboard",
    'constants' => $constants,
];
//  Judgements => JU
//Daily Orders => DO

// HIDO for highe court => fixed  
//http://65.0.170.108/

<?php






return [
    'columns' => [
        'case_number',
        'petitioner_name',
        'respondent_name',
        'petitioner_advocate',
        'respondent_advocate',
        'bench',
        'judgement_by',
        'order_date',
        'case_type',
        'case_year',
        'order_type',
        'corrigendum',
        'court_number',
        'link', //PDF [Document]	
        'reportable_judgement'



    ],
    'columnNames' => [
        "IDNumber" => 1,
        "CaseType" => 2,
        "CaseNumber" => 3,
        "CaseYear" => 4,
        "CaseNo" => 5,
        "OrderDate" => 6,
        "FilingType" => 7,
        "Filingyear" => 8,
        "Link" =>  9,
        "OrderType" =>  10,
        "OrderNo" =>  11,
        "PetitionerName" => 12,
        "RespondentName" =>  13,
        "PetitionerAdvocate" => 14,
        "RespondentAdvocate" => 15,
        "JudgementBy" =>  16,
        "ReportableJudgement" =>  17,
        "FilingNo" =>  18,
        "CINo" =>  19,
        "PGNo" =>  20,
        "Corrigendum" =>  21,
        "CaseDescription" => 22,
        "Bench" => 23,
        "CaseStatus" =>  24,
        "CourtNumber" =>  25,
        "DiaryNumber" =>  26,
    ],
    /**
     * sttarting from `0` 
     */
    'columnAddationalData' => [
        'ID' =>  1,
        'Case Type' => 2,
        'Case Number' => 3,
        'Case Year' =>  4,
        'Case No' =>  5,
        'Order Date' => 6,
        'Doc Link' =>  7,
        'CI No' => 8,
        'Filing Number' =>  9,
        'Filing Date' =>  10,
        'Registration Number' =>  11,
        'Registration Date' =>  12,
        'CNR Number' =>  13,
        'First Hearing Date' =>  14,
        'Next Hearing Date' => 15,
        'Case Stage' =>  16,
        'Decision Date' => 17,
        'Case Status' =>  18,
        'Disposal Nature' => 19,
        'Coram' => 20,
        'Bench' =>  21,
        'District' => 22,
        'Judicial' =>  23,
        'Cause List' => 24,
        'Additional Info' =>  25,
        'Petitioner Info' =>  26,
        'Respondent info' =>  27,
        'Act' =>  28,
        'Section' => 29,
        'Court Detail' =>  30,
        'Case Detail' =>  31,
        'Decision' =>  32,
        'State' =>  33,
        'District Info' => 34,
        'Fir State' => 35,
        'Fir District' => 36,
        'Fir Police Station' =>  37,
        'Fir Number' =>  38,
        'Fir Year' =>  39,
        'Hearing Info' => 40,
        'Scrutiny Date' =>  41,
        'Objection Info' =>  42,
        'Compliance Date' =>  43,
        'Receipt Date' => 44
    ],
    'higheCourtoptions' =>  [
        [
            'label' => '  Judgements / Daily Orders',
            'value' => 'HIDO',
            'disabled' => false
        ],
        [
            "label" => 'Judgements',
            'value' => 'JU',
            'disabled' => true
        ],
        [
            'label' => 'Daily Orders',
            'value' => 'DO',
            'disabled' => true
        ],
        [
            'label' => ' Case Status',
            'value' => 'CS',
            'disabled' => false
        ],
        [
            'label' => ' Cause List',
            'value' => 'CL',
            'disabled' => false
        ],


    ],
    'columnPU1111New' => [
        'case_number',
        'file_uuid',
        'petitioner_name',
        'respondent_name',
        'judgement_by',
        'order_date',
        'link',
        'created_at',
        'updated_at',
    ],
    'columnSUJUNew' => [
        'judgement_date',
        'diary_number',
        'case_number',
        'petitioner_name',
        'respondent_name',
        'petitioner_advocate',
        'respondent_advocate',
        'bench',
        'judgement_by',
        'disposal_date',
        'filed_on',
        'last_listed',
        'status',
        'link',
        'lang',
    ],

    'SupreameCourtoptions' =>  [

        [
            "label" => 'Judgements',
            'value' => 'JU',
            'disabled' => false
        ],
        [
            'label' => 'Daily Orders',
            'value' => 'DO',
            'disabled' => false
        ],
        [
            'label' => ' Case Status',
            'value' => 'CS',
            'disabled' => false
        ],
        [
            'label' => ' Cause List',
            'value' => 'CL',
            'disabled' => false
        ],


    ]



];

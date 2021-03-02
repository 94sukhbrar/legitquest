<?php

return [

    'columnNames' => [
        "IDNumber" => 0,
        "CaseType" => 1,
        "CaseNumber" => 2,
        "CaseYear" => 3,
        "CaseNo" => 4,
        "OrderDate" => 5,
        "FilingType" => 6,
        "Filingyear" => 7,
        "Link" =>  8,
        "OrderType" =>  9,
        "OrderNo" =>  10,
        "PetitionerName" => 11,
        "RespondentName" =>  12,
        "PetitionerAdvocate" => 13,
        "RespondentAdvocate" => 14,
        "JudgementBy" =>  15,
        "ReportableJudgement" =>  16,
        "FilingNo" =>  17,
        "CINo" =>  18,
        "PGNo" =>  19,
        "Corrigendum" =>  20,
        "CaseDescription" => 21,
        "Bench" => 22,
        "CaseStatus" =>  23,
        "CourtNumber" =>  24,
        "DiaryNumber" =>  25,
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

<?php

return [

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

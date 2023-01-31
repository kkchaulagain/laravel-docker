<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    "mailgun" => [
        "domain" => env("MAILGUN_DOMAIN"),
        "secret" => env("MAILGUN_SECRET"),
        "endpoint" => env("MAILGUN_ENDPOINT", "api.mailgun.net"),
    ],

    "postmark" => [
        "token" => env("POSTMARK_TOKEN"),
    ],

    "ses" => [
        "key" => env("AWS_ACCESS_KEY_ID"),
        "secret" => env("AWS_SECRET_ACCESS_KEY"),
        "region" => env("AWS_DEFAULT_REGION", "us-east-1"),
    ],
    'openai' => [
        'key' => env('OPENAI_KEY', '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'),
        'engine' => env('OPENAI_ENGINE'),
    ],
    'prompt' => [
        'requirement' => '###' . PHP_EOL . 'PROJECT: Recruitment Management' . PHP_EOL .
            "DESCRIPTION: GCD HR & Management Company is looking for a CRM solution to manage recruitment requirements from clients, job seeker profiles, and applicants. We propose a cloud-based customized CRM to meet GCD's operational requirements. The CRM will store candidate profiles securely on the cloud, provide powerful search features, and manage customers and hiring activities end-to-end. The company currently uses Google Sheets but wants a more secure and easily accessible solution to avoid data loss. They are open to discussing specific details further. @@@" . PHP_EOL .
            'REQUIREMENTS: ["store candidates profiles ","support managing customers and hiring activities end to end","store candidates profiles","provide a powerful search to retrieve profiles easily","manage clients (business partners) locally and overseas","manage end-to-end hiring from clients","manage customers","match candidates for job positions","manage positions of clients","shortlist candidates for different clients and positions","track applicants of positions","manage communications with candidates","track interviews of candidates","track candidates hiring process","track candidates joining process","track service charges payments of candidates","track invoices of candidates","track candidates service charges collection","track candidates payments collection,","track visa process of candidates"] @@@' . PHP_EOL,
        'schema' => '###' . PHP_EOL . 'PROJECT: Recruitment Management' . PHP_EOL .
            "DESCRIPTION: GCD HR & Management Company is looking for a CRM solution to manage recruitment requirements from clients, job seeker profiles, and applicants. We propose a cloud-based customized CRM to meet GCD's operational requirements. The CRM will store candidate profiles securely on the cloud, provide powerful search features, and manage customers and hiring activities end-to-end. The company currently uses Google Sheets but wants a more secure and easily accessible solution to avoid data loss. They are open to discussing specific details further. @@@" . PHP_EOL .
            'REQUIREMENTS SUMMARY: ["store candidates profiles ","support managing customers and hiring activities end to end","store candidates profiles","provide a powerful search to retrieve profiles easily","manage clients (business partners) locally and overseas","manage end-to-end hiring from clients","manage customers","match candidates for job positions","manage positions of clients","shortlist candidates for different clients and positions","track applicants of positions","manage communications with candidates","track interviews of candidates","track candidates hiring process","track candidates joining process","track service charges payments of candidates","track invoices of candidates","track candidates service charges collection","track candidates payments collection,","track visa process of candidates"] @@@' . PHP_EOL.
        'Project Schema: [{"Organization":{"table":"organizations","model":"Organization","attributes":"id (int, PK); name (varchar); phone (varchar); address (varchar); created_at (timestamp); updated_at (timestamp)"}},{"Jobs":{"table":"jobs","model":"Job","attributes":"id (int, PK); customer_id (int); name (varchar); description (varchar); created_at (timestamp); updated_at (timestamp)","relations":{"customer":{"type":"many-to-one","foreign_key":"customer_id","model":"Organization"}}}},{"Candidate":{"table":"candidates","model":"Candidate","attributes":"id (int, PK); name (varchar); phone (varchar); email (varchar); address (varchar); created_at (timestamp); updated_at (timestamp)","relations":{"applications":{"type":"one-to-many","foreign_key":"candidate_id","model":"Application"}}}},{"Application":{"table":"applications","model":"Application","attributes":"id (int, PK); candidate_id (int); job_id (int); created_at (timestamp); updated_at (timestamp)","relations":{"candidate":{"type":"many-to-one","foreign_key":"candidate_id","model":"Candidate"},"job":{"type":"many-to-one","foreign_key":"job_id","model":"Job"}}}},{"Interview":{"table":"interviews","model":"Interview","attributes":"id (int, PK); application_id (int); datetime (timestamp); location (varchar); created_at (timestamp); updated_at (timestamp)","relations":{"application":{"type":"many-to-one","foreign_key":"application_id","model":"Application"}}}},{"Service":{"table":"services","model":"Service","attributes":"id (int, PK); application_id (int); amount (int); created_at (timestamp); updated_at (timestamp)","relations":{"application":{"type":"many-to-one","foreign_key":"application_id","model":"Application"}}}},{"Invoice":{"table":"invoices","model":"Invoice","attributes":"id (int, PK); application_id (int); amount (int); created_at (timestamp); updated_at (timestamp)","relations":{"application":{"type":"many-to-one","foreign_key":"application_id","model":"Application"}}}},{"ServiceCharge":{"table":"service_charges","model":"ServiceCharge","attributes":"id (int, PK); application_id (int); amount (int); created_at (timestamp); updated_at (timestamp)","relations":{"application":{"type":"many-to-one","foreign_key":"application_id","model":"Application"}}}},{"Payment":{"table":"payments","model":"Payment","attributes":"id (int, PK); application_id (int); amount (int); created_at (timestamp); updated_at (timestamp)","relations":{"application":{"type":"many-to-one","foreign_key":"application_id","model":"Application"}}}}]@@@' . PHP_EOL
    ]
];

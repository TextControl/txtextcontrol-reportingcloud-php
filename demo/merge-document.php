<?php

include_once 'bootstrap.php';

use TXTextControl\ReportingCloud\ReportingCloud;

$reportingCloud = new ReportingCloud([
    'username' => reporting_cloud_username(),
    'password' => reporting_cloud_password(),
]);

// ---------------------------------------------------------------------------------------------------------------------

$mergeData = [
    0 => [
        'yourcompany_companyname' => 'Text Control, LLC',
        'yourcompany_zip' => '28226',
        'yourcompany_city' => 'Charlotte',
        'yourcompany_street' => '6926 Shannon Willow Rd, Suite 400',
        'yourcompany_phone' => '704 544 7445',
        'yourcompany_fax' => '704-542-0936',
        'yourcompany_url' => 'www.textcontrol.com',
        'yourcompany_email' => 'sales@textcontrol.com',
        'invoice_no' => '778723',
        'billto_name' => 'Joey Montana',
        'billto_companyname' => 'Montana, LLC',
        'billto_customerid' => '123',
        'billto_zip' => '27878',
        'billto_city' => 'Charlotte',
        'billto_street' => '1 Washington Dr',
        'billto_phone' => '887 267 3356',
        'payment_due' => '20/1/2016',
        'payment_terms' => 'NET 30',
        'salesperson_name' => 'Mark Frontier',
        'delivery_date' => '20/1/2016',
        'delivery_method' => 'Ground',
        'delivery_method_terms' => 'NET 30',
        'recipient_name' => 'Joey Montana',
        'recipient_companyname' => 'Montana, LLC',
        'recipient_zip' => '27878',
        'recipient_city' => 'Charlotte',
        'recipient_street' => '1 Washington Dr',
        'recipient_phone' => '887 267 3356',
        'item' => [
            0 => [
                'qty' => '1',
                'item_no' => '1',
                'item_description' => 'Item description 1',
                'item_unitprice' => '2663',
                'item_discount' => '20',
                'item_total' => '2130.40',
            ],
            1 => [
                'qty' => '1',
                'item_no' => '2',
                'item_description' => 'Item description 2',
                'item_unitprice' => '5543',
                'item_discount' => '0',
                'item_total' => '5543',
            ],
        ],
        'total_discount' => '532.60',
        'total_sub' => '7673.4',
        'total_tax' => '537.138',
        'total' => '8210.538',
    ],
];

// copy data 10 times

for ($i = 0; $i < 10; $i++) {
    array_push($mergeData, $mergeData[0]);
}

// ---------------------------------------------------------------------------------------------------------------------

// Template is in template storage on backend server

$arrayOfBinaryData = $reportingCloud->mergeDocument($mergeData, 'PDF', 'sample_invoice.tx');

$destinationFilename = REPORTING_CLOUD_DEMO_OUTPUT_PATH   . '/sample_invoice_merged_remote.pdf';

file_put_contents($destinationFilename, $arrayOfBinaryData[0]);

dump($destinationFilename);

// ---------------------------------------------------------------------------------------------------------------------

// Template stored locally and uploaded to backend server on merge

$sourceFilename = REPORTING_CLOUD_DEMO_RESOURCE_PATH . '/test_template.tx';

$arrayOfBinaryData = $reportingCloud->mergeDocument($mergeData, 'PDF', null, $sourceFilename);

$destinationFilename = REPORTING_CLOUD_DEMO_OUTPUT_PATH   . '/sample_invoice_merged_local.pdf';

file_put_contents($destinationFilename, $arrayOfBinaryData[0]);

dump($destinationFilename);

// ---------------------------------------------------------------------------------------------------------------------

// Template stored locally and uploaded to backend server on merge
// append=true (also default, when not set)

$sourceFilename = REPORTING_CLOUD_DEMO_RESOURCE_PATH . '/test_template.tx';

$arrayOfBinaryData = $reportingCloud->mergeDocument($mergeData, 'PDF', null, $sourceFilename, true);

$destinationFilename = REPORTING_CLOUD_DEMO_OUTPUT_PATH . '/sample_invoice_merged_append_true_all.pdf';

file_put_contents($destinationFilename, $arrayOfBinaryData[0]);

dump($destinationFilename);

// ---------------------------------------------------------------------------------------------------------------------

// Template stored locally and uploaded to backend server on merge
// append=false

$sourceFilename = REPORTING_CLOUD_DEMO_RESOURCE_PATH . '/test_template.tx';

$arrayOfBinaryData = $reportingCloud->mergeDocument($mergeData, 'PDF', null, $sourceFilename, false);

foreach ($arrayOfBinaryData as $documentNo => $binaryData) {

    $destinationFilename = REPORTING_CLOUD_DEMO_OUTPUT_PATH . sprintf('/sample_invoice_merged_append_false_%d.pdf', $documentNo);

    file_put_contents($destinationFilename, $binaryData);

    dump($destinationFilename);
}

// ---------------------------------------------------------------------------------------------------------------------



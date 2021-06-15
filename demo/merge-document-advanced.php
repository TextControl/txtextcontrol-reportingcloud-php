<?php
declare(strict_types=1);

include_once __DIR__ . '/bootstrap.php';

use Faker\Factory as FakerFactory;
use TxTextControl\ReportingCloud\ReportingCloud;
use TxTextControl\ReportingCloud\Stdlib\ConsoleUtils;
use TxTextControl\ReportingCloud\Stdlib\FileUtils;
use TxTextControl\ReportingCloud\Stdlib\Path;

// ---------------------------------------------------------------------------------------------------------------------

/**
 * Using Faker, return some random merge data to insert into the template
 *
 * @return array
 */
$getMergeDataRecord = function (): array {

    $faker = FakerFactory::create();

    $dateFormat = 'j/n/Y';
    $domainName = 'textcontrol.com';

    $totalDiscount = 0;
    $totalSub = 0;

    $item = [];

    for ($i = 0; $i <= random_int(1, 5); $i++) {

        $qty             = random_int(1, 10);
        $itemNo          = sprintf('RA%-X-%d', $i, random_int(10000, 99999));
        $itemDescription = $faker->text;
        $itemUnitPrice   = random_int(10, 500);
        $itemDiscount    = random_int(10, 15);
        $itemTotal       = ($qty * $itemUnitPrice);
        $discount        = $itemTotal * ($itemDiscount / 100);

        $totalDiscount   = $totalDiscount + $discount;
        $totalSub        = ($totalSub + $itemTotal) - $totalDiscount;

        $item[] = [
            'qty'              => $qty,
            'item_no'          => $itemNo,
            'item_description' => $itemDescription,
            'item_unitprice'   => $itemUnitPrice,
            'item_discount'    => $itemDiscount,
            'item_total'       => $itemTotal,
        ];
    }

    $totalTax = $totalSub * 0.10; // 10% sales tax
    $total    = $totalSub + $totalTax;

    return [
        'yourcompany_companyname' => 'Text Control, LLC',
        'yourcompany_zip'         => '28226',
        'yourcompany_city'        => 'Charlotte',
        'yourcompany_street'      => '6926 Shannon Willow Rd, Suite 400',
        'yourcompany_phone'       => '704-544-0000',
        'yourcompany_fax'         => '704-544-0001',
        'yourcompany_url'         => sprintf('www.%s', $domainName),
        'yourcompany_email'       => sprintf('sales@%s', $domainName),
        'invoice_no'              => sprintf('R%s', random_int(100000000, 9999999999)),
        'billto_name'             => $faker->name,
        'billto_companyname'      => $faker->company,
        'billto_customerid'       => random_int(100000000, 9999999999),
        'billto_zip'              => $faker->postcode,
        'billto_city'             => $faker->city,
        'billto_street'           => $faker->streetAddress,
        'billto_phone'            => $faker->phoneNumber,
        'payment_due'             => date($dateFormat, time() + 30 * 24 * 60 * 60),
        'payment_terms'           => 'net 30 days',
        'salesperson_name'        => $faker->name,
        'delivery_date'           => date($dateFormat, time() + 30 * 24 * 60 * 60),
        'delivery_method'         => 'Ground',
        'delivery_method_terms'   => 'net 30 days',
        'recipient_name'          => $faker->name,
        'recipient_companyname'   => $faker->company,
        'recipient_zip'           => $faker->postcode,
        'recipient_city'          => $faker->city,
        'recipient_street'        => $faker->streetAddress,
        'recipient_phone'         => $faker->phoneNumber,
        'item'                    => $item,
        'total_discount'          => $totalDiscount,
        'total_sub'               => $totalSub,
        'total_tax'               => $totalTax,
        'total'                   => $total,
    ];
};

// ---------------------------------------------------------------------------------------------------------------------

// Instantiate ReportingCloud, using your API key

$reportingCloud = new ReportingCloud([
    'api_key' => ConsoleUtils::apiKey(),
]);

// ---------------------------------------------------------------------------------------------------------------------

// Build some random merge data

$mergeData = [];

for ($i = 0; $i < 10; $i++) {
    $mergeData[] = $getMergeDataRecord();
}

// ---------------------------------------------------------------------------------------------------------------------

// Template is stored locally and uploaded to backend server on merge

$sourceFilename = sprintf(
    '%s/test_template.tx',
    Path::resource()
);

$arrayOfBinaryData = $reportingCloud->mergeDocument(
    $mergeData,
    ReportingCloud::FILE_FORMAT_PDF,
    '',
    $sourceFilename
);

$destinationFilename = sprintf(
    '%s/sample_invoice_merged_local.pdf',
    Path::output()
);

// Write the document's binary data to disk

FileUtils::write($destinationFilename, $arrayOfBinaryData[0]);

// Output to console the location of the generated document

ConsoleUtils::writeLn('Written to "%s".', $destinationFilename);

// ---------------------------------------------------------------------------------------------------------------------

// Template is in template storage on backend server

$sourceFilename = sprintf(
    '%s/test_template.tx',
    Path::resource()
);

$reportingCloud->uploadTemplate($sourceFilename);

$arrayOfBinaryData = $reportingCloud->mergeDocument(
    $mergeData,
    ReportingCloud::FILE_FORMAT_PDF,
    'test_template.tx'
);

$destinationFilename = sprintf(
    '%s/sample_invoice_merged_remote.pdf',
    Path::output()
);

// Write the document's binary data to disk

FileUtils::write($destinationFilename, $arrayOfBinaryData[0]);

// Output to console the location of the generated document

ConsoleUtils::writeLn('Written to "%s".', $destinationFilename);

// ---------------------------------------------------------------------------------------------------------------------

// Template is in template storage on backend server
// mergeSettings are set

$mergeSettings = [
    'author'                     => 'Text Control, LLC',
    'creation_date'              => time(),
    'creator_application'        => 'Your Invoice',
    'document_subject'           => 'Invoice, Payment',
    'document_title'             => 'Your Invoice for Services Rendered',
    'last_modification_date'     => time(),
    'merge_html'                 => false,
    'remove_empty_blocks'        => true,
    'remove_empty_fields'        => true,
    'remove_empty_images'        => true,
    'remove_trailing_whitespace' => true,
    'user_password'              => '1', // NOTE: You need to enter this password when opening the PDF file
    'culture'                    => 'en-US',
];

$sourceFilename = sprintf(
    '%s/test_template.tx',
    Path::resource()
);

$reportingCloud->uploadTemplate($sourceFilename);

$arrayOfBinaryData = $reportingCloud->mergeDocument(
    $mergeData,
    ReportingCloud::FILE_FORMAT_PDF,
    'test_template.tx',
    '',
    true,
    $mergeSettings
);

$destinationFilename = sprintf(
    '%s/sample_invoice_merged_remote_merge_settings.pdf',
    Path::output()
);

// Write the document's binary data to disk

FileUtils::write($destinationFilename, $arrayOfBinaryData[0]);

// Output to console the location of the generated document

ConsoleUtils::writeLn('Written to "%s".', $destinationFilename);

// ---------------------------------------------------------------------------------------------------------------------

// Template is stored locally and uploaded to backend server on merge
// append=true (also default, when not set)

$sourceFilename = sprintf(
    '%s/test_template.tx',
    Path::resource()
);

$arrayOfBinaryData = $reportingCloud->mergeDocument(
    $mergeData,
    ReportingCloud::FILE_FORMAT_PDF,
    '',
    $sourceFilename,
    true
);

$destinationFilename = sprintf(
    '%s/sample_invoice_merged_append_true_all.pdf',
    Path::output()
);

// Write the document's binary data to disk

FileUtils::write($destinationFilename, $arrayOfBinaryData[0]);

// Output to console the location of the generated document

ConsoleUtils::writeLn('Written to "%s".', $destinationFilename);

// ---------------------------------------------------------------------------------------------------------------------

// Template stored locally and uploaded to backend server on merge
// append=false

$sourceFilename = sprintf(
    '%s/test_template.tx',
    Path::resource()
);

$arrayOfBinaryData = $reportingCloud->mergeDocument(
    $mergeData,
    ReportingCloud::FILE_FORMAT_PDF,
    '',
    $sourceFilename,
    false
);

foreach ($arrayOfBinaryData as $index => $binaryData) {

    // Specify document number (index is 0-based)

    $document = $index + 1;

    // Specify destination file and filenames

    $destinationFile = sprintf(
        'sample_invoice_merged_append_false_%d.pdf',
        $document
    );

    $destinationFilename = sprintf(
        '%s/%s',
        Path::output(),
        $destinationFile
    );

    // Write the document's binary data to disk

    FileUtils::write($destinationFilename, (string) $binaryData);

    // Output to console the location of the generated document

    ConsoleUtils::writeLn('Written to "%s".', $destinationFilename);
}

// ---------------------------------------------------------------------------------------------------------------------

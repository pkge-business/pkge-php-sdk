<?php
require './vendor/autoload.php';

use Pkge\API;

$apiKey = 'YOUR_API_KEY';
$trackNumber = 'Y0084838637';

$api = new API(
    $apiKey, //Your API key
    'en', //API language
    false //Expand related objects
);

/** Enable UPS courier */
$api->couriers->enable(17);
echo 'UPS courier was enabled' . PHP_EOL;


/** Detect possible couriers for tracking number */
try {
    $couriers = $api->couriers->detectForTrackNumber($trackNumber);
    $courierId = $couriers[0]->id;
    echo 'Detected courier: ' . $couriers[0]->name . PHP_EOL;
} catch (\Pkge\Exceptions\ApiCouriersNotDetectedException $e) {
    $courierId = -1;
}


/** Add a package with error filled destination country code */
try {
    echo 'Trying to add package with incorrectly filled fields...' . PHP_EOL;
    $addedPackage = $api->packages->add($trackNumber, $courierId, [
        'destinationCountry' => 'USUS'
    ]);
} catch (\Pkge\Exceptions\ApiRequestValidationException $e) {
    echo 'Validation errors: ' . PHP_EOL;
    foreach ($e->getValidationErrors() as $field => $description) {
        echo $field . ': ' . $description . PHP_EOL;
    }

    /** Add a package without error filled fields */
    echo 'Trying to add package without incorrectly filled fields...' . PHP_EOL;
    $addedPackage = $api->packages->add($trackNumber, $courierId, [
        'destinationCountry' => 'US',
        'recipientName' => 'Recipient Name Here'
    ]);
} catch (\Pkge\Exceptions\ApiTrackNumberExistsException $e) {
    die($e->getMessage() . PHP_EOL);
}
echo 'Package was successfully added: ' . $addedPackage->trackNumber . PHP_EOL;


/** Edit a package */
$editedPackage = $api->packages->edit($addedPackage->trackNumber, [
    'note' => 'Custom package note',
    'recipientName' => 'David Recipient'
]);
echo 'Package was edited: ' . $addedPackage->trackNumber . PHP_EOL;


/** Start updating package checkpoints */
echo 'Starting package update...' . PHP_EOL;
$updatingStatus = $api->packages->update($addedPackage->trackNumber);

$i = 0;
do {
    sleep(10);
    $updatingStatus = $api->packages->getUpdatingStatus(
        $addedPackage->trackNumber,
        $updatingStatus->hash
    );

    if ($updatingStatus->isUpdating) {
        echo 'Package ' . $addedPackage->trackNumber . ' is still updating...' . PHP_EOL;
    }
    else {
        echo 'Package ' . $addedPackage->trackNumber . ' was updated successfully!' . PHP_EOL;
        sleep(3);
        print_r($updatingStatus->package->checkpoints);
        break;
    }
} while (++$i < 3);





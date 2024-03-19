<?php /** @noinspection PhpComposerExtensionStubsInspection */
// Script om Sonarqube automatisch te configureren, zodat er zonder handmatige configuratie
// Sonarqube en Jenkins te kunnen gebruiken. Hiervoor wordt gebruik gemaakt van de API van Sonarqube.

$sonarqubeUrl = 'http://sonarqube:9000';
$username = 'admin';
$password = 'admin';

$healthEndpoint = $sonarqubeUrl . '/api/v2/system/health';

// Script om to controleren als de Sonarqube-container volledig opgestart is.
$connected = false;
while (!$connected) {
    $healthRequest = curl_init($healthEndpoint);
    curl_setopt($healthRequest, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($healthRequest, CURLOPT_HTTPGET, true);
    curl_setopt($healthRequest, CURLOPT_USERPWD, "$username:$password");

    $response = curl_exec($healthRequest);

    if (!curl_errno($healthRequest)) {
        $connected = true;
    } else {
        echo 'Sonarqube not ready, sleeping 10s';
        sleep(10);
    }

    curl_close($healthRequest);
}

$status = '';
while ($status !== 'GREEN') {
    $healthRequest = curl_init($healthEndpoint);
    curl_setopt($healthRequest, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($healthRequest, CURLOPT_HTTPGET, true);
    curl_setopt($healthRequest, CURLOPT_USERPWD, "$username:$password");

    $response = curl_exec($healthRequest);

    if (!curl_errno($healthRequest)) {
        $statusResponse = json_decode($response, true);
        $status = $statusResponse['status'];
        if ($status !== 'GREEN') {
            echo 'Sonarqube status is not GREEN, sleeping 10s';
            sleep(10);
        }
    } else {
        echo 'Sonarqube not ready, sleeping 10s';
        sleep(10);
    }

    curl_close($healthRequest);
}

// Een gebruiker aanmaken om te gebruiken in Jenkins.
$usersEndpoint = $sonarqubeUrl . '/api/v2/users-management/users';
$jsonData = json_encode(array(
    "local" => true,
    "login" => "jenkins",
    "name" => "jenkins",
    "password" => "jenkins",
));

$usersRequest = curl_init($usersEndpoint);
curl_setopt($usersRequest, CURLOPT_POST, true);
curl_setopt($usersRequest, CURLOPT_RETURNTRANSFER, true);
curl_setopt($usersRequest, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
curl_setopt($usersRequest, CURLOPT_USERPWD, "$username:$password");
curl_setopt($usersRequest, CURLOPT_POSTFIELDS, $jsonData);


$response = curl_exec($usersRequest);
var_dump($response);
curl_close($usersRequest);

// Webhook instellen benodigd voor Quality Gate in Jenkins pipeline
$webhookEndpoint = $sonarqubeUrl . '/api/webhooks/create?name=jenkins&url=http://jenkins:8080/sonarqube-webhook';

$webhookRequest = curl_init($webhookEndpoint);

curl_setopt($webhookRequest, CURLOPT_RETURNTRANSFER, true);
curl_setopt($webhookRequest, CURLOPT_POST, true);
curl_setopt($webhookRequest, CURLOPT_USERPWD, "$username:$password");

$response = curl_exec($webhookRequest);

if (curl_errno($webhookRequest)) {
    echo 'Error: ' . curl_error($webhookRequest);
} else {
    $tokenData = json_decode($response, true);
    var_dump($tokenData);
}

// Jenkins gebruiken het recht geven om een analyse uit te voeren, zodat de Quality Gate gebruikt
// kan worden in een pipeline.
$permissionsEndpoint = $sonarqubeUrl . '/api/permissions/add_group?groupName=Anyone&permission=scan';

$permissionsRequest = curl_init($permissionsEndpoint);
curl_setopt($permissionsRequest, CURLOPT_RETURNTRANSFER, true);
curl_setopt($permissionsRequest, CURLOPT_POST, true);
curl_setopt($permissionsRequest, CURLOPT_USERPWD, "$username:$password");

$response = curl_exec($permissionsRequest);
var_dump($response);
curl_close($permissionsRequest);

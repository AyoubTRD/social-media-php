<?php
require __DIR__ . '/vendor/autoload.php';
$token = json_decode('{"access_token":"ya29.a0AfH6SMD8r6HR9eQ6gNuMqtiWCwa6S10x9Nr76XzMhVqE3fXyvW3ipZj2JLkELZs_X4HX1W1h-UObw1XUCcZ0FioI6jsX2dcdoYlvoMA_-f2_dnok5SsfnGqsaVJcS2fZ8OHIuRtYrEoP-MVcXqPXPwMPcOSdEI2MXMY","expires_in":3599,"scope":"https:\/\/www.googleapis.com\/auth\/drive","token_type":"Bearer","created":1591899949,"refresh_token":"1\/\/03-lTmfdTT8hpCgYIARAAGAMSNwF-L9Irz15CtaWZyprU74wSmavok8hQxE6bztXQ8IviYXlHO0q0OaMufFG7yn2TXdcvIpc4izw"}', true);

$config = json_decode('{"web":{"client_id":"199818702541-srh972mjbr1c0qns3avflncqhq62k3op.apps.googleusercontent.com","project_id":"quickstart-1574196423632","auth_uri":"https://accounts.google.com/o/oauth2/auth","token_uri":"https://oauth2.googleapis.com/token","auth_provider_x509_cert_url":"https://www.googleapis.com/oauth2/v1/certs","client_secret":"cSjPjJuW9QOqaQVzFBBIVxfj","redirect_uris":["http://localhost/"]}}', true);

function getClient($config, $accessToken)
{
    $client = new Google_Client();
    $client->setApplicationName('Google Drive API PHP Quickstart');
    $client->setScopes(Google_Service_Drive::DRIVE);
    $client->setAuthConfig($config);
    $client->setAccessType('offline');
    $client->setPrompt('select_account consent');

    $client->setAccessToken($accessToken);

    if ($client->isAccessTokenExpired()) {
        if ($client->getRefreshToken()) {
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
        } else {
            $authUrl = $client->createAuthUrl();
            printf("Open the following link in your browser:\n%s\n", $authUrl);
            print 'Enter verification code: ';
            $authCode = trim(fgets(STDIN));

            $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
            $client->setAccessToken($accessToken);

            if (array_key_exists('error', $accessToken)) {
                throw new Exception(join(', ', $accessToken));
            }
        }
    }
    return $client;
}


// Get the API client and construct the service object.
$client = getClient($config, $token);
$service = new Google_Service_Drive($client);

function upload_file($service, $file_content, $file_type='image/jpeg')
{
  $file = new Google_Service_Drive_DriveFile(array(
      'name' => uniqid(),
      'mimeType' => $file_type,
      'uploadType' => 'multipart',
      'properties' => array('something' => 'loeuf')
  ));
  $result = $service->files->create(
      $file,
      array(
          'data' => $file_content,
      )
  );

  $file_id = $result->getId();

  $service->getClient()->setUseBatch(true);
  $batch = $service->createBatch();
  $permission = new Google_Service_Drive_Permission([
    "type" => "anyone",
    "role" => "reader"
  ]);
  $request = $service->permissions->create(
    $file_id, $permission, array('fields' => 'id'));
  $batch->add($request, 'anyone');
  $batch->execute();
  $service->getClient()->setUseBatch(false);

  return "https://drive.google.com/uc?export=download&id=$file_id";
}

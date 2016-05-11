<?php

use Pyz\Shared\Mail\MailConstants;
use Spryker\Shared\Application\ApplicationConstants;
use Spryker\Shared\Payone\PayoneConstants;
use Spryker\Shared\Session\SessionConstants;

$config[ApplicationConstants::ZED_DB_ENGINE] = $config[ApplicationConstants::ZED_DB_ENGINE_PGSQL];
$config[ApplicationConstants::ZED_DB_USERNAME] = 'ubuntu';
$config[ApplicationConstants::ZED_DB_PASSWORD] = '';
$config[ApplicationConstants::ZED_DB_DATABASE] = 'circle_test';
$config[ApplicationConstants::ZED_DB_HOST] = '127.0.0.1';
$config[ApplicationConstants::ZED_DB_PORT] = 5432;

$config[ApplicationConstants::ELASTICA_PARAMETER__INDEX_NAME] = 'de_development_catalog';
$config[ApplicationConstants::ELASTICA_PARAMETER__DOCUMENT_TYPE] = 'page';

$config[ApplicationConstants::ELASTICA_PARAMETER__PORT] = '9200';

$yvesHost = 'www.de.spryker.dev';
$config[ApplicationConstants::YVES_SESSION_COOKIE_DOMAIN] = $yvesHost;
$config[ApplicationConstants::HOST_YVES] = 'http://' . $yvesHost;
$config[ApplicationConstants::HOST_STATIC_ASSETS] = $config[ApplicationConstants::HOST_STATIC_MEDIA] = $yvesHost;

$config[ApplicationConstants::HOST_SSL_YVES] = 'https://' . $yvesHost;
$config[ApplicationConstants::HOST_SSL_STATIC_ASSETS] = $config[ApplicationConstants::HOST_SSL_STATIC_MEDIA] = $yvesHost;

$zedHost = 'zed.de.spryker.dev';
$config[ApplicationConstants::HOST_ZED_GUI]
    = 'http://' . $zedHost;
$config[ApplicationConstants::HOST_ZED_API] = $zedHost;
$config[ApplicationConstants::HOST_SSL_ZED_GUI]
    = $config[ApplicationConstants::HOST_SSL_ZED_API]
    = 'https://' . $zedHost;

$config[ApplicationConstants::CLOUD_CDN_STATIC_MEDIA_HTTP] = 'http://static.de.spryker.dev';
$config[ApplicationConstants::CLOUD_CDN_STATIC_MEDIA_HTTPS] = 'https://static.de.spryker.dev';

$config[ApplicationConstants::JENKINS_BASE_URL] = 'http://localhost:10007/';
$config[MailConstants::MAILCATCHER_GUI] = 'http://' . $config[ApplicationConstants::HOST_ZED_GUI] . ':1080';

/* RabbitMQ */
$config[ApplicationConstants::ZED_RABBITMQ_HOST] = 'localhost';
$config[ApplicationConstants::ZED_RABBITMQ_PORT] = '5672';
$config[ApplicationConstants::ZED_RABBITMQ_USERNAME] = 'DE_development';
$config[ApplicationConstants::ZED_RABBITMQ_PASSWORD] = 'mate20mg';
$config[ApplicationConstants::ZED_RABBITMQ_VHOST] = '/DE_development_zed';

$config[ApplicationConstants::JENKINS_DIRECTORY] = APPLICATION_ROOT_DIR . '/shared/data/common/jenkins';

$config[ApplicationConstants::YVES_STORAGE_SESSION_REDIS_PROTOCOL] = 'tcp';
$config[ApplicationConstants::YVES_STORAGE_SESSION_REDIS_HOST] = '127.0.0.1';
$config[ApplicationConstants::YVES_STORAGE_SESSION_REDIS_PORT] = '6379';

$config[ApplicationConstants::ZED_STORAGE_SESSION_REDIS_PROTOCOL] = $config[ApplicationConstants::YVES_STORAGE_SESSION_REDIS_PROTOCOL];
$config[ApplicationConstants::ZED_STORAGE_SESSION_REDIS_PORT] = $config[ApplicationConstants::YVES_STORAGE_SESSION_REDIS_PORT];

$config[PayoneConstants::PAYONE] = [
    PayoneConstants::PAYONE_MODE => '',
];

$config[SessionConstants::SESSION_IS_TEST] = true;

$config[ApplicationConstants::APPLICATION_SPRYKER_ROOT] = APPLICATION_ROOT_DIR . '/vendor/spryker';

$config[MailConstants::MAIL_PROVIDER_MANDRILL] = [
    'api-key' => getenv('MAIL_PROVIDER_MANDRILL_API_KEY'),
    'host' => 'smtp.mandrillapp.com',
    'port' => '587',
    'username' => 'John Doe',
    'from_mail' => 'john.doe@spryker.com',
    'from_name' => 'Spryker Demoshop',
];

$config[PayoneConstants::PAYONE] = [
    PayoneConstants::PAYONE_CREDENTIALS_ENCODING => 'UTF-8',
    PayoneConstants::PAYONE_CREDENTIALS_KEY => getenv('PAYONE_CREDENTIALS_KEY'),
    PayoneConstants::PAYONE_CREDENTIALS_MID => getenv('PAYONE_CREDENTIALS_MID'),
    PayoneConstants::PAYONE_CREDENTIALS_AID => getenv('PAYONE_CREDENTIALS_AID'),
    PayoneConstants::PAYONE_CREDENTIALS_PORTAL_ID => getenv('PAYONE_CREDENTIALS_PORTAL_ID'),
    PayoneConstants::PAYONE_PAYMENT_GATEWAY_URL => 'https://api.pay1.de/post-gateway/',
    PayoneConstants::PAYONE_REDIRECT_SUCCESS_URL => $config[ApplicationConstants::HOST_YVES] . '/checkout/success/',
    PayoneConstants::PAYONE_REDIRECT_ERROR_URL => $config[ApplicationConstants::HOST_YVES] . '/checkout/index/',
    PayoneConstants::PAYONE_REDIRECT_BACK_URL => $config[ApplicationConstants::HOST_YVES] . '/checkout/regular-redirect-payment-cancellation/',
    PayoneConstants::PAYONE_MODE => '',
];

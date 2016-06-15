<?php

use Spryker\Shared\Application\ApplicationConstants;
use Spryker\Shared\Mail\MailConstants;

$yvesHost = 'www.com.spryker.dev';
$config[ApplicationConstants::HOST_YVES] = 'http://' . $yvesHost;
$config[ApplicationConstants::HOST_STATIC_ASSETS] = $config[ApplicationConstants::HOST_STATIC_MEDIA] = $yvesHost;

$config[ApplicationConstants::HOST_SSL_YVES] = 'https://' . $yvesHost;
$config[ApplicationConstants::HOST_SSL_STATIC_ASSETS] = $config[ApplicationConstants::HOST_SSL_STATIC_MEDIA] = $yvesHost;

$zedHost = 'zed.com.spryker.dev';
$config[ApplicationConstants::HOST_ZED_GUI]
    = $config[ApplicationConstants::HOST_ZED_API]
    = 'http://' . $zedHost;
$config[ApplicationConstants::HOST_SSL_ZED_GUI]
    = $config[ApplicationConstants::HOST_SSL_ZED_API]
    = 'https://' . $zedHost;

$config[ApplicationConstants::YVES_TRUSTED_HOSTS] = [$yvesHost, $zedHost];

$config[ApplicationConstants::CLOUD_CDN_STATIC_MEDIA_HTTP] = 'http://static.com.spryker.dev';
$config[ApplicationConstants::CLOUD_CDN_STATIC_MEDIA_HTTPS] = 'https://static.com.spryker.dev';

$config[MailConstants::MAILCATCHER_GUI] = 'http://' . $config[ApplicationConstants::HOST_ZED_GUI] . ':1080';

/* RabbitMQ */
$config[ApplicationConstants::ZED_RABBITMQ_HOST] = 'localhost';
$config[ApplicationConstants::ZED_RABBITMQ_PORT] = '5672';
$config[ApplicationConstants::ZED_RABBITMQ_USERNAME] = 'DE_development';
$config[ApplicationConstants::ZED_RABBITMQ_PASSWORD] = 'mate20mg';
$config[ApplicationConstants::ZED_RABBITMQ_VHOST] = '/DE_development_zed';

/* Elasticsearch */
$config[ApplicationConstants::ELASTICA_PARAMETER__INDEX_NAME] = 'us_search';

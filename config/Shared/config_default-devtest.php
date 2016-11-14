<?php

/**
 * This is the global runtime configuration for Yves and Generated_Yves_Zed in a development environment.
 */

use Spryker\Shared\Application\ApplicationConstants;
use Spryker\Shared\Payone\PayoneConstants;
use Spryker\Shared\Session\SessionConstants;
use Spryker\Shared\Storage\StorageConstants;

$config[SessionConstants::YVES_SESSION_SAVE_HANDLER] = SessionConstants::SESSION_HANDLER_REDIS;
$config[SessionConstants::ZED_SESSION_SAVE_HANDLER] = SessionConstants::SESSION_HANDLER_FILE;

$config[StorageConstants::STORAGE_REDIS_PROTOCOL] = 'tcp';
$config[StorageConstants::STORAGE_REDIS_HOST] = '127.0.0.1';
$config[StorageConstants::STORAGE_REDIS_PORT] = '10009';
$config[StorageConstants::STORAGE_REDIS_PASSWORD] = '';
$config[StorageConstants::STORAGE_REDIS_DATABASE] = 3;

$config[SessionConstants::YVES_SESSION_REDIS_PROTOCOL] = $config[StorageConstants::STORAGE_REDIS_PROTOCOL];
$config[SessionConstants::YVES_SESSION_REDIS_HOST] = $config[StorageConstants::STORAGE_REDIS_HOST];
$config[SessionConstants::YVES_SESSION_REDIS_PORT] = $config[StorageConstants::STORAGE_REDIS_PORT];
$config[SessionConstants::YVES_SESSION_REDIS_PASSWORD] = $config[StorageConstants::STORAGE_REDIS_PASSWORD];
$config[SessionConstants::YVES_SESSION_REDIS_DATABASE] = 4;

$config[SessionConstants::ZED_SESSION_REDIS_PROTOCOL] = $config[SessionConstants::YVES_SESSION_REDIS_PROTOCOL];
$config[SessionConstants::ZED_SESSION_REDIS_HOST] = $config[SessionConstants::YVES_SESSION_REDIS_HOST];
$config[SessionConstants::ZED_SESSION_REDIS_PORT] = $config[SessionConstants::YVES_SESSION_REDIS_PORT];
$config[SessionConstants::ZED_SESSION_REDIS_PASSWORD] = $config[SessionConstants::YVES_SESSION_REDIS_PASSWORD];

$config[SessionConstants::SESSION_IS_TEST] = false;

$config[PayoneConstants::PAYONE] = [
    PayoneConstants::PAYONE_MODE => '',
];

$config[ApplicationConstants::JENKINS_BASE_URL] = 'http://' . $config[ApplicationConstants::HOST_ZED_GUI] . ':10007/jenkins';
$config[ApplicationConstants::JENKINS_DIRECTORY] = '/data/shop/development/shared/data/common/jenkins';

$config[ApplicationConstants::APPLICATION_SPRYKER_ROOT] = APPLICATION_ROOT_DIR . '/vendor/spryker/spryker/Bundles';

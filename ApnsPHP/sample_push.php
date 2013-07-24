<?php
/**
 * @file
 * sample_push.php
 *
 * Push demo
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://code.google.com/p/apns-php/wiki/License
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to aldo.armiento@gmail.com so we can send you a copy immediately.
 *
 * @author (C) 2010 Aldo Armiento (aldo.armiento@gmail.com)
 * @version $Id: sample_push.php 65 2010-12-13 18:38:39Z aldo.armiento $
 */

// Adjust to your timezone
date_default_timezone_set('Asia/Tokyo');

// Report all PHP errors
error_reporting(-1);

// Using Autoload all classes are loaded on-demand
require_once 'ApnsPHP/Autoload.php';

// 開発用かリリース用かの設定とpemファイルの指定
$push = new ApnsPHP_Push(
	ApnsPHP_Abstract::ENVIRONMENT_PRODUCTION,
	'server_certificates_bundle_sandbox_production.pem'
);

//アップルリモートピアを検証するために、pemを指定する
$push->setRootCertificationAuthority('entrust_root_certification_authority.pem');

$push->connect();

// デバイストークンの設定
$message = new ApnsPHP_Message('fe85afc916011120e607e0f881723ad8c7fc6a396be1ccfadc2f46282468e7d1');

$message->setCustomIdentifier("Message-Badge-3");

$message->setBadge(3);

$message->setText('Hello APNs-enabled device!');

$message->setSound();

$message->setCustomProperty('acme2', array('bang', 'whiz'));

$message->setCustomProperty('acme3', array('bing', 'bong'));

$message->setExpiry(30);

$push->add($message);

$push->send();

$push->disconnect();

$aErrorQueue = $push->getErrors();
if (!empty($aErrorQueue)) {
	var_dump($aErrorQueue);
}

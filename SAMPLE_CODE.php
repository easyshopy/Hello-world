<?php
/**
 * Copyright (c) 2015-present, Facebook, Inc. All rights reserved.
 *
 * You are hereby granted a non-exclusive, worldwide, royalty-free license to
 * use, copy, modify, and distribute this software in source code or binary
 * form for use in connection with the web services and APIs provided by
 * Facebook.
 *
 * As with any software that integrates with the Facebook platform, your use
 * of this software is subject to the Facebook Developer Principles and
 * Policies [http://developers.facebook.com/policy/]. This copyright notice
 * shall be included in all copies or substantial portions of the software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL
 * THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER
 * DEALINGS IN THE SOFTWARE.
 *
 */

require __DIR__ . '/vendor/autoload.php';

use FacebookAds\Object\AdAccount;
use FacebookAds\Object\Campaign;
use FacebookAds\Object\AdSet;
use FacebookAds\Object\AdCreative;
use FacebookAds\Object\Ad;
use FacebookAds\Object\AdPreview;
use FacebookAds\Api;
use FacebookAds\Logger\CurlLogger;

$access_token = 'EAAHndEfLFLoBAAftjLiHGyn1Ve3C3YPRBjYED7m40CZCsx4anRNPaA2PunRGMiT9cBeS4n2UoiKQCXOdG9jWPEv58SmN9ZABwszQzdSj2urowb4jjCBqPEWu3pJ5r3ZAX1GhUCTHmGLVKZBNDvGSg8FgqDrVSmS1zhuA9PkWPnOBFISzh1ktZBOof08ZC1nPTOhkSqBDTPsAvEhRKuydiyScZB6pc9TipEZD';
$ad_account_id = 'act_121294161980375';
$app_secret = '0555a36b05b24b997188658698821f42';
$page_id = '517664731750458';
$app_id = '535961583424698';

$api = Api::init($app_id, $app_secret, $access_token);
$api->setLogger(new CurlLogger());

$fields = array(
);
$params = array(
  'objective' => 'PAGE_LIKES',
  'status' => 'PAUSED',
  'buying_type' => 'AUCTION',
  'name' => 'My Campaign',
);
$campaign = (new AdAccount($ad_account_id))->createCampaign(
  $fields,
  $params
);
$campaign_id = $campaign->id;
echo 'campaign_id: ' . $campaign_id . "\n\n";

$fields = array(
);
$params = array(
  'status' => 'PAUSED',
  'targeting' => array('geo_locations' => array('countries' => array('US'))),
  'daily_budget' => '1000',
  'billing_event' => 'IMPRESSIONS',
  'bid_amount' => '20',
  'campaign_id' => $campaign_id,
  'optimization_goal' => 'PAGE_LIKES',
  'promoted_object' => array('page_id' =>  $page_id),
  'name' => 'My AdSet',
);
$ad_set = (new AdAccount($ad_account_id))->createAdSet(
  $fields,
  $params
);
$ad_set_id = $ad_set->id;
echo 'ad_set_id: ' . $ad_set_id . "\n\n";

$fields = array(
);
$params = array(
  'body' => 'Like My Page',
  'image_url' => 'http://www.facebookmarketingdevelopers.com/static/images/resource_1.jpg',
  'name' => 'My Creative',
  'object_id' => $page_id,
  'title' => 'My Page Like Ad',
);
$creative = (new AdAccount($ad_account_id))->createAdCreative(
  $fields,
  $params
);
$creative_id = $creative->id;
echo 'creative_id: ' . $creative_id . "\n\n";

$fields = array(
);
$params = array(
  'status' => 'PAUSED',
  'adset_id' => $ad_set_id,
  'name' => 'My Ad',
  'creative' => array('creative_id' => $creative_id),
);
$ad = (new AdAccount($ad_account_id))->createAd(
  $fields,
  $params
);
$ad_id = $ad->id;
echo 'ad_id: ' . $ad_id . "\n\n";

$fields = array(
);
$params = array(
  'ad_format' => 'DESKTOP_FEED_STANDARD',
);
echo json_encode((new Ad($ad_id))->getPreviews(
  $fields,
  $params
)->getResponse()->getContent(), JSON_PRETTY_PRINT);


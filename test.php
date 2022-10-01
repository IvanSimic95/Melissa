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

require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';

use FacebookAds\Object\AdAccount;
use FacebookAds\Object\AdsInsights;
use FacebookAds\Api;
use FacebookAds\Logger\CurlLogger;

$access_token = 'EAALRlefvBlEBAExSoV5iim8fa0C6lZCGnpSyp3twSmJnNoXxxDSsl2ZAElIo6qJled9UMKYlMunPthlZBKJ8LtSDrH1ynz2KG8zhXuB63DwgdRPjOFZBaidKH3bbYm22BfgdZBON08EHQdqhn2hCMFIV4XY8YFmExRUNZBY5wJggAGebbV2KmeGCjihBgJTDQZD';
$ad_account_id = 'act_803525254130959';
$app_secret = '9dcc63f5f495b0f9aed8ea569a227eaa';
$app_id = '793391724955217';

$api = Api::init($app_id, $app_secret, $access_token);
$api->setLogger(new CurlLogger());

$fields = array(
  'spend',
  'cost_per_result',
  'cpm',
  'unique_actions:link_click',
  'website_ctr:link_click',
  'cpc',
  'results',
  'result_rate',
  'frequency',
  'quality_score_organic',
);
$params = array(
  'time_range' => array('since' => '2022-09-02','until' => '2022-10-02'),
  'filtering' => array(),
  'level' => 'campaign',
  'breakdowns' => array(),
);
echo json_encode((new AdAccount($ad_account_id))->getInsights(
  $fields,
  $params
)->getResponse()->getContent(), JSON_PRETTY_PRINT);


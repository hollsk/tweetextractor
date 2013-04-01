<?php
header('Content-Type: application/json'); 
session_start();
require_once('twitteroauth-master/twitteroauth/twitteroauth.php'); //Path to twitteroauth library

$twitteruser = $_GET["screen_name"];
$notweets = $_GET["count"];
$include_rts = $_GET["include_rts"];

$consumerkey = "ibuluHCBOmBA5JwjNCSNw";
$consumersecret = "epBGJ5w2jg7QjXEqEPRj5MQtyiqdjxWoXAdu3S4U";
$accesstoken = "112401465-4CDOXWxz2R8YGP3xk9VZDRvAjzw9ETMK0mywD0Bo";
$accesstokensecret = "Iz22NPIakj6L3edNe45BFVHPUIxowwhK9YhgyySW6I";

function getConnectionWithAccessToken($cons_key, $cons_secret, $oauth_token, $oauth_token_secret) {
  $connection = new TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);
  return $connection;
}
 
$connection = getConnectionWithAccessToken($consumerkey, $consumersecret, $accesstoken, $accesstokensecret);
$tweets = $connection->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=".$twitteruser."&count=".$notweets."&include_rts=".$include_rts);

echo 'twitterApiCallback(' . json_encode($tweets) . ');';
?>
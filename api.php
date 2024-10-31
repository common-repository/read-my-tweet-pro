<?php
define('WP_USE_THEMES', false);
require "../../../wp-config.php";
require_once dirname(__FILE__) . '/api/twitter.php';

/*$consumerKey = 'iv6p6YLvLvyVZq0mu7xJw';
$consumerSecret = 'D2DmEzOJdcqeZZYzuMvO1fxg4oHfjxq6iheLDi3Y';
$accessToken = '224649941-VnJfVjZJwq7KHkARJ8D7sYR2JbNBfaL7qBzHHv9t';
$accessTokenSecret = 'kn3FNVbMA5JC7vy0cskz5joFvJafenSwPHxDMobXU';*/

$consumerKey 		=  trim(get_option('rmtp_apikey'));
$consumerSecret 	=  trim(get_option('rmtp_apisecret'));
$accessToken 		=  trim(get_option('rmtp_apitoken'));
$accessTokenSecret  =  trim(get_option('rmtp_apitokensecret'));

$twitter = new Twitter($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret);

$screen_name = explode('from:', $_GET['screen_name']);
//if displaying user post
if (count($screen_name) > 1) {
	$screen_name = $screen_name[1];
	$statuses = $twitter->request('https://api.twitter.com/1.1/statuses/user_timeline.json', 'GET', array('screen_name' => $screen_name, 'count' => $_GET['count']));
}
//if displaying search query
else {
	$screen_name = $_GET['screen_name'];
	$statuses = $twitter->request('https://api.twitter.com/1.1/search/tweets.json', 'GET', array('q' => $screen_name, 'count' => $_GET['count']));	
}
echo json_encode($statuses);
<?php
/*
Plugin Name: Twitter Stream
Plugin URI: http://return-true.com/
Description: A simple Twitter plugin designed to show the provided username's Twitter updates. Includes file caching to prevent API overuse.
Version: 2.4
Author: Paul Robinson
Author URI: http://return-true.com

	Copyright (c) 2009, 2010 Paul Robinson (http://return-true.com)
	Twitter Stream is released under the GNU General Public License (GPL)
	http://www.gnu.org/licenses/gpl.txt

	This is a WordPress 3 plugin (http://wordpress.org).
	Plugin is well documented for those who wish to learn.
*/

/*
	There is no CSS included with this plugin to keep it simple and in one file.
	If you wish to customize things here are the CSS commands available.
	.at-reply is for @replys, .hash-tag is for #tags, finally a.twitter-link and
	a:hover.twitter-link are for autolinked URLs within the twitter stream.
	a.twitter-date & a:hover.twitter-date is for the date's permalink.
*/

//Setup oAuth data such as Twitter Streams Consumer Key etc.
if($keys = get_option('twitter_stream_keys')) {
	define('CONSUMER_KEY', $keys['consumer_key']);
	define('CONSUMER_SECRET', $keys['consumer_secret']);
	define('OAUTH_CALLBACK', 'http://' . $_SERVER['HTTP_HOST'] . preg_replace('/&wptwit-page=[^&]*/', '', $_SERVER['REQUEST_URI']) . '&wptwit-page=callback');
}

//include TwitteroAuthFile
require_once('twitteroauth/twitteroauth.php');

//If we are authenticating execute the redirection to Twitter...
if(isset($_GET['wptwit-page']) && $_GET['wptwit-page'] == 'redirect') {
	require_once('redirect.php'); //Load redirect to auth
} elseif(isset($_GET['wptwit-page']) && $_GET['wptwit-page'] == 'callback') {
	require_once('callback.php'); //Load callback to create tokens
} elseif(isset($_GET['wptwit-page']) && $_GET['wptwit-page'] == 'deletekeys') {
	delete_option('twitter_stream_keys');
	//Delete oAuth token if it is set too.
	delete_option('twitter_stream_token');
	//redirect user to the entry page to enter new keys
	header('Location: ' . preg_replace('/&wptwit-page=[^&]*/', '', $_SERVER['REQUEST_URI']));
} elseif(isset($_GET['wptwit-page']) && $_GET['wptwit-page'] == 'deletecache') {
	//run cache deletion function
	twitter_stream_delete_cache();
} elseif(isset($_POST['consumerkey']) && isset($_POST['consumersecret'])) {
	//check if keys have been sent via POST & save them here.
	update_option('twitter_stream_keys', array('consumer_key' => $_POST['consumerkey'], 'consumer_secret' => $_POST['consumersecret']));
	//redirect user to this page now that the keys have been saved. Remove the extra url param or we will endless loop.
	header('Location: ' . preg_replace('/&wptwit-page=[^&]*/', '', $_SERVER['REQUEST_URI']));
}

//Add our new page so users can authorize the plugin with Twitter... Yes, a page for 1 button...
add_action('admin_menu', 'twitter_stream_add_options');
//add our page to the settings sub menu
function twitter_stream_add_options() {
	add_options_page('Twitter Stream Authorize Page', 'Twitter Stream', 8, 'twitterstreamauth', 'twitter_stream_options_page');	
}

//Create the page...
function twitter_stream_options_page() {
?>
<div class="wrap">
   	<h2><?php _e( 'Twitter Stream Authorize Page', 'twit_sream' ); ?></h2>
   	Created by <strong>Paul Robinson</strong>.
	<small style="margin-bottom: 25px; display: block;">Confused? Unsure what to do? Check the <a href="http://return-true.com/2009/12/wordpress-plugin-twitter-stream/">documentation</a></small>
	<?php
	if(isset($_GET['wptwit-page']) && $_GET['wptwit-page'] == 'cachedeleted') {
	?>
		<div id="message" class="updated fade">
			<p><strong>
				<?php _e('Cache Deleted!', 'twit_stream' ); ?>
			</strong></p>
		</div>
	<?php
	} elseif(isset($_GET['wptwit-page']) && $_GET['wptwit-page'] == 'cachefailed') {
	?>
		<div id="message" class="error fade">
			<p><strong>
				<?php _e('Cache Deletion Failed!', 'twit_stream' ); ?>
			</strong></p>
		</div>
	<?php
	}
	?>
	<div style="width: 500px; margin-top:10px;">
    	<div style="border: 1px solid rgb(221, 221, 221); padding: 10px; float: left; background-color: white; margin-right: 15px;">
    		<div style="width: 350px; height: 130px; float:left;">
        		<h3>Donate</h3>
   				<p>If you like this plugin and have found it to be useful, please help me keep this plugin free by clicking the <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=9155415" target="_blank"><strong>donate</strong></a> button, or you can send me a gift from my <a href="https://www.amazon.co.uk/registry/wishlist/3IACY9WPVEPXC/ref=wl_web" target="_blank"><strong>Amazon wishlist</strong></a>. Thank you.</p>
				</div>
			<div style="width:100px; float:left; margin:15px 0 0 10px;">
				<a target="_blank" title="Donate" href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=9155415"><img src="<?php echo WP_PLUGIN_URL; ?>/twitter-stream/donate-paypal.jpg" alt="Donate with Paypal">	</a>
				<a target="_blank" title="Amazon Wish List" href="https://www.amazon.co.uk/registry/wishlist/3IACY9WPVEPXC/ref=wl_web">
				<img src="<?php echo WP_PLUGIN_URL; ?>/twitter-stream/amazon-wishlist.jpg" alt="My Amazon Wish List"> </a>
			</div>
			<div style="clear:both;"></div>
		</div>
    </div>
    <div style="clear: both;"></div>
	<?php
	//Have we already been authorized?
	$token = get_option('twitter_stream_token');
	if(!defined('CONSUMER_KEY') && !defined('CONSUMER_SECRET')) {
	?>
		<p style="font-weight:bold; color:#666;">oAuth is no longer optional. Due to changes to the Twitter API you must authorize Twitter Stream with your Twitter account by following the instructions below.</p>
		<h3>Create A Twitter App</h3>
		<p>To sign into Twitter via Twitter Stream you will need to register for a Twitter App. The process is fairly quick and can be done by clicking the 'Get your consumer keys' button below (opens in new window/tab), please read the following to find out what to enter.</p>
		<div style="margin: 15px 0 15px 0;"><a href="http://dev.twitter.com/apps/new/" target="_blank"><img src="<?php echo WP_PLUGIN_URL; ?>/twitter-stream/twitter-oauth-button.png" alt="Get your consumer keys"/></a></div>
		<ul>
			<li><strong>App Name &amp; Description:</strong> Any name to identify your blog (e.g. My Stream), it cannot contain the word 'Twitter'. You don't have to fill in description.</li>
			<li><strong>Website:</strong> Generally the URL to the home page of your blog.</li>
			<li><strong>Callback URL:</strong> Enter the following: <strong>http://<?php echo $_SERVER['HTTP_HOST'] . preg_replace('/&wptwit-page=[^&]*/', '', $_SERVER['REQUEST_URI']) . '&wptwit-page=callback'; ?></strong></li>
		</ul>
		<p>Once you have completed the registration you will be given a page with two very important keys <em style="color: #666;">(Consumer Key &amp; Consumer Secret)</em> on please enter them in the boxes below &amp; hit save.</p>
		<p><strong>N.B:</strong> For those who a curious Twitter Stream does not need the app to have write access so if you are want to make sure security is tight you can make sure 'read-only' is picked on your <a href="http://dev.twitter.com/apps/">App's Settings page</a>.</p>
		<h3>Enter Key Information</h3>
		<form action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>" method="post">
			<label for="consumerkey" style="font-weight:bold;display:block;width:150px;">Consumer Key:</label> <input type="text" value="" id="consumerkey" name="consumerkey" />
			<label for="consumersecret" style="font-weight:bold;display:block;width:150px;margin-top:5px;">Consumer Secret:</label> <input type="text" value="" id="consumersecret" name="consumersecret" />
			<input type="submit" value="Save" style="display:block;margin-top:10px;" />
		</form>
	<?php
	} elseif(!is_array($token) && !isset($token['oauth_token'])) {
	?>
		<h3>Sign In With Twitter</h3>
		<p>Now you have registered an Twitter App and the keys have been saved, we can now sign you into Twitter &amp; finally get Twitter Stream up and running. To sign in simply click the 'sign in with Twitter' button below, check the details on the page that follows match that of the Twitter App you created, and finally press the 'allow' button.</p>
		<div style="margin: 15px 0 15px 0;"><a href="<?php echo preg_replace('/&wptwit-page=[^&]*/', '', $_SERVER['REQUEST_URI']) . '&wptwit-page=redirect'; ?>"><img src="<?php echo WP_PLUGIN_URL; ?>/twitter-stream/darker.png" alt="Sign in with Twitter"/></a></div>
		<h3>What If I Made A Mistake Entering The Keys?</h3>
		<p>If you made a mistake entering the keys please click <a href="<?php echo preg_replace('/&wptwit-page=[^&]*/', '', $_SERVER['REQUEST_URI']) . '&wptwit-page=deletekeys'; ?>" style="color: #aa0000;">delete</a> to remove them.</p>
	<?php
	} else {
	?>
		<h3>Twitter Stream Authorized!</h3>
		<p>If you ever wish to revoke Twitter Stream's access to your twitter account just go to <a href="http://dev.twitter.com">Twitter's</a> Development website, login, then hover over your username (top right) and hit <strong>My Applications</strong>. Find the name of the application you created when authorizing Twitter Stream and click it. Next press the 'Delete' tab. Remember that doing this will obviously stop Twitter Stream from working. Once you've done that, click <a href="<?php echo preg_replace('/&wptwit-page=[^&]*/', '', $_SERVER['REQUEST_URI']) . '&wptwit-page=deletekeys'; ?>" style="color: #aa0000;">here</a> to revoke your keys from the WordPress database as they are no longer needed.</p>
		<h3>What Do I Do Now?</h3>
		<p>The easiest way to use Twitter Stream is to add it via the widgets. Just go to the widgets page and add the Twitter Stream widget to one of your widget areas. The alternative is to use the function by including &lt;php twitter_stream(); ?&gt; in your template somewhere. You can customize it using the parameters shown <a href="http://return-true.com/2009/12/wordpress-plugin-twitter-stream/">here</a>.
		<h3>I Need To Change My Keys!</h3>
		<p>If you ever need to change your consumer keys for whatever reason click <a href="<?php echo preg_replace('/&wptwit-page=[^&]*/', '', $_SERVER['REQUEST_URI']) . '&wptwit-page=deletekeys'; ?>" style="color: #aa0000;">delete</a> to remove them.</p>
	<?php
	}
	?>
	<h3>How Do I delete The Cache?</h3>
	<p>Use the small button below to delete the cache. Use this if there is an error message displaying instead of your Tweets or if you have changed your widget/template function settings.</p>
	<a href="<?php echo preg_replace('/&wptwit-page=[^&]*/', '', $_SERVER['REQUEST_URI']) . '&wptwit-page=deletecache'; ?>" style="display:block;width:95px;text-decoration:none;border:line-height:15px;margin:1px;padding:3px;font-size:11px;-moz-border-radius:4px 4px 4px 4px;-webkit-border-radius:4px 4px 4px 4px;border-radius:4px 4px 4px 4px;border-style:solid;border-width:1px;background-color:#fff0f5;border-color:#BBBBBB;color:#464646;text-align:center;">Delete Cache?</a>
	<p><small>Huge thanks to <a href="http://twitteroauth.labs.poseurtech.com/">Abraham Williams</a> for creating TwitterOAuth which is used to connect Twitter Stream to Twitter via oAuth.</small></p>
</div>
<?php
}

//Init for translations
add_action( 'init', 'twitter_stream_init' );

// Initialize the text domain for translations.
function twitter_stream_init() {
	
	$plugin_dir = basename(dirname(__FILE__));
	load_plugin_textdomain( 'twit_stream', 'wp-content/plugins/' . $plugin_dir, $plugin_dir );
	
}

//Setup the notice just in case a PHP version less than 5 is installed.
add_action('admin_head', 'twitter_stream_activation_notice');

//Check the version of PHP using the version constant. If the version is less than 5 run the notification.
function twitter_stream_activation_notice() {
	
	if(version_compare(PHP_VERSION, '5.0.0', '<')) {
		add_action('admin_notices', 'twitter_stream_show_notice');
	}
		
}

//Define the notification function for the check above. Advise the user to upgrade their PHP version or uninstall & consider an alternative plugin.
function twitter_stream_show_notice() {
		echo '<div class="error fade"><p><strong>';
		_e('You appear to be using a version of PHP lower than version 5. As noted in the description this plugin uses SimpleXML which was not available in PHP 4. Please either contact your host &amp; ask for your version of PHP to be upgraded or uninstall this plugin and consider an alternative. Sorry for the inconvenience.', 'twit_stream');
		echo '</strong></p></div>';
}

//Shell for new array/query string argument system... Redundant since intro of oAuth... Kept as alias...
function twitter_stream_args($args) {
	twitter_stream($args);
}

function twitter_stream($args = FALSE) {

	if(is_array($args)) { //Is it an array?
		$r = &$args; //Good, reference out arguments into our options array.
	} else {
		parse_str($args, $r); //It's a query string, parse out our values into our options array.
	}
	
	if(!isset($r)) {
		$r = array();
	}
	
	$defaults = array( //Set some defaults
					'username' => '',
					'count' => '10',
					'date' => FALSE,
					'profile_link' => 'Visit My Profile',
					'retweets' => 'FALSE',
					'show_followers' => FALSE,
					'cache_time' => 1800,
					'echo' => TRUE
					);
					
	$r = array_merge($defaults, $r); //Merge our defaults array onto our options array to fill in any missing values with defaults.
	
	if($r['retweets'] == "on")
		$r['retweets'] = "true";

	if(version_compare(PHP_VERSION, '5.0.0', '<')) { //Checked before hand, but if the user didn't listen tell them off & refuse to run.
		_e('You must have PHP5 or higher for this plugin to work.', 'twit_stream');
		return FALSE;
	}
	
	if($r['username'] != '') {
		$cache_path = dirname(__FILE__).'/'.$r['username'].'.cache'; //Set our cache path. Can be changed if you feel the need.
	} else {
		$cache_path = dirname(__FILE__).'/authuser.cache'; //Set our cache path. Can be changed if you feel the need.
	}
	
	//First we need to check to see if a cache file has already been made.
	if(file_exists($cache_path)) {
		$modtime = filemtime($cache_path); //Get the time the file was last modified.
		$content = twitter_stream_cache($modtime, $cache_path, $r['cache_time']); //Hand it to the cache function & get the data
		if($content !== FALSE) {
			$cache = TRUE; //Cache is still valid
		} else {
			$cache = FALSE; //Cache too old invalidate it
			unset($content); //Delete the content variable to force the script to connect to twitter & renew the cache.
			if( function_exists('wp_cache_clear_cache') ) {
				wp_cache_clear_cache();
            } elseif ( function_exists('prune_super_cache') ) {
                prune_super_cache(WP_CONTENT_DIR.'/cache/', true );
            }
		}
	} else {
		$cache = FALSE; //This is probably first run so set the cache to false so it can be created.
		if( function_exists('wp_cache_clear_cache') ) {
			wp_cache_clear_cache();
        } elseif ( function_exists('prune_super_cache') ) {
            prune_super_cache(WP_CONTENT_DIR.'/cache/', true );
        }
	}
	
	//No content is set so we either need to create the cache or it has been invalidated and we need to renew it.
	if(!isset($content)) {
		/* Get user access tokens out of the session. */
		$access_token = get_option('twitter_stream_token');
		if(empty($access_token) || $access_token === FALSE) {
			_e('Authorizing Twitter Stream with Twitter is no longer optional. You need to go to the Twitter Stream Authorization page in the WordPress Admin (under settings) before your tweets can be shown.');
			return FALSE;
		}
		/* Create a TwitterOauth object with consumer/user tokens. */
		$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
		$connection->format = 'xml';
		$content = $connection->get('statuses/user_timeline', array('screen_name' => $r['username'], 'count' => $r['count'], 'include_rts' => $r['retweets']));
	}
	
	if($cache === FALSE) {
		//If cache was set to false we need to update the cache;
		$fp = fopen($cache_path, 'w');
		if(flock($fp, LOCK_EX)) {
			fwrite($fp, $content);
			flock($fp, LOCK_UN);	
		}
		fclose($fp);
	}
	
	if($r['echo'] !== TRUE || $r['echo'] != 'true' || $r['echo'] != 'TRUE' || $r['echo'] != '1') {
		return twitter_stream_convert_to_xml($content);
	}
	
	$tweetfollow = twitter_stream_parse_tweets($content, $r);
	
	$output = $tweetfollow[0];
	
	//Now let's do some highlighting & auto linking.
	//Find all the @replies and place them in a span so CSS can be used to highlight them.
	$output = preg_replace('~(\@[a-z0-9_]+)~ise', "'<span class=\"at-reply\"><a href=\"http://twitter.com/'.substr('$1', 1).'\" title=\"View '.substr('$1', 1).'\'s profile\">$1</a></span>'", $output);
	//Find all the #tags and place them in a span so CSS can be used to highlight them.
	$output = preg_replace('~(\#[a-z0-9_]+)~ise', "'<span class=\"hash-tag\"><a href=\"http://twitter.com/search?q='.urlencode('$1').'\" title=\"Search for $1 on Twitter\">$1</a></span>'", $output);
	
	//Show follower count
	if($r['show_followers']) {
		$output .= '<div class="follower-count">'.$tweetfollow[1].' followers</div>';
	}
	
	//Link to users profile. Can be customized via the profile_link parameter & via CSS targeting.
	$output .= '<div class="profile-link"><a href="http://twitter.com/'.$tweetfollow[2].'" title="'.$r['profile_link'].'">'.$r['profile_link'].'</a></div>';
	
	
	echo '<div class="twitter-stream">'.$output.'</div>';
	
}

function twitter_stream_cache($modtime, $cache_path, $cache_time) {
	
	$thirtyago = time() - $cache_time; //the timestamp thirty minutes ago
	
	if($modtime < $thirtyago) {
		//our cache is older than 30 minutes return FALSE so the script will run the cache updater.
		return FALSE;
	}
	
	//We have already checked that the file exists. So we can assume it exsits here.
	$data = file_get_contents($cache_path);
	
	if($data !== FALSE) {
		return $data; //return our data if there wasn't a problem
	}
	
}

function twitter_stream_delete_cache() {

	$cache_path = dirname(__FILE__);
	
	if ($handle = opendir($cache_path)) {
			
		while (false !== ($file = readdir($handle))) {
			if(FALSE !== stristr($file, '.cache')) {
				unlink($cache_path.'/'.$file);
				$deleted = true;
				break;
			}
		}
		
		closedir($handle);
	}
	if($deleted === true) {
		header('Location: ' . preg_replace('/&wptwit-page=[^&]*/', '', $_SERVER['REQUEST_URI']) . '&wptwit-page=cachedeleted');
	} else {
		header('Location: ' . preg_replace('/&wptwit-page=[^&]*/', '', $_SERVER['REQUEST_URI']) . '&wptwit-page=cachefailed');
	}
	
}

//parse tweets
function twitter_stream_parse_tweets($content, $r) {
				
	$twitxml = twitter_stream_convert_to_xml($content);
	if($twitxml === FALSE || isset($twitxml->error)) {
		return FALSE;
	}
	if(empty($twitxml)) {
		return FALSE;
	}
	$followers = $twitxml->status[0]->user->followers_count;
	$username = $twitxml->status[0]->user->screen_name;
	$o = '';
	foreach($twitxml->status as $tweet) {
	
		//Find all URL's mentioned and store them in $matches. 
		//$pattern = "/(http:\/\/|https:\/\/)?(?(1)(\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}|([-a-z0-9_]+\.)?[a-z][-a-z0-9]+\.[a-z]+(\.[a-z]{2,2})?)|(www\.[a-z][-a-z0-9]+\.[a-z]+(\.[a-z]{2,2})?))\/?[a-z0-9._\/~#&=;%+?-]+[a-z0-9\/#=?]{1,1}/is";
		//New regex pattern to match t.co urls thanks to Jonny Vaughan
		$pattern = "/(http:\/\/|https:\/\/)?(?(1)(\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}|([-a-z0-9_]+\.)?[-a-z0-9]+\.[a-z]+(\.[a-z]{2,2})?)|(www\.[a-z][-a-z0-9]+\.[a-z]+(\.[a-z]{2,2})?))\/?[a-z0-9._\/~#&=;%+?-]+[a-z0-9\/#=?]{1,1}/is";
		$out_count = preg_match_all($pattern, $tweet->text, $matches);
		
		//If there were any matches
		if($out_count > 0) {
			//Loop through all the full matches
			foreach($matches[0] as $match) {
				//Use a simple string replace to replace each URL with a HTML <a href>.
				$tweet->text = str_replace($match, '<a href="'.$match.'" target="_blank" class="twitter-link">'.$match.'</a>', $tweet->text);	
			}
		}
					
		$o .= "<p>".$tweet->text;
		
		if($r['date'] !== FALSE) {
			$tweet->created_at = strtotime($tweet->created_at);
				
			if($r['date'] === TRUE || $r['date'] == 'true' || $r['date'] == 'TRUE' || $r['date'] == '1') {
				$o .= ' - ';
			} else {
				$r['date'] = trim($r['date']);
				$o .= " {$r['date']} ";	
			}
			$o .= "<a href=\"http://twitter.com/{$username}/statuses/{$tweet->id}/\" title=\"Permalink to this tweet\" target=\"_blank\" class=\"twitter-date\">".twitter_stream_time_ago($tweet->created_at)."</a>";
		}
				
		$o .= "</p>";
			
	}
		
	return array($o,$followers,$username);

}


function twitter_stream_convert_to_xml($content) {

	//Some sort of strange fix for unterminated entities in XML. Possibly related to PHP bug #36795.
	$content = str_replace('&amp;', '&amp;amp;', $content);
	//Convert the string recieved from twitter into a simple XML object.
	$twitxml = simplexml_load_string($content); //Supress errors as we check for any next anyway.
	
	if($twitxml === FALSE) {
		//Twitter was unable to provide the stream requested. Let's notify the user.
		echo '<p>';
		_e('Your Twitter stream could not be collected. Normally this is caused by no XML feed being returned. Why this happens is still unclear.', 'twit_stream');
		echo '</p>';
		return FALSE;
	}
	if(isset($twitxml->error)) {
		//Check for an error such as API overuse and display it.
		echo '<p>'.$twitxml->error.'</p>';
		return FALSE;
	}
	
	return $twitxml;

}

//Work out the time in the AGO tense. Thanks to http://css-tricks.com for this snippet...
function twitter_stream_time_ago($time)
{
   $singular = array(__("second", 'twit_stream'), __("minute", 'twit_stream'), __("hour", 'twit_stream'), __("day", 'twit_stream'), __("week", 'twit_stream'), __("month", 'twit_stream'), __("year", 'twit_stream'), __("decade", 'twit_stream'));
   $plural = array(__("seconds", 'twit_stream'), __("minutes", 'twit_stream'), __("hours", 'twit_stream'), __("days", 'twit_stream'), __("weeks", 'twit_stream'), __("months", 'twit_stream'), __("years", 'twit_stream'), __("decades", 'twit_stream'));
   $lengths = array("60","60","24","7","4.35","12","10");

   $now = time();

       $difference     = $now - $time;
       $tense         = __("ago", 'twit_stream');

   for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
       $difference /= $lengths[$j];
   }

   $difference = round($difference);

   if($difference != 1) {
	    $period = $plural[$j];
   } else {
		$period = $singular[$j];    
   }
   
   //French translation fix
   if(strcasecmp(get_bloginfo('language'), 'fr-FR') === 0) {
    return "{$tense} {$difference} {$period}";
   } else {
	return "{$difference} {$period} {$tense}";
   }
}


//For the widget to work you must have WP 2.8 or higher.
if(get_bloginfo('version') >= '2.8') {

	class TwitterStreamWidget extends WP_Widget {
	 
		function TwitterStreamWidget() {
			parent::WP_Widget(FALSE, $name = 'Twitter Stream');    
		}
	 
		function widget($args, $instance) {        
			extract( $args );
			if(empty($instance['count']))
				$instance['count'] = 10;
			if(empty($instance['username']))
				$instance['username'] = '';
			if(empty($instance['date']))
				$instance['date'] = FALSE;
			if(empty($instance['profile_link']))
				$instance['profile_link'] = 'Visit My Profile';
			if(empty($instance['retweets']))
				$instance['retweets'] = FALSE;
			if(empty($instance['show_followers']))
				$instance['show_followers'] = FALSE;
			if(empty($instance['cache_time']))
				$instance['cache_time'] = 30;
			?>
				  <?php echo $before_widget; ?>
					  <?php echo $before_title . $instance['title'] . $after_title; ?>
	 					
						  <?php 
						  unset($instance['title']);
						  twitter_stream_args($instance); 
						  
						  ?>
	 
				  <?php echo $after_widget; ?>
			<?php
	
		}
	 
	
		function update($new_instance, $old_instance) {                
			return $new_instance;
		}
	 
		function form($instance) {                
			$title = esc_attr($instance['title']);
			$username = esc_attr($instance['username']);
			$count = esc_attr($instance['count']);
			$date = esc_attr($instance['date']);
			$profile_link = esc_attr($instance['profile_link']);
			$retweets = esc_attr($instance['retweets']);
			$show_followers = esc_attr($instance['show_followers']);
			$cache_time = esc_attr($instance['cache_time']);
			?>
				<p>
                  <label for="<?php echo $this->get_field_id('title'); ?>">
				    <?php _e('Title:', 'twit_stream'); ?>
                    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
                  </label>
                </p>
				<p>
                  <label for="<?php echo $this->get_field_id('username'); ?>">
				    <?php _e('Twitter Username:', 'twit_stream'); ?>
					<br />
					<small>
					  <?php _e('(Leave blank to show your tweets)', 'twit_stream'); ?>
					</small>
                  <input class="widefat" id="<?php echo $this->get_field_id('username'); ?>" name="<?php echo $this->get_field_name('username'); ?>" type="text" value="<?php echo $username; ?>" /></label>
                </p>
				<p>
                  <label for="<?php echo $this->get_field_id('count'); ?>">
				    <?php _e('How Many Twitter Updates To Show:', 'twit_stream'); ?>
                    <input class="widefat" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="text" value="<?php echo $count; ?>" />
                  </label>
                </p>
                <p>
                  <label for="<?php echo $this->get_field_id('date'); ?>">
				    <?php _e('Show The Date:', 'twit_stream'); ?>
                    <br />
                    <small>
					  <?php _e('(Leave blank to turn off, type a separator, true or 1 will show the date)', 'twit_stream'); ?>
                    </small>
                    <input class="widefat" id="<?php echo $this->get_field_id('date'); ?>" name="<?php echo $this->get_field_name('date'); ?>" type="text" value="<?php echo $date; ?>" />
                  </label>
                </p>
                <p>
                  <label for="<?php echo $this->get_field_id('profile_link'); ?>">
				    <?php _e('Profile Link Text:', 'twit_stream'); ?>
                    <br />
                    <small>
					  <?php _e('(What the link to your Twitter profile should say)', 'twit_stream'); ?>
                    </small>
                    <input class="widefat" id="<?php echo $this->get_field_id('profile_link'); ?>" name="<?php echo $this->get_field_name('profile_link'); ?>" type="text" value="<?php echo $profile_link; ?>" />
                  </label>
                </p>
				<p>
                  <label for="<?php echo $this->get_field_id('retweets'); ?>">
				    <?php _e('Show Retweets:', 'twit_stream'); ?>
                    <br />
                    <small>
					  <?php _e('(Warning: Uses 2 API requests.)', 'twit_stream'); ?>
                    </small>
                    <input class="widefat" id="<?php echo $this->get_field_id('retweets'); ?>" name="<?php echo $this->get_field_name('retweets'); ?>" type="checkbox" <?php if($retweets == TRUE) echo 'checked="checked"'; ?> />
                  </label>
                </p>
				<p>
                  <label for="<?php echo $this->get_field_id('show_followers'); ?>">
				    <?php _e('Show Followers:', 'twit_stream'); ?>
                    <br />
                    <small>
					  <?php _e('(Shows your follower count.)', 'twit_stream'); ?>
                    </small>
                    <input class="widefat" id="<?php echo $this->get_field_id('show_followers'); ?>" name="<?php echo $this->get_field_name('show_followers'); ?>" type="checkbox" <?php if($show_followers == TRUE) echo 'checked="checked"'; ?> />
                  </label>
                </p>
				 <p>
                  <label for="<?php echo $this->get_field_id('cache_time'); ?>">
				    <?php _e('Cache Length:', 'twit_stream'); ?>
                    <br />
                    <small>
					  <?php _e('How long to cache tweets, in seconds.', 'twit_stream'); ?>
                    </small>
                    <input class="widefat" id="<?php echo $this->get_field_id('cache_time'); ?>" name="<?php echo $this->get_field_name('cache_time'); ?>" type="text" value="<?php echo $cache_time; ?>" />
                  </label>
                </p>
			<?php 
	
		}
	}
	
	add_action('widgets_init', create_function('', 'return register_widget("TwitterStreamWidget");'));

}


?>
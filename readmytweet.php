<?php
/*
Plugin Name: Read My Tweet Pro
Plugin URI: http://readmytweetpro.wpdolly.com/download/
Description: A WordPress Horizontal jQuery Twitter Scroller
Version: 1.6.2
Author: Maxx Kremer
Author URI: http://maxxkremer.com/
*/

/* On activate
----------------------------------------------------------------------------------------------------*/
function rmtp_install() {
	if(!get_option('rmtp_search')) { update_option('rmtp_search', 'from:readmytweetpro');  }
	if(!get_option('rmtp_username')) { update_option('rmtp_username', 'readmytweetpro');  }
	if(!get_option('rmtp_tweets')) { update_option('rmtp_tweets', 5);  }
	if(!get_option('rmtp_speed')) { update_option('rmtp_speed', 15);  }
	if(!get_option('rmtp_color')) { update_option('rmtp_color', 'white');  }
	if(!get_option('rmtp_width')) { update_option('rmtp_width', 'auto');  }
	if(!get_option('rmtp_margintop')) { update_option('rmtp_margintop', 0);  }
	if(!get_option('rmtp_marginbottom')) { update_option('rmtp_marginbottom', 0);  }
	if(!get_option('rmtp_marginbottom')) { update_option('rmtp_secure', 0);  }
	if(!get_option('rmtp_marginbottom')) { update_option('rmtp_rounded', 1);  }
}
register_activation_hook(__FILE__,'rmtp_install');

/* Load the script
----------------------------------------------------------------------------------------------------*/
/* Enqueue the public scripts
----------------------------------------------------------------------------------------------------*/
function readmytweet_public_scripts() {

	wp_enqueue_style("readmytweet",plugin_dir_url( __FILE__ )."/plugin/readmytweet.css");
	wp_enqueue_script("jquery");
	wp_enqueue_script("jquery.readmytweet",plugin_dir_url( __FILE__ )."/plugin/readmytweet.js", array('jquery'));

	$rmtp_vars = array(
						'homeurl' => home_url(),
						'pluginurl' => plugin_dir_url( __FILE__ )
					);

	wp_localize_script( 'jquery.readmytweet', 'rmtp_vars', $rmtp_vars);
}
add_action('wp_enqueue_scripts', 'readmytweet_public_scripts');

/* Admin Functions
----------------------------------------------------------------------------------------------------*/
function readmytweet_admin() {
    include('readmytweet_admin.php');
}
function readmytweet_admin_actions() {
	 add_menu_page("RMT Pro", "RMT Pro", 1, "RMT Pro", "readmytweet_admin", plugins_url('read-my-tweet-pro/images/twitter_icon.png'));  
}
add_action('admin_menu', 'readmytweet_admin_actions');

/* Create the div
----------------------------------------------------------------------------------------------------*/
$rmtdiv = '<div class="rmtp_holder" style="height: 60px; margin-top:'.get_option('rmtp_margintop').'px; margin-bottom:'.get_option('rmtp_marginbottom').'px;"></div>';

/* Replace the tag
----------------------------------------------------------------------------------------------------*/
function readmytweet_replacetag($content) {
	global $rmtdiv;
	$content=str_replace('[readmytweet]',$rmtdiv,$content);
    return $content;
}
add_filter('the_content','readmytweet_replacetag');

/* Readmytweet function
----------------------------------------------------------------------------------------------------*/
function readmytweet() {
	global $rmtdiv;
	echo $rmtdiv;
}

/* Load the script
----------------------------------------------------------------------------------------------------*/
function readmytweet_replace() {
	if(!get_option('rmtp_width') || get_option('rmtp_width') == 'auto') { $rmtp_width = 0; } else { $rmtp_width = get_option('rmtp_width'); } ?>
	<script type='text/javascript'>
	var $j = jQuery.noConflict();
	$j(document).ready(function() {
		$j('.rmtp_holder:eq(0)').readmytweet({
			'color':'<?=get_option('rmtp_color')?>',
			'search':'<?=get_option('rmtp_search')?>',
			'user':'<?=get_option('rmtp_username')?>',
			'width': <?=$rmtp_width?>,
			'tweets':<?=get_option('rmtp_tweets')?>,
			'speed': <?=get_option('rmtp_speed')?>,
		});
	});
	</script>
<?php
}
add_action('wp_head', 'readmytweet_replace');
?>
<?php
if($_POST['rmtp_hidden'] == 'Y') {

	 $rmtp_apikey 		= $_POST['rmtp_apikey']; update_option('rmtp_apikey', $rmtp_apikey);
	 $rmtp_apisecret = $_POST['rmtp_apisecret']; update_option('rmtp_apisecret', $rmtp_apisecret);
	 $rmtp_apitoken = $_POST['rmtp_apitoken']; update_option('rmtp_apitoken', $rmtp_apitoken);
	 $rmtp_apitokensecret = $_POST['rmtp_apitokensecret']; update_option('rmtp_apitokensecret', $rmtp_apitokensecret);

    $rmtp_search = $_POST['rmtp_search']; update_option('rmtp_search', $rmtp_search);
    $rmtp_username = $_POST['rmtp_username']; update_option('rmtp_username', $rmtp_username);
	$rmtp_tweets = $_POST['rmtp_tweets']; update_option('rmtp_tweets', $rmtp_tweets);
	$rmtp_speed = $_POST['rmtp_speed']; update_option('rmtp_speed', $rmtp_speed);
	$rmtp_color = $_POST['rmtp_color']; update_option('rmtp_color', $rmtp_color);
	$rmtp_width = $_POST['rmtp_width'];
	if(!$rmtp_width) {
		update_option('rmtp_width', 'auto');
		$rmtp_width = 'auto';
	} else if($rmtp_width == 'auto') {
		update_option('rmtp_width', 'auto');
		$rmtp_width = 'auto';
	} else if($rmtp_width < 400) {
		update_option('rmtp_width', 400);
		$rmtp_width = 400;
	} else {
		update_option('rmtp_width', $rmtp_width);
	}
	$rmtp_margintop = $_POST['rmtp_margintop']; update_option('rmtp_margintop', $rmtp_margintop);
	$rmtp_marginbottom = $_POST['rmtp_marginbottom']; update_option('rmtp_marginbottom', $rmtp_marginbottom);
	$edited = 1;
} else {

	 $rmtp_apikey = get_option('rmtp_apikey');
	 $rmtp_apisecret = get_option('rmtp_apisecret');
	 $rmtp_apitoken = get_option('rmtp_apitoken');
	 $rmtp_apitokensecret = get_option('rmtp_apitokensecret');

	 $rmtp_search = get_option('rmtp_search');
	 $rmtp_username = get_option('rmtp_username');
	 $rmtp_tweets = get_option('rmtp_tweets');
	 $rmtp_speed = get_option('rmtp_speed');
	 $rmtp_color = get_option('rmtp_color');
	 $rmtp_width = get_option('rmtp_width');
	 $rmtp_margintop = get_option('rmtp_margintop');
	 $rmtp_marginbottom = get_option('rmtp_marginbottom');
}
?>
<div class="wrap">
	<div class="icon32"><img src="<?=plugin_dir_url( __FILE__ )?>/images/twitter.png" alt="twitter"/></div>
	<h2>&nbsp;&nbsp;Read My Tweet Pro Options</h2>
	<?
	if($edited) {
	?>
	<div id='setting-error-settings_updated' class='updated settings-error'>
<p><strong>Settings saved.</strong></p></div>
	<?
	}
	?>
    <form method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
	<input type="hidden" name="rmtp_hidden" value="Y">
	<h3>How to use</h3>
	<p>Add the tag [readmytweet] on the page/blogpost where you want to display the scroller.<br>
	If you want to add the scroller to your template add the PHP function &lt;? readmytweet() ?&gt; to the desired template page.
	<br><br><i class="description">Note: You can't use multiple instances on a single page.</i></p>

	<h3>Twitter API:</h3>
	<p>You can get your Twitter API credentials <a href="https://dev.twitter.com/user/login?destination=apps" target="_blank">here</a>.</p>
	<table class="form-table">

		<tr valign="top">
		<th scope="row"><label for="rmtp_search">Consumer Key:</label></th>
			<td>
				<input name="rmtp_apikey" type="text" id="rmtp_apikey" value="<?php echo $rmtp_apikey; ?>" class="regular-text" />
<span class="description">Your Twitter API Consumer Key.</span>
			</td>
		</tr>

		<tr valign="top">
		<th scope="row"><label for="rmtp_search">Consumer Secret:</label></th>
			<td>
				<input name="rmtp_apisecret" type="text" id="rmtp_apisecret" value="<?php echo $rmtp_apisecret; ?>" class="regular-text" />
<span class="description">Your Twitter API Consumer Secret.</span>
			</td>
		</tr>

		<tr valign="top">
		<th scope="row"><label for="rmtp_search">Access Token:</label></th>
			<td>
				<input name="rmtp_apitoken" type="text" id="rmtp_apitoken" value="<?php echo $rmtp_apitoken; ?>" class="regular-text" />
<span class="description">Your Twitter API Access Token.</span>
			</td>
		</tr>

		<tr valign="top">
		<th scope="row"><label for="rmtp_search">Access Token Secret:</label></th>
			<td>
				<input name="rmtp_apitokensecret" type="text" id="rmtp_apitokensecret" value="<?php echo $rmtp_apitokensecret; ?>" class="regular-text" />
<span class="description">Your Twitter API Access Token Secret.</span>
			</td>
		</tr>

	<h3>Content options</h3>
	<table class="form-table">
		<tr valign="top">
		<th scope="row"><label for="rmtp_search">Search Query</label></th>
			<td>
				<input name="rmtp_search" type="text" id="rmtp_search" value="<?php echo $rmtp_search; ?>" class="regular-text" />
<span class="description">The search query for the tweets.</span>
			</td>
		</tr>
		<th scope="row"><label for="rmtp_username">Twitter Username</label></th>
			<td>
				<input name="rmtp_username" type="text" id="rmtp_username"  value="<?php echo $rmtp_username; ?>" class="regular-text" />
<span class="description">When someone clicks on the logo, they will be redirected to the twitter profile of this user</span>
			</td>
		</tr>
		<th scope="row"><label for="rmtp_tweets">Maxx tweets to display</label></th>
			<td>
				<select name="rmtp_tweets" id="rmtp_tweets">

				<?
				for($i=0;$i<96;$i++) {
				?>
				<option value="<?=$i+5?>" <? if($rmtp_tweets == ($i+5)) { echo 'selected'; }?>><?=$i+5?></option>
				<?
				}
				?>
				</select>
				<span class="description">How many tweets will be loaded</span>
			</td>
		</tr>
		<th scope="row"><label for="rmtp_speed">Scroll speed</label></th>
			<td>
				<select name="rmtp_speed" id="rmtp_speed">

				<?
				for($i=0;$i<40;$i++) {
				?>
				<option value="<?=$i+1?>" <? if($rmtp_speed == ($i+1)) { echo 'selected'; }?>><?=$i+1?></option>
				<?
				}
				?>
				</select>
				<span class="description">How fast do you want the tweets to scroll</span>
			</td>
		</tr>
	</table>
	<h3>Style options</h3>
	<table class="form-table">
		<tr valign="top">
		<th scope="row"><label for="rmtp_color">Background color</label></th>
			<td>
				<select name="rmtp_color" id="rmtp_color">
					<option value="black" <? if($rmtp_color == 'black') { echo 'selected'; } ?>>Black</option>
					<option value="white" <? if($rmtp_color == 'white') { echo 'selected'; } ?>>White</option>
					<option value="blue" <? if($rmtp_color == 'blue') { echo 'selected'; } ?>>Blue</option>
				</select>
				<span class="description">The background color</span>
			</td>
		</tr>
		<tr valign="top">
		<th scope="row"><label for="rmtp_width">Scroller Width</label></th>
			<td>
				<input type="text" value="<?=$rmtp_width?>" class="regular-text" name="rmtp_width" id="rmtp_width"><span class="description">If auto it will set the width to 100%</span>
			</td>
		</tr>
		<tr valign="top">
		<th scope="row"><label for="rmtp_margintop">Margin Top</label></th>
			<td>
				<input type="text" value="<?=$rmtp_margintop?>" class="regular-text" name="rmtp_margintop" id="rmtp_margintop"><span class="description">The top margin of the scroller</span>
			</td>
		</tr>
		<tr valign="top">
		<th scope="row"><label for="rmtp_margintop">Margin Bottom</label></th>
			<td>
				<input type="text" value="<?=$rmtp_marginbottom?>" class="regular-text" name="rmtp_marginbottom" id="rmtp_marginbottom"><span class="description">The bottom margin of the scroller</span>
			</td>
		</tr>
	</table>
	<p class="submit"><input type="submit" name="submit" id="submit" class="button-primary" value="Save Changes"  /></p></form>
	</form>
</div>
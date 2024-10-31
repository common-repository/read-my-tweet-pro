(function( $j ) {
var scrollY;
$j.fn.readmytweet = function(options) {
	//Set default settings
	var settings = {
		'color'         : 'black',
		'search'		: 'from:readmytweetpro',
		'user'			: 0,
		'width'			: 0,
		'tweets'		: 20,
		'speed'			: 20,
		'rounded'		: 0,
		'secure'		: 0
	};
	//Override default settings
	return this.each(function() {        
		if ( options ) { 
			$j.extend(settings,options);
		}
		//Write the html code
		$j(this).html('<div class="rmtwrapper"><div class="rmtlogo"></div><div class="rmtstage"><div class="rmtfadeleft"></div><div class="rmtfaderight"></div><div class="rmtscroller"></div></div></div>');
		//Give the wrapper a indentifier
		readmytweet = $j(this).children('.rmtwrapper');
		//Give the scroller a indentifier
		rmtScroller = readmytweet.children().children('.rmtscroller');
		//If rounded corners 
		if(settings['rounded']) {
			readmytweet.addClass('rmtrounded');
			readmytweet.children('.rmtlogo').addClass('rmtrounded');
			readmytweet.children('.rmtstage').children('.rmtfaderight').addClass('rmtrounded');
		}
		//Add the color
		readmytweet.addClass(settings['color']);
		//Set the width of all the elements
		if(settings['width']) {
			readmytweet.width(settings['width']);
		}
		readmytweet.children('.rmtstage').width(readmytweet.width()-readmytweet.children('.rmtlogo').width());
		readmytweet.children('.rmtstage').children('.rmtfaderight').css('marginLeft',readmytweet.children('.rmtstage').width()-readmytweet.children('.rmtstage').children('.rmtfaderight').width());
		//Check if we need to link the logo
		if(settings['user']) {
			readmytweet.children('.rmtlogo').css('cursor','pointer');
			readmytweet.children('.rmtlogo').click(function() {
				window.open('http://twitter.com/'+settings['user'],settings['user']);
			});
		}
		//Make a var to count the total width of the tweets
		totalWidth = 0;
		//Check if we need to load the JSON secure

		/*if(settings['secure']) {
			protocol = 'https';
			url = 'https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=twitterapi&count=2';
		} else {
			protocol = 'http';
			url = 'https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=twitterapi&count=2';
		}*/
		
		//Using Twitter API 1.1
		url = rmtp_vars.pluginurl +  '/api.php';
		url += '?screen_name=' + settings['search'] + '&count=' + settings['tweets'];
		
		//Search tweets with JSON
		$j.getJSON(url,
		{
			//Old api 1
			//screen_name: settings['search'],
			//count: settings['tweets'],
		}, function(data) {
			rmtp_count = 0;
			$j.each(data, function(i, item) {
				var twitterDate;
				rmtp_count++;
				//Beautify the date
				date = new Date(item['created_at']);
				diff = (((new Date()).getTime()-date.getTime())/1000);
				day_diff = Math.floor(diff / 86400);
				if (!day_diff) {
					if(diff < 86400) {   twitterDate = Math.floor(diff / 3600) + " hours ago"; }
					if(diff < 7200) {   twitterDate = "1 hour ago"; }
					if(diff < 3600) {   twitterDate = Math.floor(diff / 60) + " minutes ago"; }
					if(diff < 120) { 	twitterDate = "1 minute ago"; }
					if(diff < 60) { 	twitterDate = "just now"; }
				} else {
					if(day_diff < 31) { twitterDate = Math.ceil( day_diff / 7 ) + " weeks ago" }
					if(day_diff < 7) { twitterDate = day_diff + " days ago" }
					if(day_diff == 1) { twitterDate = "Yesterday" }
				}
				//Get the tweet url
				twitterUrl = 'http://twitter.com/'+item['user']['screen_name'];
				
				//Parse links in messages
				message = item['text'].replace(/(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig,"<a href='$1' target='_blank'>$1</a>");
				//Parse Users @
				message = message.replace(/(^|\s)@(\w+)/g,"$1<a href='http://www.twitter.com/$2' target='_blank'>@$2</a>");
				//Parse Hashtags
				message = message.replace(/(^|\s)#(\w+)/g,"$1<a href='http://twitter.com/search?q=%23$2' target='_blank'>#$2</a>");

				//Make our div
				htmlCode = '<div class="rmttweet"><div class="rmtavatar"><a href="'+twitterUrl+'" target="_blank"><img src="'+item['user']['profile_image_url']+'"/></a></div><div class="rmtinfo"><div class="rmtmessage">'+message+'. Tweeted about '+twitterDate+'</div></div></div>';
				//Append the code
				rmtScroller.append(htmlCode);
				//Set the rmttop width
				rmttop = rmtScroller.children(':last').children().children('.rmttop');
				rmttop.width(rmttop.children('.rmtname').width()+rmttop.children('.rmtdate').width()+22);
				//Check the total width of the div
				totalWidth += rmtScroller.children(':last').width();	
			});
			if(rmtp_count > 0) {
				//Check if we need to duplicate if there are not enough tweets
				while(totalWidth < (rmtScroller.parent().width()*2)) {
					htmlCode = rmtScroller.html();
					rmtScroller.append(htmlCode);
					totalWidth = totalWidth*2;
				}
				//Hide the scroller
				rmtScroller.hide();
				//Set the width of the container
				rmtScroller.width(totalWidth);
				//Set the speed
				speed = (41-settings['speed'])*100;
				//Set the beginning point
				rmtScroller.css('marginLeft',100);
				scrollY = 100;
				//Fadein and start to scroll
				rmtScroller.fadeIn(500,function() {
					rmtScroller.rmtScroll();
					//Check if user hovers over the scroller
					rmtScroller.hover(function() { rmtScroller.rmtPause(1); }, function() { rmtScroller.rmtPause(0); });
				});
			} else {
				htmlCode = '<div class="rmtnotweets">There are no tweets to display</div>';
				rmtScroller.hide();
				rmtScroller.append(htmlCode);
				rmtScroller.children('.rmtnotweets').css('marginLeft',60);
				rmtScroller.fadeIn(500);
			}
		});
		
	})

};
//Scroll function
$j.fn.rmtScroll = function() {
	scrollY -= 100;
	rmtScroller = $j(this);
	rmtScroller.animate({
  		marginLeft: scrollY
  	},speed, 'linear',function() {
  		$j(this).rmtOverflow();
  	});
}
//Check tweets that are offstage and remove them
$j.fn.rmtOverflow = function() {
	rmtScroller = $j(this);
	rmtTarget = $j(this).children(':first');
	//If there is a tweet offstage, remove it
	if(-scrollY>rmtTarget.width()) {
		scrollY += rmtTarget.width();
		rmtScroller.css('marginLeft',scrollY);
		rmtScroller.append('<div class="rmttweet">'+$j(this).children(':first').html()+'</div>');
		rmtTarget.remove();
	}
	$j(this).rmtScroll();
}
//Pause Scroller
$j.fn.rmtPause = function(mouseOver) {
	if(mouseOver == '1') {
		rmtScroller = $j(this);
		rmtScroller.stop();
		scrollY = parseInt(rmtScroller.css('marginLeft'));
	} else {
		rmtScroller.rmtScroll();
	}
}
})(jQuery);
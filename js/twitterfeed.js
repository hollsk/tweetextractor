(function($){
	$(document).ready(function(){ 
		$.getScript('/wp-content/themes/gemalto-reskin-2013/libs/twitter-lib.php'); 
		$('.twitter-feed-btns div').click(function(){ 
			//scrollTweets($(this).attr('class')); 
			if($(this).attr('class') == 'twitter-feed-down') {
				$('.tweetbox').animate({
					'height' : 690
				}, 'fast');
				$(this).removeClass('twitter-feed-down').addClass('twitter-feed-up');
			} else {
				$('.tweetbox').animate({
					'height' : 138
				}, 'fast');
				$(this).removeClass('twitter-feed-up').addClass('twitter-feed-down');
			}
		}); 
	}); 
})(jQuery);

function scrollTweets(trigger) { 
	var boxheight = 138; 
	var currentMargin = jQuery('.twitter-feed-display').css('margin-top'); 
	var newMargin = 0; 
	if(trigger == 'twitter-feed-down'){ 
		newMargin = parseInt(currentMargin.substr(0,currentMargin.length-2)) - boxheight; 
		if(newMargin <= -((boxheight * jQuery('.twitter-feed-display li').length)) + boxheight) { 
			newMargin = currentMargin; 
		} 
	} else { 
		newMargin = parseInt(currentMargin.substr(0,currentMargin.length-2)) + boxheight; 
		if(newMargin > 0) { 
			newMargin = 0; 
		} 
	} 
	
	jQuery('.twitter-feed-display').animate({ 
		'marginTop' : newMargin 
	}); 
	currentMargin = newMargin; 
} 

function twitterApiCallback(twitters) { 
	var statusHTML = []; 
	var path = window.location.pathname; 
	
	for (var i=0; i<twitters.length; i++){ 
		var username = twitters[i].user.screen_name; 
		var tweeter_screenname = username; 
		if(twitters[i].retweeted_status){ 
			tweeter_screenname = twitters[i].retweeted_status.user.screen_name; 
		} 
		var createdRaw = twitters[i].created_at; 
		var currentTime = new Date(); 
		var currMonth = currentTime.getMonth(); 
		var currDay = ('0' + currentTime.getDate()).slice(-2); 
		var currYear = currentTime.getFullYear(); 
		var currHours = currentTime.getHours(); 
		var currMinutes = currentTime.getMinutes(); 
		var currSeconds = currentTime.getSeconds(); 
		var createdYear = createdRaw.substr(26,4); 
		var createdMonth = createdRaw.substr(4,3); 
		var createdDay = createdRaw.substr(8,2); 
		var createdHour = createdRaw.substr(11,2); 
		var createdMinute = createdRaw.substr(14,2); 
		var createdSecond = createdRaw.substr(17,2); 
		var monthArr = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec']; 
		var createdTime = ''; 
		if(createdYear == currYear){ 
			if(createdMonth == monthArr[currMonth]){ 
				if(createdDay == currDay){ 
					if((createdHour == currHours)&&(createdMinute < currMinutes)){ 
						if(createdSecond < currSeconds){ 
							createdTime = 'a few seconds ago'; 
						} else { 
							createdTime = (currMinutes - createdMinute) + ' minutes ago'; 
						} 
					} else if(createdHour == (currHours - 1)){ 
						createdTime = (currHours - createdHour) +' hour ago'; 
					} else if(createdHour <= currHours){ 
						createdTime = (currHours - createdHour) +' hours ago'; 
					} 
				} else { 
					// different day 
					createdTime = createdMonth+' '+createdDay+' '+createdYear; 
				} 
			} else {
				// different month 
				createdTime = createdMonth+' '+createdDay+' '+createdYear; 
			} 
		} else { 
			//different year 
			createdTime = createdMonth+' '+createdDay+' '+createdYear; 
		} 
		var tweetId = twitters[i].id_str; 
		if(twitters[i].retweeted_status){ 
			var status = twitters[i].retweeted_status.text.replace(/((https?|s?ftp|ssh)\:\/\/[^"\s\<\>]*[^.,;'">\:\s\<\>\)\]\!])/g, function(url) { return '<a href="'+url+'">'+url+'</a>'; })
				.replace(/\B@([_a-z0-9]+)/ig, function(reply) { return reply.charAt(0)+'<a href="http://twitter.com/'+reply.substring(1)+'">'+reply.substring(1)+'</a>'; }); 
		} else { 
			var status = twitters[i].text.replace(/((https?|s?ftp|ssh)\:\/\/[^"\s\<\>]*[^.,;'">\:\s\<\>\)\]\!])/g, function(url) { return '<a href="'+url+'">'+url+'</a>'; })
				.replace(/\B@([_a-z0-9]+)/ig, function(reply) { return reply.charAt(0)+'<a href="http://twitter.com/'+reply.substring(1)+'">'+reply.substring(1)+'</a>'; }); 
		} 
		
		// build a new object with all the tweets we've just retrieved so it matches our own format instead of the default 
		statusHTML.push({
			'tweeter_screenname' : tweeter_screenname, 
			'status':status, 
			'username' : username, 
			'tweetid' : tweetId, 
			'datestamp' : createdTime
		}); 
	}
	
	// get the boxes for the individual tweets and stick a different tweet in each 
	var theBoxes = jQuery('.theme-blue'); 
	theBoxes.each(function(k,v){ 
		jQuery(this).find('.loading').fadeOut(750, function() { 
			statusbits = statusHTML[k].status; 
			jQuery(this).prev('.content').html('').append(statusbits).hide().fadeIn(750); 
		}); 
	}); 
	
	// get the main twitter feed box 
	var twitterfeed = jQuery('.twitter-feed'); 
	var statuses = []; 
	twitterfeed.find('ul').html('');
	//statusHTML.push('<p><a href="http://www.twitter.com/'+tweeter_screenname+'" target="_blank" class="screenname">@'+tweeter_screenname+'</a> '+status+'<br/><a class="tweetUrl" href="https://twitter.com/intent/tweet?in_reply_to='+tweetId+'">Reply</a> - <a class="tweetUrl" href="http://twitter.com/'+username+'/status/'+tweetId+'" target="_blank">View Tweet</a></p>'); 
	twitterfeed.find('.loading').fadeOut(750, function() { 
		jQuery.each(statusHTML, function(k,v){ 
			statusbits = '<div class="datestamp">' + jQuery(this)[0].datestamp + '</div>' + jQuery(this)[0].status; twitterfeed.find('ul').append('<li>' + statusbits + '</li>').hide().fadeIn(500); 
		}); 
	}); 
}
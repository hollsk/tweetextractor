var com = com || {};
com.hollsk = com.hollsk || {};

com.hollsk.Twitter = (function ($) {
	// set up the options, etc
	var Twitter = function (el) {
		this._path = window.location.pathname; 
		this._el = el;
		this.boxheight = 138;
		this.numVisibleTweets = 4;
	};
	Twitter.prototype = {
		init: function() {
			var $this = this;
			var statuses = [];

			// return tweets from API using oauth
			$.getScript( "/twitter-lib.php", function( data, textStatus, jqxhr ) {

				// empty the list
				$this._el.find('ul').html('');

				// fade out the loading message and insert tweets
				$this._el.find('.loading').fadeOut(750, function() { 
					var returnedTweets = JSON.parse(data);
					$.each(returnedTweets, function(k,v){ 
						// data massage
						var datestamp = $this.convertDatestamp(v.created_at);
						var status = v.text.replace(/((https?|s?ftp|ssh)\:\/\/[^"\s\<\>]*[^.,;'">\:\s\<\>\)\]\!])/g, function(url) { return '<a href="'+url+'">'+url+'</a>'; })
			.replace(/\B@([_a-z0-9]+)/ig, function(reply) { return reply.charAt(0)+'<a href="http://twitter.com/'+reply.substring(1)+'">'+reply.substring(1)+'</a>'; }); 

						// build each tweet
						statusbits = '<div class="datestamp"><a href="http://www.twitter.com/'+ v.user.screen_name +'" target="_blank">@' + v.user.screen_name + "</a> " + datestamp + '</div>' + status;
						$this._el.find('ul').append('<li>' + statusbits + '</li>').hide().fadeIn(500, function(){
							var $truncatedHeight = 0,
								$fullHeight = 0,
								i = 1;
							$('.twitter-feed .body li').each( function() {
								if(i < 4){
									$truncatedHeight = $truncatedHeight+$(this).outerHeight();
								}
								$fullHeight = $fullHeight + $(this).outerHeight();
								i++;
							});
							$('.twitter-feed .tweet-wrapper').css('height',$truncatedHeight);
						});
					});
				});
			});

			$('.more-tweets').on("click", function(){ 
				$this.getMoreTweets($(this));
			});

		},
		getMoreTweets: function(el) {
			var $this = this;
			var $truncatedHeight = 0,
				$fullHeight = 0,
				i = 1;
			var $tweetwrapper = $this._el.find('.tweet-wrapper');

			$('.twitter-feed .body li').each( function() {
				if(i < 4){
					$truncatedHeight = $truncatedHeight+$(this).outerHeight();
				}
				$fullHeight = $fullHeight + $(this).outerHeight();
				i++;
			});
			if(el.hasClass('twitter-feed-down')) {
				$tweetwrapper.animate({
					'height' : $fullHeight+'px'
				}, 'fast');
				el.removeClass('twitter-feed-down').addClass('twitter-feed-up').html('Collapse <span class="caret"></span>');

			} else {
				$tweetwrapper.animate({
					'height' : $truncatedHeight+'px'
				}, 'fast');
				el.removeClass('twitter-feed-up').addClass('twitter-feed-down').html('More from Twitter <span class="caret"></span>');
			}
		},
		convertDatestamp: function(created_at) {
			// turn the Twitter timestamp into a nicer one
			var createdRaw = created_at;
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
			return createdTime;
		}
	}
	return Twitter;
}(jQuery));

(function ($) {
	$(document).ready(function () {
		$('.twitter-feed').each(function () {
			var t = new com.hollsk.Twitter($(this));
			t.init();
		});
	});
}(jQuery));
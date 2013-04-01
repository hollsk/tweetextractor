<!doctype html>
<html>
<head>
	<meta charset="utf-8">
  	<title>Tweet Extractor Tool</title>
  	<meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  	<!-- Twitter Bootstrap -->
  	<link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
  	<link href="/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">

  	<link rel="stylesheet" media="screen" href="/css/screen.css"/>
</head>

<body>
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="/">Tweet Extractor Tool</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li class="active"><a href="/">Home</a></li>
              <li><a href="#about">About</a></li>
              <li><a href="mailto:github@hollsk.co.uk">Contact</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span6">
            <h2>What's this?</h2>
            <p>The Twitter API now requires a valid oAuth token before it will deliver the goodies, even if the goodies in question are part of a public feed. 
                This means that you need an application to tie the requests to so that you can be identified at the point of contact. Bleh! This is designed to work as a webservice, so you don't need to set up a new app every time you want to put a feed on a website. Or you can plug it into your actual website. Whatever suits you!</p>
              <p>An example of what you might be displaying is over there to the right -&gt;
        </div>
        <div class="span6">
          <div class="media">
              <a href="#" class="pull-left">
                <img data-src="holder.js/64x64" class="media-object" alt="64x64" style="width: 64px; height: 64px;" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAYAAACqaXHeAAACGElEQVR4nO2UwYqjUBBF+/8/pUAEeSCCiCASBBmCSJAgISPyEJH6hTsLXyfpXiakL83U4oAxWhxPmXyoKv5nPtgCbCwAW4CNBWALsLEAbAE2FoAtwMYCsAXYWAC2ABsLwBZgYwHYAmwsAFuAjQVgC7CxAGwBNhaALcDGArw8ZJvQ5A5RJIhih/o4YvtyjUeTOySJQzsuPz/vvQFWtKlARBAlDpHsx/X5LjYdc0g4Xw3+h+e9O8Dc7ZJpi00V66XHoa5xPAex9QwXZG/C64jCOTiXoZsU6nvkzsG5AuPfJ+YxAyxDHWQipGmCOHE4dNfb930RQSTH6XT4IjxUyb7ltESVxRARJPXw9DxegHN920YUx7fjop+xjg1EBOVpgV6b8Cqv4d4JRXTfpMQV5pfmkQPERQdVhe/L/XPVoXHhNf3Toa1SiAhc2WCct/3eU3l7wM/f+CvzKAE+t5JUA1QV23gIwj3q+GHDDxQnD1WP2j2cdwcsL80jBdBtDH9KMcqmQeEiiAiy4xXr4uG9h19WXMMmy+6CTRWXNtsfIMmQhgfL2svT83gBVLGMLeKHjcR5i/n7mxJe7XpYoHMfro/QXu9bFnEYlifmsQOoKnT1mKYJ0/y60FvmvT3AL8YCsAXYWAC2ABsLwBZgYwHYAmwsAFuAjQVgC7CxAGwBNhaALcDGArAF2FgAtgAbC8AWYGMB2AJsLABbgM0/93wQUoqtrCYAAAAASUVORK5CYII=">
              </a>
              <div class="media-body">
                <h4 class="media-heading">Media heading</h4>
                <ul>
                  <li class="loading">Wait! I am retrieving some Tweets!</li>
                </ul>
              </div>
            </div>        
        </div>
      </div>
      <div class="row-fluid">
        <div class="span12">
          <div id="about">
	          <h2>How do I use this?</h2>
	          <p>The webservice gives you a JSONP stream back when you feed it some parameters. Collect that JSONP stream into a callback called "twitterApiCallback" and manipulate it from there. Here is an example:</p>
	          <pre>
$(document).ready(function(){
	// request the JSONP via your own webservice - remember to add the &callback=instagram parameter
	$.ajax({
		url: 'http://your-webservice-url/twitter-lib.php?screen_name=_hollsk&callback=twitterApiCallback&count=10&include_rts=true',
		dataType: "jsonp"
	});
});
					
// do whatever you want with the callback here
function twitterApiCallback(twitters) { 
  var statusHTML = []; 
  var path = window.location.pathname; 
  
  for (var i=0; i&lt;twitters.length; i++){ 
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
          if((createdHour == currHours)&&(createdMinute &lt; currMinutes)){ 
            if(createdSecond &lt; currSeconds){ 
              createdTime = 'a few seconds ago'; 
            } else { 
              createdTime = (currMinutes - createdMinute) + ' minutes ago'; 
            } 
          } else if(createdHour == (currHours - 1)){ 
            createdTime = (currHours - createdHour) +' hour ago'; 
          } else if(createdHour &lt;= currHours){ 
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
      var status = twitters[i].retweeted_status.text.replace(/((https?|s?ftp|ssh)\:\/\/[^"\s\&lt;\&gt;]*[^.,;'">\:\s\&lt;\&gt;\)\]\!])/g, function(url) { return '&lt;a href="'+url+'"&gt;'+url+'&lt;/a&gt;'; })
        .replace(/\B@([_a-z0-9]+)/ig, function(reply) { return reply.charAt(0)+'&lt;a href="http://twitter.com/'+reply.substring(1)+'"&gt;'+reply.substring(1)+'&lt;/a&gt;'; }); 
    } else { 
      var status = twitters[i].text.replace(/((https?|s?ftp|ssh)\:\/\/[^"\s\&lt;\&gt;]*[^.,;'">\:\s\&lt;\&gt;\)\]\!])/g, function(url) { return '&lt;a href="'+url+'"&gt;'+url+'&lt;/a&gt;'; })
        .replace(/\B@([_a-z0-9]+)/ig, function(reply) { return reply.charAt(0)+'&lt;a href="http://twitter.com/'+reply.substring(1)+'"&gt;'+reply.substring(1)+'&lt;/a&gt;'; }); 
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

  // get the main twitter feed box 
  var twitterfeed = jQuery('.media'); 
  var statuses = []; 

  twitterfeed.find('.loading').fadeOut(750, function() { 
    $('.media-object').attr('src',twitters[0].user.profile_image_url);
    $('.media-heading').text(username);
    jQuery.each(statusHTML, function(k,v){ 
      statusbits = '&lt;div class="datestamp"&gt;' + jQuery(this)[0].datestamp + '&lt;/div&gt;' + jQuery(this)[0].status; twitterfeed.find('ul').append('&lt;li&gt;' + statusbits + '&lt;/li&gt;').hide().fadeIn(500); 
    }); 
  });          
}
	          </pre>
	          <h2>Is all this code yours?</h2>
	          <p>No, I used the Twitter oAuth library to do the heavy lifting because I am lazy. You'll need both. I included the whole library in this package, but here is the source for the original: <a href="https://github.com/abraham/twitteroauth" target="_blank">https://github.com/abraham/twitteroauth</a></p>
         </div>          
        </div><!--/span-->
      </div><!--/row-->

      <hr>

      <footer>
        <p><a href="http://opensource.org/licenses/mit-license.php" target="_blank">All code released under MIT License</a></p>
      </footer>

    </div><!--/.fluid-container-->

  <script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
  
  <script src="/bootstrap/js/bootstrap.min.js"></script>
  <script type="text/javascript">
        $(document).ready(function(){
          // request the JSONP via your own webservice - remember to add the &callback=instagram parameter
          $.ajax({
            url: '/twitter-lib.php?screen_name=_hollsk&callback=twitterApiCallback&count=5&include_rts=true',
            dataType: "jsonp"
          }); 
        });
                  
        // do whatever you want with the callback here
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

          // get the main twitter feed box 
          var twitterfeed = jQuery('.media'); 
          var statuses = []; 

          twitterfeed.find('.loading').fadeOut(750, function() { 
            $('.media-object').attr('src',twitters[0].user.profile_image_url);
            $('.media-heading').text(username);
            jQuery.each(statusHTML, function(k,v){ 
              statusbits = '<div class="datestamp">' + jQuery(this)[0].datestamp + '</div>' + jQuery(this)[0].status; twitterfeed.find('ul').append('<li>' + statusbits + '</li>').hide().fadeIn(500); 
            }); 
          });          
        }
  </script>
</body>
</html>

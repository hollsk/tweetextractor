Tweet extractor
===========

A php webservice that retrieves a JSONP stream from Twitter for you to use for your own nefarious purposes. 
Uses the v1.1 oauth method for the extraction of public streams.

The webservice is trivial but means you won't need to waste your own precious time setting up a new Twitter app every time you need to display a feed on some website. It's been designed to work in such a way that it will just work with any JSON-based Tweet extractor that used to work using the old API V1.0 method, but with a single change to the script url.

# Project Setup

Set up a new application for your webservice once on Twitter here: https://dev.twitter.com/apps/new

Upload the files to a server. Edit twitter-lib.php to add your own API information from Twitter. 

Follow the instructions in index.php on your server. That's it! 

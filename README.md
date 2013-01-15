Fotolia API Kits
================
Olivier Sirven <olivier@fotolia.com>
[Fotolia.com](http://www.fotolia.com/ "Fotolia")

Introduction
============
Fotolia's industry-leading API allows developers and businesses to
quickly integrate a vast database of images in their workflows and
business models.

Whether you're developing an application with millions of photos, or
integrating a stock photography library into your business to increase
customer satisfaction, Fotolia's powerful APIs are key. But technical
excellence is only part of the formula – our business development team
will work with you to determine the best way to maximize results.

Fotolia's API line-up
=====================

Partner API
-----------
Our Partner API allows you to embed royalty-free image search into
your website.

* Your customers may search the entire Fotolia library to find images
  without leaving your website.
* After finding the perfect image, your customer clicks through to us to
  buy.
* Since our Affiliate Program is also built into this API, we
  automatically pay you for all revenues generated.

[Learn more](http://www.fotolia.com/Services/API/Partner "Fotolia Partner API")

Business API
------------
Our Business API is for on-demand businesses producing custom
merchandise and products, including web site templates and printed
materials.

* Your customers will gain access to high-resolution images directly
  within your application or web-based tool.
* Wholesale pricing is available.
* You can also use this API to embed Fotolia into your intranet or
  application to make search and download faster.

[Learn more](http://www.fotolia.com/Services/API/Business "Fotolia Business API")

Reseller API
------------
Our Reseller API allows you to sell Fotolia's images under your brand name to your customers.

* Access Fotolia's entire microstock image library, with full search
  and download capability.
* A complete white-label solution, available in select markets around
  the world.

[Learn more](http://www.fotolia.com/Services/API/Reseller "Fotolia Reseller API")

Content of this package
=======================

This package contains a full implementation of the API for PHP, python
and java. Each provides an example file to show how to use it.

PHP
---

Requirements:

* [PHP >= 5.2](http://www.php.net)
* [PHP cURL extension](http://www.php.net/curl)

.Example usage

<pre>
#!/usr/bin/env php
<?php

require_once 'fotolia-api.php';

$api = new Fotolia_Api('your_api_key');

// searching for files
$results = $api->getSearchResults(
    array(
        'words' => 'car',
        'language_id' => Fotolia_Api::LANGUAGE_ID_EN_US,
        'limit' => 1,
    ));

printf("Found %d results", $results['nb_results']);

foreach ($results as $key => $value) {
    // iterating only over numeric keys and silently skip other keys
    if (is_numeric($key)) {
        printf("matching media ID: %d", $value['id']);
    }
}

// loggin in and retrieving user data
$api->loginUser('your_login', 'your_password');
print_r($api->getUserData());

// purchasing and downloading a file
$dl_data = $api->getMedia(35957426, 'XS');
$api->downloadMedia($dl_data['url'], '/tmp/' . $dl_data['name']);
</pre>

Python
------

Requirements:

* [Python >= 2.7](http://python.org/)
* [pycurl extension](http://pycurl.sourceforge.net/)


.Example usage

<pre>
#!/usr/bin/env python

import fotolia_api

api = fotolia_api.FotoliaApi('your_api_key')

# searching for files
results = api.get_search_results({'words': 'car', 'language_id': fotolia_api.LANGUAGE_ID_EN_US, 'limit': 1})
print "Found %d results" % results['nb_results']

for key, value in results.items():
    try:
        int(key)
        print "matching media ID: %d" % value['id']
    except ValueError:
        # iterating only over numeric keys and silently skip other keys
        pass

# loggin in and retrieving user data
api.login_user('your_login', 'your_password')
print api.get_user_data()

# purchasing and downloading a file
dl_data = api.get_media(35957426, 'XS')
api.download_media(dl_data['url'], '/tmp/' + str(dl_data['name']))
</pre>

Java
----

Requirements:

* [apache common HTTP client](http://hc.apache.org)
* [json simple](http://code.google.com/p/json-simple/)
* [java JDK >= 6.26](http://www.java.com)

A simple Makefile is provided to help using it. It supports following
commands:

build::
  Build the entire package

jar::
  Create a JAR file for easy inclusion

clean::
  Clean the build files

example::
  Build the example program

.Example usage

<pre>
import org.webservice.fotolia.*;
import org.json.simple.JSONObject;

public class example
{
    public static void main(String[] args)
    {
        FotoliaApi client = new FotoliaApi("your_api_key");

        // fetching a media data
        System.out.println(client.getMediaData(18136053));

        // searching files
        FotoliaSearchQuery query = new FotoliaSearchQuery();
        query.setWords("car").setLanguageId(FotoliaApi.LANGUAGE_ID_EN_US).setLimit(1);
        System.out.println(client.getSearchResults(query));

        // buying and downloading a file
        try {
            client.loginUser("your_login", "your_password");
            JSONObject res = client.getMedia(35957426, "XS");
            client.downloadMedia((String) res.get("url"), "/tmp/" + (String) res.get("name"));
        } catch (Exception e) {
            e.printStackTrace();
        }
    }
}
</pre>

Informations
------------
Email: api@fotolia.com

[Google Groups](http://groups.google.com/group/FotoliaAPI?pli=1 "Fotolia API Google Group")

[Online Documentation](http://us.fotolia.com/Services/API/Rest/Documentation "Fotolia REST API Documentation")

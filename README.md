pwnazon
=======
Fake ad server for your "Amazon Kindle with Special Offers"

Requirements
------------
* Kindle with Special Offers
* Preferably non-3G (otherwise it'll use the 3G connection to download regular ads)
* A machine where you can install a webserver, and host the fake Amazon ads
* A way of poisoning the DNS in your local network (see below)

DNS Hack Methods
----------------

The original author suggested adding a static entry to the DNS table in your router - but not all routers support that type of configuration.

Other options would be:

1.  Use something like [ettercap][1] to perform DNS Spoofing in your local network... this intercepts individual DNS requests and returns bogus responses
2.  Install a DNS proxy (such as [Dnsmasq][2]), and configure your Kindle to use that DNS instead of the default provided by your wireless router. (Hint: when you configure the WiFi network, choose static IP)  This is the method that I use.


Extras
------
The 'pwnazon_extras' directory contains another php script which will find all the pictures in a given directory and create an advert for each one. The path to the the source images is configured inside the script, while the location of the adverts (to be written to) is given as the program's single runtime argument.


Hints
-----

*  To force the Kindle to download your ads right now, deregister and reregister the Kindle from your Amazon account.


History
-------

[pwnazon][3] was originally written by Michael Shepard.

Original README follows:

> Use this to host your own ads for Amazon Kindle Special Offers. Place ads in `pwnazon_images/*_advert` directories. Any missing files are copied from the `pwnazon_images/default` folder. To make this work on your network, extract the tar to the root of your PHP-compatible server (Apache, etc.) and enter these lines into the Directory settings (or `.htaccess` if supported):
>
>     RewriteEngine on
>     RewriteRule RewriteRule ^DTCP/.*/ad-([0-9]*).([0-9]*).apg pwnazon.php?adid=$1
> 
> Be sure to enable mod_rewrite with `sudo a2enmod rewrite` if it's not already.
> 
> After that, add an entry into your router that points `adpublisher.s3.amazonaws.com` to your web server's IP.
> 
> Note that example images/default advertisements are copyrighted. Used for example only. Be sure to remove them if you don't want them stuck on your Kindle for a day (what the expiry is currently set to).
> 
> Also note that this might not work immediately. The ads ons your Kindle must expire before they are replaced. An alternative to waiting is to delete everything in the `system/.assets` folder on the Kindle.

[1]: http://ettercap.sourceforge.net/
[2]: http://thekelleys.org.uk/dnsmasq/doc.html
[3]: http://code.google.com/p/joelisester-sandbox/downloads/detail?name=pwnazon.tar.gz&can=2&q=

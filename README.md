pwnazon
=======
Fake ad server for your "Amazon Kindle with Special Offers"

History
-------

[pwnazon][1] was originally written by Michael Shepard.

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

[1]: http://code.google.com/p/joelisester-sandbox/downloads/detail?name=pwnazon.tar.gz&can=2&q=

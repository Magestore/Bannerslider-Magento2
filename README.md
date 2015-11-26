# Banner Slider Extension on Magento 2.0

Welcome to Banner Slider on Magento 2.0 Installation! We're glad you chose to install our extension.

<h2>New to Magento? Need some help?</h2>
If you're not sure about the following, you probably need a little help before you start installing the Banner Slider extension:

*	Is the Magento software <a href="http://devdocs.magento.com/guides/v2.0/install-gde/basics/basics_magento-installed.html">installed already</a>?
*	What's a <a href="http://devdocs.magento.com/guides/v2.0/install-gde/basics/basics_login.html">terminal, command prompt, or Secure Shell (ssh)</a>?
*	Where's my <a href="http://devdocs.magento.com/guides/v2.0/install-gde/basics/basics_login.html">Magento server</a> and how do I access it?

<h2></h2>
<h2>Step 1: Verify your prerequisites</h2>

Use the following table to verify you have the correct prerequisites to install the Magento software.

<table>
	<tbody>
		<tr>
			<th>Prerequisite</th>
			<th>How to check</th>
			<th>For more information</th>
		</tr>
		<tr>
			<td>Magento version Community Edition 2.0</td>
			<td>Go to admin page, you can see version of Magento 2 at left bottom page, </td>
			<td>Download Magento version Community Edition 2.0 <a href="https://www.magentocommerce.com/download">here</a></td>
		</tr>
		
</tbody>
</table>
<p>If you're not sure how to install Magento 2.0, click <a href="http://blog.magestore.com/install-magento-2-updated-latest-version/?utm_source=Github&utm_medium=Banner%20Slider%202&utm_campaign=Magento%202">here</a> for tutorial!</p>

<h2>Step 2: Pre-Installation</h2>
The Magento front end relies heavily on caching to provide a faster experience to customer. This is a wonderful tool, but can wreak havoc during the installation process. To ensure that the cache is not the cause of any problems, we should turn it off. This can be done from the admin console by navigating to the cache management page (System->Cache Management), selecting all caches, clicking "disable" from the drop-down menu, and submitting the change.

<a data-flickr-embed="true"  href="https://www.flickr.com/photos/138040484@N02/23017808190/in/dateposted-public/" title="cache"><img src="https://farm1.staticflickr.com/638/23017808190_eb32649597_o.png" width="1246" height="450" alt="cache"></a>

<h2>Step 3: Install and verify the installation</h2>
You can download as zip file and unzip Bannerslider extension or clone this repository by command:

Use SSH: git clone git@github.com:Magestore/Bannerslider.git

Use HTTPS: git clone https://github.com/Magestore/Bannerslider.git

When you completed, you have a folder with name Bannerslider, it contain all files of this extension:

<a data-flickr-embed="true"  href="https://www.flickr.com/photos/138040484@N02/23231014181/in/dateposted-public/" title="bannersliderextension"><img src="https://farm1.staticflickr.com/579/23231014181_d3b668f1cd_o.png" width="1217" height="400" alt="bannersliderextension"></a>

Now you copy folder "app" then go to magento 2 root directory and paste it with select merge folder:

<a data-flickr-embed="true"  href="https://www.flickr.com/photos/138040484@N02/22685238684/in/dateposted-public/" title="magentorootfolder"><img src="https://farm1.staticflickr.com/707/22685238684_eb7ed2d666_o.png" width="1219" height="400" alt="magentorootfolder"></a>

<a data-flickr-embed="true"  href="https://www.flickr.com/photos/138040484@N02/22945692779/in/dateposted-public/" title="copy"><img src="https://farm1.staticflickr.com/647/22945692779_0163d920f3_o.png" width="1220" height="400" alt="copy"></a>


Then you open a terminal application, change to magento root directory and use command line :

cd [magento 2 root folder]

php bin/magento setup:upgrade

Example :
<a data-flickr-embed="true"  href="https://www.flickr.com/photos/138040484@N02/23231013591/in/dateposted-public/" title="install"><img src="https://farm1.staticflickr.com/600/23231013591_1b40506c84_o.png" width="1137" height="400" alt="install"></a>

Wait a sec to complete install:

<a data-flickr-embed="true"  href="https://www.flickr.com/photos/138040484@N02/23231013931/in/dateposted-public/" title="completeinstall"><img src="https://farm6.staticflickr.com/5781/23231013931_2f12c9deb0_o.png" width="1136" height="400" alt="completeinstall"></a>

Finaly, you back to magento 2 admin, to check completed installation Bannerslider extesnion:
<a data-flickr-embed="true"  href="https://www.flickr.com/photos/138040484@N02/22945692189/in/dateposted-public/" title="successinstallbannerslider"><img src="https://farm6.staticflickr.com/5623/22945692189_fc051e00a3_o.png" width="1351" height="400" alt="successinstallbannerslider"></a>




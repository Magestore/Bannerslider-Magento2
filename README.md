# Banner Slider Extension on Magento 2.0

Welcome to Banner Slider on Magento 2.0 Installation! We're glad that you are interested in our extension.
<img src="http://blog.magestore.com/wp-content/uploads/2015/08/BS-gift.gif"></img>
<p><span style="color: #000000;">First time in the market, Magento 2 Banner Slider is upgraded to be <span style="color: #ff6600;"><strong>compatible with Magento 2</strong></span> and is promised to become <span style="color: #ff6600;"><strong>the hottest FREE extension</strong></span>.</span></p>
<p><span style="color: #000000;">Still with full features as the previous version, Magento 2 Banner Slider will <strong>attract customers right from the very first moments they are on site:</strong></span></p>
<ul class="short-features">
<li><span style="color: #000000;">Get customers' attention with eye-catching images</span></li>
<li><span style="color: #000000;">Choose among up to 36 positions &amp; a variety of effects to display slides</span></li>
<li><span style="color: #000000;">Highlight your promotion, campaign or any events by using banner slider</span></li>
<li><span style="color: #000000;">View &amp; analyze report for the effectiveness of the slides</span></li>
</ul>
<p><span style="color: #000000;"><strong>TRY LIVE DEMO HERE:</strong></span></p>
<span><a href="http://demo-magento2.magestore.com/banner-slider" target="blank"> Frontend Demo </a></span>
<br><span><a href="http://demo-magento2.magestore.com/banner-slider/admin" target="blank"> Backend Demo </a></span></br>

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
The Magento front end relies heavily on caching to provide a faster experience to customer. This is a wonderful tool, but can wreak havoc during the installation process. To ensure that cache is not the cause of any problem, you'd better turn it off. This can be done from the admin console by navigating to the Cache Management page (System->Cache Management), selecting all caches, clicking "disable" from the drop-down menu, and submitting the change.

<a data-flickr-embed="true"  href="https://www.flickr.com/photos/138040484@N02/23017808190/in/dateposted-public/" title="cache"><img src="https://farm1.staticflickr.com/638/23017808190_eb32649597_o.png" width="1246" height="450" alt="cache"></a>

You also should run the Magento software in developer mode when you’re extending or customizing it. You can use this command line to show current mode :

php bin/magento deploy:mode:show

Use this command to change to developer mode :

php bin/magento deploy:mode:set developer

<h2>Step 3: Install and verify the installation</h2>

<strong>-Install by Composer :</strong> You can install the module by Composer (If your server supports Composer). Please go to the Magento folder and run the command:

<strong>composer require magestore/module-bannerslider</strong>

<strong>-Install by uploading files:</strong>

You can download as "zip" file and unzip Banner Slider extension or clone this repository by the following commands:

Use SSH: git clone git@github.com:Magestore/Bannerslider.git

Use HTTPS: git clone https://github.com/Magestore/Bannerslider.git

When you have completed, you will have a folder containing all files of this extension. 
Then, please create the folder <strong>app/code/Magestore/Bannerslider</strong> and copy all files which you have downloaded to that folder.

<a data-flickr-embed="true"  href="https://www.flickr.com/photos/138040484@N02/23231014181/in/dateposted-public/" title="bannersliderextension"><img src="https://farm1.staticflickr.com/579/23231014181_d3b668f1cd_o.png" width="1217" height="400" alt="bannersliderextension"></a>

 After that, please uploaded the <strong>app</strong> folder to your Magento 2 root folder.

<a data-flickr-embed="true"  href="https://www.flickr.com/photos/138040484@N02/22685238684/in/dateposted-public/" title="magentorootfolder"><img src="https://farm1.staticflickr.com/707/22685238684_eb7ed2d666_o.png" width="1219" height="400" alt="magentorootfolder"></a>

<a data-flickr-embed="true"  href="https://www.flickr.com/photos/138040484@N02/22945692779/in/dateposted-public/" title="copy"><img src="https://farm1.staticflickr.com/647/22945692779_0163d920f3_o.png" width="1220" height="400" alt="copy"></a>


Then you open a terminal application, change to magento root directory and use command line :

cd [magento 2 root folder]

php bin/magento setup:upgrade

Example :
<a data-flickr-embed="true"  href="https://www.flickr.com/photos/138040484@N02/23231013591/in/dateposted-public/" title="install"><img src="https://farm1.staticflickr.com/600/23231013591_1b40506c84_o.png" width="1137" height="400" alt="install"></a>

Wait a second to complete installation process:

<a data-flickr-embed="true"  href="https://www.flickr.com/photos/138040484@N02/23231013931/in/dateposted-public/" title="completeinstall"><img src="https://farm6.staticflickr.com/5781/23231013931_2f12c9deb0_o.png" width="1136" height="400" alt="completeinstall"></a>

After that, if your website is in the production mode, please run the command:

<strong>php bin/magento setup:static-content:deploy</strong>

Finally, coming back to Magento 2 admin to check if Banner Slider extension is installed properly:
<a data-flickr-embed="true"  href="https://www.flickr.com/photos/138738707@N02/25081717235/in/dateposted-public/" title="successinstallbannerslider"><img src="https://farm2.staticflickr.com/1458/25081717235_7c98d5a5bd_h.jpg" width="1351" height="400" alt="successinstallbannerslider"></a>




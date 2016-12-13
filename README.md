# ResultCloud
Web Tool for Management of Long-Term Testing Results

<h3>Installation</h3>
<ol>
<li> Copy all source files into apache working directory.</li>
<li> Delete Config.xml file in /corly/dao/base.</li>
<li> Start web browser and go to localhost or type in your public address, if allowed.</li>
<li> Proceed with installation steps and you are good to go.</li>
</ol>

<h3>Requirements</h3>
<ul>
<li>PHP 5+</li>
<li> MySQL 5+</li>
<li> Allowed mod_rewrite</li>
<li> Modify your server POST size to allow receiving of large files (set to value that is enough to accept your inputs).</li>
<li> Set Apache to show only fatal errors. Application uses some syntax, that is, unfortunately, considered wrong, so it can lead to warnings or notices.</li>
</ul>

<h3>Overview</h3>


<h3>FAQ</h3>
<ul>
<li><i>Instead of installation window, I get only the login window and can not install.</i></li>
Make sure you deleted the Config.xml file. If the file exists, application will not know that it is not installed.

<li><i>Installation failed. It created database, but still comes up with installation steps.<i></li>
Your server probably doesn't allow the application to create Config.xml file. You can create this file manually (use the original file as template), or allow the application to create new files.

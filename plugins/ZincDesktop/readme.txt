/*
This file is part of Silex - see http://projects.silexlabs.org/?/silex

Silex is © 2010-2011 Silex Labs and is released under the GPL License:

This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License (GPL) as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version. 

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

To read the license please visit http://www.gnu.org/copyleft/gpl.html
*/

@author	lexa
@date	2011-06

********************
**  Description   **
********************

Functionalities provided by this plugin

- your site with a transparent background on the user desktop
- no installation, just a native application which launches from the hard drive
- mac and windows compatible, 1 Silex publication gives 2 pixel perfect versions

Applications we have already produced

- an installer to install programs, install drivers, call system scripts, etc.
- distribute Silex on a USB Key or CD/DVD
- make application which can access the file system, transfer files through FTP...

License

This plugin is free and open source, just like Silex. But it uses zinc which is a commercial product. You can use it as is, but there is a watermark on it. You should buy a Zinc license here if you want to remove the watermark.


********************
**  Installation  **
********************

To install this plugin on a silex server, use the manager's plugin installer (exchange platform), or copy the snapshot plugin folder in the silex_server/plugins folder.

********************
**  Activation    **
********************

Server activation (for all publications):
In the server's manager go to "Settings > Plugins > Activate a plugin", click on the plugin icon and then on "confirm".

Specific publication activation:
In the server's manager go to "Manage", click on the publication on which the plugin should be activated, then click on "Plugins > Activate a plugin", and finally click on the plugin icon and then on "confirm".

********************
**  Use           **
********************

* Make a desktop application out of a Silex site *

Download and start Silex portable app. In the Silex portable app folder, there is several folders, such as "silex_server/" and "silex_design_kit/". And there is the Silex launcher application for mac (silex.app), windows (silex.exe) and linux (silex).

Install and activate the plugin for your site in your Silex server. Then duplicate the applications (for mac, windows and linux) and rename them with the name of your site.

When you start the new application, you will see a standard native window with your site in it.

* Use Zink desktop API in your application *

In your Silex site, you can put Silex action on the components and access Zinc API to manipulate files, install programs, install drivers, call system scripts, etc.

For example, this starts a windows script :

onRelease _global.mdm.System.exec:test-script.bat

And for mac

onRelease _global.mdm.System.exec:test-script.sh

Please look at the site "portable-app" provided with Silex portable app version


********************
** Links          **
********************

Download Silex portable app version: http://projects.silexlabs.org/?/silex/flash.cms/download
Install and activate a Silex plugin: http://community.silexlabs.org/silex/help/?p=1519
Zinc web site: http://www.multidmedia.com/
Zinc API: http://www.multidmedia.com/support/livedocs/

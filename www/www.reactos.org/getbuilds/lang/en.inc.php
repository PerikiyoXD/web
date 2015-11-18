<?php
/*
  PROJECT:    ReactOS Website
  LICENSE:    GNU GPLv2 or any later version as published by the Free Software Foundation
  PURPOSE:    Easily download prebuilt ReactOS Revisions
  COPYRIGHT:  Copyright 2007-2009 Colin Finck <mail@colinfinck.de>
  TRANSLATOR: Colin Finck <mail@colinfinck.de>
  
  charset=utf-8 without BOM
*/

	$getbuilds_langres["header"] = '<a href="http://www.reactos.org/">Home</a> &gt; ReactOS SVN Trunk Builds';
	$getbuilds_langres["title"] = "Download ReactOS Trunk Builds";
	$getbuilds_langres["intro"] = 'Here you can download recent, but also older ReactOS Developer versions, which were created by our <a href="http://www.reactos.org/wiki/index.php/RosBuild">BuildBot</a>.';
	
	$getbuilds_langres["overview"] = "Overview";
	$getbuilds_langres["latestrev"] = "Latest ReactOS Revision on the SVN Server";
	$getbuilds_langres["browsesvn"] = "Browse SVN Repository online";
	$getbuilds_langres["buildbot_status"] = "BuildBot Status";
	$getbuilds_langres["buildbot_web"] = "View details at the BuildBot Web Interface";
	$getbuilds_langres["browsebuilds"] = "Browse all created Builds";
	
	$getbuilds_langres["downloadrev"] = "Download a prebuilt ReactOS Revision";
	$getbuilds_langres["js_disclaimer"] = 'You need to have JavaScript enabled in your browser to use the revision file list.<br>Alternatively, you can download all prebuilt revisions <a href="%s">here</a>.';
	$getbuilds_langres["showrevfiles"] = "Show files of revision";
	$getbuilds_langres["prevrev"] = "Previous revision";
	$getbuilds_langres["nextrev"] = "Next revision";
	$getbuilds_langres["showrev"] = "Show";
	$getbuilds_langres["gettinglist"] = "Getting file list";
	$getbuilds_langres["rangeinfo"] = "You can enter a revision number (e.g. %s) or a revision range (e.g. %s-%s)";
	$getbuilds_langres["isotype"] = "Show CD Image types";
	
	$getbuilds_langres["foundfiles"] = "Found %s files!";
	
	$getbuilds_langres["filename"] = "File name";
	$getbuilds_langres["filesize"] = "Size";
	$getbuilds_langres["filedate"] = "Last changed";
	
	$getbuilds_langres["nofiles"] 	 = "There are no prebuilt files for revision %s! The latest available files are for revision " . $rev;
	$getbuilds_langres["invalidrev"] = "Invalid revision number!";
	
	$getbuilds_langres["rangelimitexceeded"] = "The revision range can only comprise a maximum of %s revisions!";
	
	$getbuilds_langres["legend"]= "Legend";
	$getbuilds_langres["build_bootcd"] = "<tt>bootcd</tt> - BootCD ISOs are designed to install ReactOS onto an HDD and enjoy the new features since last release. You will need the ISO only for the installation. This is the recommended variant to install into a VM (VirtualBox, VMWare, QEMU).";
    $getbuilds_langres["build_livecd"] = "<tt>livecd</tt> - LiveCD ISOs allow to use ReactOS without installing it. It can be used to test ReactOS in case your HDD is not detected during BootCD installation or if you have no alternative system/VM to install on.";
    $getbuilds_langres["build_rel"] = "<tt>-rel</tt> - Release version with no debugging information, this version is smaller, but it cannot be used to produce logs.";
    $getbuilds_langres["build_dbg"] = "<tt>-dbg</tt> - Debug version includes debugging information, use this version to test, produce logs and report bugs. This is the recommended variant to install to report bugs.";
    $getbuilds_langres["build_dbgwin"] = "<tt>-dbgwin</tt> - The same as the -dbg version + includes wine Gecko and winetests. ";
?>
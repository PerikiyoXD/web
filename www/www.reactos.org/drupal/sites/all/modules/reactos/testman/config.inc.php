<?php
/*
  PROJECT:    ReactOS Web Test Manager
  LICENSE:    GNU GPLv2 or any later version as published by the Free Software Foundation
  PURPOSE:    Configuration settings for the Web Interface
  COPYRIGHT:  Copyright 2008-2011 Colin Finck <colin@reactos.org>
*/

	define("ROOT_PATH", "../");
	define("SHARED_PATH", ROOT_PATH . "drupal/sites/default/shared/");
	define("TESTMAN_PATH", "/srv/www/www.reactos.org/testman/");

	define("DEFAULT_SEARCH_LIMIT", 10);
	define("DEFAULT_SEARCH_SOURCE", "CMake_x86_GCCLin (KVM)");
	define("MAX_COMPARE_RESULTS", 5);
	define("RESULTS_PER_PAGE", 100);

?>
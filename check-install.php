#!/usr/bin/env php
<?php

/**
 * Contao Open Source CMS
 *
 * Contao Check Download Script
 * Gets the current master repository from GitHub and runs the Contao Check
 *
 * @package   Check
 * @link      http://git.io/contao-check
 * @author    xchs <http://git.io/xchs>
 * @copyright xchs 2012
 */

// Check for a given URL parameter to switch between GitHub repository branches
if (isset($argv[1]) || (isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] != ''))
{
	// Check for the first CLI argument
	if (isset($argv[1]))
	{
		$strBranch = $argv[1];
	}
	else
	{
		// Sanatize for security, remove anything but 0-9,a-z,-_,
		$strBranch = preg_replace("/[^0-9a-z\-_,.\/]+/i", "", $_SERVER['QUERY_STRING']);
	}

	// Get the respective repository branch from GitHub
	shell_exec("curl -s -L https://github.com/contao/check/tarball/" . $strBranch . " | tar -xzp");
}
else
{
	// Get the current "master" branch from the GitHub repository and extract the tar archive (tarball)
	shell_exec("curl -s -L https://github.com/contao/check/tarball/master | tar -xzp");
}

// Save the subfolder name of the unzip directory
$folder = trim(shell_exec("ls -d contao-check-*"));

// Remove some unwanted files and folders
shell_exec("rm -rf $folder/.gitattributes $folder/.gitignore $folder/README.md $folder/.tx");

// Move subfolder contents into current directory
shell_exec("mv $folder/* ./");

// Make sure to move also hidden files and folders
// shell_exec("mv $folder/.[a-z]* ./");

// Remove the unzip directory
shell_exec("rm -rf $folder");

// Remove the download script
shell_exec("rm check-install.php");

// Redirect to the "check" folder and run the Contao Check
Header("Location: check/");

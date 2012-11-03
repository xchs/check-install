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

	// Get the current master repository tarball and extract the archive
	shell_exec("curl -s -L https://github.com/contao/check/tarball/master | tar -xzp");
	
	// Save the subfolder name of the unzip directory
  $folder = trim(shell_exec("ls -d contao-check-*"));

	// Remove some unwanted files and folders
	shell_exec("rm -rf $folder/.gitignore $folder/README.md $folder/.tx");
	
	// Move subfolder contents into current directory
  shell_exec("mv $folder/* ./");
  
	// Make sure to move also hidden files and folders
  shell_exec("mv $folder/.[a-z]* ./");
  
	// Remove the unzip directory
  shell_exec("rm -rf $folder");
	
	// Remove the download script
	shell_exec("rm check-install.php");
	
	// Redirect to the "check" folder and run the Contao Check
	Header("Location: check/");
	
?>
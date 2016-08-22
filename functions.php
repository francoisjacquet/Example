<?php
/**
 * Module Functions / Actions
 * (Loaded on each page)
 *
 * @package Example module
 */


/**
 * Example module Portal Alerts.
 * Example new note.
 *
 * @uses misc/Portal.php|portal_alerts hook
 *
 * @return true if new messages note, else false.
 */
function ExamplePortalAlerts()
{
	global $note;

	if ( ! AllowUse( 'Example/ExampleWidget.php' ) )
	{
		return false;
	}

	// Add note.
	$note[] = '<img src="modules/Example/icon.png" class="button bigger" />
		I am the Example module note.
		I have been hooked by the "misc/Portal.php|portal_alerts" action and I am registered in my functions.php file.';

	return true;
}


/**
 * Register & Hook our function to
 * the 'misc/Portal.php|portal_alerts' action tag.
 *
 * List of available actions:
 * @see functions/Actions.php
 */
add_action( 'misc/Portal.php|portal_alerts', 'ExamplePortalAlerts', 15 );

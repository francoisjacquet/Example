<?php
/**
 * Menu.php file
 * Required
 * - Menu entries for the Example module
 * - Add Menu entries to other modules
 *
 * @package Example module
 */

/**
 * Use dgettext() function instead of _() for Module specific strings translation
 * see locale/README file for more information.
 */
$module_name = dgettext( 'Example', 'Example' );

// Menu entries for the Example module.
$menu['Example']['admin'] = array( // Admin menu.
	'title' => dgettext( 'Example', 'Example' ),
	'default' => 'Example/ExampleWidget.php', // Program loaded by default when menu opened.
	'Example/ExampleWidget.php' => dgettext( 'Example', 'Example Widget' ),
	1 => dgettext( 'Example', 'Setup' ), // Add sub-menu 1 (only for admins).
	'Example/Setup.php' => dgettext( 'Example', 'Setup' ),
);

$menu['Example']['teacher'] = array( // Teacher menu
	'title' => dgettext( 'Example', 'Example' ),
	'default' => 'Example/ExampleWidget.php', // Program loaded by default when menu opened.
	'Example/ExampleWidget.php' => dgettext( 'Example', 'Example Widget' ),
);

$menu['Example']['parent'] = $menu['Example']['teacher']; // Parent & student menu.

// Add a Menu entry to the Resources module.
if ( $RosarioModules['Resources'] ) // Verify Resources module is activated.
{
	$menu['Resources']['admin'] += array(
		1 => dgettext( 'Example', 'Example' ), // Add sub-menu 1.
		'Example/ExampleResource.php' => dgettext( 'Example', 'Example Resource' ),
	);
}

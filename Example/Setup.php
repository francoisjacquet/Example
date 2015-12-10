<?php
/**
 * Setup program
 * Optional
 * - Modify the Config values present in the program_config table
 *
 * @package Example module
 */

DrawHeader( ProgramTitle() ); // Display main header with Module icon and Program title.

if ( $_REQUEST['modfunc'] === 'update'
	&& isset( $_POST['values'] )
	&& AllowEdit() ) // AllowEdit must be verified before inserting, updating, deleting data.
{

	// Verify value is numeric.
	if ( empty( $_REQUEST['values']['EXAMPLE_CONFIG'] )
		|| is_numeric( $_REQUEST['values']['EXAMPLE_CONFIG'] ) )
	{
		$sql = '';

		// Build SQL queries.
		foreach ( (array) $_REQUEST['values'] as $column => $value )
		{
			$sql .= "UPDATE PROGRAM_CONFIG SET ";

			$sql .= "VALUE='" . $value . "' WHERE TITLE='" . $column . "'";

			$sql .= " AND SCHOOL_ID='" . UserSchool() . "' AND SYEAR='" . UserSyear() . "';";
		}

		// Execute queries.
		DBQuery( $sql );

		// Add note.
		$note[] = '<IMG SRC="assets/check_button.png" class="alignImg" />&nbsp;' .
			dgettext( 'Example', 'The configuration value has been modified.' );
	}
	else // If no value or value not numeric.
	{
		// Add error message.
		$error[] = _( 'Please enter valid Numeric data.' );
	}

	unset( $_REQUEST['modfunc'] );
	unset( $_SESSION['_REQUEST_vars']['values'] );
	unset( $_SESSION['_REQUEST_vars']['modfunc'] );
}

// Display Setup value form.
if ( empty( $_REQUEST['modfunc'] ) )
{
	// Display note if any.
	if ( isset( $note ) )
	{
		echo ErrorMessage( $note, 'note' );
	}

	// Display errors if any.
	if ( isset( $error ) )
	{
		echo ErrorMessage( $error, 'error' );
	}

	// Form used to send the updated Config to be processed by the same script (see at the top).
	echo '<form action="Modules.php?modname=' . $_REQUEST['modname'] .
		'&modfunc=update" method="POST">';

	// Display secondary header with Save button (aligned right).
	DrawHeader( '', SubmitButton( _( 'Save' ) ) ); // SubmitButton is diplayed only if AllowEdit.

	echo '<br />';

	// Encapsulate content in PopTable.
	PopTable( 'header', dgettext( 'Example', 'Example module Setup' ) );

	// Get program config options.
	$program_config = DBGet( DBQuery( "SELECT TITLE, VALUE
		FROM PROGRAM_CONFIG
		WHERE SCHOOL_ID='" . UserSchool() . "'
		AND SYEAR='" . UserSyear() . "'
		AND program='example'"), array(), array( 'TITLE' ) ); // The returned array will be indexed by TITLE field.

	// Display the program config options.
	echo '<fieldset><legend><b>' . dgettext( 'Example', 'Example' ) . '</b></legend><table>';

	echo '<tr style="text-align:left;"><td>' .
		TextInput(
			$program_config['EXAMPLE_CONFIG'][1]['VALUE'],
			'values[EXAMPLE_CONFIG]',
			'<span class="legend-gray" title="' . dgettext( 'Example', 'Try to enter a non-numeric value' ) . '">' .
				dgettext( 'Example', 'Example config value label' ) . ' *</span>',
			'maxlength=2 size=2 min=0'
		) . '</td></tr>';

	echo '</table></fieldset>';

	// Close PopTable.
	PopTable( 'footer' );

	// SubmitButton is diplayed only if AllowEdit.
	echo '<div class="center">' . SubmitButton( _( 'Save' ) ) . '</div>';

	echo '</form>';
}

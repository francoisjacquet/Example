<?php
/**
 * ExampleWidget.php file
 * Optional
 * - Example of Search Widget and PDF printing
 *
 * @package Example module
 */

if ( $_REQUEST['modfunc'] === 'save' ) // Print PDF.
{
	// If students selected, continue.
	if ( count( $_REQUEST['st_arr'] ) )
	{
		$st_list = '\'' . implode( '\',\'', $_REQUEST['st_arr'] ) . '\'';

		// Restrict student list to selected students.
		$extra['WHERE'] = " AND s.STUDENT_ID IN (" . $st_list . ")";

		// Get Marking Period information.
		$mp_RET = DBGet( DBQuery( "SELECT TITLE,END_DATE
			FROM SCHOOL_MARKING_PERIODS
			WHERE MP='QTR'
			AND MARKING_PERIOD_ID='" . UserMP() . "'" ) );

		// Get School information.
		$school_info_RET = DBGet( DBQuery("SELECT TITLE,PRINCIPAL
			FROM SCHOOLS WHERE ID='" . UserSchool() . "'
			AND SYEAR='" . UserSyear() . "'" ) );

		// Order by Grade levels.
		$extra['SELECT'] .= ",(SELECT SORT_ORDER
			FROM SCHOOL_GRADELEVELS
			WHERE ID=ssm.GRADE_ID) AS SORT_ORDER";

		$extra['ORDER_BY'] = 'SORT_ORDER DESC,FULL_NAME';

		// Get Teacher information.
		$extra['SELECT'] .= ",(SELECT st.FIRST_NAME||coalesce(' '||st.MIDDLE_NAME||' ',' ')||st.LAST_NAME
			FROM STAFF st,COURSE_PERIODS cp,SCHEDULE ss
			WHERE st.STAFF_ID=cp.TEACHER_ID
			AND cp.COURSE_PERIOD_ID=ss.COURSE_PERIOD_ID
			AND ss.STUDENT_ID=s.STUDENT_ID
			AND ss.SYEAR='" . UserSyear() . "'
			AND ss.MARKING_PERIOD_ID IN (" . GetAllMP( 'Qtr', GetCurrentMP( 'Qtr', DBDate(), false ) ) . ")
			AND (ss.START_DATE<='" . DBDate() . "'
				AND (ss.END_DATE>='" . DBDate() . "'
					OR ss.END_DATE IS NULL)) LIMIT 1) AS TEACHER";

		// Get student list.
		$student_RET = GetStuList( $extra );

		// PDF options.
		$no_margins = array( 'top' => 0, 'bottom' => 0, 'left' => 0, 'right' => 0 );

		$handle = PDFStart( false, $no_margins ); // Start PDF buffer.

		$_SESSION['orientation'] = 'landscape';

		$first = true;

		// Loop over the returned students array.
		foreach ( (array) $student_RET as $student )
		{
			if ( ! $first )
			{
				// Page break before new student.
				echo '<div style="page-break-after: always;"></div>';
			}
			else
				$first = false;

			echo '<br /><br /><table style="margin:0 auto; height:77%;">';

			// Format TEXTAREA content.
			$subject_text = nl2br( str_replace(
				"''", // Remove doubled quotes due tue DBEscapeString()
				"'",
				str_replace( '  ', ' &nbsp;', $_REQUEST['subject_text'] )
			) );

			// Apply the substitutions.
			$subject_text = str_replace(
				array(
					'__FULL_NAME__',
					'__FIRST_NAME__',
					'__LAST_NAME__',
					'__MIDDLE_NAME__',
					'__GRADE_ID__',
					'__SCHOOL_ID__',
					'__SUBJECT__',
				),
				array(
					$student['FULL_NAME'],
					$student['FIRST_NAME'],
					$student['LAST_NAME'],
					$student['MIDDLE_NAME'],
					$student['GRADE_ID'],
					$school_info_RET[1]['TITLE'],
					$_REQUEST['subject'],
				),
				$subject_text
			);

			// Generate the PDF content.
			echo '<tr><td><span style="font-size:xx-large;">' . $subject_text .
				'</span></td></tr></table>';

			echo '<br /><br /><table style="margin:0 auto; width:80%;">';

			echo '<tr><td><span style="font-size:x-large;">' . $student['TEACHER'] . '</span><br />
				<span style="font-size:large;">' . _( 'Teacher' ) . '</span></td>';

			echo '<td><span style="font-size:x-large;">' . $mp_RET[1]['TITLE'] . '</span>
				<br /><span style="font-size:large;">' . _( 'Marking Period' ) . '</span></td></tr>';

			echo '<tr><td><span style="font-size:x-large;">' . $school_info_RET[1]['PRINCIPAL'] . '</span><br />
				<span style="font-size:large;">' . _( 'Principal' ) . '</span></td>';

			echo '<td><span style="font-size:x-large;">' . ProperDate( date( 'Y.m.d', strtotime( $mp_RET[1]['END_DATE'] ) ) ) . '</span><br />
				<span style="font-size:large;">' . _( 'Date' ) . '</span></td></tr>';

			echo '</table>';
		}

		PDFStop( $handle ); // Send PDF buffer to impression.
	}
	else
	{
		// Use BackPrompt to display errors when printing PDF: will close the opened browser tab.
		BackPrompt( _( 'You must choose at least one student.' ) );
	}
}

// Display Search or list of students.
if ( empty( $_REQUEST['modfunc'] ) )
{
	DrawHeader( ProgramTitle() ); // Display main header with Module icon and Program title.

	// If student list.
	if ( $_REQUEST['search_modfunc'] === 'list' )
	{
		// Form used to send the students list
		// and the text to be processed by the same script (see at the top).
		echo '<FORM action="Modules.php?modname=' . $_REQUEST['modname'] .
			'&modfunc=save&include_inactive=' . $_REQUEST['include_inactive'] .
			'&_ROSARIO_PDF=true" method="POST">'; // _ROSARIO_PDF=true enables PDF printing.

		// The $extra variable contains the options for the Search function & the extra headers
		// SubmitButton is diplayed only if AllowEdit.
		$extra['header_right'] = SubmitButton( dgettext( 'Example', 'Create Subject PDF for Selected Students' ) );

		$extra['extra_header_left'] = '<table>';

		$extra['extra_header_left'] .= '<tr class="st"><td style="vertical-align: top;">' . _( 'Text' ) . '</td>
			<td><textarea name="subject_text" rows="8"></textarea></td></tr>';

		// Substitutions list.
		$extra['extra_header_left'] .= '<tr class="st"><td style="vertical-align: top;">' . _( 'Substitutions' ) . ':</td>
			<td><table><tr class="st">';

		$extra['extra_header_left'] .= '<td>__FULL_NAME__</td>
			<td>= ' . _( 'Last, First M' ) . '</td><td>&nbsp;</td>';

		$extra['extra_header_left'] .= '<td>__LAST_NAME__</td>
			<td>= ' . _( 'Last Name' ) . '</td>';

		$extra['extra_header_left'] .= '</tr><tr class="st">';

		$extra['extra_header_left'] .= '<td>__FIRST_NAME__</td>
			<td>= ' . _( 'First Name' ) . '</td><td>&nbsp;</td>';

		$extra['extra_header_left'] .= '<td>__MIDDLE_NAME__</td>
			<td>= ' . _( 'Middle Name' ) . '</td>';

		$extra['extra_header_left'] .= '</tr><tr class="st">';

		$extra['extra_header_left'] .= '<td>__SCHOOL_ID__</td>
			<td>= ' . _( 'School' ) . '</td><td>&nbsp;</td>';

		$extra['extra_header_left'] .= '<td>__GRADE_ID__</td>
			<td>= ' . _( 'Grade Level' ) . '</td>';

		$extra['extra_header_left'] .= '</tr></table>';

		$extra['extra_header_left'] .= '</tr></table>';
	}

	// If not printing page in PDF.
	if ( ! isset( $_REQUEST['_ROSARIO_PDF'] ) )
	{
		$extra['SELECT'] = ",s.STUDENT_ID AS CHECKBOX";

		$extra['functions'] = array( 'CHECKBOX' => '_makeChooseCheckbox' );

		$extra['columns_before'] = array(
			'CHECKBOX' => '</A><input type="checkbox" value="Y" name="controller" checked onclick="checkAll(this.form,this.form.controller.checked,\'st_arr\');"><A>',
		);
	}

	$extra['link'] = array( 'FULL_NAME' => false );

	$extra['new'] = true;

	$extra['options']['search'] = false;

	// Call our custom Widget.
	MyWidgets( 'subject' );

	Search( 'student_id', $extra );

	// If student list.
	if ( $_REQUEST['search_modfunc'] === 'list' )
	{
		// SubmitButton is diplayed only if AllowEdit.
		echo '<br /><div class="center">' .
			SubmitButton( dgettext( 'Example', 'Create Subject PDF for Selected Students' ) ) . '</span>';

		echo '</FORM>';
	}
}


/**
 * Make Choose Student Checkbox
 *
 * Local function
 * Begin function name with an underscore "_" when it is local.
 *
 * @see DBGet() DBGet callback function to format column
 *
 * @example $extra['functions'] = array( 'CHECKBOX' => '_makeChooseCheckbox' );
 * @param  string $value  Student ID.
 * @param  string $column 'CHECKBOX'.
 *
 * @return string         Checkbox HTML
 */
function _makeChooseCheckbox( $value, $column )
{
	return '<input type="checkbox" name="st_arr[]" value="' . $value . '" checked />';
}


/**
 * My Custom Widgets
 *
 * @example MyWidgets( 'subject' );
 *
 * @global $extra The $extra variable contains the options for the Search function
 * @global $_ROSARIO sets $_ROSARIO['SearchTerms']
 *
 * @param string $item 'subject' (Subject Widget).
 */
function MyWidgets( $item )
{
	global $extra,
		$_ROSARIO;

	switch ( $item )
	{
		// Subject Widget.
		case 'subject':

			// If subject selected.
			if ( ! empty( $_REQUEST['subject_id'] ) )
			{
				// Limit student search to subject.
				$extra['WHERE'] .=  " AND exists(SELECT ''
					FROM SCHEDULE sch, COURSE_PERIODS cp, COURSES c
					WHERE sch.STUDENT_ID=s.STUDENT_ID
					AND cp.SYEAR=ssm.SYEAR
					AND sch.SYEAR=ssm.SYEAR
					AND sch.MARKING_PERIOD_ID IN (" . GetAllMP( UserMP() ) . ")
					AND cp.COURSE_PERIOD_ID=sch.COURSE_PERIOD_ID
					AND cp.COURSE_ID=c.COURSE_ID
					AND c.SUBJECT_ID='" . $_REQUEST['subject_id'] . "')";

				// Add SearchTerms.
				if ( ! $extra['NoSearchTerms'] )
				{
					$subject_RET = DBGet( DBQuery( "SELECT TITLE
						FROM COURSE_SUBJECTS
						WHERE SUBJECT_ID='" . $_REQUEST['subject_id'] . "'
						AND SCHOOL_ID='" . UserSchool() . "'
						AND SYEAR='" . UserSyear() . "'" ) );

					$_ROSARIO['SearchTerms'] .= '<b>' . _( 'Subject' ) . ':</b> ' .
						$subject_RET[1]['TITLE'];

					$_ROSARIO['SearchTerms'] .= '<input type="hidden" id="subject" name="subject" value="' . htmlentities( $subject_RET[1]['TITLE'] ) . '" /><br />';
				}
			}

			// Get subjects.
			$subjects_RET = DBGet( DBQuery( "SELECT SUBJECT_ID,TITLE
				FROM COURSE_SUBJECTS WHERE SCHOOL_ID='" . UserSchool() . "'
				AND SYEAR='" . UserSyear() . "'" ) );

			$subjects_options = array();

			// Create select options with subjects.
			foreach ( (array) $subjects_RET as $subject )
			{
				$subjects_options[ $subject['SUBJECT_ID'] ] = $subject['TITLE'];
			}

			$allow_na = false;

			// Add Widget to Search.
			$extra['search'] .= '<tr><td>' . _( 'Subject' ) . '</td>
				<td>' . SelectInput( '', 'subject_id', '', $subjects_options, $allow_na, 'required' ) .
				'</td></tr>';

		break;
	}
}

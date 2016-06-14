<?php
/**
 * ExampleResource.php file
 *
 * Optional
 * - Adds a program to the Resources module.
 *
 * @package Example module
 */

// Display main header with Module icon and Program title.
DrawHeader( ProgramTitle() );


// Get Resources from the database.
$schools_RET = DBGet( DBQuery( "SELECT ID AS SCHOOL_ID, TITLE
	FROM SCHOOLS WHERE SYEAR='" . UserSyear() . "'
	ORDER BY ID" ), array(), array( 'SCHOOL_ID' ) );

// Get the number of Students for each school.
$students_RET = DBGet( DBQuery( "SELECT SCHOOL_ID, COUNT(STUDENT_ID) AS STUDENT_NB
	FROM STUDENT_ENROLLMENT
	WHERE SYEAR='" . UserSyear() . "'
	GROUP BY SCHOOL_ID" ), array(), array( 'SCHOOL_ID' ) );

$school_IDs = array_keys( $schools_RET );

$admins_RET = $teachers_RET = $parents_RET = array();

// For each school.
foreach ( (array) $school_IDs as $school_ID )
{
	$user_SQL = "SELECT " . $school_ID . " AS SCHOOL_ID, COUNT(STAFF_ID) AS [USER]_NB
		FROM STAFF WHERE SYEAR='" . UserSyear() . "'
		AND profile='[user]'
		AND (SCHOOLS LIKE '%," . $school_ID . ",%'
			OR SCHOOLS IS NULL
			OR SCHOOLS='')";

	// Get the number of Administrators.
	$admins_RET[ $school_ID ] = DBGet( DBQuery(
		str_replace( array( '[user]', '[USER]' ), array( 'admin', 'ADMIN' ), $user_SQL ),
		array(),
		array( 'SCHOOL_ID' )
	) );

	// Get the number of Teachers.
	$teachers_RET[ $school_ID ] = DBGet( DBQuery(
		str_replace( array( '[user]', '[USER]' ), array( 'teacher', 'TEACHER' ), $user_SQL )
	) );

	// Get the number of Parents.
	$parents_RET[ $school_ID ] = DBGet( DBQuery(
		str_replace( array( '[user]', '[USER]' ), array( 'parent', 'PARENT' ), $user_SQL )
	) );
}

// Build the Resources array for ListOutput.
$resources = array();

$i = 1; // The first key of the array should not be 0.

// For each school.
foreach ( (array) $school_IDs as $school_ID )
{
	$resources[ $i ] = (array) $schools_RET[ $school_ID ][1];
	$resources[ $i ] += (array) $students_RET[ $school_ID ][1];
	$resources[ $i ] += (array) $admins_RET[ $school_ID ][1];
	$resources[ $i ] += (array) $teachers_RET[ $school_ID ][1];
	$resources[ $i ] += (array) $parents_RET[ $school_ID ][1];

	$i++;
}

// Uncomment the following line to debug and see the Queries results
// var_dump($schools_RET,$students_RET, $admins_RET, $teachers_RET, $parents_RET, $resources);exit;

/**
 * Prepare ListOutput table options
 *
 * @see ListOutput.fnc.php for the complete list of options
 */
$columns = array(
	'TITLE' => _( 'Title' ),
	'STUDENT_NB' => dgettext( 'Example', '# of Students' ),
	'ADMIN_NB' => dgettext( 'Example', '# of Administrators' ),
	'TEACHER_NB' => dgettext( 'Example', '# of Teachers' ),
	'PARENT_NB' => dgettext( 'Example', '# of Parents' ),
);

// Display secondary header with text (aligned left).
DrawHeader( 'This is the Example Resource program from the Example module.' );

ListOutput( $resources, $columns, 'School', 'Schools' );

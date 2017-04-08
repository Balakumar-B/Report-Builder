<?php

/*
 * Example PHP implementation used for the htmlTable.html example
 */

// DataTables PHP library
include( "../../php/DataTables.php" );

// Alias Editor classes so they are easy to use
use
	DataTables\Editor,
	DataTables\Editor\Field,
	DataTables\Editor\Format,
	DataTables\Editor\Mjoin,
	DataTables\Editor\Upload,
	DataTables\Editor\Validate;

Editor::inst( $db, 'stu_results' )
	->fields(
		Field::inst( 'stu_rollno' )->validator( 'Validate::notEmpty' ),
		Field::inst( 'semester' )->validator( 'Validate::notEmpty' ),
		Field::inst( 'gpa' ),
		Field::inst( 'cgpa' ),
		Field::inst( 'arrears' ),
		Field::inst( 'backlog' )
	)
	->process( $_POST )
	->json();

<?php

/*
 * Example PHP implementation used for the index.html example
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

// Build our Editor instance and process the data coming from _POST
Editor::inst( $db, 'stu_results' )
	->fields(
		Field::inst( 'stu_rollno' )->validator( 'Validate::notEmpty' ),
		Field::inst( 'semester' )->validator( 'Validate::notEmpty' ),
		Field::inst( 'gpa' ),
		Field::inst( 'cgpa' ),
		Field::inst( 'arrears' ),
		Field::inst( 'backlog' )
		/*Field::inst( 'age' )
			->validator( 'Validate::numeric' )
			->setFormatter( 'Format::ifEmpty', null ),
		Field::inst( 'salary' )
			->validator( 'Validate::numeric' )
			->setFormatter( 'Format::ifEmpty', null ),
		Field::inst( 'start_date' )
			->validator( 'Validate::dateFormat', array(
				"format"  => Format::DATE_ISO_8601,
				"message" => "Please enter a date in the format yyyy-mm-dd"
			) )
			->getFormatter( 'Format::date_sql_to_format', Format::DATE_ISO_8601 )
			->setFormatter( 'Format::date_format_to_sql', Format::DATE_ISO_8601 )*/
	)
	->process( $_POST )
	->json();
?>
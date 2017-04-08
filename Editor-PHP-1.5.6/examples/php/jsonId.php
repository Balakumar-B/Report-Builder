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
$out = Editor::inst( $db, 'stu_results' )
	->fields(
		Field::inst( 'id' )->set(false), // ID is automatically set by the database on create
		Field::inst( 'stu_rollno' )->validator( 'Validate::notEmpty' ),
		Field::inst( 'semester' )->validator( 'Validate::notEmpty' ),
		Field::inst( 'gpa' ),
		Field::inst( 'cgpa' ),
		Field::inst( 'arrears' ),
		Field::inst( 'backlog' )
	)
	->process( $_POST )
	->data();

// On 'read' remove the DT_RowId property so we can see fully how the `idSrc`
// option works on the client-side.
if ( Editor::action( $_POST ) === Editor::ACTION_READ ) {
	for ( $i=0, $ien=count($out['data']) ; $i<$ien ; $i++ ) {
		unset( $out['data'][$i]['DT_RowId'] );
	}
}

// Send it back to the client
echo json_encode( $out );

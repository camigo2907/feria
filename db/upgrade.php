<?php
function xmldb_local_feria_upgrade($oldversion) {
	global $DB;
	$dbman = $DB->get_manager();

	/// Add a new column newcol to the mdl_myqtype_options
	if ($oldversion < 2016051705) {
	  if ($oldversion < 2016051705) {

        // Define field id to be added to proyecto.
        $table = new xmldb_table('proyecto');
        $field = new xmldb_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null, null);

        // Conditionally launch add field id.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Feria savepoint reached.
        upgrade_plugin_savepoint(true, 2016051705, 'local', 'feria');
    }
	  
		
	}

	return true;
}
<?php
function xmldb_local_feria_upgrade($oldversion) {
	global $DB;
	$dbman = $DB->get_manager();

	/// Add a new column newcol to the mdl_myqtype_options
	if ($oldversion < 2016050700) {
	  if ($oldversion < 2016050700) {

        // Define table proyecto to be created.
        $table = new xmldb_table('proyecto');

        // Adding fields to table proyecto.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('nombre', XMLDB_TYPE_CHAR, '100', null, XMLDB_NOTNULL, null, null);
        $table->add_field('categoria', XMLDB_TYPE_CHAR, '300', null, XMLDB_NOTNULL, null, null);
        $table->add_field('urlarchivo', XMLDB_TYPE_CHAR, '300', null, XMLDB_NOTNULL, null, null);
        $table->add_field('urlfoto1', XMLDB_TYPE_CHAR, '300', null, XMLDB_NOTNULL, null, null);
        $table->add_field('urlfoto2', XMLDB_TYPE_CHAR, '300', null, null, null, null);
        $table->add_field('urlfoto3', XMLDB_TYPE_CHAR, '300', null, null, null, null);
        $table->add_field('urlfoto4', XMLDB_TYPE_CHAR, '300', null, null, null, null);
        $table->add_field('userid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('urlvideo', XMLDB_TYPE_CHAR, '300', null, null, null, null);

        // Adding keys to table proyecto.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));
        $table->add_key('userid', XMLDB_KEY_FOREIGN, array('userid'), 'user', array('id'));

        // Conditionally launch create table for proyecto.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Feria savepoint reached.
        upgrade_plugin_savepoint(true, 2016050700, 'local', 'feria');
    }
		
	}

	return true;
}
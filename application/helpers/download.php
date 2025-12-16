<?php
defined('BASEPATH') or exit('No direct script access allowed');
$prefs = array(
    'tables'        => array('table1', 'table2'),   // Array of tables to backup.
    'ignore'        => array(),                     // List of tables to omit from the backup
    'format'        => 'txt',                       // gzip, zip, txt
    'filename'      => 'thisdb.sql',              // File name - NEEDED ONLY WITH ZIP FILES
    'add_drop'      => TRUE,                        // Whether to add DROP TABLE statements to backup file
    'add_insert'    => TRUE,                        // Whether to add INSERT data to backup file
    'newline'       => "\n"                         // Newline character used in backup file
);

$backup = $this->dbutil->backup($prefs);
?>
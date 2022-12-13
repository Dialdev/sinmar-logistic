<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * @var array $archives
 * @var bool $is_busy
 */

/**
 * @var SLZ_Extension_Backups $backups
 */
$backups = slz_ext('backups');

if (!class_exists('_SLZ_Ext_Backups_List_Table')) {
	slz_include_file_isolated(
		slz_ext('backups')->get_path('/includes/list-table/class--slz-ext-backups-list-table.php')
	);
}

$list_table = new _SLZ_Ext_Backups_List_Table(array(
	'archives' => $archives
));

$list_table->display();

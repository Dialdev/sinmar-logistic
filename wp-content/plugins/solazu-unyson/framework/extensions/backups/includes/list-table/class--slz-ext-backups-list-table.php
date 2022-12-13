<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Display extensions with updates on the Update Page
 */
class _SLZ_Ext_Backups_List_Table extends SLZ_WP_List_Table
{
	private $items_pre_page = 1000;

	private $total_items = null;

	private $_archives = array();

	private $_table_columns = array();
	private $_table_columns_count = 0;

	public function __construct($args)
	{
		parent::__construct(array(
			'screen' => 'slz-ext-backups'
		));

		$this->_archives = $args['archives'];

		$this->_table_columns = array(
			'cb' => ' ',
			'details' => ' ',
		);
		$this->_table_columns_count = count($this->_table_columns);
	}

	public function get_columns()
	{
		return $this->_table_columns;
	}

	public function prepare_items()
	{
		if (!is_null($this->total_items)) {
			return;
		}

		$this->total_items = count($this->_archives);

		$this->set_pagination_args(array(
			'total_items' => $this->total_items,
			'per_page'    => $this->items_pre_page,
		));

		/**
		 * @var SLZ_Extension_Backups $backups
		 */
		$backups = slz_ext('backups');

		/**
		 * Prepare items for output
		 */
		foreach ($this->_archives as $filename => $archive) {
			$time = get_date_from_gmt(
				gmdate('Y-m-d H:i:s', $archive['time']),
				get_option('date_format') . ' ' . get_option('time_format')
			);

			$filename_hash = md5($filename);

			{
				$details = array();

				$details[] = $archive['full'] ? __('Full Backup', 'slz') : __('Content Backup', 'slz');

				if (function_exists('slz_human_bytes')) {
					$details[] = slz_human_bytes(filesize($archive['path']));
				}

				$details[] = slz_html_tag('a', array(
					'href' => $backups->get_download_link($filename),
					'target' => '_blank',
					'id' => 'download-'. $filename_hash,
					'data-download-file' => $filename,
				), esc_html__('Download', 'slz'));

				$details[] = slz_html_tag('a', array(
					'href' => '#',
					'onclick' => 'return false;',
					'id' => 'delete-'. $filename_hash,
					'data-delete-file' => $filename,
					'data-confirm' => __(
						"Warning! \n".
						"You are about to delete a backup, it will be lost forever. \n".
						"Are you sure?",
						'slz'
					)
				), esc_html__('Delete', 'slz'));
			}


			$this->items[] = array(
				'cb' => slz_html_tag('input', array(
					'type' => 'radio',
					'name' => 'archive',
					'value' => $filename,
					'id' => 'archive-'. $filename_hash,
				)),
				'details' =>
					'<div>'. $time .'</div>'.
					'<div>'. implode(' | ', $details) .'</div>',
			);
		}
	}

	public function has_items()
	{
		$this->prepare_items();

		return $this->total_items;
	}

	/**
	 * (override parent)
	 */
	function single_row($item)
	{
		static $row_class = '';

		$row_class = ( $row_class == '' ? ' class="alternate"' : '' );

		echo '<tr' . $row_class . '>';
		echo $this->single_row_columns( $item );
		echo '</tr>';
	}

	protected function column_cb($item)
	{
		echo $item['cb'];
	}

	protected function column_default($item, $column_name)
	{
		echo $item[$column_name];
	}

	function no_items()
	{
		esc_html_e('No archives found', 'slz');
	}

	function extra_tablenav( $which ) {
		echo slz_html_tag('button', array(
			'type' => 'button',
			'onclick' => 'return false;',
			'class' => 'button slz-ext-backups-archive-restore-button',
			'disabled' => 'disabled',
			'data-confirm' => esc_html__("Warning! \nThe restore will replace all of your content.", 'slz'),
		), esc_html__('Restore Backup', 'slz'));
	}
}

<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

final class SLZ_Ext_Backups_Demo {
	/**
	 * @var string
	 */
	private $id;

	/**
	 * @var string
	 */
	private $screenshot;

	/**
	 * A registered download source
	 * @see SLZ_Ext_Backups_Task_Type_Download_Type
	 * @var string
	 */
	private $source_type;

	/**
	 * Args sent to download type
	 * @var array
	 */
	private $source_args = array();

	private $preview_link;

	private $title;

	private $theme;

	private $version;

	public function __construct($id, $source_type = null, $source_args = array()) {
		$this->id = $id;
		$this->source_type = $source_type;
		$this->source_args = $source_args;
	}

	public function get_id() {
		return $this->id;
	}

	public function get_screenshot() {
		return $this->screenshot;
	}

	public function set_screenshot($screenshot) {
		$this->screenshot = $screenshot;

		return $this;
	}

	public function get_source_type() {
		return $this->source_type;
	}

	public function set_source_type($source_type) {
		$this->source_type = $source_type;

		return $this;
	}

	public function get_source_args() {
		return $this->source_args;
	}

	public function set_source_args(array $source_args) {
		$this->source_args = $source_args;

		return $this;
	}

	public function get_version() {
		return $this->version;
	}

	public function set_version($version) {
		$this->source_args['version'] = $version;

		return $this;
	}

	public function get_preview_link() {
		return $this->preview_link;
	}

	public function set_preview_link($preview_link) {
		$this->preview_link = $preview_link;

		return $this;
	}

	public function get_title() {
		return $this->title;
	}

	public function set_title($title) {
		$this->title = $title;

		return $this;
	}

	public function get_theme() {
		return $this->theme;
	}

	public function set_theme($theme) {
		$this->theme = $theme;

		return $this;
	}

	public static function from_array(array $data) {
		$demo = new self($data['id']);
		$demo->set_screenshot($data['screenshot']);
		$demo->set_source_type($data['source_type']);
		$demo->set_source_args($data['source_args']);

		return $demo;
	}

	public function to_array() {
		return array(
			'id' => $this->get_id(),
			'screenshot' => $this->get_screenshot(),
			'source_type' => $this->get_source_type(),
			'source_args' => $this->get_source_args(),
		);
	}
}

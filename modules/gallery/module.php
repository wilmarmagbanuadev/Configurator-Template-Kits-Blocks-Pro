<?php
namespace BlankElementsPro\Modules\Gallery;

use BlankElementsPro\Base\Module_Base;

class Module extends Module_Base {

	public function __construct() {
		parent::__construct();

		// This is here for extensibility purposes - go to town and make things happen!
	}
	
	public function get_name() {
		return 'blank-gallery';
	}

	public function get_widgets() {
		return [
			'Gallery', // What is it goes here. This should match the widget/element class - the file name should also match but in small caps!
		];
	}
	
}
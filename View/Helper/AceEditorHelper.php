<?php
/**
 * AceEditor for baserCMS
 *
 * Copyright (c) 2013 Yusuke Hirao
 *
 * @copyright		Copyright 2013 Yusuke Hirao
 * @link			http://yusukehirao.com
 * @package			baser.plugins.htmleditor.config
 * @since			baserCMS v3.0.0
 * @version			v0.1.0
 * @license			MIT license
 *
 * [ace editor]: http://ace.c9.io/
 * [Emmet]: http://emmet.io/
 *
 */

/**
 *
 *
 */
class AceEditorHelper extends AppHelper {

	/**
	 *
	 *
	 */
	public $helpers = array('BcBaser','BcForm');

	/**
	 *
	 *
	 */
	public function editor($fieldName, $options) {
		$editor = $this->build($fieldName, $options);
		$textarea = $this->BcForm->textarea($fieldName, array('cols' => 60, 'rows' => 20));
		return $editor.$textarea;
	}

	/**
	 *
	 *
	 */
	protected function build($fieldName, $options = array()) {
		// JavaScriptファイルの読み込み
		$this->BcBaser->js(array(
			'/ace_editor/js/admin/ace/ace.js',
			'/ace_editor/js/admin/ace/ext-emmet.js',
			'/ace_editor/js/admin/ace/emmet.min.js',
			'/ace_editor/js/admin/ace/ext-language_tools.js'
		), false);
		$domId = Inflector::camelize(str_replace('.', '_', $fieldName));
		$script = <<< EOT
<script>
ace.require('ace/ext/emmet');
$(function () {
	var textarea = $('#${domId}').hide();
	var editor = ace.edit('${domId}Editor');
	editor.session.setMode('ace/mode/php');
	editor.setTheme('ace/theme/monokai');
	editor.setOption({
		enableEmmet: true,
		enableBasicAutocompletion: true
	});
	editor.getSession().setValue(textarea.val());
	editor.getSession().on('change', function(){
		textarea.val(editor.getSession().getValue());
	});
});
</script>
EOT;
		$editor = "<div id=\"${domId}Editor\" style=\"width:100%; height: 400px; text-align: left;\"></div>";
		return $script.$editor;
	}

}

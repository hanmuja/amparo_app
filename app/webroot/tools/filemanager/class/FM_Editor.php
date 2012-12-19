<?php

/**
 * This code is part of the FileManager software (www.gerd-tentler.de/tools/filemanager), copyright by
 * Gerd Tentler. Obtain permission before selling this code or hosting it on a commercial website or
 * redistributing it over the Internet or in any other medium. In all cases copyright must remain intact.
 */

include_once('FM_Tools.php');

/**
 * This class creates a text editor/viewer.
 *
 * @package FileManager
 * @subpackage class
 * @author Gerd Tentler
 */
class FM_Editor {

/* PRIVATE PROPERTIES ************************************************************************** */

	/**
	 * holds FileManager object
	 *
	 * @var FileManager
	 */
	var $_FileManager;

/* PUBLIC METHODS ****************************************************************************** */

	/**
	 * constructor
	 *
	 * @param FileManager $FileManager
	 * @return FM_Editor
	 */
	function FM_Editor(&$FileManager) {
		$this->_FileManager =& $FileManager;
	}

	/**
	 * view text editor
	 *
	 * @param FM_Entry $Entry		file entry object
	 */
	function view(&$Entry) {
		$this->_viewHeader($Entry);
		$this->_viewContent($Entry);
	}

/* PRIVATE METHODS ***************************************************************************** */

	/**
	 * view header
	 *
	 * @param FM_Entry $Entry		file entry object
	 */
	function _viewHeader(&$Entry) {
		print "cont:'{$this->_FileManager->container}',";
		print "lang:'{$this->_FileManager->language}',id:'$Entry->id',";
	}

	/**
	 * view file content
	 *
	 * @param FM_Entry $Entry		file entry object
	 */
	function _viewContent(&$Entry) {
		list($language, $content) = $this->_getContent($Entry);
		print "text:{lang:'$language',content:'" . base64_encode($content) . "'}";
	}

	/**
	 * get content
	 *
	 * @param FM_Entry $Entry		file entry object
	 * @return array				script language and file content
	 */
	function _getContent(&$Entry) {
		$file = $Entry->getFile();
		$content = htmlspecialchars(FM_Tools::readLocalFile($file));

		switch(true) {

			case preg_match('/\.jse?$/i', $Entry->name):
				$language = 'javascript';
				break;

			case preg_match('/\.(php|p?html?)$/i', $Entry->name):
				$language = 'php';
				break;

			case preg_match('/\.s?html?$/i', $Entry->name):
				$language = 'html';
				break;

			case preg_match('/\.css$/i', $Entry->name):
				$language = 'css';
				break;

			case preg_match('/\.(pm|pr?l|cgi)$/i', $Entry->name):
				$language = 'perl';
				break;

			case preg_match('/\.(xml|xslt?|wsdl|xsd|xul|rdf)$/i', $Entry->name):
				$language = 'xml';
				break;

			case preg_match('/\.sql$/i', $Entry->name):
				$language = 'sql';
				break;

			default:
				$language = '';
		}
		return array($language, $content);
	}
}

?>
<?php 

require_once 'abstract.php';

/**
 * @category   Pvg
 * @package    Pvg_Importer
 * @author     Philipp Plappert <pplappert@parfum-preisvergleich.com>
 *
 * Usage:  php -f categories.php Categories
 *
 */


class Pvg_Importer_Shell_Categories extends Mage_Shell_Abstract
{
	
	
	public function run()
	{
		$time = microtime(true);
		try {
			$this->_getArgv();
		} catch (Exception $e) {
			echo 'Error: ' . $e->getMessage() . "\n";
			echo $this->usageHelp();
		}
		
		echo 'Elapsed time: ' . round(microtime(true) - $time, 2) . 's' . "\n";
	}
	/**
	 * Retrieve category collection from database.
	 *
	 * @return Pvg_Importer_Shell_Categories
	 */
	protected function _getCategoryIds()
	{
		$collection = Mage::getResourceModel('catalog/category_collection');
		/** 
		 * @var $category Mage_Catalog_Model_Category 
		 */
		foreach ($collection as $category) {
			$ids = explode('/', $category->getPath());
			var_dump($category->getPath());
			
			$idCount  = count($ids);
			if ($idCount != 0) {
				$path = array();
				for ($i = 1; $i < $idCount; $i++) {
					$path[] = $category->load($ids[$i])->getName();
					
				}
				$root = array_shift($path);
				var_dump($path);
			}
		}
		return $this;
	}
	
	/**
	 * Get Argument from CLI - no hyphen needed
	 *
	 * @return Pvg_Importer_Shell_Categories
	 */
	protected function _getArgv()
	{
		
		$arg = strtolower($_SERVER['argv'][1]);
		if($arg == 'categories'){
			$this->_getCategoryIds();
		}else{
			Mage::throwException('Unknown argument: '.$arg);
		}
		return $this;
	}
	
	/**
	 * Retrieve Usage Help Message
	 *
	 */
	public function usageHelp()
	{
		return <<<USAGE
    	Usage:  php -f category.php Categories
				
		
     	 help                          	This help
     	 
USAGE;
	}
	

}
$shell = new Pvg_Importer_Shell_Categories();
$shell->run();


?>
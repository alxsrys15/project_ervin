<?php 
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * 
 */
class HomeController extends AppController
{

	public function beforeFilter ($event) {
		parent::beforeFilter($event);
		if (!$this->Auth->user()) {
			$this->Auth->config('authError', false);
		}
	}

	public function initialize () {
		parent::initialize();
	}
	
	public function index () {
		
	}

	public function faqs () {
		
	}
}

?>
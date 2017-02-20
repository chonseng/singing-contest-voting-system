<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class AdminController extends AppController {
	public function beforeFilter() {
		if ($this->request->action != "login") {
			if (!$this->Session->read("is_logged")) {
				$this->redirect("/admin/login");
			}
		}
	}

	public function index() {
		
	}

	public function login() {
		if ($this->request->is('post')) {

			$username = $this->request->data("Admin.login");
			$password = $this->request->data("Admin.password");
			$user = $this->Admin->findByUsernameAndPassword($username,md5($password));

			
			if (count($user) > 0) {
				$this->Session->write("is_logged", true);
				$this->redirect("/admin");
			}
			else {
				$this->Session->setFlash(__('登入失敗'), 'default', array ('class' => 'alert-box alert'));
				$this->redirect("/admin/login");
			}
		}
	}

	public function logout() {
		$this->Session->write("is_logged", false);
		$this->redirect("/admin");
	}

	public function amount() {
		$this->loadModel("Config");
		$config = $this->Config->findById("1");
		$_SESSION["voting_amount"] = $config["Config"]["voting_amount"];
	}

	public function mark() {
		$this->loadModel("Config");
		$config = $this->Config->findById("1");
		$_SESSION["voting_mark"] = $config["Config"]["voting_mark"];
	}

	public function result() {
		$this->loadModel("Config");
		$config = $this->Config->findById("1");
		$_SESSION["voting_amount"] = $config["Config"]["voting_amount"];
		// $_SESSION["voting_mark"] = $config["Config"]["voting_mark"];

		$this->loadModel("Vote");
		$this->loadModel("Singer");

		$all_singers= $this->Singer->find("all");
		$amount = count($all_singers);

		$votes = $this->Vote->findAllByVotingAmount($_SESSION["voting_amount"]);
		$results = array();
		// for ($i=0; $i < $amount; $i++) { 
		// 	$singer_id = $i+1;
		// 	$this_singer = $this->Singer->findBySingerId($singer_id);
		// 	$results[$singer_id]["name"] = $this_singer["Singer"]["name"];
		// 	$results[$singer_id]["amount"] = 0;
		// }

		$votes_people = count($this->Vote->findAllByVotingAmount($_SESSION["voting_amount"],array('fields' => 'DISTINCT Vote.user_id')));
		// $votes_amount = count($this->Vote->findAllByVotingAmount($_SESSION["voting_amount"])) * $_SESSION["voting_amount"];

		$votes_amount = 0;
		foreach ($votes as $key => $vote) {
			$singers_id_str = $vote["Vote"]["singer_id"];
			$singers_id_arr = split(",",$singers_id_str);
			foreach ($singers_id_arr as $key => $singer_id) {
				$votes_amount += $vote["Vote"]["voting_mark"];
				if (isset($results[$singer_id]["amount"])) $results[$singer_id]["amount"]+=$vote["Vote"]["voting_mark"];
				else {
					// var_dump($singer_id);
					$this_singer = $this->Singer->findBySingerId($singer_id);
					if (count($this_singer) != 0) {
						$results[$singer_id]["name"] = $this_singer["Singer"]["name"];
						$results[$singer_id]["amount"] = $vote["Vote"]["voting_mark"];
					}
					else {
						// $votes_amount--;
					}
				}
			}
		}

		ksort($results);
		
		if (!isset($_SESSION["voting_amount"])) $_SESSION["voting_amount"]=1;
		$this->set("results",$results);
		$this->set("votes_people",$votes_people);
		$this->set("votes_amount",$votes_amount);
	}

	public function result_groups() {
		$this->loadModel("Config");
		$config = $this->Config->findById("1");
		$_SESSION["groups_voting_amount"] = $config["Config"]["groups_voting_amount"];
		// $_SESSION["voting_mark"] = $config["Config"]["voting_mark"];

		$this->loadModel("Groups_vote");
		$this->loadModel("Group");

		$all_singers= $this->Group->find("all");
		$amount = count($all_singers);

		$votes = $this->Groups_vote->findAllByVotingAmount($_SESSION["voting_amount"]);
		$results = array();
		// for ($i=0; $i < $amount; $i++) { 
		// 	$singer_id = $i+1;
		// 	$this_singer = $this->Group->findBySingerId($singer_id);
		// 	$results[$singer_id]["name"] = $this_singer["Singer"]["name"];
		// 	$results[$singer_id]["amount"] = 0;
		// }

		$votes_people = count($this->Groups_vote->findAllByVotingAmount($_SESSION["voting_amount"],array('fields' => 'DISTINCT Groups_vote.user_id')));
		// $votes_amount = count($this->Groups_vote->findAllByVotingAmount($_SESSION["voting_amount"])) * $_SESSION["voting_amount"];

		$votes_amount = 0;
		foreach ($votes as $key => $vote) {
			$singers_id_str = $vote["Groups_vote"]["group_id"];
			$singers_id_arr = split(",",$singers_id_str);
			foreach ($singers_id_arr as $key => $singer_id) {
				// $votes_amount += $vote["Groups_vote"]["voting_mark"];
				$votes_amount += 1;
				if (isset($results[$singer_id]["amount"])) $results[$singer_id]["amount"]+=$vote["Groups_vote"]["voting_mark"];
				else {
					// var_dump($singer_id);
					$this_singer = $this->Group->findByGroupId($singer_id);
					if (count($this_singer) != 0) {
						$results[$singer_id]["name"] = $this_singer["Group"]["name"];
						$results[$singer_id]["amount"] = $vote["Groups_vote"]["voting_mark"];
					}
					else {
						// $votes_amount--;
					}
				}
			}
		}

		ksort($results);
		
		if (!isset($_SESSION["voting_amount"])) $_SESSION["voting_amount"]=1;
		$this->set("results",$results);
		$this->set("votes_people",$votes_people);
		$this->set("votes_amount",$votes_amount);
	}

	public function doamount() {
		if ($this->request->is('post')) {
			$this->loadModel("Config");
			$this->Config->create();
			$this->request->data["Config"]["id"] = 1;

			if ($this->Config->save($this->request->data) ) {
				$_SESSION["voting_amount"] = $this->request->data["Config"]["voting_amount"];
				$this->Session->setFlash(__('更改成功 (每人票數：'.$_SESSION["voting_amount"].")"), 'default', array ('class' => 'alert-box success'));
				$this->redirect("/admin/amount");
			} else {
				$this->Session->setFlash(__('更改失敗，請重新嘗試'), 'default', array ('class' => 'alert-box alert'));
				$this->redirect("/admin/amount");
			}

		}
	}

	public function domark() {
		if ($this->request->is('post')) {
			$this->loadModel("Config");
			$this->Config->create();
			$this->request->data["Config"]["id"] = 1;

			if ($this->Config->save($this->request->data) ) {
				$_SESSION["voting_mark"] = $this->request->data["Config"]["voting_mark"];
				$this->Session->setFlash(__('更改成功 (每票分數：'.$_SESSION["voting_mark"].")"), 'default', array ('class' => 'alert-box success'));
				$this->redirect("/admin/mark");
			} else {
				$this->Session->setFlash(__('更改失敗，請重新嘗試'), 'default', array ('class' => 'alert-box alert'));
				$this->redirect("/admin/mark");
			}

		}
	}

	public function deleteall($id) {
		
		$condition = array('Vote.voting_amount' => $id );
		$this->loadModel("Vote"); 
		$this->Vote->deleteAll($condition,false);
		$this->redirect("/admin/result");
	}

	public function deleteall_groups($id) {
		$condition = array('Groups_vote.voting_amount' => $id );
		$this->loadModel("Groups_vote"); 
		$this->Groups_vote->deleteAll($condition,false);
		$this->redirect("/admin/result_groups");
	}

	public function singers() {
		$this->loadModel("Singer");
		$singers = $this->Singer->find("all",array("order"=>"singer_id"));
		$this->set("singers",$singers);

		$enable_singers = $this->Singer->find("all",array(
			"order"=>"singer_id",
			"conditions" => array(
				"Singer.enable" => 1
			)
		));

		$disable_singers = $this->Singer->find("all",array(
			"order"=>"singer_id",
			"conditions" => array(
				"Singer.enable" => 0
			)
		));

		$this->set("enable_singers",$enable_singers);
		$this->set("disable_singers",$disable_singers);
	}

	public function deletesinger($id) {
		$this->loadModel("Singer");
		$this_singer = $this->Singer->findAllBySingerId($id);
		if (count($this_singer) > 0) {
			$this_id = $this_singer[0]["Singer"]["id"];
			$this->Singer->delete($this_id);
			$this->Session->setFlash(__('刪除成功'), 'default', array ('class' => 'alert-box success'));
			$this->redirect("/admin/singers");
		}
		else {
			$this->Session->setFlash(__('找不到該候選人'), 'default', array ('class' => 'alert-box alert'));
			$this->redirect("/admin/singers");
		}
	}

	public function add_singer() {
		$this->loadModel("Singer");
		$existing = count($this->Singer->findBySingerId($this->request->data["Singer"]["singer_id"]));
		// var_dump($this->request->data);
		// exit;
		
		if ($existing==0) {
			$this->Singer->create();

			if ($this->Singer->save($this->request->data) ) {
				$this->Session->setFlash(__('加入成功'), 'default', array ('class' => 'alert-box success'));
				$this->redirect("/admin/singers");
			} else {
				$this->Session->setFlash(__('加入失敗，請重新嘗試'), 'default', array ('class' => 'alert-box alert'));
				$this->redirect("/admin/singers");
			}
		}
		else {
			$this->Session->setFlash(__('加入失敗，已有相同編號的候選人'), 'default', array ('class' => 'alert-box alert'));
			$this->redirect("/admin/singers");
		}
	}

	public function disableSinger($id) {
		$this->loadModel("Singer");
		$existing = $this->Singer->findBySingerId($id);

		if ($existing) {
			$this->Singer->create();
			$existing["Singer"]["enable"] = 0;

			if ($this->Singer->save($existing) ) {
				$this->Session->setFlash(__('加入成功'), 'default', array ('class' => 'alert-box success'));
				$this->redirect("/admin/singers");
			} else {
				$this->Session->setFlash(__('加入失敗，請重新嘗試'), 'default', array ('class' => 'alert-box alert'));
				$this->redirect("/admin/singers");
			}
		}
		else {
			$this->Session->setFlash(__('加入失敗，已有相同編號的候選人'), 'default', array ('class' => 'alert-box alert'));
			$this->redirect("/admin/singers");
		}
	}

	public function enableSinger($id) {
		$this->loadModel("Singer");
		$existing = $this->Singer->findBySingerId($id);

		if ($existing) {
			$this->Singer->create();
			$existing["Singer"]["enable"] = 1;

			if ($this->Singer->save($existing) ) {
				$this->Session->setFlash(__('加入成功'), 'default', array ('class' => 'alert-box success'));
				$this->redirect("/admin/singers");
			} else {
				$this->Session->setFlash(__('加入失敗，請重新嘗試'), 'default', array ('class' => 'alert-box alert'));
				$this->redirect("/admin/singers");
			}
		}
		else {
			$this->Session->setFlash(__('加入失敗，已有相同編號的候選人'), 'default', array ('class' => 'alert-box alert'));
			$this->redirect("/admin/singers");
		}
	}

	public function newusers() {
		$this->loadModel("User");
		$this->User->deleteAll(array('1 = 1'));
		for ($i=0; $i < 500; $i++) { 
			$this->loadModel("User");
			$is_repeated = false;
			do {
				$random = rand(100000,999999);
				$user = $this->User->findByUsername($random);
				if (count($user)>0) $is_repeated = true;
			}while ($is_repeated);

			$num = $i+1;
			$data["User"]["id"] = $num;
			$data["User"]["username"] = $random;
			$this->User->save($data);
			// $this->User->query("INSERT INTO voting_users(`username`) VALUES ($random)");		
		}
		// for ($i=0; $i < 200; $i++) { 
		// 	$is_repeated = false;
		// 	do {
		// 		$word = "abcdefghijkmnpqrstuvwxyz23456789";
		// 		$random = substr(str_shuffle($word),0,6);
		// 		// $random = rand(100000,999999);
		// 		$singer = $this->Singer->findByPassword($random);
		// 		if (count($singer)>0) $is_repeated = true;
		// 	}while ($is_repeated);
		// 	$num = $i+1;
		// 	$data["Singer"]["id"] = $num;
		// 	$data["Singer"]["singer_id"] = $num;
		// 	$data["Singer"]["password"] = $random;
		// 	$data["Singer"]["created_at"] = date('Y-m-d H:i:s');
		// 	$this->Singer->save($data);
		// 	// $this->Singer->query("INSERT INTO marking_singers(`singer_id`,`password`) VALUES ($num,'$random')");		
		// }
		$this->Session->setFlash(__('成功更改密碼'));
		$this->redirect("/admin");
	}

	public function users() {
		$this->loadModel("User");
		$singers = $this->User->find("all");
		$this->set("singers",$singers);
	}

}

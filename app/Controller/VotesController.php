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
class VotesController extends AppController {
	public function beforeFilter() {
		if ($this->request->action != "login") {
			// var_dump($this->Session->read("user_is_logged"));
			if (!$this->Session->read("user_is_logged")) {
				$this->redirect("/votes/login");
			}
		}
	}

	public function login() {
		// for ($i=0; $i < 215; $i++) { 
		// 	$this->loadModel("User");
		// 	$is_repeated = false;
		// 	do {
		// 		$random = rand(100000,999999);
		// 		$user = $this->User->findByUsername($random);
		// 		if (count($user)>0) $is_repeated = true;
		// 	}while ($is_repeated);
		// 	$this->User->query("INSERT INTO voting_users(`username`) VALUES ($random)");		
		// }
		if ($this->request->is('post')) {
			$this->loadModel("User");
			$username = $this->request->data("User.login");


			$user = $this->User->findByUsername($username);


			if (count($user) > 0) {
				$this->Session->write("user_is_logged", true);
				$_SESSION["user_id"] = $user["User"]["id"];
				$this->redirect("/");
			}
			else {
				$this->Session->setFlash(__('登入失敗'), 'default', array ('class' => 'alert-box alert'));
				$this->redirect("/votes/login");
			}
		}
	}
	
	public function index() {
		$desc = "四強票";
		if ($_SESSION["voting_amount"] == 1 && $_SESSION["voting_mark"]==1) {
			$desc = "季軍票";
		}
		if ($_SESSION["voting_amount"] == 1 && $_SESSION["voting_mark"]==2) {
			$desc = "亞軍票";
		}
		if ($_SESSION["voting_amount"] == 1 && $_SESSION["voting_mark"]==3) {
			$desc = "冠軍票";
		}
		$this->set("desc",$desc);
	}

	public function singers() {
		$this->loadModel("Config");
		$config = $this->Config->findById("1");
		$_SESSION["voting_amount"] = $config["Config"]["voting_amount"];
		$_SESSION["voting_mark"] = $config["Config"]["voting_mark"];
		

		$this->loadModel("Singer");
		$this->loadModel("User");
			// $user_votes = $this->Vote->findAllByUserId($_SESSION["user_id"]);
			// $max_mark = 0;
			// if (count($user_votes)>0) {
			// 	foreach ($user_votes as $key => $vote) {
			// 		if ($vote["Vote"]["voting_mark"] > $max_mark) {
			// 			$max_mark = $vote["Vote"]["voting_mark"];
			// 		}
			// 	}
			// }
			// $has_next = true;
			// if ($max_mark>=3) $has_next = false; 

			// echo "<pre>";
			// var_dump($hi);
		// $ip = $_SERVER['REMOTE_ADDR'];
		// $votes= $this->Vote->findAllByAddress($ip);
		$votes = $this->Vote->findAllByUserIdAndVotingAmountAndVotingMark($_SESSION["user_id"],$_SESSION["voting_amount"],$_SESSION["voting_mark"]);
		$_SESSION["is_voted"] = false;
		if (count($votes)>0) {
			$_SESSION["is_voted"] = true;
			$singers_id_arr = split(",",$votes[0]["Vote"]["singer_id"]);
			$singers_arr = array();
			foreach ($singers_id_arr as $key => $singer_id) {
				$singers_arr[$key] = $this->Singer->findBySingerId($singer_id);
			}
			// $voted_singer = $this->Singer->findBySingerId($votes[0]["Vote"]["singer_id"]);
			$this->set("singers_arr",$singers_arr);
		}
		else {


			$votes = $this->Vote->findAllByUserIdAndVotingAmount($_SESSION["user_id"],$_SESSION["voting_amount"]);
			$voted_singer = array();
			$i = 0;
			foreach ($votes as $key => $vote) {
				$voted_singer[$i] = $vote["Vote"]["singer_id"];
				$i ++ ;
			}
			$singers = $this->Singer->find("all",array(
				"conditions" => array(
					"Singer.enable" => 1,
					"NOT" => array(
						"Singer.singer_id" => $voted_singer
					)
				),
				"order"=>"singer_id",
			));
			// echo "<pre>";
			// var_dump($vote[0]["Vote"]["singer_id"]);
			// var_dump($singers);
			$this->set("singers",$singers);
			
			$header = "";
			if ($_SESSION["voting_amount"] == 1 && $_SESSION["voting_mark"]==1) {
				$header = "季軍票(1分)";
			}
			if ($_SESSION["voting_amount"] == 1 && $_SESSION["voting_mark"]==2) {
				$header = "亞軍票(2分)";
			}
			if ($_SESSION["voting_amount"] == 1 && $_SESSION["voting_mark"]==3) {
				$header = "冠軍票(3分)";
			}
			$this->set("header",$header);
		}

	}

	public function groups() {
		$this->loadModel("Config");
		$config = $this->Config->findById("1");
		$_SESSION["groups_voting_amount"] = $config["Config"]["groups_voting_amount"];
		$_SESSION["groups_voting_mark"] = $config["Config"]["groups_voting_mark"];

		// for ($i=0; $i < 215; $i++) { 
		// 	$this->loadModel("User");
		// 	$is_repeated = false;
		// 	do {
		// 		$random = rand(100000,999999);
		// 		$user = $this->User->findByUsername($random);
		// 		if (count($user)>0) $is_repeated = true;
		// 	}while ($is_repeated);
		// 	$this->User->query("INSERT INTO users(`username`) VALUES ($random)");		
		// }

		$this->loadModel("Group");
		$this->loadModel("Groups_vote");
		$this->loadModel("User");
		// $ip = $_SERVER['REMOTE_ADDR'];
		// $votes= $this->Vote->findAllByAddress($ip);
		$votes = $this->Groups_vote->findAllByUserIdAndVotingAmountAndVotingMark($_SESSION["user_id"],$_SESSION["voting_amount"],$_SESSION["voting_mark"]);

		$_SESSION["is_voted"] = false;
		if (count($votes)>0) {
			$_SESSION["is_voted"] = true;
			$singers_id_arr = split(",",$votes[0]["Groups_vote"]["group_id"]);
			$singers_arr = array();
			foreach ($singers_id_arr as $key => $singer_id) {
				$singers_arr[$key] = $this->Group->findByGroupId($singer_id);
			}

			// $voted_singer = $this->Singer->findBySingerId($votes[0]["Vote"]["group_id"]);
			$this->set("singers_arr",$singers_arr);
		}
		else {
			$votes = $this->Groups_vote->findAllByUserIdAndVotingAmount($_SESSION["user_id"],$_SESSION["voting_amount"]);
			$voted_singer = array();
			$i = 0;
			foreach ($votes as $key => $vote) {
				$voted_singer[$i] = $vote["Groups_vote"]["group_id"];
				$i ++ ;
			}
			$singers = $this->Group->find("all",array(
				"conditions" => array(
					"Group.enable" => 1,
					"NOT" => array(
						"Group.group_id" => $voted_singer
					)
				),
				"order"=>"group_id",
			));
			// echo "<pre>";
			// var_dump($vote[0]["Vote"]["group_id"]);
			// var_dump($singers);
			$this->set("singers",$singers);
			
		}

	}

	public function add() {
		if ($this->request->is('post')) {
			// $data = $this->request->data["Activity"]["description"];
			// $this->request->data["Activity"]["description"] = $this->process_data($data);
			// var_dump($this->request->data);
			// $ip = $_SERVER['REMOTE_ADDR'];

			// var_dump($this->request->data);
			$votes = $this->request->data["Vote"]["singer_id"];
			$arr = array();
			$i = 0;
			foreach ($votes as $key => $vote) {
				$arr[$i] = $vote;
				$i++;
			}
			// echo "<pre>";
			// var_dump($arr);
			$str = "";
			for ($i=0; $i < count($arr); $i++) { 
				if ($i==count($arr)-1) $str = $str.$arr[$i];
				else $str = $str.$arr[$i].",";
			}
			// var_dump($str);
			$this->request->data["Vote"]["singer_id"] = $str;
			// var_dump($this->request->data);

			$this->Vote->create();
			$this->request->data["Vote"]["created_at"] = date('Y-m-d H:i:s');
			$this->request->data["Vote"]["voting_amount"] = $_SESSION["voting_amount"];
			$this->request->data["Vote"]["voting_mark"] = $_SESSION["voting_mark"];
			$this->request->data["Vote"]["user_id"] = $_SESSION["user_id"];
			// var_dump($this->request->data);
			// exit;

			if ($this->Vote->save($this->request->data)) {
				// $this->Session->setFlash(__('投票成功'), 'default', array ('class' => 'alert-box success'));
				$this->redirect(array('action' => 'singers'));
			} else {
				$this->Session->setFlash(__('加入失敗，請重新嘗試'), 'default', array ('class' => 'alert-box alert'));
			}
		}
		
	}

	public function add_groups() {
		if ($this->request->is('post')) {
			$this->loadModel("Groups_vote");
			// $data = $this->request->data["Activity"]["description"];
			// $this->request->data["Activity"]["description"] = $this->process_data($data);
			// var_dump($this->request->data);
			// $ip = $_SERVER['REMOTE_ADDR'];

			// var_dump($this->request->data);
			$votes = $this->request->data["Groups_vote"]["group_id"];
			$arr = array();
			$i = 0;
			foreach ($votes as $key => $vote) {
				$arr[$i] = $vote;
				$i++;
			}
			// echo "<pre>";
			// var_dump($arr);
			$str = "";
			for ($i=0; $i < count($arr); $i++) { 
				if ($i==count($arr)-1) $str = $str.$arr[$i];
				else $str = $str.$arr[$i].",";
			}
			// var_dump($str);
			$this->request->data["Groups_vote"]["group_id"] = $str;
			// var_dump($this->request->data);

			$this->Groups_vote->create();
			$this->request->data["Groups_vote"]["created_at"] = date('Y-m-d H:i:s');
			$this->request->data["Groups_vote"]["voting_amount"] = $_SESSION["voting_amount"];
			$this->request->data["Groups_vote"]["voting_mark"] = $_SESSION["voting_mark"];
			$this->request->data["Groups_vote"]["user_id"] = $_SESSION["user_id"];
			// var_dump($this->request->data);
			// exit;

			if ($this->Groups_vote->save($this->request->data)) {
				// $this->Session->setFlash(__('投票成功'), 'default', array ('class' => 'alert-box success'));
				$this->redirect(array('action' => 'groups'));
			} else {
				$this->Session->setFlash(__('加入失敗，請重新嘗試'), 'default', array ('class' => 'alert-box alert'));
			}
		}
		
	}

	public function logout() {
		$this->Session->write("user_is_logged", false);
		$this->redirect("/");
	}

}

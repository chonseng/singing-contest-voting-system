<link rel="stylesheet" href="<?php $this->Path->myroot(); ?>css/admin.css">
<div class="row">
		<h2>登入管理系統</h2>
			<?= $this->Form->create("Admin") ?>


			<?= $this->Form->input("login", array("label"=>"用戶名")) ?>
			<?= $this->Form->input("password", array("label"=>"密碼")) ?>



			<?php 
				$options = array(
				    'label' => '登入',
				    'class' => 'button medium large-12 medium-12 small-12'
				);
			?>
			<?= $this->Form->end($options) ?>
</div>
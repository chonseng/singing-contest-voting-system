

<div id="marking_wrapper">
	<div class="row">
			<?php echo $this->Session->flash(); ?>
	</div>
	<div class="row">
		<div class="login_logo"></div>
		<div class="login_title"></div>
	</div>
		<div class="row">
			<div class="marking_login">
					<?= $this->Form->create("User") ?>


					<?= $this->Form->input("login", array("label"=>"入場卷號碼", "type"=>"number")) ?>



					<?php 
						$options = array(
						    'label' => '登入',
						    'class' => 'login_btn medium large-12 medium-12 small-12'
						);
					?>
					<?= $this->Form->end($options) ?>
			</div>
		</div>
		
</div>

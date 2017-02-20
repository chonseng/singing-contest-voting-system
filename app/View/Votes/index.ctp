<style>
	body {
		background: #d5eeff;
		background: #333;
	}
</style>

<div class="row">
	<div class="header">
		<h1 id="header_text">請選擇比賽</h1>
	</div>
</div>
<div class="row">
	<a href="<?php $this->Path->myroot(); ?>votes/singers" class="match_btn button large-12 medium-12 small-12">人氣票</a>
	<!-- <a href="<?php $this->Path->myroot(); ?>votes/singers" class="match_btn button large-12 medium-12 small-12">個人賽(<?=$desc?>)</a>
	<a href="<?php $this->Path->myroot(); ?>votes/groups" class="match_btn button large-12 medium-12 small-12">團體賽</a> -->
	<a href="<?php $this->Path->myroot(); ?>votes/logout" class="button small alert large-12 medium-12 small-12">登出</a>
</div>
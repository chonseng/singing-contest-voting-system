
<div class="row">

		<a href="<?php $this->Path->myroot(); ?>admin/result" class="button large-12 medium-12 small-12 column">個人賽結果</a>
		<a href="<?php $this->Path->myroot(); ?>admin/result_groups" class="button large-12 medium-12 small-12 column">團體賽結果</a>
		<a href="<?php $this->Path->myroot(); ?>admin/amount" class="button large-12 medium-12 small-12 column">每人票數</a>
		<a href="<?php $this->Path->myroot(); ?>admin/mark" class="button large-12 medium-12 small-12 column">每票分數</a>
		<a href="<?php $this->Path->myroot(); ?>admin/singers" class="button large-12 medium-12 small-12 column">候選名單</a>

		<a href="<?php $this->Path->myroot(); ?>admin/users" class="button large-12 medium-12 small-12 column">列印投票密碼紙</a>
		<a href="<?php $this->Path->myroot(); ?>admin/newusers" class="button large-12 medium-12 small-12 column alert" onclick="return confirm('確定要更新投票密碼紙?')">更新投票密碼紙</a>
		
	

		<a href="<?php $this->Path->myroot(); ?>admin/logout" class="button small alert">登出</a>
		
</div>
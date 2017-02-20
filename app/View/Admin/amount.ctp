
<div class="row">
	<h2>每人票數</h2>
	<p>需要投給<?=$_SESSION["voting_amount"]?>位候選人</p>
	<form action="<?php $this->Path->myroot(); ?>admin/doamount" method="post">
		<input type="number" name="Config[voting_amount]">
		<input type="submit" class="button large-12 medium-12 small-12" value="提交">
	</form>

	<a href="<?php $this->Path->myroot(); ?>admin" class="button small">返回</a>
</div>
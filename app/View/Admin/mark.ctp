
<div class="row">
	<h2>每票分數</h2>
	<p>每票分數：<?=$_SESSION["voting_mark"]?></p>
	<form action="<?php $this->Path->myroot(); ?>admin/domark" method="post">
		<input type="number" name="Config[voting_mark]">
		<input type="submit" class="button large-12 medium-12 small-12" value="提交">
	</form>

	<a href="<?php $this->Path->myroot(); ?>admin" class="button small">返回</a>
</div>
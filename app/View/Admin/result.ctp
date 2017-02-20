
<?php 
	$percents = array();
	foreach ($results as $key => $result) {
	
		$percents[$key] = $result["amount"]/$votes_amount * 100;

	}
	
?>
<style>
	
	<?php foreach ($results as $key => $result) : ?>
	#singer<?= $key+1 ?> {
		width: <?=$percents[$key]?>%;
		background: orange;

	}
	
	<?php endforeach?>



</style>
<div class="row">
	<h2>結果(每人票數為<?=$_SESSION["voting_amount"]?>的選票結果)</h2>	
	<table width="100%">
		<thead>
			<tr>
				<td class="large-1 medium-1 small-1" id="names">編號</td>
				<td class="large-2 medium-2 small-3" id="names">姓名</td>
				<td class="large-9 medium-9 small-8" >票數</td>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($results as $key => $result) : ?>
			<tr>
				<td><?= $key ?></td>
				<td><?= $result["name"] ?></td>
				<td><div id="singer<?= $key+1 ?>"><?= $result["amount"] ?>&nbsp;(<?= round($percents[$key],5)?>%)</div></td>
			</tr>
			<?php endforeach ?>
		</tbody>
	</table>
	<a href="<?php $this->Path->myroot(); ?>admin/deleteall/<?=$_SESSION["voting_amount"]?>" class="button big alert confirm">刪除所有每人票數為<?=$_SESSION["voting_amount"]?>的選票</a>
	<p>總投票人數：<?=$votes_people?></p>
	<p>總票數(分數)：<?=$votes_amount?></p>

	<a href="<?php $this->Path->myroot(); ?>admin" class="button small">返回</a>
</div>
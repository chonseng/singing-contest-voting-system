<div class="row">
	<h2>有資格的候選人</h2>	
	<table width="100%">
		<thead>
			<tr>
				<td class="large-2 medium-2 small-3">編號</td>
				<td class="large-8 medium-8 small-6" id="names">姓名</td>
				<td class="large-2 medium-2 small-3">刪除</td>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($enable_singers as $key => $singer) : ?>
			<tr>
				<td><?= $singer["Singer"]["singer_id"] ?></td>
				<td><?= $singer["Singer"]["name"] ?></td>
				<td>
					<a href="<?php $this->Path->myroot(); ?>admin/disableSinger/<?=$singer["Singer"]["singer_id"]?>" class="label alert" data-singer="<?=$singer["Singer"]["name"]?>">Disable</a>
				</td>
			</tr>
			<?php endforeach ?>
		</tbody>
	</table>

	<h2>沒有資格的候選人</h2>	
	<table width="100%">
		<thead>
			<tr>
				<td class="large-2 medium-2 small-3">編號</td>
				<td class="large-8 medium-8 small-6" id="names">姓名</td>
				<td class="large-2 medium-2 small-3">刪除</td>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($disable_singers as $key => $singer) : ?>
			<tr>
				<td><?= $singer["Singer"]["singer_id"] ?></td>
				<td><?= $singer["Singer"]["name"] ?></td>
				<td>
					<a href="<?php $this->Path->myroot(); ?>admin/enableSinger/<?=$singer["Singer"]["singer_id"]?>" class="label success" data-singer="<?=$singer["Singer"]["name"]?>">Enable</a>
				</td>
			</tr>
			<?php endforeach ?>
		</tbody>
	</table>

	<h2>候選名單</h2>	
	<table width="100%">
		<thead>
			<tr>
				<td class="large-2 medium-2 small-3">編號</td>
				<td class="large-8 medium-8 small-6" id="names">姓名</td>
				<td class="large-2 medium-2 small-3">刪除</td>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($singers as $key => $singer) : ?>
			<tr>
				<td><?= $singer["Singer"]["singer_id"] ?></td>
				<td><?= $singer["Singer"]["name"] ?></td>
				<td>
					<a href="<?php $this->Path->myroot(); ?>admin/deletesinger/<?=$singer["Singer"]["singer_id"]?>" class="singer_confirm label alert" data-singer="<?=$singer["Singer"]["name"]?>">刪除</a>
				</td>
			</tr>
			<?php endforeach ?>
		</tbody>
	</table>



	<h2>新增候選人</h2>
	<form action="<?php $this->Path->myroot(); ?>admin/add_singer" method="post">
		<label for="singer_id">編號</label>
		<input type="number" name="Singer[singer_id]" id="singer_id">
		<label for="singer_name">姓名</label>
		<input type="text" name="Singer[name]" id="singer_name	">
		<input type="submit" class="button large-12 medium-12 small-12" value="提交">
	</form>


	<a href="<?php $this->Path->myroot(); ?>admin" class="button small">返回</a>
</div>
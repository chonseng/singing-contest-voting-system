<link href='http://fonts.googleapis.com/css?family=Source+Code+Pro' rel='stylesheet' type='text/css'>
<style>
	body {
		background: white;
		color: black;
	}
	p {
		color: black;
	}
</style>
<div class="singers_wrapper">
	<?php foreach ($singers as $singer) : ?>
	<div class="one_singer">
		<div>密碼：<span><?=$singer["User"]["username"]?><span></div>
		<div>登入以下網址投票：<p>http://goo.gl/88mfOZ</p></div>
		<div class="qrcode_wrapper"><img src="<?php $this->Path->myroot(); ?>img/qrcode.png"></div>
	</div>
	<?php endforeach; ?>
</div>
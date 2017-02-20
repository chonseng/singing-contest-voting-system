
<style>
	.radio-toolbar input[type="checkbox"] {
	    display:none;
	}
	input[type="checkbox"] + label {
		display: block;
	  	margin: 20px auto;

	}

	.radio-toolbar label {
		width: 100px;
		height: 100px;
		border-radius: 50%;
		padding: 18px;
	  	font-size: 16px;
	  	background: #2C3E50 url(../img/tick.png) center center no-repeat;
	  	background-size: 40%;
	  	/*border:2px solid white;*/
	  	border: 0;
	}


	.radio-toolbar input[type="checkbox"]:checked + label {
	    background-color: #3ba08d;
	    background-color: #3498DB;
	    border: 0;
	    /*border-color: #3c9a5f;*/
	    color: white;
	}

	.radio li {
		border: 1px solid black;
		margin: 0;
		padding: 0;
		margin: 10px 0;
		list-style: none;
	}
	
	

	.control {
		position: absolute;
		display: block;
		width: 50px;
		height: 50px;
	}

	#next {
		top: 0;
		right: 0;
		background: url(../img/right_arrow.png) center center no-repeat;
		background-size: 40%;
	}

	#pre {
		top: 0;
		left: 0;
		background: url(../img/left_arrow.png) center center no-repeat;
		background-size: 40%;
	}
	
	.singer_name {
		margin: 20px 0;
		font-size: 20px;
		background: url(../img/ribbon.png);
		background-size: cover;
		height: 70px;

		line-height: 55px;
		padding-left: 10px;
		color: white;
	}

	.singer img {
		border: 5px solid white;
		border-radius: 50%;
	}

	body {
		background: #d5eeff;
		background: #333;
	}

	#submit_vote {
		position: fixed;
		bottom: 0;
		width: 100%;
		height: 50px;
		margin: 0;
		background: #45B29D;
		background: #EA5543;
	}

	#header_text.alert {
		background: #EA5543;
	}

	fieldset {
		background: white;
		border: 0;
	}

	.singer_photo {
		width: 320px;
		height: 320px;
		border-radius: 50%;
		background-position: center center;
		background-size: cover;
		margin: 0 auto;
		border: 5px solid white;
	}
</style>


	
	<?php if ($_SESSION["is_voted"]) : ?>
	<div class="row">
		<div class="header">
			<h1 id="header_text">你已成功投票！</h1>
		</div>
	</div>
	<div class="row">
		<fieldset>
			<p>你的<big><?=$_SESSION["voting_mark"]?></big>分票已投給</p>
			<?php foreach ($singers_arr as $key => $singer) : ?>
			<ul>
				<li><?= $singer["Group"]["name"]?></li>
			</ul>
			<?php endforeach ?>
		</fieldset>	
		<a href="<?php $this->Path->myroot(); ?>votes/" class="button small large-12 medium-12 small-12">返回</a>
		<a href="<?php $this->Path->myroot(); ?>votes/logout" class="button small alert large-12 medium-12 small-12">登出</a>
	</div>
	<?php else :?>
	<div class="row">
		<div class="header">
			<h1 id="header_text">你需投<?=$_SESSION["groups_voting_amount"]?>票</h1>
			<a href="#" id="next" class="control"></a>
			<a href="#" id="pre" class="control"></a>
		</div>
	</div>
	<div class="row">
		<form action="<?php $this->Path->myroot(); ?>votes/add_groups" method="post" id="singerform">
			
				<!-- <div class="alert-box">你需要投給<big><?=$_SESSION["voting_amount"]?></big>位候選人</div> -->
				<!-- <div class="alert-box">這票的分數：<big><?=$_SESSION["voting_mark"]?></big></div> -->

				<?php foreach ($singers as $key => $singer) : ?>
				<div id="singer_<?= $singer['Group']['id']?>" class="singer">
					<h2 class="singer_name"><?=$singer['Group']['name']?></h2>
					<div class="singer_photo" style="background-image: url(../img/groups/<?= $singer['Group']['id']?>.jpg)"></div>
					<!-- <img src="<?php $this->Path->myroot(); ?>img/singers/<?= $singer['Group']['id']?>.jpg" alt=""> -->
					<div class="radio-toolbar">
						<input class="mycheckbox" type="checkbox" name="Groups_vote[group_id][<?=$singer['Group']['group_id']?>]" value="<?=$singer['Group']['group_id']?>" id="<?=$key?>">
						<label class="alert-box" for="<?=$key?>"></label>
					</div>
				</div>
				<?php endforeach ?>				

			<a style="margin-bottom: 80px" href="<?php $this->Path->myroot(); ?>votes/" class="button small large-12 medium-12 small-12">返回</a>
				
			<input id="submit_vote" type="submit" class="button large-12 medium-12 small-12" value="提交">
		
		</form>
	</div>

		<?php endif ?>


</div>
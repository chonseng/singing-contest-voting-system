<?php 
    if (!isset($_SESSION["voting_amount"])) {
        $_SESSION["voting_amount"] = 0;
    }

?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>培正中學歌唱比賽</title>
    <meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php $this->Path->myroot(); ?>img/apple-touch-icon-precomposed.png">
    <link rel="stylesheet" href="<?php $this->Path->myroot(); ?>css/foundation.css" />
    <link rel="stylesheet" href="<?php $this->Path->myroot(); ?>css/animate.css" />
	<link rel="stylesheet" href="<?php $this->Path->myroot(); ?>css/web.css" />
    <script src="<?php $this->Path->myroot(); ?>js/modernizr.js"></script>
    <!-- start Mixpanel --><script type="text/javascript">(function(e,b){if(!b.__SV){var a,f,i,g;window.mixpanel=b;b._i=[];b.init=function(a,e,d){function f(b,h){var a=h.split(".");2==a.length&&(b=b[a[0]],h=a[1]);b[h]=function(){b.push([h].concat(Array.prototype.slice.call(arguments,0)))}}var c=b;"undefined"!==typeof d?c=b[d]=[]:d="mixpanel";c.people=c.people||[];c.toString=function(b){var a="mixpanel";"mixpanel"!==d&&(a+="."+d);b||(a+=" (stub)");return a};c.people.toString=function(){return c.toString(1)+".people (stub)"};i="disable track track_pageview track_links track_forms register register_once alias unregister identify name_tag set_config people.set people.set_once people.increment people.append people.track_charge people.clear_charges people.delete_user".split(" ");
    for(g=0;g<i.length;g++)f(c,i[g]);b._i.push([a,e,d])};b.__SV=1.2;a=e.createElement("script");a.type="text/javascript";a.async=!0;a.src=("https:"===e.location.protocol?"https:":"http:")+'//cdn.mxpnl.com/libs/mixpanel-2.2.min.js';f=e.getElementsByTagName("script")[0];f.parentNode.insertBefore(a,f)}})(document,window.mixpanel||[]);
    mixpanel.init("e786fde23901720c334868bc055ac0f8");</script><!-- end Mixpanel -->
</head>
<body>

	<?php if ($this->params['controller'] == "admin") : ?>
		<link rel="stylesheet" href="<?php $this->Path->myroot(); ?>css/admin.css">
    <?php endif?>

    <script src="<?php $this->Path->myroot(); ?>js/jquery.js"></script>
            <?php echo $this->Session->flash(); ?>

            <?php echo $this->fetch('content'); ?>
    
	<script src="<?php $this->Path->myroot(); ?>js/vendor/fastclick.js"></script>
    <script src="<?php $this->Path->myroot(); ?>js/foundation.min.js"></script>
    <script>
        $(function() {
            FastClick.attach(document.body);
        });
        $( document ).ready(function() {
            $(".login_btn").click(function(){
                mixpanel.track("Login Button Clicked");
            })

            $("#submit_vote").click(function(){
                mixpanel.track("Vote Submitted");
            })

    		$('.confirm').click(function(){
    		       var answer = confirm("Are you sure you want to delete this item?");
    		       if (answer){
    		           return true;
    		       } else {
    		           return false;
    		       }
    		   });

    		$('.singer_confirm').click(function(){
				var singer = $(this).data("singer");
		       var answer = confirm("Are you sure you want to delete "+singer+"?");
		       if (answer){
		           return true;
		       } else {
		           return false;
		       }
		   });


    		var selectedCount = 0;
            var has_not_shown = true;
            <?php if ($this->params['controller'] == "votes" && $this->params['action'] == "groups") : ?>
                var amount = <?=$_SESSION["groups_voting_amount"]?>;
            <?php else: ?>
                var amount = <?=$_SESSION["voting_amount"]?>;
            <?php endif; ?>
            $(".mycheckbox").click(function(){
                if ($(this).is(':checked')) {
                    $(".singer_photo").eq(index).addClass('animated bounce');
    				selectedCount++;
    			}
    			else {
                    $(".singer_photo").eq(index).removeClass('animated bounce');
    				selectedCount--;
    			}

                if (selectedCount==amount) {
                    $("#submit_vote").show();
                    $('#submit_vote').addClass('animated slideInLeft');
                    has_not_shown = false;
                }
                else {
                            $("#submit_vote").hide();
                }

                if (selectedCount > amount) {
                    var temp = selectedCount - amount;
                    $("#header_text").text("多投了"+temp+"票");
                    $("#header_text").addClass("alert");
                }
                else if (selectedCount < amount) {
                    var temp = amount - selectedCount;
                    $("#header_text").text("還差"+temp+"票");
                    $("#header_text").addClass("alert");
                }
                else {
                    $("#header_text").text("請提交選票");
                    $("#header_text").removeClass("alert");
                }
                return true;
    		});

    		$("#singerform").submit(function(){
    			if (selectedCount!=amount) {
    				alert("請投給"+amount+"位候選人");
    				return false;
    			}
    		})

            var index = 0;
            var max = $(".singer").length - 1;
            $(".singer").hide();
            $(".singer").eq(index).show();
            $("#next").click(function(){
                index++;
                if (index > max) index = 0;
                $(".singer").hide();
                $(".singer").eq(index).show();
                return false;
            })
            $("#pre").click(function(){
                index--;
                if (index < 0) index = max;
                $(".singer").hide();
                $(".singer").eq(index).show();
                return false;
            })
            
            $("#submit_vote").hide();
        });
        


    </script>
    <script>
      $(document).foundation();
    </script>
</body>
</html>

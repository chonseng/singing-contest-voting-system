(function(){
	var selectedCount = 0;
	$(".mycheckbox").click(function(){
		if ($(this).is(':checked')) {
			selectedCount++;
		}
		else {
			selectedCount--;
		}
	});

	$("#singerform").submit(function(){
		if (selectedCount!=4) {
			alert("請投給四位候選人");
			return false;
		}
	})


	$(".radio-toolbar").hide();
	$(".radio-toolbar").eq(0).show();
	

})();
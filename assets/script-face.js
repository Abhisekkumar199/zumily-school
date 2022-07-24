$(document).ready(function(){
	$("#file").change(function(e){
		var img = e.target.files[0];

		if(!pixelarity.open(img, false, function(res, faces){			
			console.log(faces);

			$("#result").attr("src", res);
			$("#result1").attr("value", res);
			$("#result").css("height", "150px");
			$("#result").css("width", "150px");
			$(".face").remove();

			for(var i = 0; i < faces.length; i++){				
				$("body").append("<div class='face' style='height: "+faces[i].height+"px; width: "+faces[i].width+"px; top: "+($("#result").offset().top + faces[i].y)+"px; left: "+($("#result").offset().left + faces[i].x)+"px;'>");
			}
			
		}, "jpg", 0.7, true)){
			alert("Whoops! That is not an image!");
		}

	});
});
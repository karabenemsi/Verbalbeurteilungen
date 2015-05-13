
function save (arg1, arg2, arg3){
	var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	    document.getElementById("ajaxrequest").innerHTML=xmlhttp.responseText;
	    }
	  }
	xmlhttp.open("GET", "save.php?id=" + arg1 + "&changed=" + arg2 + "&sub=" + arg3, true);
	xmlhttp.send();
}

$(document).ready(function(){
	
	$('div .classes').click( function(){
		var num = $(this).attr('id');
		num = '#name_box-' + num;
			$('[class*="grid6_col-"]>h1').css('padding','0.2em 0 0.2em 0');
			$('[class*="grid6_col-"]>h1').css('font-size','1.6em');
			$('[class*="grid6_col-"]>p').css('font-size','0.9em');
			$('[class*="grid6_col-"]>p').css('padding','0.2em 0 0.2em 0');
			$('[id*="name_box-"]').slideUp('200','linear');
			$(num).slideDown('200','linear');		
	});
	
	$('div .namebox_close').click( function(){
			$('[id*="name_box-"]').slideUp('50','linear');
			$('.student_marks').hide();
			$('[class*="grid6_col-"]>h1').css('padding','2em 0 4em 0');
			$('[class*="grid6_col-"]>h1').css('font-size','2.3em');
			$('[class*="grid6_col-"]>p').css('font-size','1.1em');
			$('[class*="grid6_col-"]>p').css('padding','1em 0 3em 0');
			
					
	});
	
	$('div [class*="grid6_col-"]>h3').click( function(){
		$marks = $(this).siblings('.student_marks');
		$('.student_marks').slideUp('100','linear');
		$($marks).slideDown('100','linear');
		
				
	});
	$('form input[type="checkbox"]').change(function(){
		var $checkbox = $(this).parent('.student_marks-row').siblings('.student_marks-row').find('input[type="checkbox"]');
		$('#ajaxrequest').html('Saving..');
		$($checkbox).prop('checked', false);
		$(this).prop('checked', true);
		var name = $(this).prop('name');
		var substr = $(this).data('sub');
		var id = $(this).val();
		save(id, name, substr);
		
	});
	var click= 0;
	$('#copyright').dblclick(function(){
		
		switch (click) {
		case 0:
			$(this).html('Haben sie noch Fragen? Schreiben sie uns:<br><a href="mailto:florian@florianlubitz.de">E-mail</a>');
			click=1;
			console.log(click);
			break;
		case 1:
			$(this).html('Sie können uns auch gerne im Internet besuchen(Zumindest einen von uns):<br><a href="//www.florianlubitz.de" title="florianlubitz.de">Internet</a>');
			click=2;
			break;
		case 2:
			$(this).html('Entstanden ist dieses Projekt am Gymnasium Balingen in langen N&auml;chten');
			click=3;
			break;
		case 3:
			$(this).html('Ein paar Zahlen dazu:<br>ca. 56 Tassen Tee getrunken');
			click=4;
			break;
		case 4:
			$(this).html('21 schlaflose Nächte über Bugs gegrübelt und dabei 13 Pizzen vernichtet');
			click=5;
			break;
		case 5:
			$(this).html('In der Hoffunung, Sie haben das Programm, das Sie brauchen.');
			click=6;
			break;
		case 6:
			$(this).html('Wir würden uns auch &uuml;ber Vorschl&auml;ge zur Verbesserung freuen.');
			click=0;
			break;
		default:
			$(this).html('Error');
		}
		
	});
	
	
	
	
});
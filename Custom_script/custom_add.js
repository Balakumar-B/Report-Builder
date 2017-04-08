// JavaScript Document
//Following script for add.php select degree and courses
$('#curr_degree').change(function(){
		//alert("changed");				
		$('#curr_course').html("");
		var degree =  $(this).find('option:selected').val();
		//alert(degree);
		$.post('../live_search.php',{key: degree},function(data){
			//alert(data);
			$('#curr_course').html("<option value='default'>--Select--</option>");
			$('#curr_course').append(data);					 
		});//ajax call
	});
$('#curr_course').change(function(){	
		$('#curr_branch').html("");						  	
		var course = $(this).find('option:selected').val();
		//alert(course);
		$.post('../live_search.php',{key: 'current_course',course_id: course},function(data){
			$('#curr_branch').html("<option value='default'>--Select--</option>");
			$('#curr_branch').append(data);
			//alert(data);
		});
		
	});
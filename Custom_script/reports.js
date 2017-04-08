// JavaScript Document
//var index_value = 0;
$('#com_wise_course, #incom_wise_course, #blood_grpwise_course, #remark_wise_course, #religion_wise_course, #prev_degree_wise_course').change(function(){
					var selected_course = $(this).select2().val();
					//alert(selected_course);
					$.post('../live_search.php',{key: 'reports', selected_course: selected_course},function(data){
						//alert(data);
						$('#com_wise_branch').html("");
						//$('.box-footer').append(data);
						$('#com_wise_branch').html(data);
						
						$('#incom_wise_branch').html("");
						//$('.box-footer').append(data);
						$('#incom_wise_branch').html(data);
						
						$('#blood_grpwise_branch').html("");
						//$('.box-footer').append(data);
						$('#blood_grpwise_branch').html(data);
						
						$('#remark_wise_branch').html("");
						//$('.box-footer').append(data);
						$('#remark_wise_branch').html(data);
						
						$('#religion_wise_branch').html("");
						//$('.box-footer').append(data);
						$('#religion_wise_branch').html(data);
						
						$('#prev_degree_wise_branch').html("");
						//$('.box-footer').append(data);
						$('#prev_degree_wise_branch').html(data);
					
					});
					//index_value++;
				});
				
				
				
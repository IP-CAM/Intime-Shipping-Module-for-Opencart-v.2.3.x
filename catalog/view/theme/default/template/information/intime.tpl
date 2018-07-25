clear_set = setInterval(function(){
	options = {};
	options = {
	'area':'<?php echo $area['name']; ?>',
	'city':'<?php echo $city['name']; ?>',
	'branch':'<?php echo $branch['name']; ?>'
	};

	if($("select[name='"+options.area+"']").attr('data-loding')=='0'){

		console.log(options);


		getArea(options);
		$("select[name='"+options.branch+"'],select[name='"+options.area+"'],select[name='"+options.city+"']").select2();

		 $("select[name='"+options.area+"']").on('select2:select', function (e) {
				getCity(e.params.data.id,options);
		 });
		 $("select[name='"+options.city+"']").on('select2:select', function (e) {
				getBranch($("select[name='"+options.area+"'] option:selected").val(),e.params.data.id,options);
		 });
	}

	 $("input[name='"+options.area+"']")
      .replaceWith('<select id="'+$("input[name='"+options.area+"']").attr('id')+'" name="'+options.area+'" data-select-value="'+$("input[name='"+options.area+"']").attr('value')+'" data-loding="0" class="'+$("input[name='"+options.area+"']").attr('class')+'"></select>');



       $("input[name='"+options.city+"']")
      .replaceWith('<select id="'+$("input[name='"+options.city+"']").attr('id')+'" data-select-value="'+$("input[name='"+options.city+"']").attr('value')+'" name="'+options.city+'" class="'+$("input[name='"+options.city+"']").attr('class')+'"></select>');


       $("input[name='"+options.branch+"']")
      .replaceWith('<select id="'+$("input[name='"+options.branch+"']").attr('id')+'" data-select-value="'+$("input[name='"+options.branch+"']").attr('value')+'" name="'+options.branch+'" class="'+$("input[name='"+options.branch+"']").attr('class')+'"></select>');

},200);





function getArea(option){

		$.get("/index.php?route=information/intime/area", function( data ) {
			 aop = JSON.parse(data);

			 	  $("select[name='"+option.city+"']").html(" ");
			      $("select[name='"+option.branch+"']").html(" ");

			      $("select[name='"+option.area+"']").append('<option value="----">--- Выберите область ---</option>');


			  aop.forEach(function(items,i){

			  if(items.id == $("select[name='"+option.area+"']").attr('data-select-value')){
			  					getCity(items.id,option);
			  			  	      $("select[name='"+option.area+"']").append('<option selected="" value="'+items.id+'">'+items.area_name_ru+'</option>');

					}else{
			  	      $("select[name='"+option.area+"']").append('<option value="'+items.id+'">'+items.area_name_ru+'</option>');

				}

			  });

			  $("select[name='"+option.area+"']").select2();
			  $("select[name='"+option.area+"']").attr('data-loding','1')
		});
	
}



function getCity(area,option){

	$.get("/index.php?route=information/intime/city&area="+area, function( data ) {
						 aop = JSON.parse(data);
						  $("select[name='"+option.city+"']").html(" ");
						  $("select[name='"+option.branch+"']").html(" ");
						  $("select[name='"+option.city+"']").append('<option value="----">--- Выберите город ---</option>');
						  aop.forEach(function(items,i){
						   if(items.id == $("select[name='"+option.city+"']").attr('data-select-value')){
						  $("select[name='"+option.city+"']").append('<option selected="" value="'+items.id+'">'+items.locality_name_ru+'</option>');

						  getBranch(area,items.id,option);

						}else{
						  $("select[name='"+option.city+"']").append('<option value="'+items.id+'">'+items.locality_name_ru+'</option>');
						}
						  });
						  $("select[name='"+option.city+"']").select2();
					});
	
}


function getBranch(area,city,option){

		$.get("/index.php?route=information/intime/branch&intime_LOCALITY="+city+"&intime_area="+area, function( data ) {
					 aop = JSON.parse(data);

					 if(aop.length >= 1){

					 $("select[name='"+option.branch+"']").html(" ");
					 			      $("select[name='"+option.area+"']").append('<option value="----">--- Выберите отделение ---</option>');

					  aop.forEach(function(items,i){
					  	      $("select[name='"+option.branch+"']").append('<option value="'+items.id+'">'+items.branch_name_ru+" ("+items.address_ru+")"+'</option>');

					  });


					}else{

					 $("select[name='"+option.branch+"']").html(" ");
					 $("select[name='"+option.branch+"']").append('<option value="none">--- Нет отделения ---</option>');

					}

					 

					  $("select[name='"+option.branch+"']").select2();
				});


						 $("select[name='"+option.branch+"'],select[name='"+option.area+"'],select[name='"+option.city+"']").select2();

	
}
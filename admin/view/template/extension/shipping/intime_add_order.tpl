<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-flat" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body row-eq-height">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-flat" class="form-horizontal">

        	<?php $i=0; 


          foreach ($types as $key => $value) { 
          $i++;

          ?>


      <div class="col-xs-6 ">
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h3 class="panel-title"><?php echo $key; ?></h3>
                </div>
                <div class="panel-body">

                 
                    
                
                   <?php foreach ($value as $key2 => $value2) { ?>
                    <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-sender"><?php echo $value2['title']; ?></label>
                    <div class="col-sm-5">
                      <?php if(is_array($value2['value'])){ ?>
                            <select name="<?php echo $key2; ?>" id="input-sender" class="form-control">
                              <?php foreach ($value2['value'] as $key3 => $value3) { ?>
                              
                                      <option <?php if(isset($value2['selected_id'])){ if($value2['selected_id'] == $key3) { echo "selected='selected'";} } ?> value="<?php echo $key3; ?>"><?php echo $value3; ?></option>
                              <?php } ?>
                            </select>
                      <?php }else{ ?>




                            <?php 
                            if(isset($value2['group'])){ ?>
                                 <div class="input-group">

                                 <input class="form-control" value="<?php echo $value2['value']; ?>" type="text" name="<?php echo $key2; ?>">

                           		 <span class="input-group-addon"><?php echo $value2['group']; ?></span>
                           		 </div> 
                            <?php }else{ ?>

                                  <input class="form-control" value="<?php echo $value2['value']; ?>" type="text" name="<?php echo $key2; ?>">


                            <?php } ?>
                           
                      <?php }?>
                      
                    </div>
                  </div>



                   <?php }?>

              
                 
            
                </div>
              </div>
            </div>


              <?php if($i % 2){ ?>
            <div class="clearfix visible-xs"></div>
          <? }  ?>
      

            <? } ?>



   
        
        </form>
      </div>
    </div>
  </div>
</div>
<style type="text/css">
  .select2-container {
    min-width: 300px;
  }
  .row-eq-height {
  display: -webkit-box;
  display: -webkit-flex;
  display: -ms-flexbox;
  display:         flex;
}
</style>


<script type="text/javascript">

  $(document).ready(function(){

    ched = $("select[name='ched'] option:selected").val();

    if(ched == 1){
            $("select[name='pay_s_paced']").removeAttr('disabled');
            $("input[name='cash_on_delivery_sum']").removeAttr('disabled');
          }else{
            $("select[name='pay_s_paced']").attr('disabled','disabled');
            $("input[name='cash_on_delivery_sum']").attr('disabled','disabled');
          }



       $("select[name='receiver_obl']").on('select2:select', function (e) {
           $("#preloader").show();
            var data = e.params.data;
            
            $.get( "/admin/index.php?route=extension/shipping/intime/area&token=<?php echo $_GET['token']; ?>", { 'area': data.id},function(data){
                  aop = JSON.parse(data);
                     if(aop.length > 1){




                  $("select[name='receiver_locality_id']").html(" ");
                  $("#intime_BRANCH").html(" ");
                  $('#intime_BRANCH').select2();
                  aop.forEach(function(items,i){
                    $("select[name='receiver_locality_id']").append('<option value="'+items.id+'">'+items.locality_name_ru+'</option>');
                    if((aop.length-1) == i){
                        $("#preloader").hide();
                    }
                  });
                  $("select[name='receiver_locality_id']").select2();
                         }else{

                         $("#intime_BRANCH").html("'<option value=''>--- Нет отделений---</option>'");
                         $("#intime_BRANCH").attr('disabled','disabled');
                        
                      }

                });
        });


        $("select[name='receiver_locality_id']").on('select2:select', function (e) {
              $("#preloader").show();
              area = $("select[name='receiver_obl'] option:selected").val();
              var data = e.params.data;
              $.get( "/admin/index.php?route=extension/shipping/intime/branch&token=<?php echo $_GET['token']; ?>", { 'intime_area': area,'intime_LOCALITY':data.id},function(data){
                aop = JSON.parse(data);


                

                if(aop.length > 1){
                  $("select[name='receiver_warehouse_id']").html(" ");
                  $("select[name='receiver_warehouse_id']").removeAttr('disabled');
                    aop.forEach(function(items,i){

                      if(items.company_id=="1"){
                          $("select[name='receiver_warehouse_id']").append('<option value="'+items.id+'">'+items.branch_name_ru+'('+items.address_ru+')'+'</option>');
                      }


                        if((aop.length-1) == i){
                        $("#preloader").hide();
                    }
                    });
                }else{
                  $("select[name='receiver_warehouse_id']").html("'<option value=''>--- Нет отделений---</option>'");
                  $("select[name='receiver_warehouse_id']").attr('disabled','disabled');
                }
                
              
                $("#preloader").hide();
                  $("select[name='receiver_warehouse_id']").select2();
              });
        });

        $("select[name='ched']").on('select2:select', function (e) {
          if(e.params.data.id == 1){
            $("select[name='pay_s_paced']").removeAttr('disabled');
            $("input[name='cash_on_delivery_sum']").removeAttr('disabled');
          }else{
            $("select[name='pay_s_paced']").attr('disabled','disabled');
            $("input[name='cash_on_delivery_sum']").attr('disabled','disabled');
          }


        });




   
                   $('select').select2();

  });

 



    
</script>
<div id="preloader"></div>
<style type="text/css">
  .select2-container {
    min-width: 300px;
    max-width: 300px;
  }
  #preloader {
  position: fixed;
  left: 0;
  top: 0;
  z-index: 999;
  width: 100%;
  display: none;
  height: 100%;
  overflow: visible;
  background: #33333370 url('//cdnjs.cloudflare.com/ajax/libs/file-uploader/3.7.0/processing.gif') no-repeat center center;
}
</style>
<?php echo $footer; ?> 
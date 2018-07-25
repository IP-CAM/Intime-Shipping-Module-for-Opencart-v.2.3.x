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
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-flat" class="form-horizontal">

          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-general" data-toggle="tab">Основное</a></li>
            <li><a href="#tab-sender" data-toggle="tab">Отправитель</a></li>
            <li><a href="#tab-default" data-toggle="tab">Значения по умолчанию</a></li>
            <li><a href="#tab-order" data-toggle="tab">Настройки заказа</a></li>


          </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab-general">



                     <div class="form-group">
            <label class="col-sm-2 control-label" for="input-cost"><?php echo $entry_api_key; ?></label>
            <div class="col-sm-10">
              <input type="text" name="intime_api_key" value="<?php echo $intime_api_key; ?>" placeholder="<?php echo $intime_api_key; ?>" id="input-cost" class="form-control" />
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="intime_status" id="input-status" class="form-control">
                <?php if ($intime_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
          </div>
          </div>



          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
            <div class="col-sm-10">
              <input type="text" name="intime_sort_order" value="<?php echo $intime_sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" />
            </div>
          </div>




            </div>


             <div class="tab-pane" id="tab-order">


                      <div class="form-group">
            <label class="col-sm-2 control-label" for="input-cost"># Имя поля для заказа Области</label>
            <div class="col-sm-10">
                <input type="text" name="intime_order_area" value="<?php echo $intime_order_area; ?>" placeholder="<?php echo $intime_order_area; ?>" id="input-cost" class="form-control" />
            </div>
          </div>


                  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-cost">Имя поля для заказа города</label>
            <div class="col-sm-10">
                <input type="text" name="intime_order_city" value="<?php echo $intime_order_city; ?>" placeholder="<?php echo $intime_order_city; ?>" id="input-cost" class="form-control" />
            </div>
          </div>


                  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-cost">Имя поля для заказа отделения</label>
            <div class="col-sm-10">
                <input type="text" name="intime_order_branch" value="<?php echo $intime_order_branch; ?>" placeholder="<?php echo $intime_order_branch; ?>" id="input-cost" class="form-control" />
            </div>
          </div>

             </div>

            <div class="tab-pane" id="tab-default">

          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-cost">Тип груза по умолчанию</label>
            <div class="col-sm-10">
                      <select id="intime_goods" name="intime_goods" class="form-control">
                        <?php foreach($GOODS as $GOODS_row) { if($GOODS_row->isactive == 1){ ?>
                             <option <?php if($GOODS_row->id == $intime_goods) {echo "selected='selected'";}?> value="<?php echo $GOODS_row->id; ?>"><?php echo $GOODS_row->sname; ?></option>
                        <?php }} ?>
                      </select>
            </div>
          </div>

           <div class="form-group">
            <label class="col-sm-2 control-label" for="input-cost">Тип оплаты</label>
            <div class="col-sm-10">
                      <select id="intime_payment_type_id" name="intime_payment_type_id" class="form-control">
                         <option <?php if($intime_payment_type_id == "1"){ echo "selected='selected'";} ?> value="1">Наличный</option>                                  
                         <option <?php if($intime_payment_type_id == "2"){ echo "selected='selected'";} ?> value="2">Безналичный</option>
                      </select>
            </div>
          </div>


           <div class="form-group">
            <label class="col-sm-2 control-label" for="input-cost">Плательшик</label>
            <div class="col-sm-10">
                      <select id="intime_payer_type_id" name="intime_payer_type_id" class="form-control">
                                      <option <?php if($intime_payer_type_id == "2"){ echo "selected='selected'";} ?> value="2">Одержувач</option>
                                      <option <?php if($intime_payer_type_id == "1"){ echo "selected='selected'";} ?> value="1">Відправник</option>
                                      <option <?php if($intime_payer_type_id == "3"){ echo "selected='selected'";} ?> value="3">Третя особа</option>              
                                      <option <?php if($intime_payer_type_id == "4"){ echo "selected='selected'";} ?> value="4">50 на 50</option>                   
                                      <option <?php if($intime_payer_type_id == "5"){ echo "selected='selected'";} ?> value="5">Довільно</option>
                     
                      </select>
            </div>
          </div>


          




           <div class="form-group">
            <label class="col-sm-2 control-label" for="input-cost">Отказ от Упаковки</label>
            <div class="col-sm-10">
                      <select id="intime_cancel_packaging" name="intime_cancel_packaging" class="form-control">
                         <option <?php if($intime_cancel_packaging == "0"){ echo "selected='selected'";} ?> value="0">Да</option>                                  
                         <option <?php if($intime_cancel_packaging == "1"){ echo "selected='selected'";} ?> value="1">Нет</option>
                      </select>
            </div>
          </div>

           <div class="form-group">
            <label class="col-sm-2 control-label" for="input-cost">Наложка по умолчанию</label>
            <div class="col-sm-10">
                      <select id="intime_ched" name="intime_ched" class="form-control">
                         <option <?php if($intime_ched == "1"){ echo "selected='selected'";} ?> value="1">Да</option>                                  
                         <option <?php if($intime_ched == "2"){ echo "selected='selected'";} ?> value="2">Нет</option>
                      </select>
            </div>
          </div>


                  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-cost">Плательшик за наложку</label>
            <div class="col-sm-10">
                      <select id="intime_payer_type_ched" name="intime_payer_type_ched" class="form-control">
                         <option <?php if($intime_payer_type_ched == "1"){ echo "selected='selected'";} ?> value="1">Відправник сек’юрпакета(получатель груза)</option>                                  
                         <option <?php if($intime_payer_type_ched == "2"){ echo "selected='selected'";} ?> value="2">Одержувач сек’юрпакета(Отправитель груза)</option>
                      </select>
            </div>
          </div>

          

           <div class="form-group">
            <label class="col-sm-2 control-label" for="input-cost">Автовозврат(Дней)</label>
            <div class="col-sm-10">
                <input type="text" name="intime_return_day" value="<?php echo $intime_return_day; ?>" placeholder="<?php echo $intime_return_day; ?>" id="input-cost" class="form-control" />
            </div>
          </div>




   




            </div>
            <div class="tab-pane" id="tab-sender">



                  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-cost"><?php echo $entry_sender_obl; ?></label>
            <div class="col-sm-10">
                      <select id="intime_area" name="intime_area" class="form-control">
                        <?php foreach($AREA as $AREA_row) { ?>
                             <option <?php if($AREA_row->id == $intime_area) {echo "selected='selected'";}?> value="<?php echo $AREA_row->id; ?>"><?php echo $AREA_row->area_name_ru; ?></option>
                        <?php } ?>
                      </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-cost"><?php echo $entry_sender_LOCALITY; ?></label>
            <div class="col-sm-10">
                      <select id="intime_LOCALITY" name="intime_LOCALITY" class="form-control">
                        <?php foreach($LOCALITY as $LOCALITY_row) { ?>
                             <option <?php if($LOCALITY_row->id == $intime_LOCALITY) {echo "selected='selected'";}?> value="<?php echo $LOCALITY_row->id; ?>"><?php echo $LOCALITY_row->locality_name_ru; ?></option>
                        <?php } ?>
                      </select>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-cost"><?php echo $entry_sender_BRANCH; ?></label>
            <div class="col-sm-10">
                      <select id="intime_BRANCH" name="intime_BRANCH" class="form-control">
                        <?php foreach($BRANCH as $BRANCH_row) { ?>
                             <option <?php if($BRANCH_row->id == $intime_BRANCH) {echo "selected='selected'";}?> value="<?php echo $BRANCH_row->id; ?>"><?php echo $BRANCH_row->branch_name_ru; ?></option>
                        <?php } ?>
                      </select>
            </div>
          </div>




            </div>
        </div>

   
        
        </form>
      </div>
    </div>
  </div>
</div>

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
<script type="text/javascript">

  $(document).ready(function(){









       $('select').select2();

       $('#intime_area').on('select2:select', function (e) {
           $("#preloader").show();
            var data = e.params.data;
            
            $.get( "/admin/index.php?route=extension/shipping/intime/area&token=<?php echo $_GET['token']; ?>", { 'area': data.id},function(data){
                  aop = JSON.parse(data);
                     if(aop.length > 1){




                  $("#intime_LOCALITY").html(" ");
                  $("#intime_BRANCH").html(" ");
                  $('#intime_BRANCH').select2();
                  aop.forEach(function(items,i){
                    $("#intime_LOCALITY").append('<option value="'+items.id+'">'+items.locality_name_ru+'</option>');
                    if((aop.length-1) == i){
                        $("#preloader").hide();
                    }
                  });
                  $('#intime_LOCALITY').select2();
                         }else{

                         $("#intime_BRANCH").html("'<option value=''>--- Нет отделений---</option>'");
                         $("#intime_BRANCH").attr('disabled','disabled');
                        
                      }

                });
        });

        $('#intime_LOCALITY').on('select2:select', function (e) {
              $("#preloader").show();
              area = $("#intime_area option:selected").val();
              var data = e.params.data;
              $.get( "/admin/index.php?route=extension/shipping/intime/branch&token=<?php echo $_GET['token']; ?>", { 'intime_area': area,'intime_LOCALITY':data.id},function(data){
                aop = JSON.parse(data);


                

                if(aop.length > 1){
                  $("#intime_BRANCH").html(" ");
                  $("#intime_BRANCH").removeAttr('disabled');
                    aop.forEach(function(items,i){

                      if(items.company_id=="1"){
                          $("#intime_BRANCH").append('<option value="'+items.id+'">'+items.branch_name_ru+'('+items.address_ru+')'+'</option>');
                      }


                        if((aop.length-1) == i){
                        $("#preloader").hide();
                    }
                    });
                }else{
                  $("#intime_BRANCH").html("'<option value=''>--- Нет отделений---</option>'");
                  $("#intime_BRANCH").attr('disabled','disabled');
                }
                
              
                $("#preloader").hide();
                  $('#intime_BRANCH').select2();
              });
        });
  }); 
</script>
<?php echo $footer; ?> 
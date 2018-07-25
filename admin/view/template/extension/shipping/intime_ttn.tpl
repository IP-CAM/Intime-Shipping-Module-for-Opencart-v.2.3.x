

<?php echo $header; ?><?php echo $column_left; ?>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/jquery.dataTables.css">
  
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.js"></script>
<script type="text/javascript">
  $(document).ready( function () {
    $('#table_id').DataTable( {
        "language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Russian.json"
        }
    } );
} );
</script>
<div id="content" class="container">
  <div class="page-header">
    <div class="container-fluid ">
      <div class="pull-right">
        <button type="submit" form="form-flat" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-print"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> Список ТТН</h3>
      </div>
      <div class="panel-body">
        <form method="GET" target="_blank" action="/admin/index.php" enctype="multipart/form-data" id="form-flat" class="form-horizontal">

             <input type="hidden" name="route" value="extension/shipping/intime/print_ttn">
             <input type="hidden" name="token" value="<?php echo $_GET['token'];?>">


                <table id="table_id" class="table table-bordered table-hover">
              <thead>
                <td><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);"></td>
                 <?php foreach($info as $info2){  ?>

                  <?php foreach($info2 as $key1=>$info23){  ?>

                            <td><?php echo $key1; ?></td>

                  <?php } ?>




                <?php break; } ?>
              </thead>

              <tbody>

                         <?php foreach($info as $info2){
                         $color2 = "";


                                   if($info2['Статус']=="Прийнято у відділенні, готується до відправки"

                                   or $info2['Статус']=="Рухається по маршруту доставки"

                                   ){

                                   $color2 = "background:#ffffca;";

                                 }

                                   if($info2['Статус']=="Створено електронну заявку"){
                                   if(@$color[explode("</br>",$info2['№'])[0]]){

                                      $color2 = "background:#d4fdca;color:".$color[explode("</br>",$info2['№'])[0]].";";
                                   }
                                 }

                                 if($info2['Статус']=="Доставлено у відділення, готове до видачі"){

                                   $color2 = "background:#ffdfe0;";

                                 }
                                 if($info2['Статус']=="Видано одержувачу"){

                                   $color2 = "background:#d4fdca;color:".$color[$info2['decl_num']].";";

                                 }





                          ?>

                         


                        <tr style="<?php echo $color2; ?>">

                        

                          <td><input type="checkbox" name="selected[]" value="<?php echo explode("</br>",$info2['№'])[0]; ?>"></td>
                          <?php foreach($info2 as $key20 => $info23){ ?>

                            <td><?php 

                              if($key20=='date_creation' OR $key20=='date_delivery'){

                              if($key20=='date_creation'){
                              echo explode("T",$info23)[0]."<br>".str_replace(".000+03:00","",explode("T",$info23)[1]); 
                              }else{

                                  echo explode("T",$info23)[0];

                                }

                               

                            }else{
                                                          echo $info23; 


                          }


                              ?></td>



                          <?php } ?>
                          </tr>

                    <?php } ?>


              </tbody>
            </table>

   
        
        </form>
     
    </div>
  </div>
</div>
<style type="text/css">
  .select2-container {
    min-width: 300px;
  }
</style>
<script type="text/javascript">

  $(document).ready(function(){
       $('select').select2();

           $("#intime_area").change(function(){
     area = $(this).find("option:selected").val();
      $.get( "/admin/index.php?route=extension/shipping/intime/area&token=<?php echo $_GET['token']; ?>", { 'area': area},function(data){
        aop = JSON.parse(data);
        $("#intime_LOCALITY").html(" ");
        aop.forEach(function(items){
          $("#intime_LOCALITY").append('<option value="'+items.id+'">'+items.locality_name_ru+'</option>');
        });
      });


        $("#intime_LOCALITY").change(function(){
             area = $("#intime_area option:selected").val();
             LOCALITY = $("#intime_LOCALITY option:selected").val();
              $.get( "/admin/index.php?route=extension/shipping/intime/branch&token=<?php echo $_GET['token']; ?>", { 'intime_area': area,'intime_LOCALITY':LOCALITY},function(data){
                aop = JSON.parse(data);
                $("#intime_BRANCH").html(" ");
                aop.forEach(function(items){
                  if(items.company_id=="1"){
                      $("#intime_BRANCH").append('<option value="'+items.id+'">'+items.branch_name_ru+'('+items.address_ru+')'+'</option>');
                  }
                });
              });
            });


    });
                

  });

 



    
</script>
<?php echo $footer; ?> 
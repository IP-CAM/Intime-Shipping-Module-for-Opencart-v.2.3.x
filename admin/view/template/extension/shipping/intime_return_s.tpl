<?php echo $header; ?>
<?php echo $column_left; ?>

<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right"></div>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
        <div class="panel-body">



          <h1>Декларация Создана: <?php echo $Entry_declaration_ins_upd['decl_id']; ?></h1>

          <b> Примерная дата доставки: <?php echo $Entry_declaration_ins_upd['date_delivery']; ?></b><br>
          <b> Стоимость: <?php echo $Entry_declaration_ins_upd['amount']; ?> грн</b>

          






		</div>








</div>





<?php echo $footer; ?>

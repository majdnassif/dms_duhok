<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Ozcan_<?= $OrderDetails['order_number'] ?></title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url('assets/') ?>plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url('assets/') ?>dist/css/adminlte.min.css">
  <script src="<?=base_url('assets/');?>plugins/jquery/jquery.min.js"></script>
  
<script src="<?=base_url('assets/');?>plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="<?=base_url('assets/');?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <style>
    body {
      font-size: 1.3rem;
    }
  </style>
</head>

<body>
  <div class="wrapper">
    <!-- Main content -->
    <section class="invoice">
      <!-- title row -->
      <!-- <div class="row">
      <div class="col-12">
        <h2 class="page-header">
          <img src="<?php echo sys_info()['logo'] ?>" width="150" alt=""> Ozcan
          <small class="float-right"><?= $this->Dictionary->GetKeyword('Print Date') ?>: <?= date('d/m/Y') ?></small>
        </h2>
      </div>
    </div> -->
      <!-- info row -->
      <div class="row  invoice-info">
        <div class="col-md-12 mb-1">
          <h4 class="text-center"><?= $this->Dictionary->GetKeyword('order_information') ?></h4>
          <hr>
        </div>
        <div class="form-group text-center col-md-3">
          <h2 class="page-header">
            <img src="<?php echo sys_info()['logo'] ?>" width="150" alt="">

          </h2>
        </div>
        <!-- order_number -->
        <div class="form-group col-md-3">
          <label class="text-bold"><?= $this->Dictionary->GetKeyword('number') ?> :</label> <?= $OrderDetails['order_number'] ?><br>

          <label class="text-bold"><?= $this->Dictionary->GetKeyword('order_date') ?> :</label> <?= date('d/m/Y', strtotime($OrderDetails['order_date'])) ?><br>

          <label class="text-bold"><?= $this->Dictionary->GetKeyword('Print Date') ?> :</label> <?= date('d/m/Y') ?>
        </div>
        <!-- order_date -->

        <!-- barcode -->
        <div class="form-group col-md-3 text-center m-0" >
          
          <svg id="barcode" style="width: 178px; height: 100px;"></svg>
          
        </div>
         <div class="form-group col-md-3 text-center m-0" id="QRCODE">

        </div>
      </div>
      <div class="row  invoice-info">
        <div class="col-md-12 mb-1">
          <h4 class="text-center"><?= $this->Dictionary->GetKeyword('client_information') ?></h4>
          <hr>
        </div>
        <div class="form-group col-md-4">
          <label class="text-bold"><?= $this->Dictionary->GetKeyword('code') ?> :</label> <?= $OrderDetails['client_code'] ?>
        </div>
        <!-- client_name -->
        <div class="form-group col-md-4">
          <label class="text-bold"><?= $this->Dictionary->GetKeyword('name') ?> :</label> <?= $OrderDetails['client_name'] ?>
        </div>
        <!-- client_profile -->
        <div class="form-group col-md-4">
          <label class="text-bold"><?= $this->Dictionary->GetKeyword('profile') ?> :</label> <?= $OrderDetails['client_profile'] ?>
        </div>
        <!-- client_mobile_1 -->
        <div class="form-group col-md-4">
          <label class="text-bold"><?= $this->Dictionary->GetKeyword('mobile_1') ?> :</label> <?= $OrderDetails['client_mobile_1'] ?>
        </div>
        <!-- client_mobile_2 -->
        <div class="form-group col-md-4">
          <label class="text-bold"><?= $this->Dictionary->GetKeyword('mobile_2') ?> :</label> <?= $OrderDetails['client_mobile_2'] ?>
        </div>
        <!-- region_name_en -->
        <div class="form-group col-md-4">
          <label class="text-bold"><?= $this->Dictionary->GetKeyword('region') ?> :</label> <?= $OrderDetails['region_name_en'] ?>
        </div>
        <!-- client_address_1 -->
        <div class="form-group col-md-4">
          <label class="text-bold"><?= $this->Dictionary->GetKeyword('address_1') ?> :</label> <?= $OrderDetails['client_address_1'] ?>
        </div>
        <!-- client_address_2 -->
        <div class="form-group col-md-4">
          <label class="text-bold"><?= $this->Dictionary->GetKeyword('address_2') ?> :</label> <?= $OrderDetails['client_address_2'] ?>
        </div>
        <!-- platform_name_en -->
        <div class="form-group col-md-4">
          <label class="text-bold"><?= $this->Dictionary->GetKeyword('platform') ?> :</label> <?= $OrderDetails['platform_name_en'] ?>
        </div>
        <!-- client_comments -->
        <div class="form-group col-md-4">
          <label class="text-bold"><?= $this->Dictionary->GetKeyword('comments') ?> :</label> <?= $OrderDetails['client_comments'] ?>
        </div>
      </div>
      <!-- /.row -->
      <!-- Table row -->
      <div class="row">
        <div class="col-12">
          <h4 class="text-center"><?= $this->Dictionary->GetKeyword('Items') ?></h4>
        </div>
        <div class="col-12 table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th><?= $this->Dictionary->GetKeyword('Description') ?> </th>
                <th><?= $this->Dictionary->GetKeyword('qty') ?> </th>
                <th><?= $this->Dictionary->GetKeyword('Subtotal') ?> </th>
                <th><?= $this->Dictionary->GetKeyword('total') ?> </th>
              </tr>
            </thead>
            <tbody>
              <?php $i = 1;
              foreach ($OrderItems as $item) { ?>
                <tr>
                  <td><?= $i ?></td>
                  <td><?= $item['item_description'] ?></td>
                  <td><?= $item['item_qty'] ?></td>
                  <td><?= CURRENCY($item['item_price']) ?></td>
                  <th><?= CURRENCY($item['item_qty'] * $item['item_price']) ?></th>
                </tr>
              <?php $i++;
              } ?>
            </tbody>
          </table>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <div class="row">
        <!-- accepted payments column -->
        <div class="col-6">
          <!-- <p class="lead">Payment Methods:</p>
        <img src="../../dist/img/credit/visa.png" alt="Visa">
        <img src="../../dist/img/credit/mastercard.png" alt="Mastercard">
        <img src="../../dist/img/credit/american-express.png" alt="American Express">
        <img src="../../dist/img/credit/paypal2.png" alt="Paypal">

        <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
          Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem plugg dopplr
          jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
        </p> -->
        </div>
        <!-- /.col -->
        <div class="col-6">
          <div class="table-responsive">
            <table class="table">
              <tr>
                <th style="width:50%"><?= $this->Dictionary->GetKeyword('Subtotal') ?>:</th>
                <th><?= CURRENCY($OrderDetails['order_amount']) ?></th>
              </tr>
              <?php if ($OrderDetails['region_shipment_fee']) : ?>
                <tr>
                  <th><?= $this->Dictionary->GetKeyword('Shipping') ?>:</th>
                  <th><?= CURRENCY(5000) ?></th>
                </tr>
              <?php endif; ?>
              <tr>
                <th><?= $this->Dictionary->GetKeyword('Total') ?>:</th>
                <th><?= CURRENCY($OrderDetails['order_amount'] + $OrderDetails['region_shipment_fee']) ?></th>
              </tr>
            </table>
          </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- ./wrapper -->
  <!-- Page specific script -->
</body>
<script src="<?= base_url() ?>/assets/dist/js/JsBarcode.all.min.js"></script>
<script src="<?= base_url() ?>/assets/dist/js/qrcode.min.js"></script>

</html>
<script>
  JsBarcode("#barcode", "<?= $OrderDetails['order_number'] ?>", {
    height: 60
  });
  var qrcode;
  function text() {
    //document.getElementById('REMOVE_QRCODE').style.display = 'none';
    if(qrcode){
      qrcode.clear();
    }
    qrcode = new QRCode("QRCODE", {
      text: "<?= base_url('Orders/ChangeOrdersStatus/'.$OrderDetails['order_number']) ?>",
      //text: "<?= $OrderDetails['order_number'] ?>",
      width: 180,
      height: 180,
      colorDark: "#000000",
      colorLight: "#ffffff",
      correctLevel: QRCode.CorrectLevel.H
    });
   /*  $("#QRCODE").append("<div class='text-center'><h5><?= $OrderDetails['order_number'] ?></h5></div>"); */
    $("#QRCODE").find('img').css('margin', 'auto');
    /* new QRCode(document.getElementById("QRCODE"), "<?= base_url('Orders/ChangeOrdersStatus/'.$OrderDetails['order_number']) ?>"); */
  }
</script>
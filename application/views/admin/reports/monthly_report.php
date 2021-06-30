<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title>Invoice</title>
  <link rel="stylesheet" href="style.css">
  <link rel="license" href="http://www.opensource.org/licenses/mit-license/">
  <script src="script.js"></script>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <meta charset="utf-8">
  <title>CCML</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR); ?>/css/cloud-admin.css" media="screen,print" />
  <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR); ?>/css/themes/default.css" media="screen,print" id="skin-switcher" />
  <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR); ?>/css/responsive.css" media="screen,print" />
  <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR); ?>/css/custom.css" media="screen,print" />


  <style>
    body {
      background: rgb(204, 204, 204);
    }

    page {
      background: white;
      display: block;
      margin: 0 auto;
      margin-bottom: 0.5cm;
      box-shadow: 0 0 0.5cm rgba(0, 0, 0, 0.5);
    }

    page[size="A4"] {
      width: 100%;
      /* height: 29.7cm;  */
      height: auto;
    }

    page[size="A4"][layout="landscape"] {
      width: 29.7cm;
      height: 21cm;
    }

    page[size="A3"] {
      width: 29.7cm;
      height: 42cm;
    }

    page[size="A3"][layout="landscape"] {
      width: 42cm;
      height: 29.7cm;
    }

    page[size="A5"] {
      width: 14.8cm;
      height: 21cm;
    }

    page[size="A5"][layout="landscape"] {
      width: 21cm;
      height: 14.8cm;
    }

    @media print {

      body,
      page {
        margin: 0;
        box-shadow: 0;
        color: black;
      }

    }


    .table1>thead>tr>th,
    .table1>tbody>tr>th,
    .table1>tfoot>tr>th,
    .table1>thead>tr>td,
    .table1>tbody>tr>td,
    .table1>tfoot>tr>td {
      border: 1px solid black;
      text-align: center;
    }
  </style>
</head>

<body>
  <page size='A4'>
    <div style="padding: 5px;  padding-left:20px; padding-right:20px; " contenteditable="true">
      <h3 style="text-align: center;"> Alkhidmat Diagnostic Center Chitral </h3>
      <h4 style="text-align: center;">Monthly Report ( Date: <?php echo date("d F, Y ", time()) ?>)</h4>
      <div style="overflow-x:auto;">
        <table class="table1" style="font-size: 9px !important; width:99%; border-collapse: collapse !important; ">

          <tr>
            <th></th>
            <th colspan="5">LAB</th>
            <th colspan="5">ECG</th>
            <th colspan="5">X-RAY</th>
            <th colspan="5">ULTRASOUND</th>
            <th colspan="5">Dr. Naila</th>
            <th colspan="5">Dr. Shabana</th>
            <th colspan="5">US-Doppler (Dr.Shabana)</th>
            <th colspan="4">Total</th>
          </tr>
          <tr>
            <th>Date</th>
            <td>Total</td>
            <td>Canc</td>
            <td>Conf</td>
            <td>Dis</td>
            <td>Total</td>

            <td>Total</td>
            <td>Canc</td>
            <td>Conf</td>
            <td>Dis</td>
            <td>Total</td>

            <td>Total</td>
            <td>Canc</td>
            <td>Conf</td>
            <td>Dis</td>
            <td>Total</td>

            <td>Total</td>
            <td>Canc</td>
            <td>Conf</td>
            <td>Dis</td>
            <td>Total</td>

            <td>Total</td>
            <td>Canc</td>
            <td>Conf</td>
            <td>Dis</td>
            <td>Total</td>

            <td>Total</td>
            <td>Canc</td>
            <td>Conf</td>
            <td>Dis</td>
            <td>Total</td>

            <td>Total</td>
            <td>Canc</td>
            <td>Conf</td>
            <td>Dis</td>
            <td>Total</td>


            <th>Discount</th>
            <th>Total</th>
            <th>Expense</th>
            <th>Income</th>

          </tr>
          <?php
          $count = 0;
          $total_income = 0;

          foreach ($day_wise_monthly_report as $date => $report) {
            $total_income += @$report->total; ?>
            <tr <?php if ($count == 0) { ?> style="background-color:#9F9 !important; " <?php $count++;
                                                                                      } ?>>
              <td><?php echo $date; ?></td>
              <td><?php echo @$report->lab_cancelled + @$report->lab_count ?></td>
              <td><?php echo @$report->lab_cancelled ?></td>
              <td><?php echo @$report->lab_count ?></td>
              <td><?php echo @$report->lab_discount_count ?>-<?php echo @$report->lab_discount ?></td>
              <td><?php echo @$report->lab ?></td>


              <td><?php echo @$report->ecg_cancelled + @$report->ecg_count ?></td>
              <td><?php echo @$report->ecg_cancelled ?></td>
              <td><?php echo @$report->ecg_count ?></td>
              <td><?php echo @$report->ecg_discount_count ?> - <?php echo @$report->ecg_discount ?></td>
              <td><?php echo @$report->ecg ?></td>

              <td><?php @$report->x_ray_cancelled + @$report->x_ray_count ?></td>
              <td><?php echo @$report->x_ray_cancelled ?></td>
              <td><?php echo @$report->x_ray_count ?></td>
              <td><?php echo @$report->x_ray_discount_count ?> - <?php echo @$report->x_ray_discount ?></td>
              <td><?php echo @$report->x_ray ?></td>


              <td><?php echo @$report->ultrasound_cancelled + @$report->ultrasound_count ?></td>
              <td><?php echo @$report->ultrasound_cancelled ?></td>
              <td><?php echo @$report->ultrasound_count ?></td>
              <td><?php echo @$report->ultrasound_discount_count ?> - <?php echo @$report->ultrasound_discount ?></td>
              <td><?php echo @$report->ultrasound ?></td>



              <td><?php echo @$report->dr_naila_cancelled + @$report->dr_naila_count ?></td>
              <td><?php echo @$report->dr_naila_cancelled ?></td>
              <td><?php echo @$report->dr_naila_count ?></td>
              <td><?php echo @$report->dr_naila_discount_count ?> - <?php echo @$report->dr_naila_discount ?></td>
              <td><?php echo @$report->dr_naila ?></td>



              <td><?php echo @$report->dr_shabana_cancelled + @$report->dr_shabana_count ?></td>
              <td><?php echo @$report->dr_shabana_cancelled ?></td>
              <td><?php echo @$report->dr_shabana_count ?></td>
              <td><?php echo @$report->dr_shabana_discount_count ?> - <?php echo @$report->dr_shabana_discount ?></td>
              <td><?php echo @$report->dr_shabana ?></td>



              <td><?php echo @$report->dr_shabana_us_doppler_cancelled + @$report->dr_shabana_us_doppler_count ?></td>
              <td><?php echo @$report->dr_shabana_us_doppler_cancelled ?></td>
              <td><?php echo @$report->dr_shabana_us_doppler_count ?></td>
              <td><?php echo @$report->dr_shabana_us_doppler_discount_count ?> - <?php echo @$report->dr_shabana_us_doppler_discount ?></td>
              <td><?php echo @$report->dr_shabana_us_doppler ?></td>



              <td><?php echo @$report->discount_count; ?> - <?php echo @$report->discount; ?></td>
              <td><?php echo @$report->total; ?></td>
              <td><?php echo @$report->expense; ?></td>
              <td><?php echo @($report->total - $report->expense); ?></td>



            </tr>
          <?php } ?>
        </table>
      </div>






      <br />

      <?php

      $query = "SELECT
                  `roles`.`role_title`,
                  `users`.`user_title`  
              FROM `roles`,
              `users` 
              WHERE `roles`.`role_id` = `users`.`role_id`
              AND `users`.`user_id`='" . $this->session->userdata('user_id') . "'";
      $user_data = $this->db->query($query)->result()[0];
      ?> </p>

      <p class="divFooter" style="text-align: right;"><b><?php echo $user_data->user_title; ?> <?php echo $user_data->role_title; ?></b>
        <br />Alkhidmat Diagnostic Center Chitral City <br />
        <strong>Printed at: <?php echo date("d, F, Y h:i:s A", time()); ?></strong>
      </p>


    </div>

  </page>
</body>



</html>


  <?php if (isset($staff)): ?>
    <h3 class="yes_info">
      Calculate Salary for <b><?php echo CHtml::encode($staff->user_full_name); ?></b>
    </h3>
  <?php endif; ?>

<!---->
  <div id="form">
<!--    --><?php //$form=$this->beginWidget('CActiveForm', array(
//      'id'=>'calculate-form-calculate-form',
//      'enableAjaxValidation'=>false,
//     // 'type' => 'horizontal',
//    )); ?>
    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
      'id'=>'contract-form',
      'type'=>'horizontal',
      'enableAjaxValidation'=>false,
    )); ?>

      <div class="control-group">
        <?php echo $form->labelEx($model,'namtinh'); ?>
        <div class="controls">
          <div class="namtinh">
            <?php echo CHtml::dropDownList('namtinh', '2012', array(
              '2009' => 'Before May 01-2010',
              '2010' => 'Before May 01-2011',
              '2011' => 'Before Aug 01-2011',
              'end2011' => 'Before Dec 31-2011',
              '2012' => '2012, 2013',
              '2014' => 'From 2014',
            )); ?>
          </div>
        </div>
      </div>



      <div class="control-group">
        <?php echo $form->labelEx($model,'thunhap_vnd'); ?>
        <div class="controls">
          <?php echo $form->textField($model,'thunhap_vnd', array('size'=>14)); ?> VND
        </div>
      </div>

      <div class="control-group">
        <?php echo $form->labelEx($model,'thunhap_usd'); ?>
        <div class="controls">
          <?php echo $form->textField($model,'thunhap_usd', array('size'=>14)); ?> USD
        </div>
      </div>

      <div class="control-group">
        <?php echo $form->labelEx($model,'tigia'); ?>
        <div class="controls">
          <?php echo $form->textField($model,'tigia', array(  'size' => 3,)); ?> VND
        </div>

      </div>

      <div class="control-group">
        <?php echo $form->labelEx($model,'luong_toi_thieu'); ?>
        <div class="controls">
          <div id="CalculateForm_luong_toi_thieu"></div>
        </div>
      </div>

      <div class="control-group">
        <?php echo $form->labelEx($model,'bh_xh'); ?>
        <div class="controls">
          <?php echo $form->textField($model,'bh_xh', array('size' => 1)); ?><i class="help_info"> %</i>
        </div>
      </div>

      <div class="control-group">
        <?php echo $form->labelEx($model,'bh_yte'); ?>
        <div class="controls">
          <?php echo $form->textField($model,'bh_yte', array('size' => 1)); ?><i class="help_info"> %</i>
        </div>
        <?php echo $form->error($model,'bh_yte'); ?>
      </div>

      <div class="control-group">
        <?php echo $form->labelEx($model,'bh_thatnghiep'); ?>
        <div class="controls">
          <?php echo $form->textField($model,'bh_thatnghiep', array('size' => 1)); ?><i class="help_info"> %</i>
        </div>
        <?php echo $form->error($model,'bh_thatnghiep'); ?>
      </div>

      <div class="control-group">
        <?php echo $form->labelEx($model,'songuoi_phuthuoc'); ?>
        <div class="controls">
          <?php echo $form->textField($model,'songuoi_phuthuoc', array('size' => 1)); ?>
        </div>
        <?php echo $form->error($model,'songuoi_phuthuoc'); ?>
      </div>


      <div class="row buttons">
        <?php if (isset($staff)): ?>
          <?php echo CHtml::hiddenField('calculateWhat', '', array('id'=>'caculateWhat')); ?>
          <?php echo CHtml::hiddenField('employeeName', $staff->user_full_name, array('id'=>'employeeName')); ?>
          <?php echo CHtml::button('Gross to Net', array('id'=>'btnGross', 'onclick'=>'$("#btnSave").show(); $("#caculateWhat").val("gross")')); ?>
          <?php echo CHtml::button('Net to Gross', array('id'=>'btnNet', 'onclick'=>'$("#btnSave").show(); $("#caculateWhat").val("net")')); ?>
          <?php echo CHtml::submitButton('Save', array('id'=>'btnSave', 'style'=>'display:none')); ?>
        <?php else: ?>
          <?php echo CHtml::button('Gross to Net', array('id'=>'btnGross')); ?>
          <?php echo CHtml::button('Net to Gross', array('id'=>'btnNet')); ?>
        <?php endif; ?>
      </div>

    <?php $this->endWidget(); ?>
  </div>


  <div id="result" style="display:none; position: absolute; width: 700px; margin-top: -355px; margin-left: 430px; font-size: 12px;">
    <p id="salary" style="color:red"></p>

    <div style="margin-top: 15px;">
      <h2 style="font-size: 14px"><b>Details of Salary (VND)</b></h2>
      <table>
        <tbody><tr style="background-color: #EDEDED;">
          <th><b>GROSS</b></th>
          <td id="gross"></td>
        </tr>
        <tr>
          <th>Social Insurance (<span id="social_num"></span><i class="help_info"> %</i>)</th>
          <td id="social_ins"></td>
        </tr>
        <tr>
          <th>Medical Insurance (<span id="medical_num"></span><i class="help_info"> %</i>)</th>
          <td id="medical_ins"></td>
        </tr>
        <tr>
          <th>Unemployment Insurance (<span id="unemployment_num"></span><i class="help_info"> %</i>)</th>
          <td id="unemployment_ins"></td>
        </tr>
        <tr style="background-color: #EDEDED;">
          <th>Salary before Tax</th>
          <td id="salary_before_tax"></td>
        </tr>
        <tr>
          <th>Family allowances themselves</th>
          <td id="family_allow">- 9,000,000</td>
        </tr>
        <tr>
          <th>Family allowances dependent</th>
          <td id="family_depen"></td>
        </tr>
        <tr style="background-color: #EDEDED;">
          <th>Salary on Tax Duty</th>
          <td id="salary_tax"></td>
        </tr>
        <tr>
          <th>Personal Income Tax (*)</th>
          <td id="personal_tax"></td>
        </tr>
        <tr style="background-color: #EDEDED;">
          <th>
            <b>NET</b><br>
            (Salary before Tax - Personal Income Tax)
          </th>
          <td id="net"></td>
        </tr>
        </tbody></table>
    </div>

    <div style="position: absolute; margin-left: 360px; margin-top: -330px;">
      <h2 style="font-size: 14px"><b>(*) Details of Personal Income Tax (VND)</b></h2>
      <table>
        <tbody><tr style="background-color: #EDEDED;">
          <th>The level of Taxable (VND)</th>
          <th>Tax</th>
          <th>Payment</th>
        </tr>
        <tr><td>To 5 million</td><td>5%</td><td id="chiuthue_1">0</td></tr>
        <tr><td>Above 5 to 10 million</td><td>10%</td><td id="chiuthue_2">0</td></tr>
        <tr><td>Above 10 to 18 million</td><td>15%</td><td id="chiuthue_3">0</td></tr>
        <tr><td>Above 18 to 32 million</td><td>20%</td><td id="chiuthue_4">0</td></tr>
        <tr><td>Above 32 to 52 million</td><td>25%</td><td id="chiuthue_5">0</td></tr>
        <tr><td>Above 52 to 80 million</td><td>30%</td><td id="chiuthue_6">0</td></tr>
        <tr><td>Above 80 million</td><td>35%</td><td id="chiuthue_7">0</td></tr>
        </tbody></table>
    </div>
  </div>

  <style>
    table {
      border-collapse:collapse;
      /*width: 100% !important;*/
      height: 70% !important;
    }
    table, td, th {
      border:1px solid black;
      padding: -10px;
    }
    td {
      text-align:right;
    }
    table td, table th {
      padding: 2px 3px !important;
      text-align: left;
    }
  </style>

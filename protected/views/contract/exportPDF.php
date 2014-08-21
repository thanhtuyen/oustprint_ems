
<style type="text/css">
  h4{
    font-weight: bold;
  }
  h1{
    font-size: 20px;
    margin-left: 350px;
  }
  table{
    margin: auto;
    border: 0px solid gray;
    width: 800px;
  }
  table td,table th{
    border:0px solid gray;
    border-collapse: collapse;
    padding: 5px;
  }
  table th {
    width: 50px;
    font-size: 15px;
    font-family: Arial;
    text-align: left;
  }
  table td {
    width: 500px;;
    font-size: 15px;
    font-family: Arial;
  }
  .wrapper{
    margin-left: 100px;
  }
</style>

<page>

  <div>
    No: <?php echo $model->id;?>/HDLD<br/>
    <img src="http://outsprin.sakura.ne.jp/wp/wp-content/uploads/2013/03/outsprin_logos.gif" />
    <div style="margin-left: 350px">
      SOCIALIST REPUBLIC OF VIETNAM<br/>
      Independence- Freedom- Happiness<br/>
      ---------------------------------------------------------<br/>
    </div>
    <h1>
      CONTRACT STAFF
    </h1>
  </div>
  <br />
  <div class="wrapper">
    We, from one side Mrs: ...................................................                  Nationality: Vietnam<br/>
    Title: Chairman of the Board of Management<br/>
    On behalf of the OUTSPRINT Joint Stock Company<br/>
    Tel: 08 33333333333<br/>
    Address: 7/6A, Nguyen Trai Street, Ben Thanh Ward, Quan 1 District, Ho Chi Minh City.<br/>
    And from the other side <?php echo $model->employee->user->fullname;?> Nationality: Vietnam<br/>
    Date of birth: <?php echo date('M-d-Y', $model->employee->user->dob);?><br/>
    Job: <?php echo $model->employee->background;?><br/>
    Temporary residence address: <?php echo $model->employee->homeaddress;?><br/>
    Agreed to sign this labour contract and engage to satisfy the following provisions:<br/>

    <h4>Article 1: Duration and job of the Contract<br/></h4>
    -Type of the labour contract: <?php echo $model->type; ?><br/>
    -Commencing on: <?php if($model->probation_start_date)
      {
        echo date('M-d-Y', $model->probation_start_date);
      } else {
        echo date('M-d-Y', $model->contract_start_date);
      } ?><br/>
    <?php if($model->probation_start_date){
      echo "-Probationary Period:".date('M-d-Y', $model->probation_start_date)."<br/>";
     }elseif($model->contract_start_date){
      echo "-Contract Period:".date('M-d-Y', $model->probation_start_date)."<br/>";
    }
    ?>
    -Location of work: OUTSPRIN Joint Stock Company<br/>
    -Professional job:<?php echo $model->employee->background;?><br/>
    -Job discription: to execute and fullfill all the works as requested by the company leaders.<br/>
    <h4>Article 2: Working condition<br/></h4>
    -Working hour: In the morning from 7:30 am to 11:30 am; In the afternoon from 12:30   pm to 4 pm<br/>
    - To be provided equipments/tools depending on your concrete jobs.<br/>

    <h4>Article 3: Obligations and rights of the Employee<br/></h4>
    <h4>1. Rights</h4><br/>
    - Transportation means: Self-sufficed<br/>
    - Main basic salary: 2.500.000 dong. Salary during Probationary Period: entitle to receive 85% of the basic salary (including salary and other attached benefits).<br/>
    -To be paid on the 10th day of per month<br/>
    -Bonus: to be paid in accordance with the dedication of the employee and the outcome of the company’s business.<br/>
    -Salary increment: according to the business result and the yearly experience of the employee.<br/>
    -To be equipped with labor safety facilities as regulated by the company provisions.<br/>
    -Time of rest:<br/>
    + Weekly resting time: to rest on Saturday moring and Sunday, eventhough, if the company is under the urgent request of increasing working productivity, the employee still have to work on resting days.<br/>
    + The employee is entitled to annual leave of 12 days per year and on national holidays under the provisions of the State.<br/>
    + If the employee goes on business vacation to execute projects handled by the company, the company will be in charge of preparing accomodation and necessary personal facilties for the employee under the existing provisions.<br/>
    -Social & health insurance: Social and health insurance of the Employee will be paid in accordance with the regulations of the State.<br/>
    <h4>2. Obligations</h4><br/>
    -To fullfill all the contents as commited and the jobs in the contract<br/>
    -To submit notorized certificate (of the highest intellectual degree as requested for the position) to the company right after the Contract is signed.<br/>
    -To obey all the working regulations, regulations of labor safety, labor disciplines.<br/>
    -To pay the individual income tax as so provided by the State.<br/>
    -Absolutely do not take advantage of the company’s clients for individual benefit (if any)<br/>
    -If for any reasons, the employee wants to terminate the labour contract, the employee shall notice the copany’s leaders at least 15 days in advance.<br/>
    -In cases, when the employee causes damages to the company, the employee will be pay compensation for that. If the damages are too serious, the employee will be subject to legal responsiltities.<br/>
    <h4>Article 4: Rights and obligations of the employer<br/></h4>

    <h4>1.Obligations<br/></h4>
    -Assure job for the employee and fully complete the conditions committed in the Labour contract.<br/>
    -Fully and duly pay the employee all the remuneration and benefits as committed in the Labour contract and the collective labor accord.<br/>

    <h4>2.Rights<br/></h4>
    -To manage the employee to fullfill the job in the contract (including appointment, assigning the employee to another job, temporarily suspending the job).<br/>
    -To temporarily defer, to terminate the labour contract, to discipline the employee under the provisions of the law and labour regulaton issued by the company.<br/>

   <h4>Article 5: Implementation guidance<br/></h4>
    -Any issues which are not regulated by this contract are regulated by the application of the collective labour accord. If there is no collective labour accord, legal provions on labour relations shall be applied.<br/>
    -This Contract is made in 2 copies, 1 copy will be kept by the Employer and 1 copy to be kept by the Employee.<br/>
    -If the two parties sign in contractual appendix, such appendix shall have the same legal value as of contractual terms.<br/>
    -The contract takes effect since the date of signing.<br/>
    <span style="margin-right: 100px; "> Ho Chi Minh <?php echo date('d-m-Y');?>...<br/></span>
    <br/>
    <table>
      <tr>
        <td> Employee<br/>
          (Signed)<br/>
          FULL NAME<br/>
        </td>
        <td style="margin-left: 200px">
          Employer<br/>
          (Signed and Sealed)<br/>
          FULL NAME<br/>
        </td>
      </tr>
    </table>

  </div>
</page>


<style type="text/css">
  h1{
    font-size: 40px;
    text-align: center;
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
    text-align: left;
  }
   table th {
     width: 100px;
   }
  table td {
    width: 500px;;
  }
</style>

<page>

  <div>
    <img src="http://outsprin.sakura.ne.jp/wp/wp-content/uploads/2013/03/outsprin_logos.gif" />
    <h1>
     PROFILE STAFF
    </h1>
  </div>
  <br />

  <table>
    <tr>
      <th>Full Name</th>
      <td><?php echo $model->user->fullname;?></td>
    </tr>
    <tr>
      <th>Birthday</th>
      <td><?php echo date('M-d-Y', $model->user->dob);?></td>
    </tr>
    <tr>
      <th>Email</th>
      <td><?php echo $model->user->email;?></td>
    </tr>
    <tr>
      <th>Job Title</th>
      <td><?php echo $model->job_title;?></td>
    </tr>

    <tr>
      <th>Degree</th>
      <td><?php echo $model->degree;?></td>
    </tr>

    <tr>
      <th>Degree Name</th>
      <td><?php echo $model->degree_name;?></td>
    </tr>

    <tr>
      <th>Background</th>
      <td><?php echo $model->background;?></td>
    </tr>

    <tr>
      <th>Telephone</th>
      <td><?php ($model->telephone)?$telephone = '0'.$model->telephone:"";
              echo $telephone;?></td>
    </tr>

    <tr>
      <th>Mobile</th>
      <td><?php ($model->mobile)?$mobile = '0'.$model->mobile:"";
            echo $mobile;?></td>
    </tr>

    <tr>
      <th>Homeaddress</th>
      <td><?php echo $model->homeaddress;?></td>
    </tr>

    <tr>
      <th>Department</th>
      <td><?php echo $model->department;?></td>
    </tr>

    <tr>
      <th>Personal Email</th>
      <td><?php echo $model->personal_email;?></td>
    </tr>

    <tr>
      <th>Education</th>
      <td><?php echo $model->education;?></td>
    </tr>

    <tr>
      <th>Skill</th>
      <td><?php echo $model->skill;?></td>
    </tr>

    <tr>
      <th>Experience</th>
      <td><?php echo $model->experience;?></td>
    </tr>

    <tr>
      <th>Note</th>
      <td><?php echo $model->notes;?></td>
    </tr>


  </table>
</page>

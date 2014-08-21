

<style>
  .span9{
    width: 100% !important;
  }
  #user{
    border-radius: 15px;
    width: 200px;
    height: 150px;
    background-color:  rgb(67,133,215)  ;
    z-index: -1;
    margin-bottom: 30px;
    padding-top: 2px;
    text-align: center;

  }
  #user-on{
    border-radius: 10px;
    width: 200px;
    height: 150px;
    background-color: rgb(247,247,247) ;
    z-index: 1;
    margin-left:15px;
    opacity:0.75;
    border:2px solid rgb(67,133,215) ;
    margin-top: 15px;
    margin-bottom: 10px;

  }

  #profile{
    border-radius: 15px;
    width: 200px;
    height: 150px;
    background-color:  rgb(67,133,215)  ;
    z-index: -1;
    margin-bottom: 10px;
    text-align: center;
    float:left;
  }
  #profile-on{
    border-radius: 10px;
    width: 200px;
    height: 150px;
    background-color: white ;
    z-index: 1;
    margin-top: 15px;;
    margin-left:15px;
    opacity:0.75;
    border:2px solid rgb(67,133,215) ;
  }

  #department{
    margin-top: 50px;
    margin-left: 50px;
    }
</style>
<div id="department">
  <div id ="wrapper" >
    <div id="user" style="margin-left: 30%">
      <div id="user-on">
        Director</br>
        Daily meeting at the week,<br/>
        talk online with client and <br/>director work here.
      </div>
    </div>
  </div>

  <div id ="wrapper" style="float: left">
    <div id="profile">
      <div id="profile-on">
       Reception<br/>
        Organization to receive or <br/>greet any visitors or clients <br/>and answer telephone calls.
      </div>
    </div>
  </div>

  <div id="wrapper" style="float: left">
    <?php $image = Yii::app()->request->baseUrl.'/images/line.png';
    echo CHtml::image($image);?>

  </div>

  <div id ="wrapper" style="float: left">
    <div id="profile">
      <div id="profile-on">
        Development</br>
        Discussion with client,<br/>then
        design, built project, development<br/>
        test and release product
      </div>
    </div>
  </div>

  <div id="wrapper" style="float: left">
    <?php $image = Yii::app()->request->baseUrl.'/images/line.png';
    echo CHtml::image($image);?>

  </div>

  <div id ="wrapper" style="float: left">
    <div id="profile">
      <div id="profile-on">
        HR</br>
        Management person, recruitment,<br/>
        organization event...
      </div>
    </div>

  </div>

</div>

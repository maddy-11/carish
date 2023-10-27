<style>
  .alertt {
    padding: 0px 20px;
    border: 2px solid #f44336;
    color: #f44336;
    border-radius: 10px;
    width: 100%;
    background-color: #fff;
  }

  /*.closebtn {
  margin-left: 15px;
  color: white;
  font-weight: bold;
  float: right;
  font-size: 22px;
  line-height: 20px;
  cursor: pointer;
  transition: 0.3s;
}
*/
  .main {
    /*display:flex;*/
  }

  .closebtn:hover {
    color: black;
  }

  .cross {
    /*display:block;*/
    font-size: 24px;
    margin-right: 30px;
    margin-top: 0px;
    position: relative;
  }

  .cross:hover {
    cursor: pointer;
  }
</style>
<?php
$vars = Session::all();
foreach ($vars as $key => $value) {
  switch ($key) {
    case 'success':
    case 'error':
    case 'warning':
    case 'info':
?>


      @if($key == 'error')
      <div class="alertt mb-4">

        <div class="main">
          <strong><span class="cross" onclick="this.parentElement.parentElement.parentElement.style.display='none';"><span style="position: absolute;top: 10px;padding-right: 20px;"><i class="fa fa-times" style="font-size: 28px;font-weight: 100;"></i></span></span></strong> <span style="font-size: 24px;"><b>Error</b></span><br>
          <span style="margin-left: 30px;">{!! $value !!}</span>
        </div>
      </div>
      @else
      <div class="alert alert-{{ ($key == 'error') ? 'danger' : $key }} alert-dismissable" id="carnumbererror">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>@if($key == 'error') <h4><i class="icon fa fa-check"></i> Alert!</h4>@endif
        <strong>{{ ucfirst(@$key) }}:</strong> {!! $value !!}
      </div>
      @endif

  <?php
      Session::forget($key);
      break;
    default:
  }
}
if ($errors->any()) { ?>

  <!-- <div class="alert alert-danger alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <h4><i class="icon fa fa-check"></i> Alert!</h4>
    @foreach($errors->all() as $error)
    <p>{{ $error }}</p>
    @endforeach
</div> -->

  <div class="alertt mb-4">

    <div class="main">
      <strong><span class="cross" onclick="this.parentElement.parentElement.parentElement.style.display='none';"><span style="position: absolute;top: 10px;padding-right: 20px;"><i class="fa fa-times" style="font-size: 28px;font-weight: 100;"></i></span></span></strong> <span style="font-size: 24px;"><b>Error</b></span><br>
      <span style="margin-left: 30px;"> @foreach($errors->all() as $error)
        <span>{{ $error }}</span>
        @endforeach</span>
    </div>
  </div>



<?php } ?>
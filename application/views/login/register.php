 <!-- Bootstrap V4.0 CSS -->
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<!-- Custom Fonts -->
<link href="<?php echo base_url();?>assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

 <title>Registration Form</title>
<section>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-8 col-xl-6">
          <div class="row">
            <div class="col text-center">
              <h1>Register</h1>
<!--              <p class="text-h3">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia. </p>-->
            </div>
          </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                        </div>
                        <div class="panel-body">
                            <?php echo $alert;?>
                            <form method="post" class="form-horizontal">
                                <div class="form-group">
                                    <label class="control-label col-md-2">Username <span class="required">*</span></label>
                                    <div class="col-md-10">
                                        <input type="text" name="username" class="form-control" value="<?php echo $data['username'];?>">
                                        <?php echo form_error('username', '<div class="error">', '</div>'); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-2">Password <span class="required">*</span></label>
                                    <div class="col-md-10">
                                        <input type="text" name="password" class="form-control" value="<?php echo $data['password'];?>">
                                        <?php echo form_error('password', '<div class="error">', '</div>'); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-2">Name <span class="required">*</span></label>
                                    <div class="col-md-10">
                                        <input type="text" name="name" class="form-control" value="<?php echo $data['name'];?>">
                                        <?php echo form_error('name', '<div class="error">', '</div>'); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-2">Province <span class="required">*</span></label>
                                    <div class="col-md-10">
                                        <?php echo form_dropdown('province_id', $provinces, $data['province_id'], 'class="form-control"'); ?>
                                        <?php echo form_error('province_id', '<div class="error">', '</div>'); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-2">City <span class="required">*</span></label>
                                    <div class="col-md-10">
                                        <?php echo form_dropdown('city_id', $citys, $data['city_id'], 'class="form-control"'); ?>
                                        <?php echo form_error('city_id', '<div class="error">', '</div>'); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-2">Gender <span class="required">*</span></label>
                                    <div class="col-md-10">
                                        <?php echo form_dropdown('gender', array('0' => 'Male', '1' => 'Female'), $data['gender'], 'class="form-control"'); ?>
                                        <?php echo form_error('gender', '<div class="error">', '</div>'); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-2">Address <span class="required">*</span></label>
                                    <div class="col-md-10">
                                        <input type="text" name="address" class="form-control" value="<?php echo $data['address'];?>">
                                        <?php echo form_error('address', '<div class="error">', '</div>'); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-2">Phone <span class="required">*</span></label>
                                    <div class="col-md-10">
                                        <input type="text" name="phone" class="form-control" value="<?php echo $data['phone'];?>">
                                        <?php echo form_error('phone', '<div class="error">', '</div>'); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-2">Email <span class="required">*</span></label>
                                    <div class="col-md-10">
                                        <input type="text" name="email" class="form-control" value="<?php echo $data['email'];?>">
                                        <?php echo form_error('email', '<div class="error">', '</div>'); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-2">Birthdate <span class="required">*</span></label>
                                    <div class="col-md-10">
                                        <input type="date" name="birthdate" class="form-control" value="<?php echo $data['birthdate'];?>">
                                        <?php echo form_error('birthdate', '<div class="error">', '</div>'); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-2">
                                        <input type="hidden" name="id" value="<?php echo $data['id'];?>">
                                    </div>
                                    <div class="col-md-10">
                                        <input type="submit" name="simpan" class="btn btn-primary" value="Save">
                                            <a href="<?php echo site_url('login');?>" class="btn btn-danger">Login</a>
                                            <a href="<?php echo site_url('login');?>" class="btn btn-primary">Back</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
      </div>
    </div>
  </section>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

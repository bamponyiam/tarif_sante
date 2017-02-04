<?php include("header.php"); ?>
<?php 
	include("sidebar.php"); 
	require_once("classes/Currency.php");
	$currency = Currency::getInstance();
?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><i class="fa fa-plus-square fa-fw"></i> New User</h1>
                </div>
                <form method="post" action="new_user_add_process.php">
                <div class="col-lg-6">
               		<div class="col-lg-6">
                		<div class="form-group">
							<label >Username</label>
							<input type="text" class="form-control" name="username" />
					  	</div>
					</div>
				  	<div class="col-lg-6">
					  	<div class="form-group">
							<label >Password</label>
							<input type="text" class="form-control" name="password" />
					  	</div>
					</div>	 
					<div class="col-lg-6">
					  	<div class="form-group">
							<label >Firstname</label>
							<input type="text" class="form-control" name="firstname" />
						</div>
					</div>
					<div class="col-lg-6">
					  	<div class="form-group">
							<label >Lastname</label>
							<input type="text" class="form-control" name="lastname" />
					  	</div>
					</div>	
					<div class="col-lg-12">
					  	<div class="form-group">
							<label >Email</label>
							<input type="text" class="form-control" name="email" />
					  	</div>
					</div> 
					<div class="col-lg-12">
					  	<div class="form-group">
							<label >Office</label>
							<select class="form-control" name="office">
								<option value="KHM">Cambodia</option>
								<option value="THA">Thailand</option>
								<option value="MMR">Myanmar</option>
								<option value="LAO">Lao</option>
							</select>
							
					  	</div>
					</div> 
				<div class="col-lg-12"> <br /> <input type="submit" value=" Submit " class="btn btn-primary" /></div>
               </div>

                </form>
                
               
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
<?php include("footer.php"); ?>
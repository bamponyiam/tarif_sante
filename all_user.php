<?php 
	include("header.php");
	include("sidebar.php");
	require_once("classes/User.php");
	$user = User::getInstance();
?>


        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><i class="fa fa-user fa-fw"></i> All Users </h1>
                </div>
			</div>
                <div class="row">
                <div class="col-lg-12">
                <div class="panel-body">
                <a href="newuser" class="btn btn-primary" ><i class="fa fa-plus fa-fw"></i> Add new user </a>
                <?php
					$all = $user->getAllUser();
					if(sizeof($all) > 0){ ?>
					
                        <!-- /.panel-heading -->
                        
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        
                                        <th>Login</th>
                                        <th>Fullname</th>
                                        <th>Email</th>
                                        <th>Office</th>
                                        <th>Last login</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   <?php $i = 1;
										 foreach($all as $p){ ?>
										 <tr class="odd">
											<td><?php echo $p['login']?></td>
											<td><?php echo ucfirst($p['firstname']).' '.strtoupper($p['lastname']);?></td>
											<td><?php echo $p['email']?></td>
											<td><?php echo $p['office']?></td>
											<td><?php echo $p['last_login']?></td>
										</tr>
											 
									<?php	$i++; }
									?>
                                    
                                    
                                </tbody>
                            </table>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    

					</div>
						
				<?php } ?>
            
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
<?php include("footer.php"); ?>
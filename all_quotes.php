<?php 
	include("header.php");
	include("sidebar.php");

	require_once("classes/Quotation.php");
	$quotation = Quotation::getInstance();

	require_once("classes/Applicant.php");
	$applicant = Applicant::getInstance();
?>


        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><i class="fa fa-bars fa-fw"></i> Quotations </h1>
                </div>
			</div>
                <div class="row">
                <div class="col-lg-12">
                <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-quotes">
                                <thead>
                                    <tr>
                                        <th width="5%">ID</th>
                                        <th width="10%">Date</th>
                                        <th width="10%">Reference</th>
                                        <th>Insured</th>
                                        <th width="10%">Created By</th>
                                        <th width="10%">Currency</th>
                                        <th width="10%">Type quote</th>
                                        <th width="8%">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
								<?php
									if($u['office'] == 'ALL'){
										$all = $quotation->getAllQuotation();
									}else{
										$all = $quotation->getAllQuotationByOffice($u['office']);
									}
									

									if(sizeof($all) > 0){ ?>

										<!-- /.panel-heading -->

												   <?php
														 foreach($all as $p){ 
														 $insured = $applicant->getApplicantByQuoteIndiv($p['id_quote']);
													?>
														 <tr class="odd">
														 	<td class="text-center"><?php echo $p['id_quote']?></td>
															<td><?php 
															 $day = explode(" ",$p['date_quote']);
															 $day_full = explode("-",$day[0]);
															 
															 echo $day_full[2].'/'.$day_full[1].'/'.$day_full[0].' '.$day[1];
															?></td>
															
															<td><a href="view-quote?id=<?php echo $p['id_quote']; ?>"><?php echo $p['reference'].''.$p['id_quote'];?></a></td>
															<td><?php echo $insured['firstname'].' '.strtoupper($insured['lastname'])?><span style="float:right"><a class="red" href="delete-quote?id=<?php echo $p['id_quote'] ?>" onclick="return confirm('Are you sure to delete this quotation?')"><i class="fa fa-fw fa-remove"></i> Delete</a> &nbsp; | &nbsp; <a href="duplicate?id=<?php echo $p['id_quote'] ?>"><i class="fa fa-clone" aria-hidden="true"></i> Duplicate</a></span></td>
															<td><?php $create = $user->getUserById($p['id_user']); echo $create['firstname']; ?></td>
															<td><?php echo $p['currency']?></td>
															<td class="text-center"><?php echo $p['type_con']?></td>
															<td class="text-center"><?php echo $p['status']?></td>
														</tr>

													<?php	 }
													?>

								<?php } ?>
           					</tbody>
                            </table>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    

					</div>
            
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
<?php include("footer.php"); ?>
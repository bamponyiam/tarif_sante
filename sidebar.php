<div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                            </div>
                            <!-- /input-group -->
                        </li>
                        <li>
                            <a href="index"><i class="fa fa-file-o fa-fw"></i> New Quote </a>
                        </li>
                        <li>
                            <a href="quotes"><i class="fa fa-bars fa-fw"></i> Quotations </a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-building-o fa-fw"></i> Products <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                
                                <li>
                                    <a href="product"> <i class="fa fa-bars fa-fw"></i> Product List</a>
                                </li>
                                <li>
                                    <a href="newproduct"><i class="fa fa-plus-square fa-fw"></i> New Product</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="currency"><i class="fa fa-usd fa-fw"></i> Currency </a>
                        </li>
                        <?php if($_SESSION['login'] == '90001'){?>
                        <li>
                            <a href="users"><i class="fa fa-user fa-fw"></i> User </a>
                        </li>
                        <?php } ?>
                        <?php /*?><li>
                            <a href="#"><i class="fa fa-folder fa-fw"></i> Reports <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="">New Product</a>
                                </li>
                                <li>
                                    <a href="">Product List</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li><?php */?>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
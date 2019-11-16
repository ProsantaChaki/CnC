<?php include('includes/header.php'); ?> 
                    <!--Btn Outer-->
<!--                <div class="btn-outer">
                        <a href="donate.php" class="theme-btn donate-btn btn-style-one"><span class="fa fa-arrow-circle-right"></span>&ensp;donate</a>
                    </div>-->
                    
                    <!--Nav Outer-->
                    <?php include('includes/top_menu.php'); ?> 
                    <!--Nav Outer End-->                   
            	</div>    
            </div>
        </div>    
    </header>
    <!--End Main Header -->    
    <!--Page Title-->
	<?php 
		$project_info = $dbClass->getSingleRow("select title, details, date_format(start_date, '%d %b %Y %h:%s %p') start_date, 
												date_format(end_date, '%d %b %Y %h:%s %p') end_date,
												CASE project_type WHEN 1 THEN 'On Going' WHEN 2 THEN 'Up Coming' WHEN 3 THEN 'Completed' END project_type
												from project
												where title = '".$_GET['project']."'"); 
	?>
    <section class="page-title" style="background-image:url(images/background/6.jpg);">
    	<div class="auto-container">
        	<div class="inner-box">
                <h1>Projects</h1>
                <ul class="bread-crumb">
                	<li><a href="index.php"><span class="fa fa-home"></span></a></li>
                    <li>Projects</li>
                    <li><?php echo $project_info['title'] ?></li>
                </ul>
            </div>
        </div>
    </section>
    <!--End Page Title-->
    
   <!--Project Section-->
    <section class="project-single-section">
    	<div class="auto-container">
        	<!--Project Single-->
			<div class="project-single">
            	<div class="row clearfix">
                    <!--Content Column-->
                    <div class="content-column col-md-4 col-sm-12 col-xs-12">
                        <h2><?php echo $project_info['title'] ?></h2>
                        <div class="text"><?php echo $project_info['details'] ?></div>
                        <ul class="project-info">
                        	<li><span>Start Date :</span><?php echo $project_info['start_date'] ?></li>
                            <li><span>End Date :</span><?php echo $project_info['end_date'] ?></li>
                            <li><span>Status :</span><?php echo $project_info['project_type'] ?></li>
                        </ul>
                        <ul class="social-icon-one">
                        	<li class="share">Share : </li>
                            <li><a href="#"><span class="fa fa-facebook"></span></a></li>
                            <li><a href="#"><span class="fa fa-twitter"></span></a></li>
                            <li><a href="#"><span class="fa fa-google-plus"></span></a></li>
                        </ul>
                    </div>
                    <!--Slider Column-->
                    <div class="slider-column col-md-8 col-sm-12 col-xs-12">
                    	<div class="inner-content">
							<div class="single-item-carousel owl-carousel owl-theme">
							<?php 
								$attach_html = '';
								$attachment_info =  $dbClass->getSingleRow("select attachment from project where title = '".$_GET['project']."'");
								$attachment_array = explode(",",$attachment_info['attachment']);
								for($i=0;$i<count($attachment_array);$i++){
									$attach_html .=
										'<div class="project-slide">
											<img src="admin/document/project_attachment/'.$attachment_array[$i].'" alt="" />
										</div>';
								} 
								if(empty($attachment_info['attachment'])) 
									$attach_html = 
										'<div class="project-slide">
											<img src="images/default.jpg" alt="" />
										</div>';
								echo $attach_html;		
							?>
							</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!--Related Projects-->
            <div class="related-projects">
            	<h2>OTHER PROJECTS</h2>
                <div class="row clearfix">
				<?php 
					$project_html = '';
					$other_project_info = $dbClass->getResultList("select id, title, attachment from project where title != '".$_GET['project']."'"); 
									
					foreach($other_project_info as $row){			
						extract($row);
						$attach_project_html = '';
						$attachment_array = explode(",",$attachment);
						$attach_project_html =	'<img src="../web_project/admin/document/project_attachment/'.$attachment_array[0].'"';						
						if(empty($attachment)) 
							$attach_project_html = 	'<img src="images/default.jpg" alt="" />';
						$project_html .=
						'<div class="default-gallery-item col-md-3 col-sm-6 col-xs-12">
							<div class="inner-box">
								<figure class="image-box">'.$attach_project_html.'</figure>
								<!--Overlay Box-->
								<div class="overlay-box">
									<div class="overlay-inner">
										<div class="content">
											<div class="category">'.$row['title'].'</div>
											<h4><a href="project-details.php?project='.$row['title'].'">'.$row['title'].'</a></h4>
											<a href="project-details.php?project='.$row['title'].'" class="option-btn"><span class="flaticon-cross-2"></span></a>
										</div>
									</div>
								</div>
							</div>
						</div>'; 
					}
					echo $project_html;
				?>
				
                   
                </div>
            </div>
      	</div>
    </section>
    <!--Project Section-->
 <?php include('includes/footer.php'); ?> 
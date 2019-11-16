<?php include('includes/header.php'); ?>

 <!-- Start Main -->
	<main>
		<div class="main-part">
			<!-- 
			<section class="breadcrumb-part" data-stellar-offset-parent="true" data-stellar-background-ratio="0.5" style="background-image: url('images/breadbg1.jpg');">
				<div class="container">
					<div class="breadcrumb-inner">
						<h2>Gallery</h2>
						<a href="index.php">Home</a>
						<span>Gallery</span>
					</div>
				</div>
			</section>
			 -->
			<section class="home-icon">
				<div class="icon-default">
					<img src="images/scroll-arrow.png" alt="">
				</div>
				<div class="container">
					<div class="gallery-royal">
						<div class="galleryportfolio category">
							<div class="portfolioFilter-inner bg-skeen">							
						<?php
							$album = "";
							if(isset($_GET['album'])) $album = $_GET['album'];
							
							$page = 1;
							if(isset($_GET['page'])) $page = $_GET['page'];
							if($page==1) $prev_page = 1;
							else 		 $prev_page = $page-1;
							
							$limit_to = ($page-1)*12;
							$limit_from = $page*12;
							
							$album_info =  $dbClass->getResultList("select * from image_album ");
							
							$count = 0;
							foreach ($album_info as $row){
								extract($row);
								$active_class = "not_active";
								if($album == "" && $count==0){
									$active_class = "current";
									$active_album = $album_name;
								}	
								else if($album !="" && $album == $album_name) {
									$active_class = "current";
									$active_album = $album;
								}						
								//die;  
								echo '<a class=" uppercase '.$active_class.'" href="gallery.php?album='.$album_name.'">'.$album_name.'</a>';
								$count++;
							}
						?>	
							</div>
						</div>
						<div class="row gallery-filter">
						    <?php
								$sql = "select img.title, img.attachment, alb.album_name 
																			from gallary_images img
																			join image_album alb on alb.id = img.album_id 
																			where alb.album_name = '".$active_album."' order by alb.id desc limit $limit_to, $limit_from";
								//echo $sql;
								$attachemnt_info =  $dbClass->getResultList($sql);										
								foreach ($attachemnt_info as $row){
									extract($row);
							?>
						
							<div class="col-md-3 col-sm-4 col-xs-12 isotope-item vegetarian italian">
								<div class="gallery-megic-blog">
									<a href="admin/document/gallary_attachment/<?php echo $attachment; ?>" class="magnific-popup" >
										<img src="admin/document/gallary_attachment/<?php echo $attachment; ?>" alt="">
										<div class="gallery-megic-inner">
											<div class="gallery-megic-out">
												<div class="gallery-megic-detail">
													<h5><?php echo $title; ?></h5>
													<span><?php echo $album_name; ?></span>
												</div>
											</div>
										</div>
									</a>
								</div>
							</div>						
						<?php
							}
							$error_html= '';
							if(empty($attachemnt_info)){
								$error_html =
									'<div>
										<div class="alert alert-warning" style="text-align:center">
											<h2>There is no image in this album. </h2>
										</div>
									</div>
									';
								echo $error_html;
							}						
						?>
						</div>
					</div>
					<div class="gallery-pagination">
						<div class="gallery-pagination-inner">
							<ul>
								<li><a href='gallery.php?album=<?php echo $active_album; ?>&page=<?php echo $prev_page; ?>'class="pagination-prev"><i class="icon-left-4"></i> <span>PREV page</span></a></li>
								<?php
									$img_info =  $dbClass->getSingleRow("select count(img.id)  total_images
																			from gallary_images img
																			join image_album alb on alb.id = img.album_id 
																			where alb.album_name = '".$active_album."' order by alb.id desc");									
									$total_page = ceil($img_info['total_images']/12);
									for($ppage=1; $ppage<=$total_page; $ppage++){
										$class= "";
										if($page == $ppage)	$class= "active";
										echo "<li class='$class'><a href='gallery.php?album=$active_album&page=$ppage'><span>$ppage</span></a></li>";
									}
									if($page==$total_page) $next_page = $total_page;
									else 		 	  	   $next_page = $page+1;
									
								?>	                                                
								<li><a href='gallery.php?album=<?php echo $active_album; ?>&page=<?php echo $next_page; ?>' class="pagination-next"><span>next page</span> <i class="icon-right-4"></i></a></li>
							</ul>
						</div>
					</div>	
				</div>
			</section>
		</div>
	</main>
	<!-- End Main -->
   <?php include('includes/footer.php'); ?> 


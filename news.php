<?php include('includes/header.php'); ?>                    
<!-- Start Main -->
        <main>
            <div class="main-part">
                <!-- 
                <section class="breadcrumb-part" data-stellar-offset-parent="true" data-stellar-background-ratio="0.5" style="background-image: url('images/breadbg1.jpg');">
                    <div class="container">
                        <div class="breadcrumb-inner">
                            <h2>News & Events</h2>
                            <a href="index.php">Home</a>
                            <span>News & Events</span>
                        </div>
                    </div>
                </section>
                -->
                 <section class="home-icon blog-main-section blog-list-outer">
                    <div class="icon-default">
                        <img src="images/scroll-arrow.png" alt="">
                    </div>
                    <div class="container">
                        <div class="row">                           
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="blog-right-section">
						<?php
							$news_html = "";
							$page = 1;
							if(isset($_GET['page'])) $page = $_GET['page'];
							if($page==1) $prev_page = 1;
							else 		 $prev_page = $page-1;
							
							
							$limit_to = ($page-1)*12;
							$limit_from = $page*12;
							
							$news_info =  $dbClass->getResultList("select n.id, n.title, n.details, n.attachment, n.post_date,banner_img, 
																date_format(n.post_date, '%b') c_month, date_format(n.post_date, '%d') c_date,	
																concat(e.full_name, ' (',e.designation_name,')') emp_name 
																from web_notice n
																join user_infos e on e.emp_id = n.posted_by
																where `type`= 1 order by  id desc limit $limit_to, $limit_from");	
							foreach ($news_info as $row){
								extract($row);
								?>
																	
                                    <div class="blog-right-listing wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="300ms">
                                        <div class="feature-img">
										<?php
										if(trim($banner_img) == "") $banner_img = "no_image.png";									
										?>
                                            <img src="admin/document/banner_attachment/<?php echo $banner_img; ?>" alt="">
                                            <div class="date-feature"><?php echo $c_date; ?>
                                                <br> <small><?php echo $c_month; ?></small></div>
                                        </div>
                                        <div class="feature-info">
                                            <span><i class="icon-user"></i> <?php echo $emp_name; ?></span>
											<span><i class="icon-clock"></i> <?php echo $post_date; ?></span>
                                            <h5><?php echo $title; ?></h5>
                                            <p><?php echo $details; ?></h5></p>
                                        </div>
                                    </div>
							<?php
							}
							?>	
							        <div class="gallery-pagination">
                                        <div class="gallery-pagination-inner">
                                            <ul>
                                                <li><a href='news.php?page=<?php echo $prev_page; ?>'class="pagination-prev"><i class="icon-left-4"></i> <span>PREV page</span></a></li>
												<?php
													$news_info =  $dbClass->getSingleRow("select count(n.id) total_news	from web_notice n");
													$total_page = ceil($news_info['total_news']/12);
													for($ppage=1; $ppage<=$total_page; $ppage++){
														$class= "";
														if($page == $ppage)	$class= "active";
														echo "<li class='$class'><a href='news.php?page=$ppage'><span>$ppage</span></a></li>";
													}
													if($page==$total_page) $next_page = $total_page;
													else 		 	  	   $next_page = $page+1;
													
												?>	                                                
												<li><a href='news.php?page=<?php echo $next_page; ?>' class="pagination-next"><span>next page</span> <i class="icon-right-4"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>							
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
	
            </div>
        </main>
        <!-- End Main -->
<?php include('includes/footer.php'); ?>  

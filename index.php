<?php
session_start();
include('includes/config.php');
include('includes/header.php');
?>



    <div class="container-fluid paddding mb-5">
        <div class="row mx-0">
            <?php
            $querynew = mysqli_query($con, "SELECT * FROM tblposts WHERE tblposts.Is_Active = 1 ORDER BY tblposts.PostingDate DESC LIMIT 5");
            $firstRow = mysqli_fetch_array($querynew);
            
            if ($firstRow) {
            ?>
                <div class="col-md-6 col-12 paddding animate-box" data-animate-effect="fadeIn">
                    <div class="fh5co_suceefh5co_height">
                        <img src="admin/postimages/<?php echo htmlentities($firstRow['PostImage']); ?>" alt="img" />
                        <div class="fh5co_suceefh5co_height_position_absolute"></div>
                        <div class="fh5co_suceefh5co_height_position_absolute_font">
                            <div class="">
                                <a href="javascript:void(0)" class="color_fff">
                                    <i class="fa fa-clock-o"></i>&nbsp;&nbsp;<?php echo htmlentities($firstRow['PostingDate']); ?>
                                </a>
                            </div>
                            <div class="">
                                <a href="news-details.php?nid=<?php echo htmlentities($firstRow['id']) ?>" class="fh5co_good_font">
                                    <?php echo htmlentities($firstRow['PostTitle']); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 soancd">
                    <div class="row">
                        <?php
                        $index = 0;
                        mysqli_data_seek($querynew,0);
                        while ($row = mysqli_fetch_array($querynew)) {
                            $index++;
                            if($index == 1) continue;
                            if ($index > 4) break;

                        ?>
                         <div class="col-md-6 col-6 paddding animate-box" data-animate-effect="fadeIn">
                            <div class="fh5co_suceefh5co_height_2"><img src="admin/postimages/<?php echo htmlentities($row['PostImage']); ?>" alt="img" style="width: 100%;"/>
                                <div class="fh5co_suceefh5co_height_position_absolute"></div>
                                <div class="fh5co_suceefh5co_height_position_absolute_font_2">
                                    <div class=""><a href="javascript:void(0)" class="color_fff"> <i class="fa fa-clock-o"></i>&nbsp;&nbsp;<?php echo htmlentities($row['PostingDate']); ?></a></div>
                                    <div class=""><a href="news-details.php?nid=<?php echo htmlentities($row['id']) ?>" class="fh5co_good_font_2"> <?php echo htmlentities($row['PostTitle']); ?> </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <?php } else {
                echo "<div style='text-align:center'>No post</div>";
            }?>

        </div>
    </div>

    <div class="container-fluid pt-3">
        <div class="container animate-box" data-animate-effect="fadeIn">
            <div>
                <div class="fh5co_heading fh5co_heading_border_bottom py-2 mb-4">Trending</div>
            </div>
            <div class="owl-carousel owl-theme js" id="slider1">
                <?php
                $query = mysqli_query($con, "SELECT tblposts.id as pid, tblposts.PostTitle as posttitle, tblposts.PostImage, tblcategory.CategoryName as category, tblcategory.id as cid, tblsubcategory.Subcategory as subcategory, tblposts.PostDetails as postdetails, tblposts.PostingDate as postingdate, tblposts.PostUrl as url FROM tblposts LEFT JOIN tblcategory ON tblcategory.id = tblposts.CategoryId LEFT JOIN tblsubcategory ON tblsubcategory.SubCategoryId = tblposts.SubCategoryId WHERE tblposts.Is_Active = 1 ORDER BY tblposts.viewCounter DESC");
                while ($row = mysqli_fetch_array($query)) {
                    ?>
                    <div class="item px-2" style="width:100%;">
                        <div class="fh5co_latest_trading_img_position_relative">
                            <div class="fh5co_latest_trading_img">
                                <img src="admin/postimages/<?php echo htmlentities($row['PostImage']); ?>"
                                    alt="<?php echo htmlentities($row['posttitle']); ?>"
                                    class="fh5co_img_special_relative" />
                            </div>
                            <div class="fh5co_latest_trading_img_position_absolute"></div>
                            <div class="fh5co_latest_trading_img_position_absolute_1">
                                <a href="news-details.php?nid=<?php echo htmlentities($row['pid']) ?>" class="text-white">
                                    <?php echo htmlentities($row['posttitle']); ?> </a>
                                <div class="fh5co_latest_trading_date_and_name_color">
                                    <?php echo htmlentities($row['postingdate']); ?></div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <?php
    $query = mysqli_query($con, 'SELECT * FROM tblcategory WHERE Is_Active = 1');
    while ($row = mysqli_fetch_array($query)) {
        $query1 = mysqli_query($con, 'SELECT * FROM tblposts WHERE Is_Active = 1 AND CategoryId =' . $row['id'] . ' LIMIT 6');
        $length = mysqli_num_rows($query1);
        if ($length == 0) {
            continue;
        }
    ?>
    <div class="container-fluid pb-4 pt-5">
        <div class="container animate-box">
                    <div>
                        <div class="fh5co_heading fh5co_heading_border_bottom py-2 mb-4">
                            <?php echo htmlentities($row['CategoryName']) ?></div>
                    </div>
                    <div class="owl-carousel owl-theme" id="slider2">
                        <?php
                        while ($row1 = mysqli_fetch_array($query1)) {
                            ?>
                            <div class="item px-2">
                                <div class="fh5co_hover_news_img">
                                    <div class="fh5co_news_img"><img
                                            src="admin/postimages/<?php echo htmlentities($row1['PostImage']); ?>"
                                            alt="<?php echo htmlentities($row1['PostTitle']); ?>" /></div>
                                    <div>
                                        <a href="news-details.php?nid=<?php echo htmlentities($row1['id']) ?>"
                                            class="d-block fh5co_small_post_heading"><span
                                                class=""><?php echo htmlentities($row1['PostTitle']); ?></span></a>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
    </div>
    <?php
    } ?>
<div class="container-fluid fh5co_video_news_bg pb-4">
    <div class="container animate-box" data-animate-effect="fadeIn">
        <div>
            <div class="fh5co_heading fh5co_heading_border_bottom pt-5 pb-2 mb-4  text-white">Video News</div>
        </div>
        <div>
            <div class="owl-carousel owl-theme" id="slider3">
                <div class="item px-2">
                    <div class="fh5co_hover_news_img">
                        <div class="fh5co_hover_news_img_video_tag_position_relative">
                            <div class="fh5co_news_img">
                                <iframe id="video" width="100%" height="200"
                                        src="https://www.youtube.com/embed/aM9g4r9QUsM?rel=0&amp;showinfo=0"
                                        frameborder="0" allowfullscreen></iframe>
                            </div>
                            <div class="fh5co_hover_news_img_video_tag_position_absolute fh5co_hide">
                                <img src="images/ariel-lustre-208615.jpg" alt=""/>
                            </div>
                            <div class="fh5co_hover_news_img_video_tag_position_absolute_1 fh5co_hide" id="play-video">
                                <div class="fh5co_hover_news_img_video_tag_position_absolute_1_play_button_1">
                                    <div class="fh5co_hover_news_img_video_tag_position_absolute_1_play_button">
                                        <span><i class="fa fa-play"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pt-2">
                            <a href="#" class="d-block fh5co_small_post_heading fh5co_small_post_heading_1">
                            <span class="">The top 10 funniest videos on YouTube </span></a>
                            <div class="c_g"><i class="fa fa-clock-o"></i> Oct 16,2017</div>
                        </div>
                    </div>
                </div>
                <div class="item px-2">
                    <div class="fh5co_hover_news_img">
                        <div class="fh5co_hover_news_img_video_tag_position_relative">
                            <div class="fh5co_news_img">
                                <iframe id="video_2" width="100%" height="200"
                                        src="https://www.youtube.com/embed/aM9g4r9QUsM?rel=0&amp;showinfo=0"
                                        frameborder="0" allowfullscreen></iframe>
                            </div>
                            <div class="fh5co_hover_news_img_video_tag_position_absolute fh5co_hide_2">
                                <img src="images/39-324x235.jpg" alt=""/></div>
                            <div class="fh5co_hover_news_img_video_tag_position_absolute_1 fh5co_hide_2" id="play-video_2">
                                <div class="fh5co_hover_news_img_video_tag_position_absolute_1_play_button_1">
                                    <div class="fh5co_hover_news_img_video_tag_position_absolute_1_play_button">
                                        <span><i class="fa fa-play"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pt-2">
                            <a href="#" class="d-block fh5co_small_post_heading fh5co_small_post_heading_1">
                            <span class="">The top 10 embedded YouTube videos this month</span></a>
                            <div class="c_g"><i class="fa fa-clock-o"></i> Oct 16,2017</div>
                        </div>
                    </div>
                </div>
                <div class="item px-2">
                    <div class="fh5co_hover_news_img">
                        <div class="fh5co_hover_news_img_video_tag_position_relative">
                            <div class="fh5co_news_img">
                                <iframe id="video_3" width="100%" height="200"
                                        src="https://www.youtube.com/embed/aM9g4r9QUsM?rel=0&amp;showinfo=0"
                                        frameborder="0" allowfullscreen></iframe>
                            </div>
                            <div class="fh5co_hover_news_img_video_tag_position_absolute fh5co_hide_3">
                                <img src="images/joe-gardner-75333.jpg" alt=""/></div>
                            <div class="fh5co_hover_news_img_video_tag_position_absolute_1 fh5co_hide_3" id="play-video_3">
                                <div class="fh5co_hover_news_img_video_tag_position_absolute_1_play_button_1">
                                    <div class="fh5co_hover_news_img_video_tag_position_absolute_1_play_button">
                                        <span><i class="fa fa-play"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pt-2">
                            <a href="#" class="d-block fh5co_small_post_heading fh5co_small_post_heading_1">
                            <span class="">The top 10 best computer speakers in the market</span></a>
                            <div class="c_g"><i class="fa fa-clock-o"></i> Oct 16,2017</div>
                        </div>
                    </div>
                </div>
                <div class="item px-2">
                    <div class="fh5co_hover_news_img">
                        <div class="fh5co_hover_news_img_video_tag_position_relative">
                            <div class="fh5co_news_img">
                                <iframe id="video_4" width="100%" height="200"
                                        src="https://www.youtube.com/embed/aM9g4r9QUsM?rel=0&amp;showinfo=0"
                                        frameborder="0" allowfullscreen></iframe>
                            </div>
                            <div class="fh5co_hover_news_img_video_tag_position_absolute fh5co_hide_4">
                                <img src="images/vil-son-35490.jpg" alt=""/>
                            </div>
                            <div class="fh5co_hover_news_img_video_tag_position_absolute_1 fh5co_hide_4" id="play-video_4">
                                <div class="fh5co_hover_news_img_video_tag_position_absolute_1_play_button_1">
                                    <div class="fh5co_hover_news_img_video_tag_position_absolute_1_play_button">
                                        <span><i class="fa fa-play"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pt-2">
                            <a href="#" class="d-block fh5co_small_post_heading fh5co_small_post_heading_1">
                                <span class="">The top 10 best computer speakers in the market</span></a>
                            <div class="c_g"><i class="fa fa-clock-o"></i> Oct 16,2017</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <div class="container-fluid pb-4 pt-4 paddding">
        <div class="container paddding">
            <div class="row mx-0">
                <div class="col-md-8 animate-box" data-animate-effect="fadeInLeft">
                    <div>
                        <div class="fh5co_heading fh5co_heading_border_bottom py-2 mb-4">News</div>
                    </div>
                    <div class="row pb-4">
                        <div class="col-md-5">
                            <div class="fh5co_hover_news_img">
                                <div class="fh5co_news_img"><img src="images/nathan-mcbride-229637.jpg" alt="" /></div>
                                <div></div>
                            </div>
                        </div>
                        <div class="col-md-7 animate-box">
                            <a href="single.html" class="fh5co_magna py-2"> Magna aliqua ut enim ad minim veniam quis
                                nostrud quis xercitation ullamco. </a> <a href="single.html"
                                class="fh5co_mini_time py-3"> Thomson Smith -
                                April 18,2016 </a>
                            <div class="fh5co_consectetur"> Amet consectetur adipisicing elit, sed do eiusmod tempor
                                incididunt
                                ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.
                            </div>
                        </div>
                    </div>
                    <div class="row pb-4">
                        <div class="col-md-5">
                            <div class="fh5co_hover_news_img">
                                <div class="fh5co_news_img"><img src="images/ryan-moreno-98837.jpg" alt="" /></div>
                                <div></div>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <a href="single.html" class="fh5co_magna py-2"> Magna aliqua ut enim ad minim veniam quis
                                nostrud quis xercitation ullamco. </a> <a href="#" class="fh5co_mini_time py-3"> Thomson
                                Smith -
                                April 18,2016 </a>
                            <div class="fh5co_consectetur"> Quis nostrud exercitation ullamco laboris nisi ut aliquip ex
                                ea
                                commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum
                                dolore.
                            </div>
                            <ul class="fh5co_gaming_topikk pt-3">
                                <li> Why 2017 Might Just Be the Worst Year Ever for Gaming</li>
                                <li> Ghost Racer Wants to Be the Most Ambitious Car Game</li>
                                <li> New Nintendo Wii Console Goes on Sale in Strategy Reboot</li>
                                <li> You and Your Kids can Enjoy this News Gaming Console</li>
                            </ul>
                        </div>
                    </div>
                    <div class="row pb-4">
                        <div class="col-md-5">
                            <div class="fh5co_hover_news_img">
                                <div class="fh5co_news_img">
                                    <img src="images/photo-1449157291145-7efd050a4d0e-578x362.jpg" alt="" />
                                </div>
                                <div></div>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <a href="single.html" class="fh5co_magna py-2"> Magna aliqua ut enim ad minim veniam quis
                                nostrud quis xercitation ullamco. </a> <a href="#" class="fh5co_mini_time py-3"> Thomson
                                Smith -
                                April 18,2016 </a>
                            <div class="fh5co_consectetur"> Quis nostrud xercitation ullamco laboris nisi aliquip ex ea
                                commodo
                                consequat.
                            </div>
                        </div>
                    </div>
                    <div class="row pb-4">
                        <div class="col-md-5">
                            <div class="fh5co_hover_news_img">
                                <div class="fh5co_news_img"><img src="images/office-768x512.jpg" alt="" /></div>
                                <div></div>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <a href="single.html" class="fh5co_magna py-2"> Magna aliqua ut enim ad minim veniam quis
                                nostrud quis xercitation ullamco. </a> <a href="#" class="fh5co_mini_time py-3"> Thomson
                                Smith -
                                April 18,2016 </a>
                            <div class="fh5co_consectetur"> Amet consectetur adipisicing elit, sed do eiusmod tempor
                                incididunt
                                ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mx-0 animate-box" data-animate-effect="fadeInUp">
                <div class="col-12 text-center pb-4 pt-4">
                    <a href="#" class="btn_mange_pagging"><i class="fa fa-long-arrow-left"></i>&nbsp;&nbsp; Previous</a>
                    <a href="#" class="btn_pagging">1</a>
                    <a href="#" class="btn_pagging">2</a>
                    <a href="#" class="btn_pagging">3</a>
                    <a href="#" class="btn_pagging">...</a>
                    <a href="#" class="btn_mange_pagging">Next <i class="fa fa-long-arrow-right"></i>&nbsp;&nbsp; </a>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid fh5co_footer_bg pb-3">
        <div class="container animate-box">
            <div class="row">
                <div class="col-12 spdp_right py-5"><img src="images/white_logo.png" alt="img" class="footer_logo" />
                </div>
                <div class="clearfix"></div>
                <div class="col-12 col-md-4 col-lg-3">
                    <div class="footer_main_title py-3"> About</div>
                    <div class="footer_sub_about pb-3"> Lorem Ipsum is simply dummy text of the printing and typesetting
                        industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an
                        unknown printer took a galley of type and scrambled it to make a type specimen book.
                    </div>
                    <div class="footer_mediya_icon">
                        <div class="text-center d-inline-block"><a class="fh5co_display_table_footer">
                                <div class="fh5co_verticle_middle"><i class="fa fa-linkedin"></i></div>
                            </a></div>
                        <div class="text-center d-inline-block"><a class="fh5co_display_table_footer">
                                <div class="fh5co_verticle_middle"><i class="fa fa-google-plus"></i></div>
                            </a></div>
                        <div class="text-center d-inline-block"><a class="fh5co_display_table_footer">
                                <div class="fh5co_verticle_middle"><i class="fa fa-twitter"></i></div>
                            </a></div>
                        <div class="text-center d-inline-block"><a class="fh5co_display_table_footer">
                                <div class="fh5co_verticle_middle"><i class="fa fa-facebook"></i></div>
                            </a></div>
                    </div>
                </div>
                <div class="col-12 col-md-3 col-lg-2">
                    <div class="footer_main_title py-3"> Category</div>
                    <ul class="footer_menu">
                        <li><a href="#" class=""><i class="fa fa-angle-right"></i>&nbsp;&nbsp; Business</a></li>
                        <li><a href="#" class=""><i class="fa fa-angle-right"></i>&nbsp;&nbsp; Entertainment</a></li>
                        <li><a href="#" class=""><i class="fa fa-angle-right"></i>&nbsp;&nbsp; Environment</a></li>
                        <li><a href="#" class=""><i class="fa fa-angle-right"></i>&nbsp;&nbsp; Health</a></li>
                        <li><a href="#" class=""><i class="fa fa-angle-right"></i>&nbsp;&nbsp; Life style</a></li>
                        <li><a href="#" class=""><i class="fa fa-angle-right"></i>&nbsp;&nbsp; Politics</a></li>
                        <li><a href="#" class=""><i class="fa fa-angle-right"></i>&nbsp;&nbsp; Technology</a></li>
                        <li><a href="#" class=""><i class="fa fa-angle-right"></i>&nbsp;&nbsp; World</a></li>
                    </ul>
                </div>
                <div class="col-12 col-md-5 col-lg-3 position_footer_relative">
                    <div class="footer_main_title py-3"> Most Viewed Posts</div>
                    <div class="footer_makes_sub_font"> Dec 31, 2016</div>
                    <a href="#" class="footer_post pb-4"> Success is not a good teacher failure makes you humble </a>
                    <div class="footer_makes_sub_font"> Dec 31, 2016</div>
                    <a href="#" class="footer_post pb-4"> Success is not a good teacher failure makes you humble </a>
                    <div class="footer_makes_sub_font"> Dec 31, 2016</div>
                    <a href="#" class="footer_post pb-4"> Success is not a good teacher failure makes you humble </a>
                    <div class="footer_position_absolute"><img src="images/footer_sub_tipik.png" alt="img"
                            class="width_footer_sub_img" /></div>
                </div>
                <div class="col-12 col-md-12 col-lg-4 ">
                    <div class="footer_main_title py-3"> Last Modified Posts</div>
                    <a href="#" class="footer_img_post_6"><img src="images/allef-vinicius-108153.jpg" alt="img" /></a>
                    <a href="#" class="footer_img_post_6"><img src="images/32-450x260.jpg" alt="img" /></a>
                    <a href="#" class="footer_img_post_6"><img src="images/download (1).jpg" alt="img" /></a>
                    <a href="#" class="footer_img_post_6"><img src="images/science-578x362.jpg" alt="img" /></a>
                    <a href="#" class="footer_img_post_6"><img src="images/vil-son-35490.jpg" alt="img" /></a>
                    <a href="#" class="footer_img_post_6"><img src="images/zack-minor-15104.jpg" alt="img" /></a>
                    <a href="#" class="footer_img_post_6"><img src="images/download.jpg" alt="img" /></a>
                    <a href="#" class="footer_img_post_6"><img src="images/download (2).jpg" alt="img" /></a>
                    <a href="#" class="footer_img_post_6"><img src="images/ryan-moreno-98837.jpg" alt="img" /></a>
                </div>
            </div>
            <div class="row justify-content-center pt-2 pb-4">
                <div class="col-12 col-md-8 col-lg-7 ">
                    <div class="input-group">
                        <span class="input-group-addon fh5co_footer_text_box" id="basic-addon1"><i
                                class="fa fa-envelope"></i></span>
                        <input type="text" class="form-control fh5co_footer_text_box" placeholder="Enter your email..."
                            aria-describedby="basic-addon1">
                        <a href="#" class="input-group-addon fh5co_footer_subcribe" id="basic-addon12"> <i
                                class="fa fa-paper-plane-o"></i>&nbsp;&nbsp;Subscribe</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid fh5co_footer_right_reserved">
        <div class="container">
            <div class="row  ">
                <div class="col-12 col-md-6 py-4 Reserved"> © Copyright 2018, All rights reserved. Design by <a
                        href="https://freehtml5.co" title="Free HTML5 Bootstrap templates">FreeHTML5.co</a>. </div>
                <div class="col-12 col-md-6 spdp_right py-4">
                    <a href="#" class="footer_last_part_menu">Home</a>
                    <a href="Contact_us.html" class="footer_last_part_menu">About</a>
                    <a href="Contact_us.html" class="footer_last_part_menu">Contact</a>
                    <a href="blog.html" class="footer_last_part_menu">Latest News</a>
                </div>
            </div>
        </div>
    </div>


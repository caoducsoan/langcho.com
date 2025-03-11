
        <div class="col-md-3 animate-box" data-animate-effect="fadeInRight">
                <div>
                    <div class="fh5co_heading fh5co_heading_border_bottom py-2 mb-4">Tags</div>
                </div>
                <div class="clearfix"></div>
                <div class="fh5co_tags_all">
                <?php $query=mysqli_query($con,"select id,CategoryName from tblcategory");
while($row=mysqli_fetch_array($query))
{
?>
                    <a href="category.php?catid=<?php echo htmlentities($row['id'])?>" class="fh5co_tagg"><?php echo htmlentities($row['CategoryName']);?></a>
                    <?php } ?>
                </div>
                <div>
                    <div class="fh5co_heading fh5co_heading_border_bottom pt-3 py-2 mb-4">Most Popular</div>
                </div>
                <?php
$query1=mysqli_query($con,"select tblposts.id as pid,tblposts.PostTitle as posttitle,tblposts.PostImage,tblcategory.CategoryName as category,tblcategory.id as cid,tblsubcategory.Subcategory as subcategory,tblposts.PostDetails as postdetails,tblposts.PostUrl as url from tblposts left join tblcategory on tblcategory.id=tblposts.CategoryId left join  tblsubcategory on  tblsubcategory.SubCategoryId=tblposts.SubCategoryId  order by viewCounter desc limit 5");
while ($result=mysqli_fetch_array($query1)) {
?>
                <div class="row pb-3">
                    <div class="col-5 align-self-center">
                        <img src="admin/postimages/<?php echo htmlentities($result['PostImage']);?>"
                         alt="<?php echo htmlentities($result['posttitle']);?>" 
                         class="fh5co_most_trading"/>
                    </div>
                    <div class="col-7 paddding">
                        <div class="most_fh5co_treding_font"> <?php echo htmlentities($result['posttitle']);?></div>
                    </div>
                </div>
                <?php } ?>
            </div>
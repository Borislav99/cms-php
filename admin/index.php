<?php include "includes/admin_header.php"?>;
<?php 
    //hvatanje korisnickog imena radi personalizacije
    $username = $_SESSION['username'];
?>
<div id="wrapper">
    <!-- Navigation -->
    <?php include "includes/admin_navigation.php";?>;

    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Welcome to admin
                        <small><?php 
                            //prikaz korisnickog imena radi personalizacije
                            echo $username
                            ?></small>
                    </h1>
                </div>
            </div>
            <!-- /.row -->

            <!-- /.row -->

            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-file-text fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php 
                                    //trenutni broj objava
                                    $post_counts = get_all_user_posts('posts', null);
                                    echo "<div class='huge'>$post_counts</div>"
                                ?>
                                    <div>Posts</div>
                                </div>
                            </div>
                        </div>
                        <a href="posts.php?source=view_all_posts.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-comments fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php 
                                    //trenutni broj komentara
                                    $comments_counts = get_all_post_user_comms(null);
                                    echo "<div class='huge'>$comments_counts</div>";
                                    ?>
                                    <div>Comments</div>
                                </div>
                            </div>
                        </div>
                        <a href="comments.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-list fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php 
                                    //trenutni broj kategorija
                                    $categories_counts = get_all_user_cats();
                                    echo "<div class='huge'>$categories_counts</div>";
                                    ?>
                                    <div>Categories</div>
                                </div>
                            </div>
                        </div>
                        <a href="categories.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <!-- /.row -->
            <!-- RAD -->
            <?php 
            //broj objava koje su draft
            $post_draft_count = get_all_user_posts('posts', 'draft');
            //broj objava koje su published
            $post_published_count = get_all_user_posts('posts', 'published');
            //broj omogucenih komentara
            $all_approved_comments = get_all_post_user_comms('approved');
            //broj onemogucenih komentara
            $all_unapproved_comments = get_all_post_user_comms('unapproved');
            ?>
            <!-- RAD -->
            <div class="row">
                <!-- -->
                <script type="text/javascript">
                    google.charts.load('current', {
                        'packages': ['bar']
                    });
                    google.charts.setOnLoadCallback(drawChart);

                    function drawChart() {
                        var data = google.visualization.arrayToDataTable([
                            ['Data', 'Count'],
                            <?php 
                            //nazivi vertikalnih grafikona
                            $element_text = ['All Posts', 'Published Posts', 'Draft Posts', 'Comments', 'Approved Comments', 'Unapproved Comments', 'Categories'];
                            //njihove vrijednosti
                            $element_count = [$post_counts, $post_published_count, $post_draft_count, $comments_counts, $all_approved_comments, $all_unapproved_comments, $categories_counts];
                            //za svaki od elemenata, prikazi grafikon
                            for($i=0; $i<count($element_count); $i++) {
                                echo "['{$element_text[$i]}',{$element_count[$i]}],";
                            };
                            ?>
                            //['Posts', 1000],
                        ]);

                        var options = {
                            chart: {
                                title: '',
                                subtitle: '',
                            }
                        };

                        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

                        chart.draw(data, google.charts.Bar.convertOptions(options));
                    }

                </script>
                <div id="columnchart_material" style="width: 'auto'; height: 500px;"></div>
            </div>
        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

    <?php include "includes/admin_footer.php"?>;

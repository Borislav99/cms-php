<?php include "includes/admin_header.php"?>;
<?php 
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
                        Welcome to Admin Dashboard
                        <small><?php echo get_user_name();?></small>
                    </h1>
                </div>
            </div>
            <!-- /.row -->

            <!-- /.row -->

            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-file-text fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php 
                                    $post_counts = recordCount('posts');
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
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-comments fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php 
                                    $comments_counts = recordCount('comments');
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
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-user fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php 
                                    $users_counts = recordCount('users');
                                    echo "<div class='huge'>$users_counts</div>";
                                    ?>
                                    <div> Users</div>
                                </div>
                            </div>
                        </div>
                        <a href="users.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-list fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php 
                                    $categories_counts = recordCount('categories');
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
            //num of draft posts
            $post_draft_count = checkStatus('posts', 'post_status', 'draft');
            //num of published posts
            $post_published_count = checkStatus('posts', 'post_status', 'published');
            //num of approved comms
            $all_approved_comments = checkStatus('comments', 'comment_status', 'approved');
            //num of unapproved comms
            $all_unapproved_comments = checkStatus('comments', 'comment_status', 'unapproved');
            //num of admins
            $all_admins = getUserRole('users', 'admin');
            //num of subs
            $all_subscribers = getUserRole('users', 'subscriber');
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
                            $element_text = ['All Posts', 'Published Posts', 'Draft Posts', 'Comments', 'Approved Comments', 'Unapproved Comments', 'Users', 'Admins', 'Subscribers', 'Categories'];
                            $element_count = [$post_counts, $post_published_count, $post_draft_count, $comments_counts, $all_approved_comments, $all_unapproved_comments, $users_counts, $all_admins, $all_subscribers, $categories_counts];
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

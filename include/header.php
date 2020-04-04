<div class="my-navbar">
    <div class="logo">
        <a href='/blog/posts/' > <img src="/blog/assets/icons/logo.png" alt="logo not found"></a>
    </div>
    <div class="nav-links">
        <i class="fa fa-bars menuicon"></i>
        <div class="links ">
            <div class=''>
                <div><a href="/blog/posts/index.php">Home</a></div>
                <?php
                    if(!isset($_SESSION['auth'])){
                ?>
                        <div><a href="/blog/auth/login.php">Login</a></div>
                        <div><a href="/blog/auth/register.php">Register</a></div>
                <?php 
                    } else {
                ?>  
                    <div >
                        <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <?=$_SESSION['auth']['name']?> <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu " aria-labelledby="navbarDropdown">
                            <div class="dropdown-item">
                                <a href="/blog/dashboard.php">Dashboard</a>
                            </div>
                            <div class="dropdown-item">
                                <a href="/blog/posts/create.php">Create Post</a>
                            </div>
                            <div class="dropdown-item">
                                <a href="/blog/controller/auth/logout.php">
                                    Logout
                                </a>
                            </div>
                        </div>
                    </div>
                <?php
                    }
                ?>
            </div>
        </div>
    </div>
</div>
</div>

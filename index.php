<?php
// Include the conn.php file to establish a connection to the database
include 'src/conn.php';

// Define the name of the table we want to query
$table_name = 'dokumen';

// Query the database to count the number of rows in the table
$stored_article = $db->query("SELECT COUNT(*) FROM $table_name");
$stored_article = mysqli_fetch_array($stored_article);

// Query the database to sum the character lengths of the "isi" column in the table
$total_char = $db->query("SELECT SUM(CHAR_LENGTH(isi)) FROM $table_name");
$total_char = mysqli_fetch_array($total_char);

// Query the database to retrieve the size of the data and indexes of the table
$db_size = $db->query("SELECT DATA_LENGTH, INDEX_LENGTH FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME = '$table_name'");
$db_size = mysqli_fetch_array($db_size);

// Calculate the size of the data in the table in bytes
$data_size_bytes = $db_size['DATA_LENGTH'];

// Calculate the size of the indexes in the table in bytes
$index_size_bytes = $db_size['INDEX_LENGTH'];

// Calculate the total size of the table in MB
$total_size_mb = ($data_size_bytes + $index_size_bytes) / 1024 / 1024;
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Cloud Archive Manager based on Knuth-Morris-Pratt Algorithm">
    <meta name="keywords" content="archive manager, kmp">
    <meta name="author" content="gk">
    
    <!-- Title -->
    <title>Qubit Search</title>

    <!-- Styles -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp" rel="stylesheet">
    <link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/plugins/perfectscroll/perfect-scrollbar.css" rel="stylesheet">
    <link href="assets/plugins/pace/pace.css" rel="stylesheet">

    
    <!-- Theme Styles -->
    <link href="assets/css/main.min.css" rel="stylesheet">
    <link href="assets/css/horizontal-menu/horizontal-menu.css" rel="stylesheet">
    <link href="assets/css/custom.css" rel="stylesheet">

    <link rel="icon" type="image/png" href="assets/images/favicon.ico" />

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <div class="app horizontal-menu align-content-stretch d-flex flex-wrap">
        <div class="app-container">
            <div class="app-header">
                <nav class="navbar navbar-light navbar-expand-lg container">
                    <div class="container-fluid">
                        <div class="navbar-nav" id="navbarNav">
                            <div class="logo">
                                <a href="#">QUBIT SEARCH</a>
                            </div>
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link hide-sidebar-toggle-button" href="#"><i class="material-icons">last_page</i></a>
                                </li>
                            </ul>
            
                        </div>
                        <div class="d-flex">
                            <ul class="navbar-nav">
                                <li class="nav-item hidden-on-mobile">
                                    <a href="#" class="nav-link active">Home</a>
                                </li>
                                <li class="nav-item hidden-on-mobile">
                                    <a href="https://cmps-people.ok.ubc.ca/ylucet/DS/KnuthMorrisPratt.html" target="_blank" class="nav-link">KMP Visualization</a>
                                </li>
                                <li class="nav-item hidden-on-mobile">
                                    <a href="https://github.com/gungkrisna/kmp-article-search" target="_blank" class="nav-link">GitHub</a>
                                </li>
                                <li class="nav-item hidden-on-desktop">
                                    <a class="nav-link toggle-search" href="#"><i class="material-icons">search</i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>

            <div class="app-menu hidden-on-desktop">
                <div class="container">
                    <ul class="menu-list">
                        <li class="active-page">
                            <a href="index.html" class="active">Home</a>
                        </li>
                        <li>
                            <a href="https://cmps-people.ok.ubc.ca/ylucet/DS/KnuthMorrisPratt.html">KMP Visualization</a>
                        </li>
                        <li>
                            <a href="#">Documentation</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="app-content">
                <div class="content-wrapper">
                    <div class="container">
                    <div class="row">
                        <div class="col-md-6 offset-md-3 mt-3">
                            <div class="d-flex flex-row justify-content-center">
                            <img src="assets/images/main-logo.png" alt="" srcset="" style="max-width: 40%;">                            </div>
                            <div class="d-flex justify-content-center main-logo m-5">
                                <a href="#">QUBIT</a>
                            </div>
                            <form action="search/" method="get">
                                <div class="input-group mb-3">
                                    <input type="text" name="q" id="q" class="form-control" placeholder="Cari kueri artikel">
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row mt-5">
                            <div class="col-xl-4">
                                <div class="card widget widget-stats">
                                    <div class="card-body">
                                        <div class="widget-stats-container d-flex">
                                            <div class="widget-stats-icon widget-stats-icon-warning">
                                                <i class="material-icons-outlined">description</i>
                                            </div>
                                            <div class="widget-stats-content flex-fill">
                                                <span class="widget-stats-title">Stored Article</span>
                                                <span class="widget-stats-amount"><?= number_format($stored_article[0]) ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="card widget widget-stats">
                                    <div class="card-body">
                                        <div class="widget-stats-container d-flex">
                                            <div class="widget-stats-icon widget-stats-icon-danger">
                                                <i class="material-icons-outlined">storage</i>
                                            </div>
                                            <div class="widget-stats-content flex-fill">
                                                <span class="widget-stats-title">Storage Used</span>
                                                <span class="widget-stats-amount"><?= round($total_size_mb, 1) ?> MB</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="card widget widget-stats">
                                    <div class="card-body">
                                        <div class="widget-stats-container d-flex">
                                            <div class="widget-stats-icon widget-stats-icon-primary">
                                                <i class="material-icons-outlined">subtitles</i>
                                            </div>
                                            <div class="widget-stats-content flex-fill">
                                                <span class="widget-stats-title">Total Character Length</span>
                                                <span class="widget-stats-amount"><?= number_format($total_char[0]) ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Javascripts -->
    <script src="assets/plugins/jquery/jquery-3.5.1.min.js"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/plugins/perfectscroll/perfect-scrollbar.min.js"></script>
    <script src="assets/plugins/pace/pace.min.js"></script>
    <script src="assets/js/main.min.js"></script>
    <script src="assets/js/custom.js"></script>
    <script src="assets/js/pages/dashboard.js"></script>
</body>
</html>
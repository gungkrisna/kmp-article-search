<?php
include '../src/conn.php';
include '../src/search.php';

// Initialize variables
$search_query = trim($_GET['q'], " ");

// Get the current page number for pagination
if (isset($_GET['page'])) {
    $current_page = $_GET['page'];
} else {
    $current_page = 1;
}

// Check if search query is empty
if ($search_query == '') {
    echo "<script>
    window.location.href='../';
    </script>";
}

// Get all articles from the database
$articles_query = $db->query("SELECT * FROM dokumen");
$articles = $articles_query->fetch_all(MYSQLI_ASSOC);

// Elapsed time for KMP Search query
$elapsed_time = 0;

// Search the query from the article
$results = search($search_query, $articles, $elapsed_time);

// Calculate the total number of pages for pagination
$total_pages = ceil(count($results) / 10);

// Calculate the first and last result for the current page
$first_page = (10 * $current_page) - 10;
$last_page = 10 * $current_page;
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
    <title><?= $search_query ?> - Qubit Search</title>

    <!-- Styles -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp" rel="stylesheet">
    <link href="../assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/plugins/perfectscroll/perfect-scrollbar.css" rel="stylesheet">
    <link href="../assets/plugins/pace/pace.css" rel="stylesheet">

    
    <!-- Theme Styles -->
    <link href="../assets/css/main.min.css" rel="stylesheet">
    <link href="../assets/css/horizontal-menu/horizontal-menu.css" rel="stylesheet">
    <link href="../assets/css/custom.css" rel="stylesheet">

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

            <div class="search container">
                <form action="" method="get">
                    <input class="form-control" type="text" name="q" id="q" value="<?= $search_query ?>" placeholder="Cari kueri artikel" aria-label="Search">
                </form>
                <a href="#" class="toggle-search"><i class="material-icons">close</i></a>
            </div>
            <div class="app-header">
                <nav class="navbar navbar-light navbar-expand-lg container">
                    <div class="container-fluid">
                        <div class="navbar-nav" id="navbarNav">
                            <div class="logo">
                                <a href="../">QUBIT SEARCH</a>
                            </div>
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link hide-sidebar-toggle-button" href="#"><i class="material-icons">last_page</i></a>
                                </li>
                                <li class="nav-item">
                                    <div class="input-group toggle-search hidden-on-mobile">
                                        <span class="input-group-text input-group-text-searchbar"><i class="material-icons">search</i></span>
                                            <input type="text" class="form-control" id="search" style="border-left: 0; border-right: 0" value="<?= $search_query ?>" placeholder="Telusuri Berkas" readonly>
                                    </div>
                                </li>
                            </ul>
            
                        </div>
                        <div class="d-flex">
                            <ul class="navbar-nav">
                                <li class="nav-item hidden-on-mobile">
                                    <a href="../" class="nav-link">Home</a>
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
                        <li>
                            <a href="../" class="active">Home</a>
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
                            <div class="col">
                                <div class="card widget widget-list widget-files mt-3">
                                    <div class="card-header">
                                        <ul class="nav nav-tabs card-header-tabs">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active" style="padding: 18px 30px" id="all-tab" data-bs-toggle="tab" data-bs-target="#all" type="button" role="tab" aria-controls="all" aria-selected="true">Semua</button>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="card-body">
                                        <div class="tab-content" id="myTabContent">
                                            <div class="tab-pane fade active show" id="all" role="tabpanel" aria-labelledby="all-tab">
                                                <p class="card-text" class="text-muted">Ditemukan <?= (isset($results) && !empty($results)) ? count($results) : "0" ?> hasil dari <?= $articles_query->num_rows; ?> artikel (<?= round(($elapsed_time/1e+9), '3') ?> detik)</p>
                                                <ul class="widget-list-content list-unstyled mt-3 mb-5">
                                                    <?php for ($i = $first_page; $i < $last_page; $i++) : ?>
                                                        <?php if (isset($results[$i]['title'])) : ?>
                                                            <li class="widget-list-item widget-list-item-blog-post">
                                                                <span class="widget-list-item-icon widget-list-item-icon"><i class="material-icons-outlined">article</i></span>
                                                                <span class="widget-list-item-description">
                                                                    <a href="../dokumen/?id=<?= $results[$i]['id'] ?>" class="widget-list-item-description-title">
                                                                        <?= $results[$i]['title'] ?>
                                                                    </a>
                                                                    <span class="widget-list-item-description-content">
                                                                        <?= $results[$i]['description'] ?>
                                                                    </span>
                                                                </span>
                                                            </li>
                                                        <?php endif; ?>
                                                    <?php endfor; ?>
                                                </ul>
                                                <nav aria-label="..." class="table-responsive">
                                                    <ul class="pagination">
                                                        <li class="page-item . <?php echo ($current_page == 1 ? 'disabled' : 'enabled')  ?> . ">
                                                            <a class="page-link" href="../search/?q=<?= $search_query ?>&page=<?= $current_page - 1 ?>" tabindex="-1" aria-disabled="true">Previous</a>
                                                        </li>
                                                        <?php for ($i = 1; $i <= $total_pages ; $i++) : ?>
                                                            <li class="page-item <?php echo ($current_page == $i ?: 'active') ?>">
                                                                <a class="page-link" href="../search/?q=<?= $search_query ?>&page=<?= $i ?>"><?= $i ?></a>
                                                            </li>
                                                        <?php endfor; ?>
                                                        <li class="page-item . <?php echo ($current_page == $total_pages  ? 'disabled' : 'enabled')  ?> . ">
                                                            <a class="page-link" href="../search/?q=<?= $search_query ?>&page=<?= $current_page + 1 ?>" tabindex="-1" aria-disabled="true">Next</a>
                                                        </li>
                                                    </ul>
                                                </nav>
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
    <script src="../assets/plugins/jquery/jquery-3.5.1.min.js"></script>
    <script src="../assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="../assets/plugins/perfectscroll/perfect-scrollbar.min.js"></script>
    <script src="../assets/plugins/pace/pace.min.js"></script>
    <script src="../assets/js/main.min.js"></script>
    <script src="../assets/js/custom.js"></script>
    <script src="../assets/js/pages/dashboard.js"></script>
</body>
</html>
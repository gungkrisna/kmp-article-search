
<?php
include '../src/conn.php';

// Get the ID from the URL
$id = $_GET['id'];

// Check if article id is empty
if ($id == '') {
    echo "<script>
    window.location.href='../';
    </script>";
}

// Retrieve the article from the database
$query = "SELECT judul, isi FROM dokumen WHERE id='$id'";
$result = mysqli_query($db, $query);

// Check if the query returned any results
if (mysqli_num_rows($result) == 0) {
    echo "<script>
    window.location.href='../';
    </script>";
  } else {
    // ID exists in the database
    // Continue with the rest of the script
    $article = mysqli_fetch_assoc($result);
  }

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
    <title><?= $article['judul']; ?> - Qubit Search</title>

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

    <link rel="icon" type="image/png" href="../assets/images/favicon.ico" />

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
                                <a href="../">QUBIT SEARCH</a>
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
                            <div class="page-description">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="../">Home</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Artikel</li>
                                    </ol>
                                </nav>
                                <h1><?= $article['judul']; ?></h1>
                                <span style="text-align:justify;"><?= $article['isi']; ?></span>
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
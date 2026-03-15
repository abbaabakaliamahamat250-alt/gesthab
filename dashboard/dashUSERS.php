<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="style/style.css">
   <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
   <link rel="stylesheet" href="style/boxicons.min.css">
   
    <title>Dashboard</title>
</head>
<body>
    <!--SIDEBAR-->
    <section id="sidebar">
        <a href="#" class="brand">
            <i class="bx bxs-smile"></i>
            <span class="text">ADMIN</span>
        </a>
        <ul class="side-menu top">
            <li class="active">
                <a href="#">
                    <i class="bx bxs-dashboard"></i>
                    <span class="text">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="bx bxs-shopping-bag-alt"></i>
                    <span class="text">Effectuer Demande</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="bx bxs-message-dots"></i>
                    <span class="text">Mes Demandes</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="bx bxs-doughnut-chart"></i>
                    <span class="text">Nofier</span>
                </a>
            </li>
        </ul>
        <ul class="side-menu">
        <li>
                <a href="#">
                    <i class="bx bxs-cog"></i>
                    <span class="text">setting</span>
                </a>
            </li><li>
                <a href="#" class="logout">
                    <i class="bx bxs-log-out-circle"></i>
                    <span class="text">logout</span>
                </a>
            </li>
        </ul>
    </section>
    <!--SIDEBAR-->

    <!-- CONTENT -->
     <section id="content">

         <!-- NAVBAR-->
            <nav>
                <i class="bx bx-menu"></i>
                <a href="#" class="nav-link">catregories</a>
                <form action="#">
                    <div class="form-input">
                        <input type="search" placeholder="search.....">
                        <button type="submit" class="search-btb"><i class="bx bx-search"></i></button>
                    </div>
                </form>
                <a href="#" class="notification">
                    <i class="bx bxs-bell "></i>
                    <span class="num">8</span>
                </a>
                <a href="#" class="profile">
                    <img style="width: 40px; height: 40px; bottom: 5000px;" src="img/img.jpg">
                </a>
            </nav>
         <!-- NAVBAR-->
<!-- MAIN-->
    <main>
        <div class="head-title">
            <div class="left">
                <h1>Dashboard</h1>
                <ul class="breadcrumb">
                    <li>
                        <a href="#">Dashboard</a>
                    </li>
                    <li><i class="bx bx-chevron-right"></i></li>
                    <li>
                        <a class="active" href="#">Home</a>
                    </li>
                </ul>
            </div>
         </div>
         <ul class="box-info">
            <li>
                <i class="bx bxs-group"></i>
                <span class="text">
                    <h3>09</h3>
                    <p>Direction Commerciale</p>
                </span>
            </li>
            <li>
                <i class="bx bxs-group"></i>
                <span class="text">
                    <h3>05</h3>
                    <p>Chef Hierarchique</p>
                </span>
            </li>
            <li>
                <i class="bx bxs-group"></i>
                <span class="text">
                    <h3>05</h3>
                    <p>Resource Humaine</p>
                </span>
            </li>
         </ul>
         <div class="table-data">
            <div class="order">
                <div class="head">
                    <h3>Direction Commerciale</h3>
                    <i class="bx bx-search"></i>
                    <i class="bx bx-filter"></i>
                </div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Email</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                            <img style="width: 40px; height: 40px; bottom: 5000px;" src="img/img2.jpg">
                                <p>john doe</p>
                            </td>
                            <td>123@gmail.com</td>
                            <td><span class="statuts complete">actif</span></td>
                        </tr>
                        <tr>
                            <td>
                            <img style="width: 40px; height: 40px; bottom: 5000px; " src="img/img2.jpg">
                                <p>john doe</p>
                            </td>
                            <td>123@gmail.com</td>
                            <td><span class="statuts non-actif">non-actif</span></td>
                        </tr>
                        <tr>
                            <td>
                            <img style="width: 40px; height: 40px; bottom: 5000px; " src="img/img2.jpg">
                                <p>john doe</p>
                            </td>
                            <td>123@gmail.com</td>
                            <td><span class="statuts complete">actif</span></td>
                        </tr>
                        <tr>
                            <td>
                            <img style="width: 40px; height: 40px; bottom: 5000px; " src="img/img2.jpg">
                                <p>M.Lazarus</p>
                            </td>
                            <td>123@gmail.com</td>
                            <td><span class="statuts non-actif">non-actif</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="order">
            <div class="head">
                    <h3>Resource Humaine</h3>
                    <i class="bx bx-plus"></i>
                    <i class="bx bx-filter"></i>
                </div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Email</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                            <img style="width: 40px; height: 40px; bottom: 5000px;" src="img/img1.jpg">
                                <p>john doe</p>
                            </td>
                            <td>abc@gmail.com</td>
                            <td><span class="statuts non-actif">non-actif</span></td>
                        </tr>
                        <tr>
                            <td>
                            <img style="width: 40px; height: 40px; bottom: 5000px; " src="img/img1.jpg">
                                <p>john doe</p>
                            </td>
                            <td>abc@gmail.com</td>
                            <td><span class="statuts complete">actif</span></td>
                        </tr>
                        <tr>
                            <td>
                            <img style="width: 40px; height: 40px; bottom: 5000px; " src="img/img1.jpg">
                                <p>john doe</p>
                            </td>
                            <td>abc@gmail.com</td>
                            <td><span class="statuts non-actif">non-actif</span></td>
                        </tr>
                        <tr>
                            <td>
                            <img style="width: 40px; height: 40px; bottom: 5000px; " src="img/img1.jpg">
                                <p>john doe</p>
                            </td>
                            <td>abc@gmail.com</td>
                            <td><span class="statuts complete">actif</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
         </div>
    </main>
    <!-- MAIN-->
    </section>
         <!-- CONTENT -->
    <script src="script.js"></script>
</body>
</html>
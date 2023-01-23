<html>
    <?php include '../parts/head.html'; ?>
    <style>
<?php include '../css/loginCSS.html'; ?>
    </style>
    <body>
        <?php
        include '../parts/header.php';
        require_once('../scripts/database.php');
        include('../scripts/get_user.php');
        include('../scripts/main_scr.php');
        $sql;
        ?>

        <section>
            <?php foreach ($logs as $log) : ?>
                <h1><?php echo $log["meno"] ?></h1>
                <div class="tbl-header">
                    <table cellpadding="0" cellspacing="0" border="0">
                        <form method="post">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
                                <input class="btn btn-primary" type="submit" name="Submit"></input>
                            </div>
                        </form>
                        <?php
                        $columns = array('meno', 'priezvisko', 'trieda', 'skrinka');
                        $column = isset($_GET['column']) && in_array($_GET['column'], $columns) ? $_GET['column'] : $columns[0];
                        $sort_order = isset($_GET['order']) && strtolower($_GET['order']) == 'desc' ? 'DESC' : 'ASC';
                        $id = isset($_GET["id"]) ? $_GET["id"] : "";
                        $up_or_down = str_replace(array('ASC', 'DESC'), array('up', 'down'), $sort_order);
                        $asc_or_desc = $sort_order == 'ASC' ? 'desc' : 'asc';
                        $add_class = ' class="highlight"';
                        $users = [];
                        ?>
                        <thead>
                            <tr>
                                <th><a href="main.php?id=<?php echo $id; ?>&column=meno&order=<?php echo $asc_or_desc; ?>">Meno<i class="fas fa-sort<?php echo $column == 'meno' ? '-' . $up_or_down : ''; ?>"></i></a></th>
                                <th><a href="main.php?id=<?php echo $id; ?>&column=priezvisko&order=<?php echo $asc_or_desc; ?>">Priezvisko<i class="fas fa-sort<?php echo $column == 'priezvisko' ? '-' . $up_or_down : ''; ?>"></i></a></th>
                                <th><a href="main.php?id=<?php echo $id; ?>&column=trieda&order=<?php echo $asc_or_desc; ?>">Trieda<i class="fas fa-sort<?php echo $column == 'trieda' ? '-' . $up_or_down : ''; ?>"></i></a></th>
                                <th><a href="main.php?id=<?php echo $id; ?>&column=skrinka&order=<?php echo $asc_or_desc; ?>">Skrinka<i class="fas fa-sort<?php echo $column == 'skrinka' ? '-' . $up_or_down : ''; ?>"></i></a></th>
                                <th>Upravit</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="tbl-content">
                    <table cellpadding="0" cellspacing="0" border="0">
                        <tbody>
                            <?php
                            if (isset($_POST['Submit'])) {
                                $search = mysqli_real_escape_string($conn, $_POST['search']);
                                $sqlu = "SELECT * FROM student WHERE `meno` LIKE '%$search%' OR `priezvisko` LIKE '%$search%' OR `trieda` LIKE '%$search%' OR `skrinka` LIKE '%$search%' AND idSkoly=$id ORDER BY $column $sort_order;";
                                $sql = $sqlu;
                                $results = mysqli_query($conn, $sqlu);
                                $queryResult = mysqli_num_rows($results);
                                if ($queryResult > 0) {
                                    // Loop through the result set and display the data
                                    while ($user = mysqli_fetch_array($results)) {
                                        ?>
                                        <tr>
                                            <td<?php echo $column == 'meno' ? $add_class : ''; ?>><?php echo $user["meno"] ?></td>
                                            <td<?php echo $column == 'priezvisko' ? $add_class : ''; ?>><?php echo $user["priezvisko"] ?></td>
                                            <td<?php echo $column == 'trieda' ? $add_class : ''; ?>><?php echo $user["trieda"] ?></td>
                                            <td<?php echo $column == 'skrinka' ? $add_class : ''; ?>><?php echo $user["skrinka"] ?></td>
                                            <td><a class="btn btn-primary" href="../sites/studentU.php<?php echo "?user=" . $user["id"]; ?>" >Upraviť</a></td>
                                        </tr><?php
                                    }
                                } else {
                                    echo "No results";
                                }
                            } else {
                                $sqln = "SELECT * FROM student WHERE idSkoly=$id ORDER BY $column $sort_order;";
                                $sql = $sqln;
                                $up_or_down = str_replace(array('ASC', 'DESC'), array('up', 'down'), $sort_order);
                                $asc_or_desc = $sort_order == 'ASC' ? 'desc' : 'asc';
                                $add_class = ' class="highlight"';
                                $results = mysqli_query($conn, $sql);
                                $queryResult = mysqli_num_rows($results);
                                while ($user = mysqli_fetch_array($results)) {
                                    ?>
                                    <tr>
                                        <td<?php echo $column == 'meno' ? $add_class : ''; ?>><?php echo $user["meno"] ?></td>
                                        <td<?php echo $column == 'priezvisko' ? $add_class : ''; ?>><?php echo $user["priezvisko"] ?></td>
                                        <td<?php echo $column == 'trieda' ? $add_class : ''; ?>><?php echo $user["trieda"] ?></td>
                                        <td<?php echo $column == 'skrinka' ? $add_class : ''; ?>><?php echo $user["skrinka"] ?></td>
                                        <td><a class="btn btn-primary" href="../sites/studentU.php<?php echo "?user=" . $user["id"]; ?>" >Upraviť</a></td>
                                    </tr><?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div>
                    <a class="btn btn-success" href="../sites/student.php<?php echo "?ids=" . $log["id"]; ?>" >Pridať</a>
                    <a class="btn btn-success" href="../parts/pdf.php?sql=<?php echo $sql;?>">Vytlačiť PDF</a>    
                </div>
            <?php endforeach ?>
        </section>
        <?php include '../parts/footer.php'; ?>
    </body>
</html>
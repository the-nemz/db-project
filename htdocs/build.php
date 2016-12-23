
<?php

    /**
     * File that take the user input and builds the query.
     */

    $joined = False;
    $where = False;

    $sort1 = $_POST['sort1'];
    $sort2 = $_POST['sort2'];

    if ($sort1 == "continent" || $sort1 == "population" ||
        $sort2 == "continent" || $sort2 == "population") {
        $ordjoin = True;
    } else {
        $ordjoin = False;
    }

    if ($ordjoin || $cont = $_POST['cont'] || $pop = $_POST['pop']) {
        $heads = array("genus_species", "commonnames", "continent",
                       "country", "population", "author", "year",
                       "venomous", "live_bearing");

        $joined = True;
        $qry = " (snake INNER JOIN country ON country=name)";

        if ($cont = $_POST['cont']) {
            if ($where) {
                $qry .= " AND continent='" . $cont . "'";
            } else {
                $qry .= " WHERE continent='" . $cont . "'";
                $where = True;
            }
            $heads = array_diff($heads, array("continent"));
        }
        if ($pop = $_POST['pop']) {
            if ($comp = $_POST['comp']) {
                $adder = "population" . $comp . $pop;
                if ($where) {
                    $qry .= " AND " . $adder;
                } else {
                    $qry .= " WHERE " . $adder;
                    $where = True;
                }
                if ($comp == "=") {
                    $heads = array_diff($heads, array("population"));
                }
            }
        } elseif ($sort1 != "population" && $sort2 != "population") {
            $heads = array_diff($heads, array("population"));
        }

    } else {
        $heads = array("genus_species", "commonnames", "country",
                       "author", "year", "venomous", "live_bearing");
        $qry = " snake";
    }


    if ($genus = $_POST['genus']) {
        if ($where) {
            $qry .= " AND genus='" . $genus . "'";
        } else {
            $qry .= " WHERE genus='" . $genus . "'";
            $where = True;
        }
    }
    if ($species = $_POST['species']) {
        if ($where) {
            $qry .= " AND species='" . $species . "'";
        } else {
            $qry .= " WHERE species='" . $species . "'";
            $where = True;
        }
    }
    if ($htaxa = $_POST['htaxa']) {
        if ($where) {
            $qry .= " AND high_taxa LIKE '%" . $htaxa . "%'";
        } else {
            $qry .= " WHERE high_taxa LIKE '%" . $htaxa . "%'";
            $where = True;
        }
        array_unshift($heads, "high_taxa");
    }
    if ($cname = $_POST['cname']) {
        if ($where) {
            $qry .= " AND commonnames LIKE '%" . $cname . "%'";
        } else {
            $qry .= " WHERE commonnames LIKE '%" . $cname . "%'";
            $where = True;
        }
    }
    if ($cnrty = $_POST['cnrty']) {
        if ($where) {
            $qry .= " AND country='" . $cnrty . "'";
        } else {
            $qry .= " WHERE country='" . $cnrty . "'";
            $where = True;
        }
        $heads = array_diff($heads, array("country", "population"));
    }
    if ($auth = $_POST['auth']) {
        if ($where) {
            $qry .= " AND author LIKE '%" . $auth . "%'";
        } else {
            $qry .= " WHERE author LIKE '%" . $auth . "%'";
            $where = True;
        }
    }
    if ($yeardis = $_POST['yeardis']) {
        if ($tframe = $_POST['tframe']) {
            $adder = "year" . $tframe . $yeardis;
            if ($where) {
                $qry .= " AND " . $adder;
            } else {
                $qry .= " WHERE " . $adder;
                $where = True;
            }
            if ($tframe == "=") {
                $heads = array_diff($heads, array("year"));
            }
        }
    }
    if ($venom = $_POST['venom']) {
        $adder = "venomous" . $venom;
        if ($where) {
            $qry .= " AND " . $adder;
        } else {
            $qry .= " WHERE " . $adder;
            $where = True;
        }
        $heads = array_diff($heads, array("venomous"));
    }
    if ($liveb = $_POST['liveb']) {
        $adder = "live_bearing" . $liveb;
        if ($where) {
            $qry .= " AND " . $adder;
        } else {
            $qry .= " WHERE " . $adder;
            $where = True;
        }
        $heads = array_diff($heads, array("live_bearing"));
    }

    if ($groupby = $_POST['group']) {
        $endqry = " GROUP BY genus_species ";
        $heads = array_diff($heads, array("country", "population"));
    } else {
        $endqry = "";
    }

    if ($sort1 = $_POST['sort1']) {

        $endqry .= " ORDER BY " . $sort1;
        if ($sort1dir = $_POST['sort1dir']) {
            $endqry .= " " . $sort1dir;
        }

        if ($sort2 = $_POST['sort2']) {
            $endqry .= ", " . $sort2;
            if ($sort2dir = $_POST['sort2dir']) {
                $endqry .= " " . $sort2dir;
            }
            if ($sort2 == "population") {
                $heads = array_diff($heads, array("country", "population"));
                array_unshift($heads, "country", "population");
            } else {
                $heads = array_diff($heads, array($sort2));
                array_unshift($heads, $sort2);
            }

        }

        if ($sort1 == "population") {
            $heads = array_diff($heads, array("country", "population"));
            array_unshift($heads, "country", "population");
        } else {
            $heads = array_diff($heads, array($sort1));
            array_unshift($heads, $sort1);
        }
    }

    $qrybeg = "SELECT " . implode(", ", $heads) . " FROM";
    $allqry = $qrybeg . $qry . $endqry;

    echo $allqry;

    session_start();
    $_SESSION['headers'] = $heads;
    $_SESSION['querystring'] = $allqry;

    header("Location: http://localhost/display.php"); /* Redirect browser */
    exit();

?>



<?php
    $con = mysqli_connect("my_db_host", "my_db_username", "my_db_pass", "my_db_name");

    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    $result = mysqli_query(
        $con,
        "SELECT * FROM hlstats_Servers
        WHERE serverId='2'"
    );
?>

<html>
    <head></head>
    <body>
        <table>
            <?php while ($row = mysqli_fetch_array($result)): ?>
                <?php $genus_species = $row['genus_species']; ?>
                <?php $high_taxa = $row['high_taxa']; ?>
                <?php $genus = $row['genus']; ?>
                <?php $species = $row['species']; ?>
                <?php $author = $row['author']; ?>
                <?php $year = $row['year']; ?>
                <?php $commonnames = $row['commonnames'] ; ?>
                <?php $country = $row['country']; ?>
                <?php $venomous = $row['venomous']; ?>
                <?php $live_bearing = $row['live_bearing']; ?>

                <tr>
                    <td>Paweriuhkae</td>
                    <td><?php echo $genus_species; ?></td>
                </tr>
                <tr>
                    <td>Ip cmd</td>
                    <td><?php echo $high_taxa; ?></td>
                </tr>
                <tr>
                    <td>Jelenlegi plya</td>
                    <td><?php echo $genus; ?></td>
                </tr>
                <tr>
                    <td>Dtkosok</td>
                    <td><?php echo $species; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </body>
</html>

<?php mysqli_close($con); ?>
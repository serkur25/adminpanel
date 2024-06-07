<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Oyun İncelemeleri</title>
        <link rel="stylesheet" href="style.css">
        <style>
        body {
            background-color: #333;
            color: white;
            font-family: Arial, sans-serif;
        }

        .main-banner {
            position: relative;
            width: 100%;
            height: 300px;
            background-size: cover;
            background-position: center;
            margin-bottom: 20px;
            display: flex;
            align-items: flex-end;
            justify-content: flex-start;
        }

        .main-banner h1 {
            background: rgba(0, 0, 0, 0.7);
            padding: 15px;
            border-radius: 5px;
            font-size: 2em;
            color: yellow;
            margin: 20px;
        }

        .haberler {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            justify-content: center;
        }

        .haber {
            display: flex;
            flex-direction: column;
            width: calc(45% - 15px);
            background-color: #444;
            border-radius: 10px;
            overflow: hidden;
            text-align: left;
            position: relative;
            border: 2px solid #555;
            transition: transform 0.3s;
        }

        .haber img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            background-color: #222;
            transition: filter 0.3s;
        }

        .haber:hover img {
            filter: brightness(50%);
        }

        .haber-content {
            padding: 10px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .haber h2 {
            font-size: 1.3em;
            margin: 0 0 10px 0;
        }

        .haber p {
            margin: 0 0 10px 0;
        }

        .haber a {
            color: white;
            text-decoration: none;
            position: absolute;
            bottom: 10px;
            right: 10px;
            background: rgba(0, 0, 0, 0.7);
            padding: 5px 10px;
            border-radius: 5px;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .haber:hover a {
            opacity: 1;
        }

        section.abone-ol,
        footer {
            text-align: center;
            color: white;
            margin-top: 20px;
        }

        footer {
            margin-top: 50px;
            padding: 20px;
            background-color: #222;
        }

        .sosyal-medya {
            margin-top: 10px;
        }

        .sosyal-medya a {
            margin-right: 10px;
        }

        .sosyal-medya img {
            width: 30px;
            height: 30px;
        }
        </style>
    </head>

    <body>
        <?php include 'navbar.html'; ?>

        <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "oyun_incelemeleri";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Bağlantı hatası: " . $conn->connect_error);
    }

    $sql_latest = "SELECT id, gorsel_url, baslik, aciklama FROM haberler ORDER BY id DESC LIMIT 1";
    $result_latest = $conn->query($sql_latest);

    if ($result_latest->num_rows > 0) {
        $latest_game = $result_latest->fetch_assoc();
        echo '<div class="main-banner" style="background-image: url(' . $latest_game["gorsel_url"] . ');">';
        echo '<h1>' . $latest_game["baslik"] . '</h1>';
        echo '</div>';
    } else {
        echo "En son eklenen haber bulunamadı.";
    }
    ?>

        <div class="haberler">
            <?php
        $sql = "SELECT id, gorsel_url, baslik, aciklama FROM haberler WHERE id != " . $latest_game["id"] . " ORDER BY id DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $short_description = substr($row["aciklama"], 0, 100) . '...';
                echo '<div class="haber">';
                echo '<img src="' . $row["gorsel_url"] . '" alt="' . $row["baslik"] . '">';
                echo '<div class="haber-content">';
                echo '<h2>' . $row["baslik"] . '</h2>';
                echo '<p>' . $short_description . '</p>';
                echo '<a href="haberdetay.php?id=' . $row["id"] . '">Haberi Oku</a>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo "Hiç haber bulunamadı.";
        }
        $conn->close();
        ?>
        </div>

        <footer>
            <div class="sosyal-medya">
                <a href="#"><img src="facebook-icon.png" alt="Facebook"></a>
                <a href="#"><img src="twitter-icon.png" alt="Twitter"></a>
                <a href="#"><img src="instagram-icon.png" alt="Instagram"></a>
            </div>
            <p>&copy; 2024 Oyun İnceleme Sitesi. Tüm Hakları Saklıdır.</p>
        </footer>
    </body>

</html>
<?php include ('./inc/functions.php') ?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assignment 1 - PHP and MySQL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="./css/style.css" rel="stylesheet">
    <script>
        function showDecklist(id) {
            let deck = document.getElementById("decklist-" + id);
            deck.classList.toggle("closed");
        }
    </script>
</head>

<body class="container">
    <h1>PHP Database Connection - Kwasi Apenteng</h1>
    <?php
    $connect = mysqli_connect("localhost", "root", "root", "http5225");
    if (!$connect) {
        echo 'Error code: ' . mysqli_connect_errno();
        echo 'Error code: ' . mysqli_connect_error();
        exit;
    }
    ?>
    <div class="container">
        <h2>All Structure Decks</h2>
        <div class="row">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Prefix</th>
                        <th scope="col">Name</th>
                        <th scope="col">Release Date</th>
                        <th scope="col">Cards</th>
                        <th scope="col">Decklist</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    //Getting the only deck with a decklist in the currecntly in the database (hardcoded)
                    $query = 'SELECT * FROM ygo_products WHERE id = 116';
                    $results = mysqli_query($connect, $query);
                    if (!$results) {
                        echo 'Error Message' . mysqli_error($connect);
                    } else {
                        $deck = mysqli_fetch_assoc($results);
                        echo "
                        <tr>
                            <th scope = 'row'>{$deck['code']}</th>
                            <td>{$deck['name']}</td>
                            <td>{$deck['released']}</td>
                            <td>{$deck['cards']}</td>
                            <td><button onclick='showDecklist({$deck['id']})'>View</button></td>
                        </tr>";
                        echo "<tr id='decklist-{$deck['id']}' class='closed'>";
                    }
                    ?>
                    <td colspan="5">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Card Number</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Attribute</th>
                                    <th scope="col">Level/Rank/Rating</th>
                                    <th scope="col">Attack</th>
                                    <th scope="col">Defense</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                //Main Deck monster cards
                                $query = 'SELECT *
                                            FROM monster_cards
                                            WHERE set_number=116 AND fusion=0 AND synchro=0 AND xyz=0 AND link=0
                                            ORDER BY number';
                                $result = mysqli_query($connect, $query);
                                if (!$result) {
                                    echo 'Error Message' . mysqli_error($connect);
                                } else {
                                    createMonsterCards($result);
                                }

                                //Main Deck spell and trap cards
                                $query = 'SELECT *
                                            FROM spell_trap_cards
                                            WHERE set_number=116
                                            ORDER BY number';
                                $result = mysqli_query($connect, $query);
                                if (!$result) {
                                    echo 'Error Message' . mysqli_error($connect);
                                } else {
                                    createSpellTrapCards($result);
                                }

                                //Extra deck cards
                                $query = 'SELECT *
                                            FROM monster_cards
                                            WHERE set_number=116 AND (fusion=1 OR synchro=1 OR xyz=1 OR link=1)
                                            ORDER BY number';
                                $result = mysqli_query($connect, $query);
                                if (!$result) {
                                    echo 'Error Message' . mysqli_error($connect);
                                } else {
                                    createMonsterCards($result);
                                }
                                ?>
                            </tbody>
                        </table>
                    </td>
                    </tr>
                    <?php
                    //Getting the rest of the structure decks
                    $query = 'SELECT * FROM ygo_products WHERE id != 116';
                    $result = mysqli_query($connect, $query);
                    if (!$result) {
                        echo 'Error Message' . mysqli_error($connect);
                    } else {
                        foreach ($result as $row) {
                            echo
                                "<tr>
                                <th scope = 'row'>{$row['code']}</th>
                                <td>{$row['name']}</td>
                                <td>{$row['released']}</td>
                                <td>{$row['cards']}</td>
                                <td><button disabled>View</button></td>
                            </tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
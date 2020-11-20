<?php
    include('data_connection.php');
    $query = "SELECT * FROM Utilisateur ORDER BY id";
    $statement = $connect->prepare($query);
    if ($statement->execute()) {
        # code...
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            # code...
            $data[] = $row;
        }
        echo json_encode($data);
    }
?>
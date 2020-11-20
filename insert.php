<?php

    include('data_connection.php');
    $form_data = json_decode(file_get_contents("php://input"));
    $error = '';
    $message = '';
    $validation_error= '';
    $nom = '';
    $prénom = '';
    $email = '';
    $date_creation = '';
    $date_modification = '';
    if ($form_data->action == 'fetch_single_data') {
        # code...
        $query = "SELECT * FROM Utilisateur WHERE id ' ".$form_data->id."'";
    } else {
        # code...
        if (empty($form_data->nom)) {
            # code...
            $error[] = 'la case de nom ne doit pas être vide';
            $statement = $connect-> prepare($query);
            $statement->execute();
            $result = $statement->fetchAll();
            foreach ($result as $row) {
                # code...
                $output['nom'] = $row['nom'];
                $output['prénom'] = $row['prénom'];
                $output['email'] = $row['email'];
            }
        } else {
            # code...
            $nom = $form_data->$nom;
        }
        if (empty($form_data->$prénom)) {
            # code...
            $error[] = 'la case de prénom ne doit pas être vide';
    
        } else {
            # code...
            $prénom = $form_data->$prénom;
        }
        if (empty($form_data->email)) {
            # code...
            $error[] = 'la case email ne doit pas être vide';
    
        } else {
            # code...
            $email = $form_data->$email;
        }
        if (empty($error)) {
            # code...
            if ($form_data->action == 'Insert') {
                # code...
                $data = array(
                    ':nom' =>$nom,
                    ':prénom' =>$prénom,
                    ':email' =>$email,
                    ':date_creation' =>$date_creation,
                    ':date_modification' =>$date_modification,
                );
                $query = "
                INSERT INTO Utilisateur 
                (nom,prénom,email,date_creation,date_modification) VALUES
                (:nom,prénom,:email,:date_creation,:date_modification)
                ";
                $statement = $connect->prepare($query);
                if ($statement->execute()) {
                    # code...
                    $message = "votre donnée a été bien enregistrer";
                }
            }
            if ($form_data->action == 'Edit') {
                # code...
                $data = array(
                    ':nom' =>$nom,
                    ':prénom' =>$prénom,
                    ':email' =>$email,
                    ':date_creation' =>$date_creation,
                    ':date_modification' =>$date_modification,
                    ':id' => $form_data->id,
                );
                $query = "
                    UPDATE Utilisateur
                    SET  nom = :nom , prénom = :prénom, email = :email
                    WHERE id = :id
                ";
                $statement = $connect->prepare($query);
                if ($statement->execute($data)) {
                    # code...
                    $output['message'] = "votre donnée a été bien éditer"
                }
            }
    
        } else {
            # code...
            $validation_error = implode(", ", $error);
        }
        $output = array(
            'error' => $validation_error,
            'message' => $message,
        );
}
 
 echo json_encode($output);
?>
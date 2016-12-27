<?php
    include 'include/init.php';
    if (isset($_POST['id']))
    {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $id = $_POST['id'];

        $query = "SELECT * FROM fbusers WHERE fbid = $id";
        $results = $database->get_results( $query );
        if(count($results) == 0)
        {
            $data = array(
                'username' => $name,
                'email' => $email,
                'fbid' => $id
                );
            $add_query = $database->insert( 'fbusers', $data );
            if( $add_query )
            {
                return 1;
            }
        }
        else
        {
            return 0;
        }
    }
<?php
    function OpenDatabase()
    {
        // database credentials
        $dbhost = 'ec2-54-225-68-71.compute-1.amazonaws.com';
        $dbname = 'd3ar7t8tetdrcf';
        $dbuser = 'dsopbqzhyxbsde';
        $dbpass = 'b86d277ac2d5a0ef1f262c137b63d43e4811fd71abc6c4fa59db3452d2dfd8bf';

        // open a connection to the database server
        $connection = pg_pconnect ( "host='$dbhost' dbname='$dbname' user='$dbuser' password='$dbpass'" );

        if ( !$connection )
        {
            die ( "Could not open connection to database server!" );
        }

        return $connection;
    }

    function QueryDatabase ( $connection, $query )
    {
        $result = pg_query ( $connection, $query ) or die ( "Error in query: '$query' (" . pg_last_error ( $connection ) . ')' );

        return $result;
    }

    function GetNumRows ( $result )
    {
        return pg_numrows ( $result );
    }

    function ReadField ( $result, $row, $field )
    {
        return pg_result ( $result, $row, '"' . $field . '"' );
    }

    function CloseDatabase ( $connection )
    {
        pg_close ( $connection );
    }
?>

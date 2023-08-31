<!DOCTYPE html>
<html>
    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script> 
        <link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="/main.css">
        <script type="text/javascript" src="/wonde_app.js"></script>
        <script type="text/javascript" src="//cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

        <style>
            .loader {
                border: 16px solid #f3f3f3; /* Light grey */
                border-top: 16px solid #3498db; /* Blue */
                border-radius: 50%;
                width: 120px;
                height: 120px;
                animation: spin 2s linear infinite;
                margin:0 auto;
            }

            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
        </style>
    </head>
    <body>
<?php
    $employee_exists = 0;
    include_once('constants.php');
    $name = explode(' ', $_POST["name"]);

    require __DIR__."/vendor/autoload.php";

    //connect to api
    $client = new \Wonde\Client(constants::API_KEY);

    //request access to data
    $client->requestAccess(constants::SCHOOL_ID);

    // Get single school
    $school = $client->school(constants::SCHOOL_ID);

    // Get employees
    foreach ($school->employees->all() as $employee) {
        if($employee->forename == $name[0] && $employee->surname == $name[1]){
            echo '<h1>'.$employee->forename . ' ' . $employee->surname . " ($employee->id)</h1>";

            $employee_details = $school->employees->get($employee->id,['classes']);
            $employee_exists = 1;
        }
    }
    

?>
        <div id="main" style="visibility: hidden;">
<?php if($employee_exists == 1){ ?>
            <table id="wonde_table" class="display nowrap">
                <thead>
                    <tr>
                        <td></td>
                        <td>Class Name</td>
                        <td>Subject</td>
                        <td style="display:none;">Attendees</td>
                    </tr>
                </thead>
                <tbody>
<?php 
    foreach($employee_details->classes as $classes)
    {
        foreach($classes as $class)
        {
            $class_details = $school->classes->get($class->id,['students']);

            echo "<td></td><td>$class_details->name</td><td>$class_details->subject</td><td style='display:none;'>";

            foreach($class_details->students->data as $student)
            {
                echo $student->forename . ' ' . $student->surname.'<br>';
            }
            echo "</td></tr>";
        }
    }
?>
                </tbody>
            </table>
<?php 
    }
    else
    { 
        echo "<h1>There are no employees by that name</h1>"; 
    }
?>
        </main>
    </body>
</html>
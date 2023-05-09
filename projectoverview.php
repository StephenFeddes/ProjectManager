<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Project Overview</title>
    <style>
        img[src="https://cdn.000webhost.com/000webhost/logo/footer-powered-by-000webhost-white2.png" ]
        {display:none;}
    </style>
  </head>
  
<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark" aria-label="Fifth navbar example">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">SoftCo</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar"
                aria-controls="navbarsExample05" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbar">
                <div class="navbar-nav me-auto mb-2 mb-lg-0">
                    <a class="nav-link" aria-current="players" href="createproject.php">Create Project</a>
                    <a class="nav-link" href="updateproject.php">Update Project</a>
                    <a class="nav-link" href="dropproject.php">Drop Project</a>
                    <a class="nav-link" href="projectoverview.php">Project Overview</a>
                </div>
                <div class="navbar-nav ms-auto">
                    <a class="nav-link" aria-current="page" href="departments.php">Departments</a>
                    <a class="nav-link" aria-current="page" href="employees.php">Employees</a>
                    <a class="nav-link" aria-current="page" href="createemployee.php">Create Employee</a>
                    <a class="nav-link" aria-current="page" href="dropemployee.php">Drop Employee</a>
                    <a class="nav-link" aria-current="page" href="assignemployee.php">Assign Employee</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="row">
      <div class="col-md-6 mx-auto">
        <div class="card card-body bg-light mt-5">
          <h2>Project Overview</h2>
          <p>Input a project name to examine its details</p>
        
          <form action="projectoverview.php" method="post">


            <div class="form-group">
                <label for="ProjectName">Project Name:</label>
                <input type="text" name="ProjectName" class="form-control form-control-lg">
            </div>

            <div class="row">
              <div class="col">
                <input type="submit" value="Select" class="btn btn-primary btn-block">
              </div>
            </div>
          </form>
        </div>
      </div>
    </div> 

    <div class="px-4 py-5 my-5 text-center">

        <?php include 'connection.php';
        
            // Does not let users see an error on the webpage
            ini_set('display_errors', 0);

            # Gets the user input from the forms and stores it an array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            # Trims the user input and adds it to a new array
            $data = [
            "ProjectName" => trim($_POST["ProjectName"]),
            ];

            // Get general project info
            $sql = "SELECT ProjectID, PatronCompanyName, Budget, DueDate FROM project WHERE ProjectName = ?";
            $statement1 = $conn->prepare($sql);
            $statement1->bindValue(1, $data["ProjectName"]);
            $statement1->execute();
            $row1 = $statement1->fetch();
            
            // This code should only run if the user has entered a project name
            if ($data["ProjectName"] != "") {
                echo "Project <b>$data[ProjectName]</b>, sponsored by <b>$row1[PatronCompanyName]</b>, has a budget of <b>$$row1[Budget]</b> and is due by <b>$row1[DueDate]</b> <br>";
                echo "<h2>The employees in this project are:</h2>";
              }

            $sql = "SELECT FirstName, LastName, E.EmployeeID, DepartmentName
                FROM employee AS E
                INNER JOIN department AS D
                ON E.DepartmentID = D.DepartmentID 
                INNER JOIN employeeproject AS EP
                ON E.EmployeeID = EP.EmployeeID
                WHERE EP.ProjectID = ?";

            $statement2 = $conn->prepare($sql);
            $statement2->bindValue(1, $row1["ProjectID"]);
            $statement2->execute();

            // This code will not run if the user has not entered a project name
            // Echo the projects employee/department info
            while ($row2 = $statement2->fetch() AND $row1["ProjectID"] != "") {
                echo "<p><b>$row2[FirstName] $row2[LastName] </b> with employee ID <b>$row2[EmployeeID]</b> from <b>$row2[DepartmentName]</b></p>";
            }
        ?>
    </div>



    <div class="px-4 py-5 my-5 text-center">
        <h1 class="fw-bold" style="margin: 0px">Projects:</h1>
        <?php
            $sql = "SELECT ProjectName FROM project";
            $statement = $conn->query($sql);

            // Echo all the current projects available
            while ($row = $statement->fetch()) {
              echo "<div class='container-fluid'><b>$row[ProjectName]</b></div>";
              }
        ?>
    </div>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>

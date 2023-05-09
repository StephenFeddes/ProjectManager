<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Assign Employee</title>
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
          <h2>Assign Employee</h2>
          <p>Select an Employee ID and project name to assign an employee to a project</p>
        
          <form action="assignemployee.php" method="post">


            <div class="form-group">
                <label for="ProjectName">Project Name:</label>
                <input type="text" name="ProjectName" class="form-control form-control-lg">
            </div>
            <div class="form-group">
                <label for="EmployeeID">Employee ID:</label>
                <input type="number" name="EmployeeID" class="form-control form-control-lg">
            </div>

            <div class="row">
              <div class="col">
                <input type="submit" value="Assign" class="btn btn-primary btn-block">
              </div>
            </div>
          </form>
        </div>
      </div>
    </div> 

<?php include 'connection.php';
    // Does not let users see an error on the webpage
    ini_set('display_errors', 0);

    # Gets the user input from the forms and stores it in an array
    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

    # Trims the user input and adds it to a new array
    $data = [
      "ProjectName" => trim($_POST["ProjectName"]),
      "EmployeeID" => trim($_POST["EmployeeID"]),
    ];

    $sql = "SELECT ProjectID FROM project WHERE ProjectName = ?";
    $statement = $conn->prepare($sql);
    $statement->bindValue(1, $data["ProjectName"]);
    $statement->execute();

    // Assign employees to projects by adding them to the EmployeeProject Table
    while ($row = $statement->fetch()) {
        $data["ProjectName"] = (int) $row["ProjectID"];

        $sql = "INSERT INTO employeeproject (ProjectID, EmployeeID) VALUES (?, ?)";
        
        $statement = $conn->prepare($sql);
        $statement->bindValue(1, $data["ProjectName"]);
        $statement->bindValue(2, $data["EmployeeID"]);
        $statement->execute();
    }
?>

<div class="px-4 py-5 my-5 text-center">
    <h1 class="fw-bold" style="margin: 0px">Employees:</h1>

    <div style="margin: 20px">
      <?php
        ini_set('display_errors', 0);
          
        $sql = "SELECT FirstName, LastName, EmployeeID, DepartmentID FROM employee";
        $statement = $conn->query($sql);

        while ($row = $statement->fetch()) {
          $sql = "SELECT DepartmentName FROM department WHERE DepartmentID = $row[DepartmentID] ";
          $statement1 = $conn->query($sql);
          $row1 = $statement1->fetch();
            
          echo "<div class='container-fluid'><b>$row[FirstName] $row[LastName]</b> from <b>$row1[DepartmentName]</b> has employee ID <b>$row[EmployeeID]</b></div>";
        }
      ?>
    </div>
  </div>

  <div class="px-4 py-5 my-5 text-center">
    <h1 class="fw-bold" style="margin: 0px">Projects:</h1>

        <div style="margin: 20px">
            <?php
                $sql = "SELECT ProjectName FROM project";
                $statement = $conn->query($sql);

                // Display current projects
                while ($row = $statement->fetch()) {
                echo "<div class='container-fluid'><b>$row[ProjectName]</b></div>";
                }
            ?>
        </div>
    </div>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
  </script>
</body>
</html>

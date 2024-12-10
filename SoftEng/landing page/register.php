<?php
include '../connection.php';

$collegesQuery = "SELECT DISTINCT college FROM courses";
$collegesStmt = $con->prepare($collegesQuery);
$collegesStmt->execute();
$existingColleges = $collegesStmt->fetchAll(PDO::FETCH_COLUMN);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $studentNumber = $_POST['student_number'];
    $lastName = $_POST['last_name'];
    $firstName = $_POST['first_name'];
    $middleName = $_POST['middle_name'];
    $college = $_POST['college'];
    $department = $_POST['department'];
    $section = $_POST['section'];
    $yearGraduated = $_POST['year_graduated'];
    $contactNumber = $_POST['contact_number'];
    $personalEmail = $_POST['personal_email'];
    $employment = $_POST['employment'];
    $employmentStatus = $_POST['employment_status'];
    $presentOccupation = $_POST['present_occupation'];
    $nameOfEmployer = $_POST['name_of_employer'];
    $addressOfEmployer = $_POST['address_of_employer'];
    $numberOfYearsInPresentEmployer = $_POST['number_of_years_in_present_employer'];
    $typeOfEmployer = $_POST['type_of_employer'];
    $majorLineOfBusiness = $_POST['major_line_of_business'];
    $email = $_POST['email'];
    $password = $_POST['pass'];
    $confirmPassword = $_POST['conPass'];

    if ($password !== $confirmPassword) {
        echo "<script>alert('Passwords do not match!');</script>";
    } else {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert into the database
        $stmt = $con->prepare("INSERT INTO users (student_number, last_name, first_name, middle_name, college, department, section, year_graduated, contact_number, personal_email, employment, employment_status, present_occupation, name_of_employer, address_of_employer, number_of_years_in_present_employer, type_of_employer, major_line_of_business, email, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        try {
            if ($stmt->execute([$studentNumber, $lastName, $firstName, $middleName, $college, $department, $section, $yearGraduated, $contactNumber, $personalEmail, $employment, $employmentStatus, $presentOccupation, $nameOfEmployer, $addressOfEmployer, $numberOfYearsInPresentEmployer, $typeOfEmployer, $majorLineOfBusiness, $email, $hashedPassword])) {
                echo "<script>alert('Registration successful! Redirecting to login page.');</script>";
                header("Location: index.php");
                exit;
            } else {
                echo "<script>alert('Registration failed! Please try again.');</script>";
            }
        } catch (PDOException $e) {
            echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Alumni</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <link rel="stylesheet" href="../assets/css/reg.css">
</head>

<body>
    <div class="container form-container mt-5">
        <header class="mb-4">Register Alumni</header>
        <form action="register.php" method="POST" class="form">
            <div class="mb-3">
                <div class="col-md-4">
                    <label for="student-number" class="form-label">Student Number</label>
                    <input type="text" id="student-number" name="student_number" class="form-control" required autocomplete="student-number">
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" required autocomplete="family-name">
                    </div>
                    <div class="col-md-4">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" required autocomplete="given-name">
                    </div>
                    <div class="col-md-4">
                        <label for="middle_name" class="form-label">Middle Name</label>
                        <input type="text" class="form-control" id="middle_name" name="middle_name" autocomplete="additional-name">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="college" class="form-label">College</label>
                        <select class="form-control" id="college" name="college" required>
                            <option value="">Select College</option>
                            <?php foreach ($existingColleges as $college): ?>
                                <option value="<?= htmlspecialchars($college) ?>"><?= htmlspecialchars($college) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="department" class="form-label">Department</label>
                        <select class="form-control" id="department" name="department" required>
                            <option value="">Select Department</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="section" class="form-label">Section</label>
                        <select class="form-control" id="section" name="section" required>
                            <option value="">Select Section</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="year_graduated" class="form-label">Year Graduated</label>
                        <input type="text" class="form-control" id="year_graduated" name="year_graduated" required>
                    </div>
                    <div class="col-md-4">
                        <label for="contact_number" class="form-label">Contact Number</label>
                        <input type="text" class="form-control" id="contact_number" name="contact_number" required>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="email" class="form-label">Personal Email</label>
                            <input type="email" class="form-control" id="email" name="email" required autocomplete="email">
                        </div>
                        <div class="col-md-4">
                            <label for="pass" class="form-label">Password</label>
                            <input type="password" class="form-control" id="pass" name="pass" required autocomplete="new-password">
                        </div>
                        <div class="col-md-4">
                            <label for="conPass" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="conPass" name="conPass" required autocomplete="new-password">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="employment" class="form-label">Employment</label>
                        <select id="employment" name="employment" class="form-control" required onchange="toggleEmploymentFields()">
                            <option value="">Select Employment</option>
                            <option value="Employed">Employed</option>
                            <option value="Self-employed">Self-employed</option>
                            <option value="Actively looking for a job">Actively Looking for a Job</option>
                            <option value="Never been employed">Never Been Employed</option>
                        </select>
                    </div>
                    <div class="col-md-6" id="employment-status-container" style="display: none;">
                        <label for="employment_status" class="form-label">Employment Status</label>
                        <select id="employment_status" name="employment_status" class="form-control">
                            <option value="">Select Employment Status</option>
                            <option value="Regular/Permanent">Regular/Permanent</option>
                            <option value="Casual">Casual</option>
                            <option value="Contractual">Contractual</option>
                            <option value="Temporary">Temporary</option>
                            <option value="Part-time (seeking full-time)">Part-time (seeking full-time)</option>
                            <option value="Part-time (but not seeking full-time)">Part-time (but not seeking full-time)</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                </div>

                <div id="employmentFields" style="display: none;">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="present_occupation" class="form-label">Present Occupation</label>
                            <input type="text" class="form-control" id="present_occupation" name="present_occupation">
                        </div>
                        <div class="col-md-4">
                            <label for="name_of_employer" class="form-label">Name of Employer</label>
                            <input type="text" class="form-control" id="name_of_employer" name="name_of_employer">
                        </div>
                        <div class="col-md-4">
                            <label for="address_of_employer" class="form-label">Address of Employer</label>
                            <input type="text" class="form-control" id="address_of_employer" name="address_of_employer">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="number_of_years_in_present_employer" class="form-label">Years in Present Employer</label>
                            <input type="number" class="form-control" id="number_of_years_in_present_employer" name="number_of_years_in_present_employer">
                        </div>
                        <div class="col-md-4">
                            <label for="type_of_employer" class="form-label">Type of Employer</label>
                            <input type="text" class="form-control" id="type_of_employer" name="type_of_employer">
                        </div>
                        <div class="col-md-4">
                            <label for="major_line_of_business" class="form-label">Major Line of Business</label>
                            <input type="text" class="form-control" id="major_line_of_business" name="major_line_of_business">
                        </div>
                    </div>
                </div>

                <div class="button-container d-flex justify-content-between mt-4">
                    <button type="button" class="btn btn-secondary" onclick="history.back()">Back</button>
                    <button type="submit" class="btn btn-primary">Register</button>
                </div>

        </form>
    </div>

    <script>
        function toggleEmploymentFields() {
            const employment = document.getElementById("employment").value;
            const employmentStatusContainer = document.getElementById("employment-status-container");
            const employmentFields = document.getElementById("employmentFields");
            const employmentStatus = document.getElementById("employment_status");

            if (employment === "Employed") {
                employmentStatusContainer.style.display = "block";
                employmentFields.style.display = "block";
                employmentStatus.required = true;
            } else {
                employmentStatusContainer.style.display = "none";
                employmentFields.style.display = "none";
                employmentStatus.required = false;
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const collegeSelect = document.getElementById('college');
            const departmentSelect = document.getElementById('department');
            const sectionSelect = document.getElementById('section');

            collegeSelect.addEventListener('change', function() {
                updateDepartments(this.value);
            });

            departmentSelect.addEventListener('change', function() {
                updateSections(this.value);
            });
        });

        function updateDepartments(college) {
            const departmentSelect = document.getElementById('department');
            const sectionSelect = document.getElementById('section');

            departmentSelect.innerHTML = '<option value="">Select Department</option>';
            sectionSelect.innerHTML = '<option value="">Select Section</option>';

            if (college) {
                fetch(`../dashboard/get_departments.php?college=${encodeURIComponent(college)}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        data.forEach(department => {
                            const option = document.createElement('option');
                            option.value = department;
                            option.textContent = department;
                            departmentSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error fetching departments:', error));
            }
        }

        function updateSections(department) {
            const sectionSelect = document.getElementById('section');

            sectionSelect.innerHTML = '<option value="">Select Section</option>';

            if (department) {
                fetch(`../dashboard/get_sections.php?department=${encodeURIComponent(department)}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        data.forEach(section => {
                            const option = document.createElement('option');
                            option.value = section;
                            option.textContent = section;
                            sectionSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error fetching sections:', error));
            }
        }
    </script>

</body>

</html>

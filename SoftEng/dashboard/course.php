<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courses</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" crossorigin="anonymous" />
</head>
<body class="bg-content">
    <main class="dashboard d-flex">
        <?php include "component/sidebar.php"; ?>
        <div class="container-fluid px-4">
            <?php include "component/header.php"; ?>

            <div class="mt-3">
                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addCourseModal">
                    Add Course
                </button>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>College</th>
                            <th>Department</th>
                            <th>Section</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT id, college, department, section FROM courses ORDER BY college, department, section";
                        $stmt = $con->prepare($query);
                        $stmt->execute();
                        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        if ($results) {
                            $lastCollege = '';
                            $lastDepartment = '';

                            foreach ($results as $row) {
                                $collegeDisplay = ($lastCollege !== $row['college']) ? $row['college'] : '';
                                $departmentDisplay = ($lastDepartment !== $row['department']) ? $row['department'] : '';

                                echo "<tr>
                                    <td>{$collegeDisplay}</td>
                                    <td>{$departmentDisplay}</td>
                                    <td>{$row['section']}</td>
                                    <td>
                                        <button class='btn btn-warning btn-sm' 
                                            data-bs-toggle='modal' 
                                            data-bs-target='#editCourseModal'
                                            data-id='{$row['id']}' 
                                            data-college='{$row['college']}'
                                            data-department='{$row['department']}'
                                            data-section='{$row['section']}'>
                                            Edit
                                        </button>
                                        <form method='POST' style='display:inline;' onsubmit='return confirm(\"Are you sure?\");'>
                                            <input type='hidden' name='delete_id' value='{$row['id']}'>
                                            <button type='submit' class='btn btn-danger btn-sm'>Delete</button>
                                        </form>
                                    </td>
                                </tr>";

                                $lastCollege = $row['college'];
                                $lastDepartment = $row['department'];
                            }
                        } else {
                            echo "<tr><td colspan='4'>No courses available.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Add Course Modal -->
    <div class="modal fade" id="addCourseModal" tabindex="-1" aria-labelledby="addCourseModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addCourseModalLabel">Add Course</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="CollegeName" class="form-label">College</label>
                            <input type="text" class="form-control" id="CollegeName" name="CollegeName" required>
                        </div>
                        <div class="mb-3">
                            <label for="DepartmentName" class="form-label">Department</label>
                            <input type="text" class="form-control" id="DepartmentName" name="DepartmentName" required>
                        </div>
                        <div class="mb-3">
                            <label for="SectionName" class="form-label">Section</label>
                            <input type="text" class="form-control" id="SectionName" name="SectionName[]" required>
                        </div>
                        <div id="additionalSections"></div>
                        <button type="button" class="btn btn-secondary btn-sm" id="addSectionBtn">Add Section</button>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="../assets/js/bootstrap.bundle.js"></script>
    <script>
        const addSectionBtn = document.getElementById('addSectionBtn');
        const additionalSections = document.getElementById('additionalSections');

        addSectionBtn.addEventListener('click', () => {
            const sectionInput = document.createElement('input');
            sectionInput.type = 'text';
            sectionInput.name = 'SectionName[]';
            sectionInput.className = 'form-control mt-2';
            sectionInput.placeholder = 'Enter another section name';
            additionalSections.appendChild(sectionInput);
        });

        const editCourseModal = document.getElementById('editCourseModal');
        editCourseModal.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const college = button.getAttribute('data-college');
            const department = button.getAttribute('data-department');
            const section = button.getAttribute('data-section');

            document.getElementById('editCourseId').value = id;
            document.getElementById('editCollegeName').value = college;
            document.getElementById('editDepartmentName').value = department;
            document.getElementById('editSectionName').value = section;
        });
    </script>
</body>
</html>

<?php require_once '../classes/middlewares.php'; ?>
<?php require_once '../classes/crud.php'; ?>
<?php middleware::session(["id"], "admin/index.php", false); ?>
<!-- Navigation-->
<nav class="navbar navbar-expand-lg navbar-dark bg-default fixed-top" id="mainNav">
    <a class="navbar-brand p-2" href="index.php">
        <b>LMS</b>
    </a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">

            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
                <a class="nav-link" href="dashboard.php">
                    <i class="fa fa-fw fa-dashboard"></i>
                    <span class="nav-link-text">Dashboard</span>
                </a>
            </li>

            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Classes">
                <a class="nav-link" href="classes.php">
                    <i class="fa fa-fw fa-calendar"></i>
                    <span class="nav-link-text">Classes</span>
                </a>
            </li>
            <?php if ($_SESSION["role"] == "Admin") : ?>
                <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Buildings">
                    <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#Buildings" data-parent="#mylistings">
                        <i class="fa fa-fw fa-building"></i>
                        <span class="nav-link-text">Buildings</span>
                    </a>
                    <ul class="sidenav-second-level collapse" id="Buildings">
                        <li>
                            <a href="buildings.php">Buildings</a>
                        </li>
                        <li>
                            <a href="building-departments.php">Departments</a>
                        </li>
                        <li>
                            <a href="building-offices.php">Offices</a>
                        </li>
                        <li>
                            <a href="building-labs.php">Labs</a>
                        </li>
                        <li>
                            <a href="building-lecture-halls.php">Lecture hall</a>
                        </li>
                    </ul>
                </li>
            <?php endif; ?>

            <?php if ($_SESSION["role"] == "Admin") : ?>
                <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Users">
                    <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#users" data-parent="#mylistings">
                        <i class="fa fa-fw fa-users"></i>
                        <span class="nav-link-text">Users</span>
                    </a>
                    <ul class="sidenav-second-level collapse" id="users">

                        <li>
                            <a href="user-admins.php">Admins</a>
                        </li>
                        <li>
                            <a href="user-faculty.php">Faculty</a>
                        </li>
                        <li>
                            <a href="user-researchers.php">Researchers</a>
                        </li>
                        <li>
                            <a href="user-students.php">Students</a>
                        </li>

                    </ul>
                </li>
            <?php endif; ?>
            <?php if ($_SESSION["role"] == "Admin" || $_SESSION["role"] == "Student") : ?>
                <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Major / Minor">
                    <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#mjmin" data-parent="#mylistings">
                        <i class="fa fa-fw fa-th"></i>
                        <span class="nav-link-text">Courses</span>
                    </a>
                    <ul class="sidenav-second-level collapse" id="mjmin">
                        <li>
                            <a href="courses.php">Courses</a>
                        </li>
                        <li>
                            <a href="course-prerequsites.php">Prerequsites</a>
                        </li>
                        <?php if ($_SESSION["role"] == "Admin") : ?>
                            <li>
                                <a href="course-major.php">Majors</a>
                            </li>
                            <li>
                                <a href="course-minor.php">Minors</a>
                            </li>
                        <?php endif; ?>
                        <?php if ($_SESSION["role"] == "Student") : ?>
                            <li>
                                <a href="course-major-student.php">Majors</a>
                            </li>
                            <li>
                                <a href="course-minor-student.php">Minors</a>
                            </li>
                        <?php endif; ?>
                        <li>
                            <a href="course-major-requirements.php">Major requirements</a>
                        </li>
                        <li>
                            <a href="course-minor-requirements.php">Minor requirements</a>
                        </li>
                    </ul>
                </li>
            <?php endif; ?>
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Advisors">
                <a class="nav-link" href="advisors.php">
                    <i class="fa fa-fw fa-user-plus"></i>
                    <span class="nav-link-text">Advisors</span>
                </a>
            </li>
            <?php if ($_SESSION["role"] == "Admin" || $_SESSION["role"] == "Faculty") : ?>
                <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Attendence">
                    <a class="nav-link" href="class-attendence.php">
                        <i class="fa fa-fw fa-check"></i>
                        <span class="nav-link-text">Attendence</span>
                    </a>
                </li>
                <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Grades">
                    <a class="nav-link" href="class-grades.php">
                        <i class="fa fa-fw fa-check-circle"></i>
                        <span class="nav-link-text">Grades</span>
                    </a>
                </li>
            <?php endif; ?>

            <?php if ($_SESSION["role"] == "Admin" || $_SESSION["role"] == "Student") : ?>
                <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Enrollment">
                    <a class="nav-link" href="class-enrollment.php">
                        <i class="fa fa-fw fa-list"></i>
                        <span class="nav-link-text">Enrollment</span>
                    </a>
                </li>
            <?php endif; ?>

            <?php if ($_SESSION["role"] == "Admin") : ?>
                <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Others">
                    <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#others" data-parent="#mylistings">
                        <i class="fa fa-fw fa-plus"></i>
                        <span class="nav-link-text">Others</span>
                    </a>
                    <ul class="sidenav-second-level collapse" id="others">
                        <li>
                            <a href="others-days.php">Days</a>
                        </li>
                        <li>
                            <a href="others-periods.php">Periods</a>
                        </li>
                        <li>
                            <a href="others-time-slots.php">Time slots</a>
                        </li>
                        <li>
                            <a href="others-semesters.php">Semesters</a>
                        </li>
                        <li>
                            <a href="others-holds.php">Holds</a>
                        </li>
                    </ul>
                </li>
            <?php endif; ?>
        </ul>
        <ul class="navbar-nav sidenav-toggler">
            <li class="nav-item">
                <a class="nav-link text-center" id="sidenavToggler">
                    <i class="fa fa-fw fa-angle-left"></i>
                </a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link text-white" href="../index.php">
                    <i class="fa fa-fw fa-globe"></i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" data-toggle="modal" data-target="#logout">
                    <i class="fa fa-fw fa-sign-out"></i>Logout
                </a>
            </li>
        </ul>
    </div>
</nav>
<!-- /Navigation-->
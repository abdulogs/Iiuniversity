<?php include('./layout/head.php')    ?>
<?php include('./layout/header.php')    ?>
<!-- Header Top END ==== -->
<!-- Content -->
<?php include('./layout/slider.php')    ?>

<div class="container">
    <h2>Major courses</h2>
    <div class="row">
        <!-- <div class="col-md-5 col-md-5">
            <select name="">
                <option selected>Select Semester</option>
                <option value="">3</option>
                <option value="">4</option>
                <option value="">5</option>
            </select>
        </div>

        <div class="col-md-3 col-md-3">
            <input type="submit" name="btn" value="Search">
        </div> -->
        <div class="table-responsive col-12 mb-5 mt-4">
            <table class="table table-card table-sm mb-0">
                <thead class="bg-light border-top">
                    <th>ID</th>
                    <th>Course#</th>
                    <th>Course name</th>
                    <th>Course section</th>
                    <th>Course credits</th>
                    <th></th>
                    </tr>
                </thead>
                <tbody class="font-12">
                    <?php
                    $majors = crud::select();
                    $majors = crud::columns(["r.MajorReqID", "c.Title", "r.CourseID", "c.CreditHours", "c.Section"]);
                    $majors = crud::table("major_req as r");
                    $majors = crud::join(["courses AS c" => ["c.CourseID" => "r.CourseID"]], "LEFT");
                    $majors = crud::where(["r.MajorID" => $_GET["id"]]);
                    $majors = crud::execute();
                    $majors = crud::fetch("all");
                    if ($majors) {
                        foreach ($majors as $major) { ?>
                            <tr>
                                <td><?php echo $major["CourseID"]; ?></td>
                                <td><?php echo $major["Title"]; ?></td>
                                <td><?php echo $major["CreditHours"]; ?></td>
                                <td><?php echo $major["Section"]; ?></td>
                                <td><a href="course-schedule.php?id=<?php echo $major["CourseID"]; ?>" class="btn-link">View schedule</a></td>
                            </tr>
                    <?php }
                    } else {
                        echo "<tr><td colspan='5'  class='text-center'>No courses exists</td></tr>";
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<?php include('./layout/footer.php')    ?>
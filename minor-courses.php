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
                    <th>Course#</th>
                    <th>Course name</th>
                    <th>Course section</th>
                    <th>Course credits</th>
                    <th></th>
                    </tr>
                </thead>
                <tbody class="font-12">
                    <?php
                    $minors = crud::select();
                    $minors = crud::columns(["r.MinorReqID", "c.Title", "c.CourseID", "c.CreditHours", "c.Section"]);
                    $minors = crud::table("minor_req as r");
                    $minors = crud::join(["courses AS c" => ["c.CourseID" => "r.CourseID"]], "LEFT");
                    $minors = crud::where(["r.MinorID" => $_GET["id"]]);
                    $minors = crud::order("r.MinorID", "DESC");
                    $minors = crud::execute();
                    $minors = crud::fetch("all");
                    if ($minors) {
                        foreach ($minors as $minor) { ?>
                            <tr>
                                <td><?php echo $minor["CourseID"]; ?></td>
                                <td><?php echo $minor["Title"]; ?></td>
                                <td><?php echo $minor["CreditHours"]; ?></td>
                                <td><?php echo $minor["Section"]; ?></td>
                                <td><a href="course-schedule.php?id=<?php echo $minor["CourseID"]; ?>" class="btn-link">View schedule</a></td>
                            </tr>
                    <?php }
                    } else {
                        echo "<tr><td colspan='5' class='text-center'>No courses exists</td></tr>";
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<?php include('./layout/footer.php')    ?>
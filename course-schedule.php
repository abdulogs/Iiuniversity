<?php include('./layout/head.php')    ?>
<?php include('./layout/header.php')    ?>
<!-- Header Top END ==== -->
<!-- Content -->
<?php include('./layout/slider.php')    ?>

<?php
if (in_array(date("m"), [3, 4, 5, 6, 7, 8])) {
    $type = "Fall";
} else if (in_array(date("m"), [9, 10, 11, 12, 1, 2])) {
    $type = "Spring";
}
?>


<div class="container">
    <h2>Course Schedule of Semester</h2>
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
                    <tr>
                        <th class="border-0">CRN</th>
                        <th class="border-0">Section</th>
                        <th class="border-0">Course#</th>
                        <th class="border-0">Course Name</th>
                        <th class="border-0">Department</th>
                        <th class="border-0">Day</th>
                        <th class="border-0">Start Time</th>
                        <th class="border-0">End Time</th>
                        <th class="border-0">Semester</th>
                        <th class="border-0">Year</th>
                        <th class="border-0">Room Number</th>
                        <th class="border-0">Building</th>
                        <th class="border-0">Prof. Firstname</th>
                        <th class="border-0">Prof. lastname</th>
                        <th class="border-0">Seats</th>
                        <th class="border-0">Capacity</th>
                    </tr>
                </thead>
                <tbody id="data" class="font-12">
                    <?php
                    $classes = crud::select();
                    $classes = crud::columns(["c.CRN", "c.CourseID", "u.F_Name", "u.L_Name", "r.RoomNumber", "p.End_Time"]);
                    $classes = crud::columnsmore(["s.SemesterName", "s.Year", "t.PeriodID", "e.Title",]);
                    $classes = crud::columnsmore(["d.Name as department", "b.Name as building", "p.Start_Time"]);
                    $classes = crud::columnsmore(["r.Capacity", "r.Seats", "e.Section", "de.DayOfWeek as day"]);
                    $classes = crud::table("class as c");
                    $classes = crud::join(["courses AS e" => ["e.CourseID" => "c.CourseID"]], "LEFT");
                    $classes = crud::join(["timeslot AS t" => ["t.TimeslotID" => "c.TimeslotID"]], "LEFT");
                    $classes = crud::join(["room AS r" => ["r.RoomID" => "c.RoomID"]], "LEFT");
                    $classes = crud::join(["semesteryear AS s" => ["s.SemesterID" => "c.SemesterID"]], "LEFT");
                    $classes = crud::join(["users AS u" => ["u.UserID" => "c.FacultyID"]], "LEFT");
                    $classes = crud::join(["department AS d" => ["d.DeptID" => "e.DeptID"]], "LEFT");
                    $classes = crud::join(["building AS b" => ["b.BuildingID" => "r.BuildingID"]], "LEFT");
                    $classes = crud::join(["day AS de" => ["de.DayID" => "t.DayID"]], "LEFT");
                    $classes = crud::join(["period AS p" => ["p.PeriodID" => "t.PeriodID"]], "LEFT");
                    $classes = crud::where(["c.CourseID" => $_GET["id"], "s.Year" => date("Y"), "s.SemesterName" => $type]);
                    $classes = crud::execute();
                    $classes = crud::fetch("all");
                    if ($classes) {
                        foreach ($classes as $class) { ?>
                            <tr>
                                <td class="px-3"><?php echo $class["CRN"]; ?></td>
                                <td class="text-break"><?php echo $class["Section"]; ?></td>
                                <td class="text-break"><?php echo ucFirst($class["CourseID"]); ?></td>
                                <td class="text-break"><?php echo ucFirst($class["Title"]); ?></td>
                                <td class="text-break"><?php echo ucFirst($class["department"]); ?></td>
                                <td class="text-break"><?php echo ucFirst($class["day"]); ?></td>
                                <td class="text-break"><?php echo ucFirst($class["Start_Time"]); ?></td>
                                <td class="text-break"><?php echo ucFirst($class["End_Time"]); ?></td>
                                <td class="text-break"><?php echo $class["SemesterName"]; ?></td>
                                <td class="text-break"><?php echo $class["Year"]; ?></td>
                                <td class="text-break"><?php echo ucFirst($class["RoomNumber"]); ?></td>
                                <td class="text-break"><?php echo ucFirst($class["building"]); ?></td>
                                <td class="text-break"><?php echo ucFirst($class["F_Name"]); ?></td>
                                <td class="text-break"><?php echo ucFirst($class["L_Name"]); ?></td>
                                <td class="text-break"><?php echo $class["Seats"]; ?></td>
                                <td class="text-break"><?php echo $class["Capacity"]; ?></td>
                            </tr>
                            <?php }
                    } else {
                        echo "<tr><td colspan='17' class='text-center'>No classes exists</td></tr>";
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include('./layout/footer.php')    ?>
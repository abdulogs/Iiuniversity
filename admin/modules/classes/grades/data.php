<?php
require_once "../../../../classes/crud.php";

if (!isset($_POST) and $_SERVER['REQUEST_METHOD'] == !"POST") {

  echo "<tr><td class='align-middle px-3' colspan='13' data-label='Error message'>Something went wrong</td></tr>";
} else {

  $limit = (isset($_POST["limit"])) ? $_POST["limit"] : 5;
  $page = (isset($_POST["page"])) ? $_POST["page"] : 1;

  // if (in_array(date("m"), [3, 4, 5, 6, 7, 8])) {
  //   $classType = "Fall";
  // } else if (in_array(date("m"), [9, 10, 10, 12, 1, 2])) {
  //   $classType = "Spring";
  // }

  /*** Fetching all data ***/
  $enrollments = crud::select();
  $enrollments = crud::columns(["e.id", "e.StudentID", "e.CRN", "e.GRADE", "su.F_Name AS sfname",]);
  $enrollments = crud::columnsmore(["fu.F_Name AS ffname", "fu.L_Name AS flname", "r.RoomNumber",]);
  $enrollments = crud::columnsmore(["co.Title as course", "su.L_Name AS slname"]);
  $enrollments = crud::columnsmore(["r.RoomType", "sy.SemesterName", "sy.Year", "d.DayOfWeek",]);
  $enrollments = crud::columnsmore(["s.StudentType", "dp.Name AS department", "b.Name AS building"]);
  $enrollments = crud::columnsmore(["p.Start_Time", "p.End_Time", "sy.grade_time"]);
  $enrollments = crud::table("enrollment as e");
  $enrollments = crud::join(["student AS s" => ["s.StudentID" => "e.StudentID"]], "LEFT");
  $enrollments = crud::join(["users AS su" => ["su.UserID" => "s.StudentID"]], "LEFT");
  $enrollments = crud::join(["class AS c" => ["c.CRN" => "e.CRN"]], "LEFT");
  $enrollments = crud::join(["faculty AS f" => ["f.FacultyID" => "c.FacultyID"]], "LEFT");
  $enrollments = crud::join(["users AS fu" => ["fu.UserID" => "f.FacultyID"]], "LEFT");
  $enrollments = crud::join(["room AS r" => ["r.RoomID" => "c.RoomID"]], "LEFT");
  $enrollments = crud::join(["courses AS co" => ["co.CourseID" => "c.CourseID"]], "LEFT");
  $enrollments = crud::join(["department AS dp" => ["dp.DeptID" => "co.DeptID"]], "LEFT");
  $enrollments = crud::join(["building AS b" => ["b.BuildingID" => "r.BuildingID"]], "LEFT");
  $enrollments = crud::join(["semesteryear AS sy" => ["sy.SemesterID" => "c.SemesterID"]], "LEFT");
  $enrollments = crud::join(["timeslot AS t" => ["t.TimeSlotID" => "c.TimeslotID"]], "LEFT");
  $enrollments = crud::join(["period AS p" => ["p.PeriodID" => "t.PeriodID"]], "LEFT");
  $enrollments = crud::join(["day AS d" => ["d.DayID" => "t.DayID"]], "LEFT");

  if ($_SESSION["role"] == "Faculty") {
    /*** Search all data ***/
    if (!empty($_POST["search"])) {
      $enrollments =  crud::search([
        "co.Title" => $_POST["search"],
        "fu.F_Name" => $_POST["search"],
        "fu.L_Name" => $_POST["search"],
        "r.RoomNumber" => $_POST["search"],
        "d.DayOFWeek" => $_POST["search"],
        "b.Name" =>  $_POST["search"],
        "dp.Name" =>  $_POST["search"],
      ]);
      $enrollments = crud::and([
        "c.FacultyID" => $_SESSION["id"],
        // "sy.Year" => date("Y"),
        // "sy.SemesterName" => $classType
      ]);
      $enrollments =  crud::in("sy.SemesterName", ["Fall", "Spring"], " AND ");
      $enrollments =  crud::in("sy.Year", [2021, 2022], " AND ");
    } else {
      $enrollments =  crud::where([
        "c.FacultyID" => $_SESSION["id"],
        // "sy.Year" => date("Y"),
        // "sy.SemesterName" => $classType
      ]);
      $enrollments =  crud::in("sy.SemesterName", ["Fall", "Spring"], " AND ");
      $enrollments =  crud::in("sy.Year", [2021, 2022], " AND ");
    }
  } else {
    if (!empty($_POST["search"])) {
      $enrollments =  crud::search([
        "co.Title" => $_POST["search"],
        "fu.F_Name" => $_POST["search"],
        "fu.L_Name" => $_POST["search"],
        "r.RoomNumber" => $_POST["search"],
        "d.DayOFWeek" => $_POST["search"],
        "b.Name" =>  $_POST["search"],
        "dp.Name" =>  $_POST["search"],
      ]);
      // $enrollments = crud::and([
      //   "sy.Year" => date("Y"),
      //   "sy.SemesterName" => $classType
      // ]);
    } else {
      $enrollments =  crud::where([]);
      $enrollments =  crud::in("sy.SemesterName", ["Fall", "Spring"], " AND ");
      $enrollments =  crud::in("sy.Year", [2021, 2022], " AND ");
    }
  }

  /*** sort all data ***/
  if (!isset($_POST["sort"]) || $_POST["sort"] == "recent") {
    $enrollments =  crud::order("e.id", "DESC");
  } else {
    $enrollments = crud::order("e.id", "ASC");
  }

  $enrollments = ($limit == "all") ?: crud::paging($page, $limit);
  $enrollments = crud::execute();
  $enrollments = crud::fetch("all");
  if ($enrollments) {
    foreach ($enrollments as $enrollment) { ?>
      <tr>
        <td class="align-middle px-3" data-label="Id">
          <?php echo $enrollment["StudentID"]; ?>
        </td>
        <td class="align-middle text-break" data-label="Faculty">
          <?php echo ucFirst($enrollment["sfname"] . " " . $enrollment["slname"]); ?>
        </td>
        <td class="align-middle text-break" data-label="Student">
          <?php echo ucFirst($enrollment["ffname"] . " " . $enrollment["flname"]); ?>
        </td>
        <td class="align-middle text-break" data-label="Course">
          <?php echo ucFirst($enrollment["course"]); ?>
        </td>
        <td class="align-middle text-break" data-label="Department">
          <?php echo ucFirst($enrollment["department"]); ?>
        </td>
        <td class="align-middle text-break" data-label="Building">
          <?php echo ucFirst($enrollment["building"]); ?>
        </td>
        <td class="align-middle text-break" data-label="Room">
          <?php echo $enrollment["RoomNumber"]; ?>
        </td>
        <td class="align-middle text-break" data-label="Semester">
          <?php echo $enrollment["SemesterName"] . " - " . $enrollment["Year"]; ?>
        </td>
        <td class="align-middle text-break" data-label="Grade">
          <?php echo $enrollment["GRADE"]; ?>
        </td>
        <td class="align-middle px-3" scope="row" data-label="Controls">

          <?php if ($_SESSION["role"] == "Admin") : ?>
            <a class="updateBtn fa fa-pencil mr-1 font-16 text-success" data-id="<?php echo $enrollment["id"]; ?>" href="javascript:void(0)" title="Update"></a>
          <?php elseif ($_SESSION["role"] == "Faculty") : ?>
            <?php if (strtotime(date("m/d/Y")) <= strtotime($enrollment["grade_time"])) : ?>
              <a class="updateBtn fa fa-pencil mr-1 font-16 text-success" data-id="<?php echo $enrollment["id"]; ?>" href="javascript:void(0)" title="Update"></a>

            <?php else : ?>
              -
            <?php endif; ?>
          <?php else : ?>
            -
          <?php endif; ?>


          <?php if ($_SESSION["role"] == "Admin") : ?>
            <a class="deletebBtn fa fa-trash mr-1 font-16 text-danger" data-id="<?php echo $enrollment["id"]; ?>" href="javascript:void(0)" title="Delete"></a>
          <?php else : ?>
            -
          <?php endif; ?>
        </td>

      </tr>

    <?php } ?>
    <tr id="loader"></tr>

    <?php if ($limit == "all") : ?>
    <?php else : ?>
      <tr id="pagination" class="bg-light">
        <td colspan="10" class="text-center">
          <?php $attr = (isset($_POST["sort"]) || isset($_POST["limit"]) || isset($_POST["search"])) ? "loadFiltered" : "loadmore"; ?>
          <button type="button" class="btn btn-sm btn-light border" id="<?php echo $attr; ?>" data-paging="<?php echo $page + 1; ?>">
            Load More
          </button>
        </td>
      </tr>
    <?php endif; ?>

  <?php } else { ?>
    <tr class="bg-light">
      <td colspan="10" class="text-center">
        <button type="button" class="btn btn-sm btn-outline-dark" disabled>No Results</button>
      </td>
    </tr>
<?php }
} ?>
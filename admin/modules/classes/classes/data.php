<?php
require_once "../../../../classes/crud.php";

if (!isset($_POST) and $_SERVER['REQUEST_METHOD'] == !"POST") {

  echo "<tr><td class='align-middle px-3' colspan='7' data-label='Error message'>Something went wrong</td></tr>";
} else {

  $limit = (isset($_POST["limit"])) ? $_POST["limit"] : 5;
  $page = (isset($_POST["page"])) ? $_POST["page"] : 1;

  /*** Fetching all data ***/
  $classes = crud::select();
  $classes = crud::columns(["c.CRN", "u.F_Name", "u.L_Name", "r.RoomNumber", "s.SemesterName", "s.Year",]);
  $classes = crud::columnsmore(["t.PeriodID", "e.Title", "p.Start_Time", "p.End_Time", "d.DayOFWeek"]);
  $classes = crud::table("class as c");
  $classes = crud::join(["courses AS e" => ["e.CourseID" => "c.CourseID"]], "LEFT");
  $classes = crud::join(["timeslot AS t" => ["t.TimeslotID" => "c.TimeslotID"]], "LEFT");
  $classes = crud::join(["period AS p" => ["p.PeriodID" => "t.PeriodID"]], "LEFT");
  $classes = crud::join(["day AS d" => ["d.DayID" => "t.DayID"]], "LEFT");
  $classes = crud::join(["room AS r" => ["r.RoomID" => "c.RoomID"]], "LEFT");
  $classes = crud::join(["semesteryear AS s" => ["s.SemesterID" => "c.SemesterID"]], "LEFT");
  $classes = crud::join(["enrollment AS m" => ["m.CRN" => "c.CRN"]], "LEFT");
  $classes = crud::join(["users AS u" => ["u.UserID" => "c.FacultyID"]], "LEFT");

  if ($_SESSION["role"] == "Admin") {
    /*** Search all data ***/
    if (!empty($_POST["search"])) {
      $classes =  crud::search([
        "c.CRN" => $_POST["search"],
        "u.F_Name" => $_POST["search"],
        "u.L_Name" => $_POST["search"],
        "r.RoomNumber" => $_POST["search"],
        "s.SemesterName" => $_POST["search"],
        "s.Year" => $_POST["search"],
        "t.PeriodID" => $_POST["search"],
        "e.Title" => $_POST["search"],
        "d.DayOFWeek" => $_POST["search"],
      ]);
      $classes = crud::or([
        "s.SemesterName" => "Fall", "s.SemesterName" => "Spring", "s.Year" => 2021, "s.Year" => 2022
      ]);
    } else {
      $classes = crud::or([
        "s.SemesterName" => "Fall", "s.SemesterName" => "Spring", "s.Year" => 2021,  "s.Year" => 2022
      ], true);
    }
  } else if ($_SESSION["role"] == "Faculty") {
    /*** Search all data ***/
    if (!empty($_POST["search"])) {
      $classes =  crud::search([
        "c.CRN" => $_POST["search"],
        "u.F_Name" => $_POST["search"],
        "u.L_Name" => $_POST["search"],
        "r.RoomNumber" => $_POST["search"],
        "s.SemesterName" => $_POST["search"],
        "s.Year" => $_POST["search"],
        "t.PeriodID" => $_POST["search"],
        "e.Title" => $_POST["search"],
        "d.DayOFWeek" => $_POST["search"],
        "c.FacultyID" => $_SESSION["id"]
      ]);
      $classes =  crud::in("s.SemesterName", ["Fall", "Spring"], " AND ");
      $classes =  crud::in("s.Year", [2021, 2022], " AND ");
    } else {
      $classes =  crud::where(["c.FacultyID" => $_SESSION["id"]]);
      $classes =  crud::in("s.SemesterName", ["Fall", "Spring"], " AND ");
      $classes =  crud::in("s.Year", [2021, 2022], " AND ");
    }
  } else if ($_SESSION["role"] == "Student") {

    /*** Search all data ***/
    if (!empty($_POST["search"])) {
      $classes =  crud::search([
        "c.CRN" => $_POST["search"],
        "u.F_Name" => $_POST["search"],
        "u.L_Name" => $_POST["search"],
        "r.RoomNumber" => $_POST["search"],
        "s.SemesterName" => $_POST["search"],
        "s.Year" => $_POST["search"],
        "t.PeriodID" => $_POST["search"],
        "e.Title" => $_POST["search"],
        "d.DayOFWeek" => $_POST["search"],
        "m.StudentID" => $_SESSION["id"]
      ]);
      $classes =  crud::in("s.SemesterName", ["Fall", "Spring"], " AND ");
      $classes =  crud::in("s.Year", [2021, 2022], " AND ");
    } else {
      $classes =  crud::where(["m.StudentID" => $_SESSION["id"]]);
      $classes =  crud::in("s.SemesterName", ["Fall", "Spring"], " AND ");
      $classes =  crud::in("s.Year", [2021, 2022], " AND ");
    }
  }

  /*** sort all data ***/
  if (!isset($_POST["sort"]) || $_POST["sort"] == "recent") {
    $classes =  crud::order("c.CRN", "DESC");
  } else {
    $classes = crud::order("c.CRN", "ASC");
  }


  $classes = ($limit == "all") ?: crud::paging($page, $limit);
  $classes = crud::execute();
  $classes = crud::fetch("all");
  if ($classes) {
    foreach ($classes as $class) { ?>
      <tr>
        <td class="align-middle px-3" data-label="Id"><?php echo $class["CRN"]; ?></td>
        <td class="align-middle text-break" data-label="Faculty"><?php echo ucFirst($class["F_Name"] . " " . $class["L_Name"]); ?></td>
        <td class="align-middle text-break" data-label="Room"><?php echo ucFirst($class["RoomNumber"]); ?></td>
        <td class="align-middle text-break" data-label="Semester"><?php echo $class["SemesterName"] . " " . $class["Year"]; ?></td>
        <td class="align-middle text-break" data-label="Timeslot"><?php echo $class["Start_Time"] . " - " . $class["End_Time"] . " - " . $class["DayOFWeek"]; ?></td>
        <td class="align-middle text-break" data-label="Course"><?php echo ucFirst($class["Title"]); ?></td>
        <td class="align-middle px-3" scope="row" data-label="Controls">
          <?php if ($_SESSION["role"] == "Admin") : ?>
            <a class="updateBtn fa fa-pencil mr-1 font-16 text-success" data-id="<?php echo $class["CRN"]; ?>" href="javascript:void(0)" title="Edit"></a>
            <a class="deletebBtn fa fa-trash mr-1 font-16 text-danger" data-id="<?php echo $class["CRN"]; ?>" href="javascript:void(0)" title="Delete"></a>
        </td>
      <?php else : ?>
        -
      <?php endif; ?>
      </tr>

    <?php } ?>
    <tr id="loader"></tr>

    <?php if ($limit == "all") : ?>
    <?php else : ?>
      <tr id="pagination" class="bg-light">
        <td colspan="7" class="text-center">
          <?php $attr = (isset($_POST["sort"]) || isset($_POST["limit"]) || isset($_POST["search"])) ? "loadFiltered" : "loadmore"; ?>
          <button type="button" class="btn btn-sm btn-light border" id="<?php echo $attr; ?>" data-paging="<?php echo $page + 1; ?>">
            Load More
          </button>
        </td>
      </tr>
    <?php endif; ?>

  <?php } else { ?>
    <tr class="bg-light">
      <td colspan="7" class="text-center">
        <button type="button" class="btn btn-sm btn-outline-dark" disabled>No Results</button>
      </td>
    </tr>
<?php }
} ?>
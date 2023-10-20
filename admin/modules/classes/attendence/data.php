<?php
require_once "../../../../classes/crud.php";

if (!isset($_POST) and $_SERVER['REQUEST_METHOD'] == !"POST") {

  echo "<tr><td class='align-middle px-3' colspan='7' data-label='Error message'>Something went wrong</td></tr>";
} else {

  $limit = (isset($_POST["limit"])) ? $_POST["limit"] : 5;
  $page = (isset($_POST["page"])) ? $_POST["page"] : 1;

  /*** Fetching all data ***/
  $classes = crud::select();
  $classes = crud::columns(["a.id", "a.StudentID", "u.F_Name", "u.L_Name", "r.RoomNumber", "s.SemesterName",]);
  $classes = crud::columnsmore(["t.PeriodID", "e.Title", "p.Start_Time", "p.End_Time", "a.DateAtt",]);
  $classes = crud::columnsmore(["s.Year", "a.Present"]);
  $classes = crud::table("attendence as a");
  $classes = crud::join(["class AS c" => ["c.CRN" => "a.CRN"]], "LEFT");
  $classes = crud::join(["courses AS e" => ["e.CourseID" => "c.CourseID"]], "LEFT");
  $classes = crud::join(["timeslot AS t" => ["t.TimeslotID" => "c.TimeslotID"]], "LEFT");
  $classes = crud::join(["period AS p" => ["p.PeriodID" => "t.PeriodID"]], "LEFT");
  $classes = crud::join(["room AS r" => ["r.RoomID" => "c.RoomID"]], "LEFT");
  $classes = crud::join(["semesteryear AS s" => ["s.SemesterID" => "c.SemesterID"]], "LEFT");
  $classes = crud::join(["users AS u" => ["u.UserID" => "a.StudentID"]], "LEFT");

  if ($_SESSION["role"] == "Admin") {
    if (!empty($_POST["search"])) {
      $classes =  crud::search([
        "a.StudentID" => $_POST["search"],
        "u.F_Name" => $_POST["search"],
        "u.L_Name" => $_POST["search"],
        "r.RoomNumber" => $_POST["search"],
        "s.SemesterName" => $_POST["search"],
        "s.Year" => $_POST["search"],
        "e.Title" => $_POST["search"],
      ]);
    } else {
      $classes =  crud::in("s.SemesterName", ["Fall", "Spring"], " WHERE ");
      $classes =  crud::in("s.Year", [2021, 2022], " AND ");
    }
  } else if ($_SESSION["role"] == "Faculty") {
    /*** Search all data ***/
    if (!empty($_POST["search"])) {
      $classes =  crud::search([
        "a.StudentID" => $_POST["search"],
        "u.F_Name" => $_POST["search"],
        "u.L_Name" => $_POST["search"],
        "r.RoomNumber" => $_POST["search"],
        "s.SemesterName" => $_POST["search"],
        "s.Year" => $_POST["search"],
        "e.Title" => $_POST["search"],

      ])::and(["c.FacultyID" => $_SESSION["id"]]);
      $classes =  crud::in("s.SemesterName", ["Fall", "Spring"], " AND ");
      $classes =  crud::in("s.Year", [2021, 2022], " AND ");
    } else {
      $classes =  crud::where(["c.FacultyID" => $_SESSION["id"]]);
      $classes =  crud::in("s.SemesterName", ["Fall", "Spring"], " AND ");
      $classes =  crud::in("s.Year", [2021, 2022], " AND ");
    }
  }

  /*** sort all data ***/
  if (!isset($_POST["sort"]) || $_POST["sort"] == "recent") {
    $classes =  crud::order("a.id", "DESC");
  } else {
    $classes = crud::order("a.id", "ASC");
  }

  $classes = ($limit == "all") ?: crud::paging($page, $limit);
  $classes = crud::execute();
  $classes = crud::fetch("all");
  if ($classes) {
    foreach ($classes as $class) { ?>
      <tr>
        <td class="align-middle px-3" data-label="Id"><?php echo $class["StudentID"]; ?></td>
        <td class="align-middle text-break" data-label="Student"><?php echo ucFirst($class["F_Name"] . " " . $class["L_Name"]); ?></td>
        <td class="align-middle text-break" data-label="Course"><?php echo ucFirst($class["Title"]); ?></td>
        <td class="align-middle text-break" data-label="Room"><?php echo $class["RoomNumber"]; ?></td>
        <td class="align-middle text-break" data-label="Date">
          <?php echo date('F d, Y', strtotime($class['DateAtt'])); ?>
        </td>
        <td class="align-middle text-break" data-label="Status">
          <?php if ($class["Present"] == 0) {
            echo "<span class='badge badge-danger'>Absent</span>";
          } elseif ($class["Present"] == 1) {
            echo "<span class='badge badge-success'>Present</span>";
          }  ?>
        </td>
        <td class="align-middle px-3" scope="row" data-label="Controls">
          <a class="updateBtn fa fa-pencil mr-1 font-16 text-success" data-id="<?php echo $class["id"]; ?>" href="javascript:void(0)" title="Edit"></a>
          <a class="deletebBtn fa fa-trash mr-1 font-16 text-danger" data-id="<?php echo $class["id"]; ?>" href="javascript:void(0)" title="Delete"></a>
        </td>
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
<?php
require_once "../../classes/crud.php";

if (!isset($_POST) and $_SERVER['REQUEST_METHOD'] == !"POST") {

  echo "<tr><td class='px-3' colspan='16' data-label='Error message'>Something went wrong</td></tr>";
} else {

  $limit = (isset($_POST["limit"])) ? $_POST["limit"] : 10;
  $page = (isset($_POST["page"])) ? $_POST["page"] : 1;

  // if (in_array(date("m"), [3, 4, 5, 6, 7, 8])) {
  //   $type = "Fall";
  // } else if (in_array(date("m"), [9, 10, 11, 12, 1, 2])) {
  //   $type = "Spring";
  // }

  /*** Fetching all data ***/
  $classes = crud::select();
  $classes = crud::columns(["c.CRN", "c.CourseID", "u.F_Name", "u.L_Name", "r.RoomNumber", "p.End_Time"]);
  $classes = crud::columnsmore(["s.SemesterName", "s.Year", "t.PeriodID", "e.Title", "de.DayOfWeek as day"]);
  $classes = crud::columnsmore(["d.Name as department", "b.Name as building", "p.Start_Time"]);
  $classes = crud::columnsmore(["r.Capacity", "r.Seats"]);
  $classes = crud::columnsmore(["e.Section"]);
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
  // $classes = (!empty($_POST["search"])) ? crud::search(["s.Year" => date("Y"), "s.SemesterName" => $type]) : crud::where(["s.Year" => date("Y"), "s.SemesterName" => $type]);

  $classes =  crud::in("s.SemesterName", ["Fall", "Spring"]," WHERE ");
  $classes =  crud::in("s.Year", [2021, 2022], " AND ");

  $classes = crud::order("c.CRN", "DESC");
  $classes = ($limit == "all") ?: crud::paging($page, $limit);
  $classes = crud::execute();
  $classes = crud::fetch("all");
  if ($classes) {
    foreach ($classes as $class) { ?>
      <tr>
        <td class="text-break p-1"><?php echo $class["CRN"]; ?></td>
        <td class="text-break p-1"><?php echo $class["Section"]; ?></td>
        <td class="text-break p-1"><?php echo ucFirst($class["CourseID"]); ?></td>
        <td class="text-break p-1"><?php echo ucFirst($class["Title"]); ?></td>
        <td class="text-break p-1"><?php echo ucFirst($class["department"]); ?></td>
        <td class="text-break p-1"><?php echo ucFirst($class["day"]); ?></td>
        <td class="text-break p-1"><?php echo ucFirst($class["Start_Time"]); ?></td>
        <td class="text-break p-1"><?php echo ucFirst($class["End_Time"]); ?></td>
        <td class="text-break p-1"><?php echo $class["SemesterName"]; ?></td>
        <td class="text-break p-1"><?php echo $class["Year"]; ?></td>
        <td class="text-break p-1"><?php echo ucFirst($class["RoomNumber"]); ?></td>
        <td class="text-break p-1"><?php echo ucFirst($class["building"]); ?></td>
        <td class="text-break p-1"><?php echo ucFirst($class["F_Name"]); ?></td>
        <td class="text-break p-1"><?php echo ucFirst($class["L_Name"]); ?></td>
        <td class="text-break"><?php echo $class["Seats"]; ?></td>
        <td class="text-break"><?php echo $class["Capacity"]; ?></td>
      </tr>

    <?php } ?>
    <tr id="loader"></tr>

    <?php if ($limit == "all") : ?>
    <?php else : ?>
      <tr id="pagination" class="bg-light">
        <td colspan="16" class="text-center">
          <?php $attr = (isset($_POST["sort"]) || isset($_POST["limit"]) || isset($_POST["search"])) ? "loadFiltered" : "loadmore"; ?>
          <button type="button" class="btn btn-sm text-light font-12" id="<?php echo $attr; ?>" data-paging="<?php echo $page + 1; ?>">
            Load More
          </button>
        </td>
      </tr>
    <?php endif; ?>

  <?php } else { ?>
    <tr class="bg-light">
      <td colspan="16" class="text-center">
        <button type="button" class="btn btn-sm text-light font-12" disabled>No Results</button>
      </td>
    </tr>
<?php }
} ?>
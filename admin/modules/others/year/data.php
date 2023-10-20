<?php
require_once "../../../../classes/crud.php";

if (!isset($_POST) and $_SERVER['REQUEST_METHOD'] == !"POST") {
  echo "<tr><td>Something went wrong</td></tr>";
} else {
  $limit = (isset($_POST["limit"])) ? $_POST["limit"] : 5;
  $page = (isset($_POST["page"])) ? $_POST["page"] : 1;

  /*** Fetching all data ***/
  $semesters = crud::select();
  $semesters = crud::columns(["SemesterID", "SemesterName", "Year", "StartDate", "EndDate"]);
  $semesters = crud::columnsmore(["grade_time", "reg_time", "drop_time"]);
  $semesters = crud::table("semesteryear");

  /*** Search all data ***/
  if (!empty($_POST["search"])) {
    $semesters =  crud::search([
      "SemesterID" => $_POST["search"],
      "SemesterName" => $_POST["search"],
      "Year" => $_POST["search"],
      "StartDate" => $_POST["search"],
      "EndDate" => $_POST["search"],
      "grade_time" => $_POST["search"],
      "reg_time" => $_POST["search"],
      "drop_time" => $_POST["search"],
    ]);
  }

  /*** sort all data ***/
  if (!isset($_POST["sort"]) || $_POST["sort"] == "recent") {
    $semesters =  crud::order("SemesterID", "DESC");
  } else {
    $semesters = crud::order("SemesterID", "ASC");
  }

  $semesters = ($limit == "all") ?: crud::paging($page, $limit);
  $semesters = crud::execute();
  $semesters = crud::fetch("all");
  if ($semesters) {
    foreach ($semesters as $semester) { ?>
      <tr>
        <td class="align-middle px-3" data-label="ID">
          <?php echo $semester["SemesterID"]; ?>
        </td>
        <td class="align-middle" data-label="Name">
          <?php echo $semester["SemesterName"]; ?>
        </td>
        <td class="align-middle" data-label="Year">
          <?php echo $semester["Year"]; ?>
        </td>
        <td class="align-middle" data-label="Start Date">
          <?php echo date('F d, Y', strtotime($semester["StartDate"])); ?>
        </td>
        <td class="align-middle" data-label="End Date">
          <?php echo date('F d, Y', strtotime($semester["EndDate"])); ?>
        </td>
        <td class="align-middle" data-label="Grading time limit">
          <?php echo date('F d, Y', strtotime($semester["grade_time"])); ?>
        </td>
        <td class="align-middle" data-label="Registertion time limit">
          <?php echo date('F d, Y', strtotime($semester["reg_time"])); ?>
        </td>
        <td class="align-middle" data-label="Droping time limit">
          <?php echo date('F d, Y', strtotime($semester["drop_time"])); ?>
        </td>
        <td class="align-middle px-3" scope="row" data-label="Controls">
          <a class="updateBtn fa fa-pencil mr-1 font-19 text-success" data-id="<?php echo $semester["SemesterID"]; ?>" href="javascript:void(0)" title="View"></a>
          <a class="deletebBtn fa fa-trash mr-1 font-19 text-danger" data-id="<?php echo $semester["SemesterID"]; ?>" href="javascript:void(0)" title="Delete"></a>
        </td>
      </tr>

    <?php } ?>
    <tr id="loader"></tr>

    <?php if ($limit == "all") : ?>
    <?php else : ?>
      <tr id="pagination" class="bg-light">
        <td colspan="9" class="text-center">
          <?php $attr = (isset($_POST["sort"]) || isset($_POST["limit"]) || isset($_POST["search"])) ? "loadFiltered" : "loadmore"; ?>
          <button type="button" class="btn btn-sm btn-light border" id="<?php echo $attr; ?>" data-paging="<?php echo $page + 1; ?>">
            Load More
          </button>
        </td>
      </tr>
    <?php endif; ?>

  <?php } else { ?>
    <tr class="bg-light">
      <td colspan="9" class="text-center">
        <button type="button" class="btn btn-sm btn-outline-dark" disabled>No Results</button>
      </td>
    </tr>
<?php }
} ?>
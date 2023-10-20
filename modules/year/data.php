<?php
require_once "../../classes/crud.php";

if (!isset($_POST) and $_SERVER['REQUEST_METHOD'] == !"POST") {

  echo "<tr><td class='align-middle px-3' colspan='8' data-label='Error message'>Something went wrong</td></tr>";
} else {

  $limit = (isset($_POST["limit"])) ? $_POST["limit"] : 5;
  $page = (isset($_POST["page"])) ? $_POST["page"] : 1;

  /*** Fetching all data ***/
  $semesters = crud::select();
  $semesters = crud::columns(["SemesterID", "SemesterName", "Year", "StartDate", "EndDate"]);
  $semesters = crud::columnsmore(["grade_time", "reg_time", "drop_time"]);
  $semesters = crud::table("semesteryear");
  $semesters =  crud::order("SemesterID", "DESC");
  $semesters = ($limit == "all") ?: crud::paging($page, $limit);
  $semesters = crud::execute();
  $semesters = crud::fetch("all");
  if ($semesters) {
    foreach ($semesters as $semester) { ?>
      <tr>
        <td class="align-middle px-3" data-label="Id">
          <?php echo $semester["SemesterID"]; ?>
        </td>
        <td class="align-middle" data-label="Name">
          <?php echo $semester["SemesterName"]; ?>
        </td>
        <td class="align-middle" data-label="Year">
          <?php echo $semester["Year"]; ?></td>
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
      </tr>

    <?php } ?>
    <tr id="loader"></tr>

    <?php if ($limit == "all") : ?>
    <?php else : ?>
      <tr id="pagination" class="bg-light">
        <td colspan="8" class="text-center">
          <?php $attr = (isset($_POST["sort"]) || isset($_POST["limit"]) || isset($_POST["search"])) ? "loadFiltered" : "loadmore"; ?>
          <button type="button" class="btn btn-sm text-light font-12" id="<?php echo $attr; ?>" data-paging="<?php echo $page + 1; ?>">
            Load More
          </button>
        </td>
      </tr>
    <?php endif; ?>

  <?php } else { ?>
    <tr class="bg-light">
      <td colspan="8" class="text-center">
        <button type="button" class="btn btn-sm text-light font-12" disabled>No Results</button>
      </td>
    </tr>
<?php }
} ?>
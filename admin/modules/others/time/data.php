<?php
require_once "../../../../classes/crud.php";

if (!isset($_POST) and $_SERVER['REQUEST_METHOD'] == !"POST") {
  echo "<tr><td>Something went wrong</td></tr>";
} else {
  $limit = (isset($_POST["limit"])) ? $_POST["limit"] : 5;
  $page = (isset($_POST["page"])) ? $_POST["page"] : 1;

  /*** Fetching all data ***/
  $timings = crud::select();
  $timings = crud::columns(["t.TimeSlotID", "d.DayOfWeek", "t.PeriodID", "p.Start_Time", "p.End_Time"]);
  $timings = crud::table("timeslot as t");
  $timings = crud::join(["day AS d" => ["d.DayID" => "t.DayID"]], "LEFT");
  $timings = crud::join(["period AS p" => ["p.PeriodID" => "t.PeriodID"]], "LEFT");

  /*** Search all data ***/
  if (!empty($_POST["search"])) {
    $timings =  crud::search([
      "t.TimeSlotID" => $_POST["search"],
      "p.Start_Time" => $_POST["search"],
      "p.End_Time" => $_POST["search"],
      "d.DayOfWeek" => $_POST["search"],
    ]);
  }

  /*** sort all data ***/
  if (!isset($_POST["sort"]) || $_POST["sort"] == "recent") {
    $timings =  crud::order("t.TimeSlotID", "DESC");
  } else {
    $timings = crud::order("t.TimeSlotID", "ASC");
  }

  $timings = ($limit == "all") ?: crud::paging($page, $limit);
  $timings = crud::execute();
  $timings = crud::fetch("all");
  if ($timings) {
    foreach ($timings as $timing) { ?>
      <tr>
        <td class="align-middle px-3" data-label="Id"><?php echo $timing["TimeSlotID"]; ?></td>
        <td class="align-middle text-break" data-label="Day"><?php echo ucFirst($timing["DayOfWeek"]); ?></td>
        <td class="align-middle text-break" data-label="Pre"><?php echo $timing["Start_Time"] . " - " . $timing["End_Time"]; ?></td>
        <td class="align-middle px-3" scope="row" data-label="Controls">
          <a class="updateBtn fa fa-pencil mr-1 font-16 text-success" data-id="<?php echo $timing["TimeSlotID"]; ?>" href="javascript:void(0)" title="View"></a>
          <a class="deletebBtn fa fa-trash mr-1 font-16 text-danger" data-id="<?php echo $timing["TimeSlotID"]; ?>" href="javascript:void(0)" title="Delete"></a>
        </td>
      </tr>

    <?php } ?>
    <tr id="loader"></tr>

    <?php if ($limit == "all") : ?>
    <?php else : ?>
      <tr id="pagination" class="bg-light">
        <td colspan="4" class="text-center">
          <?php $attr = (isset($_POST["sort"]) || isset($_POST["limit"]) || isset($_POST["search"])) ? "loadFiltered" : "loadmore"; ?>
          <button type="button" class="btn btn-sm btn-light border" id="<?php echo $attr; ?>" data-paging="<?php echo $page + 1; ?>">
            Load More
          </button>
        </td>
      </tr>
    <?php endif; ?>

  <?php } else { ?>
    <tr class="bg-light">
      <td colspan="4" class="text-center">
        <button type="button" class="btn btn-sm btn-outline-dark" disabled>No Results</button>
      </td>
    </tr>
<?php }
} ?>
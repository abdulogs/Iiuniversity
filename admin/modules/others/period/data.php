<?php
require_once "../../../../classes/crud.php";

if (!isset($_POST) and $_SERVER['REQUEST_METHOD'] == !"POST") {
  echo "<tr><td>Something went wrong</td></tr>";
} else {
  $limit = (isset($_POST["limit"])) ? $_POST["limit"] : 5;
  $page = (isset($_POST["page"])) ? $_POST["page"] : 1;

  /*** Fetching all data ***/
  $periods = crud::select();
  $periods = crud::columns(["PeriodID", "Start_Time", "End_Time"]);
  $periods = crud::table("period");

  /*** Search all data ***/
  if (!empty($_POST["search"])) {
    $periods =  crud::search([
      "PeriodID" => $_POST["search"],
      "Start_Time" => $_POST["search"],
      "End_Time" => $_POST["search"],
    ]);
  }

  /*** sort all data ***/
  if (!isset($_POST["sort"]) || $_POST["sort"] == "recent") {
    $periods =  crud::order("PeriodID", "DESC");
  } else {
    $periods = crud::order("PeriodID", "ASC");
  }

  $periods = ($limit == "all") ?: crud::paging($page, $limit);
  $periods = crud::execute();
  $periods = crud::fetch("all");
  if ($periods) {
    foreach ($periods as $period) { ?>
      <tr>
        <td class="align-middle px-3" data-label="Id"><?php echo $period["PeriodID"]; ?></td>
        <td class="align-middle text-break" data-label="Start"><?php echo ucFirst($period["Start_Time"]); ?></td>
        <td class="align-middle text-break" data-label="Start"><?php echo ucFirst($period["End_Time"]); ?></td>
        <td class="align-middle px-3" scope="row" data-label="Controls">
          <a class="updateBtn fa fa-pencil mr-1 font-16 text-success" data-id="<?php echo $period["PeriodID"]; ?>" href="javascript:void(0)" title="View"></a>
          <a class="deletebBtn fa fa-trash mr-1 font-16 text-danger" data-id="<?php echo $period["PeriodID"]; ?>" href="javascript:void(0)" title="Delete"></a>
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
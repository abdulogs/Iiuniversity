<?php
require_once "../../../../classes/crud.php";

if (!isset($_POST) and $_SERVER['REQUEST_METHOD'] == !"POST") {

  echo "<tr><td class='align-middle px-3' colspan='3' data-label='Error message'>Something went wrong</td></tr>";
} else {

  $limit = (isset($_POST["limit"])) ? $_POST["limit"] : 5;
  $page = (isset($_POST["page"])) ? $_POST["page"] : 1;

  /*** Fetching all data ***/
  $buildings = crud::select()::columns(["BuildingID", "Name"])::table("building");

  /*** Search all data ***/
  if (!empty($_POST["search"])) {
    $buildings =  crud::search([
      "BuildingID" => $_POST["search"],
      "Name" => $_POST["search"],
    ]);
  }

  /*** sort all data ***/
  if (!isset($_POST["sort"]) || $_POST["sort"] == "recent") {
    $buildings =  crud::order("BuildingID", "DESC");
  } else {
    $buildings = crud::order("BuildingID", "ASC");
  }

  $buildings = ($limit == "all") ?: crud::paging($page, $limit);
  $buildings = crud::execute();
  $buildings = crud::fetch("all");
  if ($buildings) {
    foreach ($buildings as $building) { ?>
      <tr>
        <td class="align-middle px-3" data-label="ID"><?php echo $building["BuildingID"]; ?></td>
        <td class="align-middle text-break" data-label="Name"><?php echo ucFirst($building["Name"]); ?></td>
        <td class="align-middle px-3" data-label="Controls">
          <a class="updateBtn fa fa-pencil mr-1 font-16 text-success" data-id="<?php echo $building["BuildingID"]; ?>" href="javascript:void(0)" title="Update"></a>
          <a class="deletebBtn fa fa-trash mr-1 font-16 text-danger"  data-id="<?php echo $building["BuildingID"]; ?>" href="javascript:void(0)" title="Delete"></a>
        </td>
      </tr>
    <?php } ?>

    <tr id="loader"></tr>

    <?php if ($limit == "all") : ?>
    <?php else : ?>
      <tr id="pagination" class="bg-light">
        <td colspan="3" class="text-center">
          <?php $attr = (isset($_POST["sort"]) || isset($_POST["limit"]) || isset($_POST["search"])) ? "loadFiltered" : "loadmore"; ?>
          <button type="button" class="btn btn-sm btn-light border" id="<?php echo $attr; ?>" data-paging="<?php echo $page + 1; ?>">
            Load More
          </button>
        </td>
      </tr>
    <?php endif; ?>

  <?php } else { ?>
    <tr class="bg-light">
      <td colspan="3" class="text-center">
        <button type="button" class="btn btn-sm btn-outline-dark" disabled>No Results</button>
      </td>
    </tr>
<?php }
} ?>
<?php
require_once "../../classes/crud.php";

if (!isset($_POST) and $_SERVER['REQUEST_METHOD'] == !"POST") {

  echo "<tr><td class='align-middle px-3' colspan='2' data-label='Error message'>Something went wrong</td></tr>";
} else {

  $limit = (isset($_POST["limit"])) ? $_POST["limit"] : 5;
  $page = (isset($_POST["page"])) ? $_POST["page"] : 1;

  /*** Fetching all data ***/
  $buildings = crud::select();
  $buildings = crud::columns(["BuildingID", "Name"]);
  $buildings = crud::table("building");
  $buildings = (!empty($_POST["search"])) ? crud::search(["Name" => $_POST["search"]]) : $buildings;
  $buildings = (!isset($_POST["sort"]) || $_POST["sort"] == "recent") ? crud::order("BuildingID", "ASC") : crud::order("BuildingID", "DESC");
  $buildings = ($limit == "all") ?: crud::paging($page, $limit);
  $buildings = crud::execute();
  $buildings = crud::fetch("all");
  if ($buildings) {
    foreach ($buildings as $building) { ?>
      <tr>
        <td class="align-middle px-3" data-label="Id"><?php echo $building["BuildingID"]; ?></td>
        <td class="align-middle text-break" data-label="Name"><?php echo ucFirst($building["Name"]); ?></td>
      </tr>

    <?php } ?>
    <tr id="loader"></tr>

    <?php if ($limit == "all") : ?>
    <?php else : ?>
      <tr id="pagination" class="bg-light">
        <td colspan="2" class="text-center">
          <?php $attr = (isset($_POST["sort"]) || isset($_POST["limit"]) || isset($_POST["search"])) ? "loadFiltered" : "loadmore"; ?>
          <button type="button" class="btn btn-sm text-light font-12" id="<?php echo $attr; ?>" data-paging="<?php echo $page + 1; ?>">
            Load More
          </button>
        </td>
      </tr>
    <?php endif; ?>

  <?php } else { ?>
    <tr class="bg-light">
      <td colspan="2" class="text-center">
        <button type="button" class="btn btn-sm text-light" disabled>No Results</button>
      </td>
    </tr>
<?php }
} ?>
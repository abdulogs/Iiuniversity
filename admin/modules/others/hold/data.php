<?php
require_once "../../../../classes/crud.php";

if (!isset($_POST) and $_SERVER['REQUEST_METHOD'] == !"POST") {
  echo "<tr><td>Something went wrong</td></tr>";
} else {
  $limit = (isset($_POST["limit"])) ? $_POST["limit"] : 5;
  $page = (isset($_POST["page"])) ? $_POST["page"] : 1;

  /*** Fetching all data ***/
  $holds = crud::select();
  $holds = crud::columns(["HoldID", "HoldType"]);
  $holds = crud::table("hold");


  /*** Search all data ***/
  if (!empty($_POST["search"])) {
    $holds =  crud::search([
      "HoldID" => $_POST["search"],
      "HoldType" => $_POST["search"],
    ]);
  }

  /*** sort all data ***/
  if (!isset($_POST["sort"]) || $_POST["sort"] == "recent") {
    $holds =  crud::order("HoldID", "DESC");
  } else {
    $holds = crud::order("HoldID", "ASC");
  }

  $holds = ($limit == "all") ?: crud::paging($page, $limit);
  $holds = crud::execute();
  $holds = crud::fetch("all");
  if ($holds) {
    foreach ($holds as $hold) { ?>
      <tr>
        <td class="align-middle px-3" data-label="Id"><?php echo $hold["HoldID"]; ?></td>
        <td class="align-middle text-break" data-label="Type"><?php echo ucFirst($hold["HoldType"]); ?></td>
        <td class="align-middle px-3" scope="row" data-label="Controls">
          <a class="updateBtn fa fa-pencil mr-1 font-16 text-success" data-id="<?php echo $hold["HoldID"]; ?>" href="javascript:void(0)" title="View"></a>
          <a class="deletebBtn fa fa-trash mr-1 font-16 text-danger" data-id="<?php echo $hold["HoldID"]; ?>" href="javascript:void(0)" title="Delete"></a>
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
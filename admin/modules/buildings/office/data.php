<?php
require_once "../../../../classes/crud.php";

if (!isset($_POST) and $_SERVER['REQUEST_METHOD'] == !"POST") {
  echo "<tr><td  colspan='6'>Something went wrong</td></tr>";
} else {

  $limit = (isset($_POST["limit"])) ? $_POST["limit"] : 5;
  $page = (isset($_POST["page"])) ? $_POST["page"] : 1;

  /*** Fetching all data ***/
  $rooms = crud::select();
  $rooms = crud::columns(["r.RoomID", "r.RoomNumber", "r.Capacity", "r.Seats", "b.Name"]);
  $rooms = crud::table("room as r");
  $rooms = crud::join(["building AS b" => ["b.BuildingID" => "r.BuildingID"]], "LEFT");

  /*** Search all data ***/
  if (!empty($_POST["search"])) {
    $rooms =  crud::search([
      "r.RoomID" => $_POST["search"],
      "r.RoomNumber" => $_POST["search"],
      "r.Seats" => $_POST["search"],
      "r.Capacity" => $_POST["search"],
      "b.Name" => $_POST["search"],
    ])::and([
      "r.RoomType" => "Office"
    ]);
  } else {
    $rooms = crud::where([
      "r.RoomType" => "Office"
    ]);
  }

  /*** sort all data ***/
  if (!isset($_POST["sort"]) || $_POST["sort"] == "recent") {
    $rooms =  crud::order("r.RoomID", "DESC");
  } else {
    $rooms = crud::order("r.RoomID", "ASC");
  }

  $rooms = ($limit == "all") ?: crud::paging($page, $limit);
  $rooms = crud::execute();
  $rooms = crud::fetch("all");
  if ($rooms) {
    foreach ($rooms as $room) { ?>
      <tr>
        <td class="align-middle px-3" data-label="ID">
          <?php echo $room["RoomID"]; ?>
        </td>
        <td class="align-middle text-break" data-label="Building">
          <?php echo ucFirst($room["Name"]); ?>
        </td>
        <td class="align-middle text-break" data-label="Number">
          <?php echo $room["RoomNumber"]; ?></td>
        <td class="align-middle text-break" data-label="Capacity">
          <?php echo $room["Capacity"]; ?>
        </td>
        <td class="align-middle text-break" data-label="Seats">
          <?php echo $room["Seats"]; ?>
        </td>
        <td class="align-middle px-3" scope="row" data-label="Controls">
          <a class="updateBtn fa fa-pencil mr-1 font-16 text-success" data-id="<?php echo $room["RoomID"]; ?>" href="javascript:void(0)" title="View"></a>
          <a class="deletebBtn fa fa-trash mr-1 font-16 text-danger" data-id="<?php echo $room["RoomID"]; ?>" href="javascript:void(0)" title="Delete"></a>
        </td>
      </tr>

    <?php } ?>
    <tr id="loader"></tr>

    <?php if ($limit == "all") : ?>
    <?php else : ?>
      <tr id="pagination" class="bg-light">
        <td colspan="6" class="text-center">
          <?php $attr = (isset($_POST["sort"]) || isset($_POST["limit"]) || isset($_POST["search"])) ? "loadFiltered" : "loadmore"; ?>
          <button type="button" class="btn btn-sm btn-light border" id="<?php echo $attr; ?>" data-paging="<?php echo $page + 1; ?>">
            Load More
          </button>
        </td>
      </tr>
    <?php endif; ?>

  <?php } else { ?>
    <tr class="bg-light">
      <td colspan="6" class="text-center">
        <button type="button" class="btn btn-sm btn-outline-dark" disabled>No Results</button>
      </td>
    </tr>
<?php }
} ?>
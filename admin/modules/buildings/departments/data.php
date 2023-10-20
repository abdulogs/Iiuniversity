<?php
require_once "../../../../classes/crud.php";

if (!isset($_POST) and $_SERVER['REQUEST_METHOD'] == !"POST") {

  echo "<tr><td class='align-middle px-3' colspan='9' data-label='Error message'>Something went wrong</td></tr>";
} else {

  $limit = (isset($_POST["limit"])) ? $_POST["limit"] : 5;
  $page = (isset($_POST["page"])) ? $_POST["page"] : 1;

  /*** Fetching all data ***/
  $departments = crud::select();
  $departments = crud::columns(["d.DeptID", "d.Name", "d.Contact", "d.Chairman", "d.Manager"]);
  $departments = crud::columnsmore(["r.RoomNumber", "r.RoomType", "b.Name as building"]);
  $departments = crud::table("department as d");
  $departments = crud::join(["room AS r" => ["r.RoomID" => "d.RoomID"]], "LEFT");
  $departments = crud::join(["building AS b" => ["b.BuildingID" => "r.BuildingID"]], "LEFT");

  /*** Search all data ***/
  if (!empty($_POST["search"])) {
    $departments =  crud::search([
      "d.DeptID" => $_POST["search"],
      "d.Name" => $_POST["search"],
      "d.Contact" => $_POST["search"],
      "d.Chairman" => $_POST["search"],
      "d.Manager" => $_POST["search"],
      "r.RoomNumber" => $_POST["search"],
      "r.RoomType" => $_POST["search"],
      "r.Seats" => $_POST["search"],
      "r.Capacity" => $_POST["search"],
      "b.Name" => $_POST["search"],
    ]);
  }

  /*** sort all data ***/
  if (!isset($_POST["sort"]) || $_POST["sort"] == "recent") {
    $departments =  crud::order("d.DeptID", "DESC");
  } else {
    $departments = crud::order("d.DeptID", "ASC");
  }

  $departments = ($limit == "all") ?: crud::paging($page, $limit);
  $departments = crud::execute();
  $departments = crud::fetch("all");
  if ($departments) {
    foreach ($departments as $department) { ?>
      <tr>
        <td class="align-middle px-3" data-label="ID">
          <?php echo $department["DeptID"]; ?>
        </td>
        <td class="align-middle" data-label="Name">
          <?php echo ucFirst($department["Name"]); ?>
        </td>
        <td class="align-middle" data-label="Contact">
          <?php echo $department["Contact"]; ?>
        </td>
        <td class="align-middle" data-label="Chairman">
          <?php echo ucFirst($department["Chairman"]); ?>
        </td>
        <td class="align-middle" data-label="Manager">
          <?php echo ucFirst($department["Manager"]); ?>
        </td>
        <td class="align-middle" data-label="Building">
          <?php echo ucFirst($department["building"]); ?>
        </td>
        <td class="align-middle" data-label="Room #">
          <?php echo $department["RoomNumber"]; ?>
        </td>
        <td class="align-middle" data-label="Room Type">
          <?php echo $department["RoomType"]; ?>
        </td>
        <td class="align-middle px-3" scope="row" data-label="Controls">
          <a class="updateBtn fa fa-pencil mr-1 font-16 text-success" data-id="<?php echo $department["DeptID"]; ?>" href="javascript:void(0)" title="Edit"></a>
          <a class="deletebBtn fa fa-trash mr-1 font-16 text-danger" data-id="<?php echo $department["DeptID"]; ?>" href="javascript:void(0)" title="Delete"></a>
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
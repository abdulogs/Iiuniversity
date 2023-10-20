<?php
require_once "../../classes/crud.php";

if (!isset($_POST) and $_SERVER['REQUEST_METHOD'] == !"POST") {

  echo "<tr><td class='align-middle px-3' colspan='6' data-label='Error message'>Something went wrong</td></tr>";
} else {

  $limit = (isset($_POST["limit"])) ? $_POST["limit"] : 10;
  $page = (isset($_POST["page"])) ? $_POST["page"] : 1;

  /*** Fetching all data ***/
  $departments = crud::select();
  $departments = crud::columns(["d.DeptID", "d.Name", "d.Contact", "d.Chairman","d.Manager","r.RoomID", "r.RoomNumber"]);
  $departments = crud::table("department as d");
  $departments = crud::join(["room AS r" => ["r.RoomID" => "d.RoomID"]], "LEFT");
  $departments = (!isset($_POST["sort"]) || $_POST["sort"] == "recent") ? crud::order("d.DeptID", "ASC") : crud::order("d.DeptID", "DESC");
  $departments = ($limit == "all") ?: crud::paging($page, $limit);
  $departments = crud::execute();
  $departments = crud::fetch("all");
  if ($departments) {
    foreach ($departments as $department) { ?>
      <tr>
        <td class="align-middle px-3" data-label="Id"><?php echo $department["DeptID"]; ?></td>
        <td class="align-middle text-break" data-label="Name"><?php echo ucFirst($department["Name"]); ?></td>
        <td class="align-middle text-break" data-label="Contact"><?php echo ucFirst($department["Contact"]); ?></td>
        <td class="align-middle text-break" data-label="Chairman"><?php echo ucFirst($department["Chairman"]); ?></td>
        <td class="align-middle text-break" data-label="Manager"><?php echo ucFirst($department["Manager"]); ?></td>
        <td class="align-middle text-break" data-label="Room"><?php echo ucFirst($department["RoomNumber"]); ?></td>
      </tr>

    <?php } ?>
    <tr id="loader"></tr>

    <?php if ($limit == "all") : ?>
    <?php else : ?>
      <tr id="pagination" class="bg-light">
        <td colspan="6" class="text-center">
          <?php $attr = (isset($_POST["sort"]) || isset($_POST["limit"]) || isset($_POST["search"])) ? "loadFiltered" : "loadmore"; ?>
          <button type="button" class="btn btn-sm text-light font-12" id="<?php echo $attr; ?>" data-paging="<?php echo $page + 1; ?>">
            Load More
          </button>
        </td>
      </tr>
    <?php endif; ?>

  <?php } else { ?>
    <tr class="bg-light">
      <td colspan="6" class="text-center">
        <button type="button" class="btn btn-sm text-light font-12" disabled>No Results</button>
      </td>
    </tr>
<?php }
} ?>
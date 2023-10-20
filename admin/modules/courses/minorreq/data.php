<?php
require_once "../../../../classes/crud.php";

if (!isset($_POST) and $_SERVER['REQUEST_METHOD'] == !"POST") {

  echo "<tr><td class='align-middle px-3' colspan='5' data-label='Error message'>Something went wrong</td></tr>";
} else {

  $limit = (isset($_POST["limit"])) ? $_POST["limit"] : 5;
  $page = (isset($_POST["page"])) ? $_POST["page"] : 1;

  /*** Fetching all data ***/
  $minors = crud::select();
  $minors = crud::columns(["r.MinorReqID", "m.Name", "c.Title", "d.Name as department"]);
  $minors = crud::table("minor_req as r");
  $minors = crud::join(["minor AS m" => ["m.MinorID" => "r.MinorID"]], "LEFT");
  $minors = crud::join(["courses AS c" => ["c.CourseID" => "r.CourseID"]], "LEFT");
  $minors = crud::join(["department AS d" => ["d.DeptID" => "m.DeptID"]], "LEFT");


  /*** Search all data ***/
  if (!empty($_POST["search"])) {
    $minors =  crud::search([
      "r.MinorReqID" => $_POST["search"],
      "c.Title" => $_POST["search"],
      "d.Name" => $_POST["search"],
      "m.Name" => $_POST["search"],
    ]);
  }

  /*** sort all data ***/
  if (!isset($_POST["sort"]) || $_POST["sort"] == "recent") {
    $minors =  crud::order("r.MinorReqID", "DESC");
  } else {
    $minors = crud::order("r.MinorReqID", "ASC");
  }

  $minors = ($limit == "all") ?: crud::paging($page, $limit);
  $minors = crud::execute();
  $minors = crud::fetch("all");
  if ($minors) {
    foreach ($minors as $minor) { ?>
      <tr>
        <td class="align-middle px-3" data-label="ID">
          <?php echo $minor["MinorReqID"]; ?>
        </td>
        <td class="align-middle text-break" data-label="Minor">
          <?php echo ucFirst($minor["Name"]); ?>
        </td>
        <td class="align-middle text-break" data-label="Course">
          <?php echo ucFirst($minor["Title"]); ?>
        </td>
        <td class="align-middle text-break" data-label="Department">
          <?php echo ucFirst($minor["department"]); ?>
        </td>
        <td class="align-middle px-3" scope="row" data-label="Controls">
          <?php if ($_SESSION["role"] == "Admin") : ?>
            <a class="updateBtn fa fa-pencil mr-1 font-16 text-success" data-id="<?php echo $minor["MinorReqID"]; ?>" href="javascript:void(0)" title="View"></a>
            <a class="deletebBtn fa fa-trash mr-1 font-16 text-danger" data-id="<?php echo $minor["MinorReqID"]; ?>" href="javascript:void(0)" title="Delete"></a>
          <?php else : ?>
            -
          <?php endif; ?>
        </td>
      </tr>

    <?php } ?>
    <tr id="loader"></tr>

    <?php if ($limit == "all") : ?>
    <?php else : ?>
      <tr id="pagination" class="bg-light">
        <td colspan="5" class="text-center">
          <?php $attr = (isset($_POST["sort"]) || isset($_POST["limit"]) || isset($_POST["search"])) ? "loadFiltered" : "loadmore"; ?>
          <button type="button" class="btn btn-sm btn-light border" id="<?php echo $attr; ?>" data-paging="<?php echo $page + 1; ?>">
            Load More
          </button>
        </td>
      </tr>
    <?php endif; ?>

  <?php } else { ?>
    <tr class="bg-light">
      <td colspan="5" class="text-center">
        <button type="button" class="btn btn-sm btn-outline-dark" disabled>No Results</button>
      </td>
    </tr>
<?php }
} ?>
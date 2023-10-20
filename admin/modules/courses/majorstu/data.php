<?php
require_once "../../../../classes/crud.php";
if (!isset($_POST) and $_SERVER['REQUEST_METHOD'] == !"POST") {
  echo "<tr><td>Something went wrong</td></tr>";
} else {

  $limit = (isset($_POST["limit"])) ? $_POST["limit"] : 5;
  $page = (isset($_POST["page"])) ? $_POST["page"] : 1;

  /*** Fetching all data ***/
  $majors = crud::select();
  $majors = crud::columns(["s.id", "m.Name", "m.MajorID", "d.Name as department", "DateDeclaration"]);
  $majors = crud::table("studentmajor as s");
  $majors = crud::join(["major AS m" => ["m.MajorID" => "s.MajorID"]], "LEFT");
  $majors = crud::join(["department AS d" => ["d.DeptID" => "m.DeptID"]], "LEFT");


  /*** Search all data ***/
  if (!empty($_POST["search"])) {
    $majors =  crud::search([
      "m.MajorID" => $_POST["search"],
      "m.Name" => $_POST["search"],
      "d.Name" => $_POST["search"],
    ]);
  }

  /*** sort all data ***/
  if (!isset($_POST["sort"]) || $_POST["sort"] == "recent") {
    $majors =  crud::order("s.id", "DESC");
  } else {
    $majors = crud::order("s.id", "ASC");
  }

  $majors = ($limit == "all") ?: crud::paging($page, $limit);
  $majors = crud::execute();
  $majors = crud::fetch("all");
  if ($majors) {
    foreach ($majors as $major) { ?>
      <tr>
        <td class="align-middle px-3" data-label="Id">
          <?php echo $major["MajorID"]; ?>
        </td>
        <td class="align-middle text-break" data-label="Major">
          <?php echo ucFirst($major["Name"]); ?>
        </td>
        <td class="align-middle text-break" data-label="Course">
          <?php echo date('F d, Y', strtotime($major['DateDeclaration'])); ?>
        </td>
        <td class="align-middle text-break" data-label="Department">
          <?php echo ucFirst($major["department"]); ?>
        </td>
        <td class="align-middle px-3" scope="row" data-label="Controls">
          <a class="updateBtn fa fa-pencil mr-1 font-16 text-success" data-id="<?php echo $major["id"]; ?>" href="javascript:void(0)" title="View"></a>
          <a class="deletebBtn fa fa-trash mr-1 font-16 text-danger" data-id="<?php echo $major["id"]; ?>" href="javascript:void(0)" title="Delete"></a>
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
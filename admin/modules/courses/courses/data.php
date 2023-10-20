<?php
require_once "../../../../classes/crud.php";

if (!isset($_POST) and $_SERVER['REQUEST_METHOD'] == !"POST") {

  echo "<tr><td class='align-middle px-3' colspan='6' data-label='Error message'>Something went wrong</td></tr>";
} else {

  $limit = (isset($_POST["limit"])) ? $_POST["limit"] : 5;
  $page = (isset($_POST["page"])) ? $_POST["page"] : 1;

  /*** Fetching all data ***/
  $courses = crud::select();
  $courses = crud::columns(["c.CourseID", "c.Title", "c.Section", "c.CreditHours", "d.DeptID", "d.Name"]);
  $courses = crud::table("courses as c");
  $courses = crud::join(["department AS d" => ["d.DeptID" => "c.DeptID"]], "LEFT");

  /*** Search all data ***/
  if (!empty($_POST["search"])) {
    $courses =  crud::search([
      "d.Name" => $_POST["search"],
      "c.Title" => $_POST["search"],
      "c.Section" => $_POST["search"],
      "c.CreditHours" => $_POST["search"],
      "c.CourseID" => $_POST["search"],
    ]);
  }

  /*** sort all data ***/
  if (!isset($_POST["sort"]) || $_POST["sort"] == "recent") {
    $courses =  crud::order("c.CourseID", "DESC");
  } else {
    $courses = crud::order("c.CourseID", "ASC");
  }

  $courses = ($limit == "all") ?: crud::paging($page, $limit);
  $courses = crud::execute();
  $courses = crud::fetch("all");
  if ($courses) {
    foreach ($courses as $course) { ?>
      <tr>
        <td class="align-middle px-3" data-label="Id">
          <?php echo $course["CourseID"]; ?>
        </td>
        <td class="align-middle text-break" data-label="Name">
          <?php echo ucFirst($course["Title"]); ?>
        </td>
        <td class="align-middle text-break" data-label="Credit Hours">
          <?php echo ucFirst($course["CreditHours"]); ?>
        </td>
        <td class="align-middle text-break" data-label="Section">
          <?php echo $course["Section"]; ?>
        </td>
        <td class="align-middle text-break" data-label="Department">
          <?php echo ucFirst($course["Name"]); ?>
        </td>
        <td class="align-middle px-3" scope="row" data-label="Controls">
          <?php if ($_SESSION["role"] == "Admin") : ?>
            <a class="updateBtn fa fa-pencil mr-1 font-16 text-success" data-id="<?php echo $course["CourseID"]; ?>" href="javascript:void(0)" title="View"></a>
            <a class="deletebBtn fa fa-trash mr-1 font-16 text-danger" data-id="<?php echo $course["CourseID"]; ?>" href="javascript:void(0)" title="Delete"></a>
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
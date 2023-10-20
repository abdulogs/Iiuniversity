<?php
require_once "../../classes/crud.php";

if (!isset($_POST) and $_SERVER['REQUEST_METHOD'] == !"POST") {

  echo "<tr><td class='align-middle px-3' colspan='5' data-label='Error message'>Something went wrong</td></tr>";
} else {

  $limit = (isset($_POST["limit"])) ? $_POST["limit"] : 5;
  $page = (isset($_POST["page"])) ? $_POST["page"] : 1;

  /*** Fetching all data ***/
  $courses = crud::select();
  $courses = crud::columns(["c.CourseID", "c.Title","c.Section" ,"c.CreditHours", "d.DeptID", "d.Name"]);
  $courses = crud::table("courses as c");
  $courses = crud::join(["department AS d" => ["d.DeptID" => "c.DeptID"]], "LEFT");
  $courses = (!empty($_POST["search"])) ? crud::search(["c.DeptID" => $_POST["search"], "c.Title" => $_POST["search"],]) : $courses;
  $courses = (!isset($_POST["sort"]) || $_POST["sort"] == "recent") ? crud::order("c.CourseID", "ASC") : crud::order("c.CourseID", "DESC");
  $courses = ($limit == "all") ?: crud::paging($page, $limit);
  $courses = crud::execute();
  $courses = crud::fetch("all");
  if ($courses) {
    foreach ($courses as $course) { ?>
      <tr>
        <td><?php echo $course["CourseID"]; ?></td>
        <td><?php echo ucFirst($course["Title"]); ?></td>
        <td><?php echo ucFirst($course["CreditHours"]); ?></td>
        <td><?php echo $course["Section"]; ?></td>
        <td><?php echo ucFirst($course["Name"]); ?></td>
      </tr>

    <?php } ?>
    <tr id="loader"></tr>

    <?php if ($limit == "all") : ?>
    <?php else : ?>
      <tr id="pagination" class="bg-light">
        <td colspan="5" class="text-center">
          <?php $attr = (isset($_POST["sort"]) || isset($_POST["limit"]) || isset($_POST["search"])) ? "loadFiltered" : "loadmore"; ?>
          <button type="button" class="btn btn-sm text-light font-12" id="<?php echo $attr; ?>" data-paging="<?php echo $page + 1; ?>">
            Load More
          </button>
        </td>
      </tr>
    <?php endif; ?>

  <?php } else { ?>
    <tr class="bg-light">
      <td colspan="5" class="text-center">
        <button type="button" class="btn btn-sm text-light font-12" disabled>No Results</button>
      </td>
    </tr>
<?php }
} ?>
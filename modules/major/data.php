<?php
require_once "../../classes/crud.php";

if (!isset($_POST) and $_SERVER['REQUEST_METHOD'] == !"POST") {

  echo "<tr><td class='align-middle px-3' colspan='4' data-label='Error message'>Something went wrong</td></tr>";
} else {

  $limit = (isset($_POST["limit"])) ? $_POST["limit"] : 5;
  $page = (isset($_POST["page"])) ? $_POST["page"] : 1;

  /*** Fetching all data ***/
  $majors = crud::select();
  $majors = crud::columns(["m.MajorID", "d.DeptID", "m.Name as major", "d.Name as deparment"]);
  $majors = crud::table("major as m");
  $majors = crud::join(["department AS d" => ["d.DeptID" => "m.DeptID"]], "LEFT");
  $majors = (!empty($_POST["search"])) ? crud::search(["m.Name" => $_POST["search"]]) : $majors;
  $majors = (!isset($_POST["sort"]) || $_POST["sort"] == "recent") ? crud::order("m.MajorID", "ASC") : crud::order("m.MajorID", "DESC");
  $majors = ($limit == "all") ?: crud::paging($page, $limit);
  $majors = crud::execute();
  $majors = crud::fetch("all");
  if ($majors) {
    foreach ($majors as $major) { ?>
      <tr>
        <td><?php echo $major["MajorID"]; ?></td>
        <td><?php echo $major["major"]; ?></td>
        <td><?php echo $major["deparment"]; ?></td>
        <td><a href="major-courses.php?id=<?php echo $major["MajorID"]; ?>" class="btn-link">View courses</a></td>
      </tr>

    <?php } ?>
    <tr id="loader"></tr>

    <?php if ($limit == "all") : ?>
    <?php else : ?>
      <tr id="pagination" class="bg-light">
        <td colspan="4" class="text-center">
          <?php $attr = (isset($_POST["sort"]) || isset($_POST["limit"]) || isset($_POST["search"])) ? "loadFiltered" : "loadmore"; ?>
          <button type="button" class="btn btn-sm text-light font-12" id="<?php echo $attr; ?>" data-paging="<?php echo $page + 1; ?>">
            Load More
          </button>
        </td>
      </tr>
    <?php endif; ?>

  <?php } else { ?>
    <tr class="bg-light">
      <td colspan="4" class="text-center">
        <button type="button" class="btn btn-sm text-light font-12" disabled>No Results</button>
      </td>
    </tr>
<?php }
} ?>
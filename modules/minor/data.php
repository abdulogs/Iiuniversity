<?php
require_once "../../classes/crud.php";

if (!isset($_POST) and $_SERVER['REQUEST_METHOD'] == !"POST") {

  echo "<tr><td class='align-middle px-3' colspan='4' data-label='Error message'>Something went wrong</td></tr>";
} else {

  $limit = (isset($_POST["limit"])) ? $_POST["limit"] : 5;
  $page = (isset($_POST["page"])) ? $_POST["page"] : 1;

  /*** Fetching all data ***/
  $minors = crud::select();
  $minors = crud::columns(["m.MinorID", "d.DeptID", "m.Name as minor", "d.Name as deparment"]);
  $minors = crud::table("minor as m");
  $minors = crud::join(["department AS d" => ["d.DeptID" => "m.DeptID"]], "LEFT");
  $minors = (!empty($_POST["search"])) ? crud::search(["m.Name" => $_POST["search"]]) : $minors;
  $minors = (!isset($_POST["sort"]) || $_POST["sort"] == "recent") ? crud::order("m.MinorID", "ASC") : crud::order("m.MinorID", "DESC");
  $minors = ($limit == "all") ?: crud::paging($page, $limit);
  $minors = crud::execute();
  $minors = crud::fetch("all");
  if ($minors) {
    foreach ($minors as $minor) { ?>
      <tr>
        <td><?php echo $minor["MinorID"]; ?></td>
        <td><?php echo $minor["minor"]; ?></td>
        <td><?php echo $minor["deparment"]; ?></td>
        <td><a href="minor-courses.php?id=<?php echo $minor["MinorID"]; ?>" class="btn-link">View courses</a></td>
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
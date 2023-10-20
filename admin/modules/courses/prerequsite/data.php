<?php
require_once "../../../../classes/crud.php";

if (!isset($_POST) and $_SERVER['REQUEST_METHOD'] == !"POST") {

  echo "<tr><td class='align-middle px-3' colspan='5' data-label='Error message'>Something went wrong</td></tr>";
} else {

  $limit = (isset($_POST["limit"])) ? $_POST["limit"] : 5;
  $page = (isset($_POST["page"])) ? $_POST["page"] : 1;

  /*** Fetching all data ***/
  $prerequsites = crud::select();
  $prerequsites = crud::columns(["p.PreReqID", "c.Title", "cp.Title as course", "p.MinGrade"]);
  $prerequsites = crud::table("prerequsite as p");
  $prerequsites = crud::join(["courses AS cp" => ["cp.CourseID" => "p.PreReqID"]], "LEFT");
  $prerequsites = crud::join(["courses AS c" => ["c.CourseID" => "p.CourseID"]], "LEFT");

  /*** Search all data ***/
  if (!empty($_POST["search"])) {
    $prerequsites =  crud::search([
      "p.PreReqID" => $_POST["search"],
      "c.Title" => $_POST["search"],
      "cp.Title" => $_POST["search"],
      "p.MinGrade" => $_POST["search"],
    ]);
  }

  /*** sort all data ***/
  if (!isset($_POST["sort"]) || $_POST["sort"] == "recent") {
    $prerequsites =  crud::order("p.PreReqID", "DESC");
  } else {
    $prerequsites = crud::order("p.PreReqID", "ASC");
  }

  $prerequsites = ($limit == "all") ?: crud::paging($page, $limit);
  $prerequsites = crud::execute();
  $prerequsites = crud::fetch("all");
  if ($prerequsites) {
    foreach ($prerequsites as $prerequsite) { ?>
      <tr>
        <td class="align-middle px-3" data-label="Id"><?php echo $prerequsite["PreReqID"]; ?></td>
        <td class="align-middle text-break" data-label="Course"><?php echo ucFirst($prerequsite["course"]); ?></td>
        <td class="align-middle text-break" data-label="Course pre"><?php echo ucFirst($prerequsite["Title"]); ?></td>
        <td class="align-middle text-break" data-label="Min Grade"><?php echo ucFirst($prerequsite["MinGrade"]); ?></td>
        <td class="align-middle px-3" scope="row" data-label="Controls">
          <?php if ($_SESSION["role"] == "Admin") : ?>
            <a class="updateBtn fa fa-pencil mr-1 font-16 text-success" data-id="<?php echo $prerequsite["PreReqID"]; ?>" href="javascript:void(0)" title="View"></a>
            <a class="deletebBtn fa fa-trash mr-1 font-16 text-danger" data-id="<?php echo $prerequsite["PreReqID"]; ?>" href="javascript:void(0)" title="Delete"></a>
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
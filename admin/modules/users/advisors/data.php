<?php
require_once "../../../../classes/crud.php";

if (!isset($_POST) and $_SERVER['REQUEST_METHOD'] == !"POST") {
  echo "<tr><td>Something went wrong</td></tr>";
} else {

  $limit = (isset($_POST["limit"])) ? $_POST["limit"] : 5;
  $page = (isset($_POST["page"])) ? $_POST["page"] : 1;

  /*** Fetching all data ***/
  $users = crud::select();
  $users = crud::columns(["a.AdvisorID", "f.F_Name as ffname", "f.L_Name as flname", "s.F_Name as sfname"]);
  $users = crud::columnsmore(["s.L_Name as slname", "a.AssignDate"]);
  $users = crud::table("student_advisor as a");
  $users = crud::join(["users AS f" => ["f.UserID" => "a.FacultyID"]], "LEFT");
  $users = crud::join(["users AS s" => ["s.UserID" => "a.StudentID"]], "LEFT");

  /*** Search all data ***/
  if (!empty($_POST["search"])) {
    $users =  crud::search([
      "f.F_Name" => $_POST["search"],
      "f.L_Name" => $_POST["search"],
      "s.F_Name" => $_POST["search"],
      "s.L_Name" => $_POST["search"],
    ]);

    if ($_SESSION["role"] == "Student") {
      $users = crud::and(["a.StudentID" => $_SESSION["id"]]);
      $users = crud::or(["s.UserType" => "Student", "s.UserType" => "Faculty"]);

    } else {
      $users = crud::and(["s.UserType" => "Student"]);
      $users = crud::or(["s.UserType" => "Student", "s.UserType" => "Faculty"]);
    }
  }

  /*** sort all data ***/
  if (!isset($_POST["sort"]) || $_POST["sort"] == "recent") {
    $users =  crud::order("a.AdvisorID", "DESC");
  } else {
    $users = crud::order("a.AdvisorID", "ASC");
  }

  $users = ($limit == "all") ?: crud::paging($page, $limit);
  $users = crud::execute();
  $users = crud::fetch("all");
  if ($users) {
    foreach ($users as $student) { ?>
      <tr>
      <td class="align-middle px-3" data-label="ID">
          <?php echo $student["AdvisorID"]; ?>
        </td>
        <td class="align-middle" data-label="student">
          <?php echo ucFirst($student["sfname"] . " " . $student["slname"]); ?>
        </td>
        <td class="align-middle" data-label="Faculty">
          <?php echo ucFirst($student["ffname"] . " " . $student["flname"]); ?>
        </td>
        <td class="align-middle" data-label="Date">
          <?php echo date('F d, Y', strtotime($student["AssignDate"])); ?>
        </td>
        <td class="align-middle px-3" scope="row" data-label="Controls">
          <?php if ($_SESSION["role"] == "Faculty"  || $_SESSION["role"] == "Admin") : ?>
            <a class="updateBtn fa fa-pencil mr-1 font-16 text-success" data-id="<?php echo $student["AdvisorID"]; ?>" href="javascript:void(0)" title="View"></a>
            <a class="deletebBtn fa fa-trash mr-1 font-16 text-danger" data-id="<?php echo $student["AdvisorID"]; ?>" href="javascript:void(0)" title="Delete"></a>
        </td>
      <?php else : ?>
        -
      <?php endif; ?>
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
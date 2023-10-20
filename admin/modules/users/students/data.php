<?php
require_once "../../../../classes/crud.php";

if (!isset($_POST) and $_SERVER['REQUEST_METHOD'] == !"POST") {

  echo "<tr><td class='align-middle px-3' colspan='11' data-label='Error message'>Something went wrong</td></tr>";
} else {

  $limit = (isset($_POST["limit"])) ? $_POST["limit"] : 20;
  $page = (isset($_POST["page"])) ? $_POST["page"] : 1;

  /*** Fetching all data ***/
  $users = crud::select();
  $users = crud::columns(["u.UserID", "u.F_Name", "u.L_Name", "u.DOB", "u.Phone", "u.DateCreated"]);
  $users = crud::columnsmore(["u.Email", "h.HoldType", "s.StudentType", "s.StudentStatus", "s.CreditEarned"]);
  $users = crud::table("users as u");
  $users = crud::join(["student AS s" => ["s.StudentID" => "u.UserID"]], "LEFT");
  $users = crud::join(["student_hold AS sh" => ["sh.StudentID" => "s.StudentID"]], "LEFT");
  $users = crud::join(["hold AS h" => ["h.HoldID" => "sh.HoldID"]], "LEFT");


  /*** Search all data ***/
  if (!empty($_POST["search"])) {
    $users =  crud::search([
      "u.UserID" => $_POST["search"],
      "u.F_Name" => $_POST["search"],
      "u.L_Name" => $_POST["search"],
      "u.DOB" => $_POST["search"],
      "u.Phone" => $_POST["search"],
      "u.Email" => $_POST["search"],
      "s.StudentType" => $_POST["search"],
      "s.StudentStatus" => $_POST["search"],
      "s.CreditEarned" => $_POST["search"],
      "h.HoldType" => $_POST["search"],
    ])::and(["u.UserType" => "Student"]);
  } else {
    $users = crud::where([
      "u.UserType" => "Student"
    ]);
  }

  /*** sort all data ***/
  if (!isset($_POST["sort"]) || $_POST["sort"] == "recent") {
    $users =  crud::order("u.UserID", "DESC");
  } else {
    $users = crud::order("u.UserID", "ASC");
  }

  $users = ($limit == "all") ?: crud::paging($page, $limit);
  $users = crud::execute();
  $users = crud::fetch("all");
  if ($users) {
    foreach ($users as $user) { ?>
      <tr>
        <td class="align-middle px-3" data-label="ID">
          <?php echo $user["UserID"]; ?>
        </td>
        <td class="align-middle text-break" data-label="Fullname">
          <?php echo ucFirst($user["F_Name"]) . " " . ucFirst($user["L_Name"]); ?>
        </td>
        <td class="align-middle text-break" data-label="Email Address">
          <?php echo $user["Email"]; ?>
        </td>
        <td class="align-middle text-break" data-label="Phone">
          <?php echo $user["Phone"]; ?>
        </td>
        <td class="align-middle text-break" data-label="Date of birth">
          <?php echo date('F d, Y', strtotime($user["DOB"])); ?>
        </td>
        <td class="align-middle text-break" data-label="Type">
          <?php echo $user["StudentType"]; ?>
        </td>
        <td class="align-middle text-break" data-label="Credits">
          <?php echo $user["CreditEarned"]; ?>
        </td>
        <td class="align-middle text-break" data-label="Hold">
          <?php echo (empty($user["HoldType"])) ? "N/A" : $user["HoldType"]; ?>
        </td>
        <td class="align-middle text-break" data-label="Status">
          <?php echo (empty($user["graduate"])) ? "Under graduate" : "Graduate"; ?>
        </td>
        <td class="align-middle text-break" data-label="Created at">
          <?php echo date('F d, Y', strtotime($user["DateCreated"])); ?>
        </td>
        <td class="align-middle px-3" scope="row" data-label="Controls">
          <a class="updateBtn fa fa-pencil mr-1 font-16 text-success" data-id="<?php echo $user["UserID"]; ?>" href="javascript:void(0)" title="View"></a>
          <a class="deletebBtn fa fa-trash mr-1 font-16 text-danger" data-id="<?php echo $user["UserID"]; ?>" href="javascript:void(0)" title="Delete"></a>
        </td>
      </tr>

    <?php } ?>
    <tr id="loader"></tr>

    <?php if ($limit == "all") : ?>
    <?php else : ?>
      <tr id="pagination" class="bg-light">
        <td colspan="11" class="text-center">
          <?php $attr = (isset($_POST["sort"]) || isset($_POST["limit"]) || isset($_POST["search"])) ? "loadFiltered" : "loadmore"; ?>
          <button type="button" class="btn btn-sm btn-light border" id="<?php echo $attr; ?>" data-paging="<?php echo $page + 1; ?>">
            Load More
          </button>
        </td>
      </tr>
    <?php endif; ?>

  <?php } else { ?>
    <tr class="bg-light">
      <td colspan="11" class="text-center">
        <button type="button" class="btn btn-sm btn-outline-dark" disabled>No Results</button>
      </td>
    </tr>
<?php }
} ?>
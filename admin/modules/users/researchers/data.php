<?php
require_once "../../../../classes/crud.php";

if (!isset($_POST) and $_SERVER['REQUEST_METHOD'] == !"POST") {

  echo "<tr><td class='align-middle px-3' colspan='8' data-label='Error message'>Something went wrong</td></tr>";
} else {

  $limit = (isset($_POST["limit"])) ? $_POST["limit"] : 5;
  $page = (isset($_POST["page"])) ? $_POST["page"] : 1;

  /*** Fetching all data ***/
  $users = crud::select();
  $users = crud::columns(["UserID", "F_Name", "L_Name", "DOB", "Phone", "DateCreated", "Email"]);
  $users = crud::table("users");


  /*** Search all data ***/
  if (!empty($_POST["search"])) {
    $users =  crud::search([
      "UserID" => $_POST["search"],
      "F_Name" => $_POST["search"],
      "L_Name" => $_POST["search"],
      "DOB" => $_POST["search"],
      "Phone" => $_POST["search"],
      "Email" => $_POST["search"],
    ])::and(["UserType" => "Researcher"]);
  } else {
    $users = crud::where([
      "UserType" => "Researcher"
    ]);
  }

  /*** sort all data ***/
  if (!isset($_POST["sort"]) || $_POST["sort"] == "recent") {
    $users =  crud::order("UserID", "DESC");
  } else {
    $users = crud::order("UserID", "ASC");
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
        <td class="align-middle text-break" data-label="Firstname">
          <?php echo ucFirst($user["F_Name"]); ?>
        </td>
        <td class="align-middle text-break" data-label="Lastname">
          <?php echo ucFirst($user["L_Name"]); ?>
        </td>
        <td class="align-middle text-break" data-label="Email Address">
          <?php echo $user["Email"]; ?>
        </td>
        <td class="align-middle text-break" data-label="Phone">
          <?php echo $user["Phone"]; ?>
        </td>
        <td class="align-middle text-break" data-label="Dob">
          <?php echo date('F d, Y', strtotime($user["DOB"])); ?>
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
        <td colspan="8" class="text-center">
          <?php $attr = (isset($_POST["sort"]) || isset($_POST["limit"]) || isset($_POST["search"])) ? "loadFiltered" : "loadmore"; ?>
          <button type="button" class="btn btn-sm btn-light border" id="<?php echo $attr; ?>" data-paging="<?php echo $page + 1; ?>">
            Load More
          </button>
        </td>
      </tr>
    <?php endif; ?>

  <?php } else { ?>
    <tr class="bg-light">
      <td colspan="8" class="text-center">
        <button type="button" class="btn btn-sm btn-outline-dark" disabled>No Results</button>
      </td>
    </tr>
<?php }
} ?>
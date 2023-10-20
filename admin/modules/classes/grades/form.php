<?php
require_once "../../../../classes/crud.php";

if (!isset($_POST) and $_SERVER['REQUEST_METHOD'] !== "POST") {
  echo "Request failed";
} elseif (empty($_POST['id'])) { ?>

<?php } ?>


<?php
if (!empty($_POST['id'])) {
  $id = htmlentities(htmlspecialchars(strip_tags($_POST['id'])));
  $enrollment = crud::select();
  $enrollment = crud::columns(["e.GRADE", "u.F_Name", "u.L_Name", "s.Title", "e.id", "e.CRN"]);
  $enrollment = crud::table("enrollment as e");
  $enrollment = crud::join(["class AS c" => ["c.CRN" => "e.CRN"]], "LEFT");
  $enrollment = crud::join(["courses AS s" => ["s.CourseID" => "c.CourseID"]], "LEFT");
  $enrollment = crud::join(["users AS u" => ["u.UserID" => "e.StudentID"]], "LEFT");
  $enrollment = crud::where(["id" => $id]);
  $enrollment = crud::execute();
  $enrollment = crud::fetch("one");

  if ($enrollment) { ?>
    <form class="modal-content border-0 shadow-lg" id="update">
      <div class="modal-header d-flex align-items-center align-middle p-2">
        <h5 class="modal-title font-20 m-0">
          <b><span class="fa fa-plus-circle mr-2 font-20 text-success"></span>UPDATE</b>
        </h5>
        <button class="btn btn-icon waves-effect waves-light text-dark btn-sm" data-dismiss="modal" aria-label="Close">
          <i class="fa fa-close"></i>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-row">
          <input name="id" type="hidden" value="<?php echo $enrollment["id"] ?>" />

          <?php if ($_SESSION["role"] == "Faculty" || $_SESSION["role"] == "Admin") : ?>
            <div class="form-group col-sm-4 mb-2">
              <label class="font-weight-bolder mb-0" for="student">Student</label>
              <select class="custom-select font-12">
                <option value="">Select</option>
                <option selected>
                  <?php echo $enrollment["F_Name"] . " " . $enrollment["L_Name"]; ?>
                </option>
              </select>
            </div>
            <div class="form-group col-sm-4 mb-2">
              <label class="font-weight-bolder mb-0" for="course">Course</label>
              <select class="custom-select font-12">
                <option value="">Select</option>
                <option selected><?php echo $enrollment["Title"]; ?></option>
              </select>
            </div>

            <div class="form-group col-sm-4 mb-2">
              <label class="font-weight-bolder mb-0" for="grade">Grade</label>
              <input class="form-control font-12" id="grade" name="grade" type="text" value="<?php echo $enrollment["GRADE"] ?>" required />
            </div>
          <?php endif; ?>
        </div>
      </div>
      <div class="modal-footer bg-light">
        <button class="btn btn-light border btn-sm" type="button" data-dismiss="modal">Close</button>
        <button class="btn btn-success btn-sm btn-submit" id="btn-submit" type="submit">Proceed</button>
      </div>
    </form>
<?php }
} ?>
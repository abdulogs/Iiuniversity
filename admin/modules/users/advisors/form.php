<?php
require_once "../../../../classes/crud.php";

if (!isset($_POST) and $_SERVER['REQUEST_METHOD'] !== "POST") {
  echo "Request failed";
} elseif (empty($_POST['id'])) { ?>
  <form class="modal-content border-0 shadow-lg" method="post" id="create">
    <div class="modal-header d-flex align-items-center align-middle p-2">
      <h5 class="modal-title font-20 m-0">
        <b><span class="fa fa-plus-circle mr-2 font-20 text-success"></span>CREATE</b>
      </h5>
      <button class="btn btn-icon waves-effect waves-light text-dark btn-sm" data-dismiss="modal" aria-label="Close">
        <i class="fa fa-close"></i>
      </button>
    </div>
    <div class="modal-body">
      <div class="form-row">
        <div class="form-group col-sm-4 mb-0">
          <label class="font-weight-bolder mb-0" for="id">ID</label>
          <input class="form-control" type="text" id="id" name="id" required />
        </div>
        <div class="form-group col-sm-4 mb-2">
          <label class="font-weight-bolder mb-0" for="student">Student</label>
          <select class="custom-select font-12" id="student" name="student" required>
            <option value="">Select</option>
            <?php
            $students = crud::select()::columns(["UserID", "F_Name", "L_Name"])::table("users")::where(["UserType" => "Student"])::execute();
            $students = crud::fetch("all");
            if ($students) {
              foreach ($students as $student) { ?>
                <option value="<?php echo $student["UserID"] ?>">
                  <?php echo $student["F_Name"] . " " . $student["L_Name"]; ?>
                </option>
            <?php }
            } ?>
          </select>
        </div>
        <div class="form-group col-sm-4 mb-2">
          <label class="font-weight-bolder mb-0" for="faculty">Faculty</label>
          <select class="custom-select font-12" id="faculty" name="faculty" required>
            <option value="">Select</option>
            <?php
            $facultys = crud::select()::columns(["UserID", "F_Name", "L_Name"])::table("users")::where(["UserType" => "Faculty"])::execute();
            $facultys = crud::fetch("all");
            if ($facultys) {
              foreach ($facultys as $faculty) { ?>
                <option value="<?php echo $faculty["UserID"] ?>">
                  <?php echo $faculty["F_Name"] . " " . $faculty["L_Name"]; ?>
                </option>
            <?php }
            } ?>
          </select>
        </div>
      </div>
    </div>
    <div class="modal-footer bg-light">
      <button class="btn btn-light border btn-sm" type="button" data-dismiss="modal">Close</button>
      <button class="btn btn-success btn-sm btn-submit" id="btn-submit" type="submit">Proceed</button>
    </div>
  </form>
<?php } ?>


<?php
if (!empty($_POST['id'])) {
  $id = htmlentities(htmlspecialchars(strip_tags($_POST['id'])));
  $student = crud::select()::columns(["AdvisorID", "StudentID", "FacultyID"])::table("student_advisor");
  $student = crud::where(["AdvisorID" => $id])::execute();
  $student = crud::fetch("one");

  if ($student) { ?>
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
          <div class="form-group col-sm-4 mb-0">
            <label class="font-weight-bolder mb-0" for="id">ID</label>
            <input class="form-control" type="text" value="<?php echo $student['AdvisorID']; ?>" disabled />
            <input name="id" type="hidden" value="<?php echo $student['AdvisorID']; ?>" />
          </div>
          <div class="form-group col-sm-4 mb-2">
            <label class="font-weight-bolder mb-0" for="student">Student</label>
            <select class="custom-select font-12" id="student" name="student" required>
              <option value="">Select</option>
              <?php
              $students = crud::select()::columns(["UserID", "F_Name", "L_Name"])::table("users")::where(["UserType" => "Student"])::execute();
              $students = crud::fetch("all");
              if ($students) {
                foreach ($students as $stu) { ?>
                  <option value="<?php echo $stu["UserID"] ?>" <?php echo ($stu["UserID"] == $student["StudentID"]) ? "selected" : ""; ?>>
                    <?php echo $stu["F_Name"] . " " . $stu["L_Name"]; ?>
                  </option>
              <?php }
              } ?>
            </select>
          </div>
          <div class="form-group col-sm-4 mb-2">
            <label class="font-weight-bolder mb-0" for="faculty">Faculty</label>
            <select class="custom-select font-12" id="faculty" name="faculty" required>
              <option value="">Select</option>
              <?php
              $facultys = crud::select()::columns(["UserID", "F_Name", "L_Name"])::table("users")::where(["UserType" => "Faculty"])::execute();
              $facultys = crud::fetch("all");
              if ($facultys) {
                foreach ($facultys as $faculty) { ?>
                  <option value="<?php echo $faculty["UserID"] ?>" <?php echo ($faculty["UserID"] == $student["FacultyID"]) ? "selected" : ""; ?>>
                    <?php echo $faculty["F_Name"] . " " . $faculty["L_Name"]; ?>
                  </option>
              <?php }
              } ?>
            </select>
          </div>
        </div>
      </div>
      <div class="modal-footer bg-light">
        <button class="btn btn-light border btn-sm" type="button" data-dismiss="modal">Close</button>
        <button class="btn btn-success btn-sm btn-submit" id="btn-submit" type="submit">Proceed</button>
      </div>
    </form>
<?php }
} ?>
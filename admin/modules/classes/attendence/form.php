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
        <div class="form-group col-sm-4 mb-2">
          <label class="font-weight-bolder mb-0" for="student">Student</label>
          <select class="custom-select font-12" id="student" name="student" required>
            <option value="">Select</option>
            <?php
            $students = crud::select();
            $students = crud::columns(["u.F_Name", "u.L_Name", "e.StudentID","o.Title"]);
            $students = crud::table("class as c");
            $students = crud::join(["enrollment AS e" => ["e.CRN" => "c.CRN"]], "RIGHT");
            $students = crud::join(["courses AS o" => ["o.CourseID" => "c.CourseID"]], "RIGHT");
            $students = crud::join(["users AS u" => ["u.UserID" => "e.StudentID"]], "LEFT");
            $students = crud::where(["c.FacultyID" => $_SESSION["id"]]);
            $students = crud::execute();
            $students = crud::fetch("all");
            if ($students) {
              foreach ($students as $student) { ?>
                <option value="<?php echo $student["StudentID"] ?>">
                  <?php echo ucfirst($student["F_Name"] . " " . $student["L_Name"])." (".$student["Title"].")"; ?>
                </option>
            <?php }
            } ?>
          </select>
        </div>
        <div class="form-group col-sm-4 mb-2">
          <label class="font-weight-bolder mb-0" for="class">Class</label>
          <select class="custom-select font-12" id="class" name="class" required>
            <option value="">Select</option>
            <?php
            $courses = crud::select();
            $courses = crud::columns(["e.Title", "c.CRN"]);
            $courses = crud::table("class as c");
            $courses = crud::join(["courses AS e" => ["e.CourseID" => "c.CourseID"]], "LEFT");
            $courses = crud::where(["c.FacultyID" => $_SESSION["id"]]);
            $courses = crud::execute();
            $courses = crud::fetch("all");
            if ($courses) {
              foreach ($courses as $course) { ?>
                <option value="<?php echo $course["CRN"] ?>"><?php echo $course["Title"]; ?></option>
            <?php }
            } ?>
          </select>
        </div>
        <div class="form-group col-sm-4 mb-2">
          <label class="font-weight-bolder mb-0" for="sstatus">Status</label>
          <select class="custom-select font-12" id="sstatus" name="sstatus" required>
            <option value="">Select</option>
            <option value="1">Present</option>
            <option value="0">Absent</option>
          </select>
        </div>
      </div>
    </div>
    <div class="modal-footer bg-light align-middle p-2">
      <button class="btn btn-light border btn-sm" type="button" data-dismiss="modal">Close</button>
      <button class="btn btn-success btn-sm btn-submit" id="btn-submit" type="submit">Proceed</button>
    </div>
  </form>
<?php } ?>


<?php
if (!empty($_POST['id'])) {
  $id = htmlentities(htmlspecialchars(strip_tags($_POST['id'])));
  $attendence = crud::select();
  $attendence = crud::columns(["CRN", "StudentID", "Present","id"]);
  $attendence = crud::table("attendence")::where(["id" => $id])::execute();
  $attendence = crud::fetch("one");

  if ($attendence) { ?>
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
          <div class="form-group col-sm-4 mb-2">
            <label class="font-weight-bolder mb-0" for="student">Student</label>
            <input type="hidden" value="<?php echo $attendence["id"] ?>" id="id" name="id">
            <select class="custom-select font-12" id="student" name="student" readonly>
              <?php
              $students = crud::select();
              $students = crud::columns(["F_Name", "L_Name", "UserID"]);
              $students = crud::table("users");
              $students = crud::where(["UserID" => $attendence["StudentID"]]);
              $students = crud::execute();
              $students = crud::fetch("all");
              if ($students) {
                foreach ($students as $student) { ?>
                  <option value="<?php echo $student["StudentID"] ?>" selected>
                    <?php echo ucfirst($student["F_Name"] . " " . $student["L_Name"]); ?>
                  </option>
              <?php }
              } ?>
            </select>
          </div>
          <div class="form-group col-sm-4 mb-2">
            <label class="font-weight-bolder mb-0" for="class">Class</label>
            <select class="custom-select font-12" id="class" name="class" required>
              <option value="">Select</option>
              <?php
              $courses = crud::select();
              $courses = crud::columns(["e.Title", "c.CRN"]);
              $courses = crud::table("class as c");
              $courses = crud::join(["courses AS e" => ["e.CourseID" => "c.CourseID"]], "LEFT");
              $courses = crud::where(["c.FacultyID" => $_SESSION["id"]]);
              $courses = crud::execute();
              $courses = crud::fetch("all");
              if ($courses) {
                foreach ($courses as $course) { ?>
                  <option <?php echo ($attendence["CRN"] == $course["CRN"]) ? "selected" : ""; ?> value="<?php echo $course["CRN"] ?>">
                    <?php echo $course["Title"]; ?>
                  </option>
              <?php }
              } ?>
            </select>
          </div>
          <div class="form-group col-sm-4 mb-2">
            <label class="font-weight-bolder mb-0" for="sstatus">Status</label>
            <select class="custom-select font-12" id="sstatus" name="sstatus" required>
              <optgroup label="Selected">
                <option value="<?php echo $attendence["Present"]; ?>">
                <?php echo ($attendence["Present"] == 0) ? "Absent" : "Present"; ?>
              </option>
              </optgroup>
              <option value="1">Present</option>
              <option value="0">Absent</option>
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
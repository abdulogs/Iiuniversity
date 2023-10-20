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
        <div class="form-group col-sm-12 mb-2">
          <label class="font-weight-bolder mb-0" for="course">Course</label>
          <select class="custom-select font-12" id="course" name="course" required>
            <option value="">Select</option>
            <?php
            if (in_array(date("m"), [3, 4, 5, 6, 7, 8])) {
              $type = "Fall";
            } else if (in_array(date("m"), [9, 10, 11, 12, 1, 2])) {
              $type = "Spring";
            }
            $courses = crud::select();
            $courses = crud::columns(["c.Title", "e.CRN", "s.SemesterName","s.Year"]);
            $courses = crud::table("class as e");
            $courses = crud::join(["courses AS c" => ["c.CourseID" => "e.CourseID"]], "LEFT");
            $courses = crud::join(["semesteryear AS s" => ["s.SemesterID" => "e.SemesterID"]], "LEFT");
            $courses = crud::where(["s.SemesterName" => $type, "s.Year" => date("Y")]);
            $courses = crud::test();
            $courses = crud::execute();
            $courses = crud::fetch("all");
            if ($courses) {
              foreach ($courses as $course) { ?>
                <option value="<?php echo $course["CRN"] ?>">
                  <?php
                  echo $course["Title"] . " (" . $course["SemesterName"] . " -" . $course["Year"] . ")";
                  ?>
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
  $enrollment = crud::select();
  $enrollment = crud::columns(["e.GRADE", "u.F_Name", "u.L_Name", "s.Title", "e.id", "e.CRN"]);
  $enrollment = crud::table("enrollment as e");
  $enrollment = crud::join(["class AS c" => ["c.CRN" => "e.CRN"]], "LEFT");
  $enrollment = crud::join(["courses AS s" => ["s.CourseID" => "c.CourseID"]], "LEFT");
  $enrollment = crud::join(["users AS u" => ["u.UserID" => "e.StudentID"]], "LEFT");
  $enrollment = crud::and(["id" => $id]);
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
          <div class="form-group col-sm-12 mb-2">
            <label class="font-weight-bolder mb-0" for="course">Courses</label>
            <select class="custom-select font-12" id="course" name="course" required>
              <option value="">Select</option>
              <?php
              if (in_array(date("m"), [3, 4, 5, 6, 7, 8])) {
                $type = "Fall";
              } else if (in_array(date("m"), [9, 10, 11, 12, 1, 2])) {
                $type = "Spring";
              }
              $courses = crud::select();
              $courses = crud::columns(["c.Title", "e.CRN", "s.SemesterName", "s.Year"]);
              $courses = crud::table("class as e");
              $courses = crud::join(["courses AS c" => ["c.CourseID" => "e.CourseID"]], "LEFT");
              $courses = crud::join(["semesteryear AS s" => ["s.SemesterID" => "e.SemesterID"]], "LEFT");
              $courses = crud::where(["s.SemesterName" => $type, "s.Year" => date("Y")]);
              $courses = crud::test();
              $courses = crud::execute();
              $courses = crud::fetch("all");
              if ($courses) {
                foreach ($courses as $course) { ?>
                  <option <?php echo ($course["CRN"] == $enrollment["CRN"]) ? "selected" : ""; ?> value="<?php echo $course["CRN"] ?>">
                    <?php
                    echo $course["Title"] . " (" . $course["SemesterName"] . " -" . $course["Year"] . ")";
                    ?>
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